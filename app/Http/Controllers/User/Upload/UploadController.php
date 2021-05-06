<?php


namespace App\Http\Controllers\User\Upload;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\Upload\XmlFormat;
use App\Http\Controllers\User\Upload\OutputFile;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\Upload\ApiException;
use App\Models\User;
use App\Models\User_Files;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
// 	private static $stMsg = array();
	/*
	 * 0：失敗
	 * 1：成功
	 * 2：なし
	 */
	private $stMsgs = array(
							'status' => '99',
							'msg' => array()
						);
	
	public function __construct()
	{
		$this->middleware('auth:user');
	}
	/**
	 * show_upload
	 * @param Request $request
	 * @return view();
	 */
	public function index()
	{
		$userId = Auth::id();
		$user = User::find(Auth::id());
		
		try {
			//クエリビルダ
			$shop = DB::table('shops')
			->select('id','shop_num', 'shop_api_key', 'updated_at')
			->where('user_id',$userId)
			->get();
			
			
			//ファイル保存の履歴を取得する。
			$userFiles = DB::table('user_files')
				->select('id', 'filepath', 'filename', 'created_at')
				->where('user_id', '=', $userId)
				->Where('app_no', '=', '2')
				->latest('created_at')//作成日時で降順
				->limit(5)
				->get();
			
			
		} catch (Exception $e) {
			$this->stMsgs['status'] = '0';
			$this->stMsgs['msg'][] = strval($e->getCode()) .'：' .$e->getMessage();
		}finally {
			//ステータス
			$stMsgs = $this->stMsgs;
			return view('user.csv_upload', compact('stMsgs', 'user', 'userFiles' ));
		}
	}
	
	/**
	 * csv_upload
	 * CSVアップロードから一行ずつリクエストを送信する。
	 * @param Request $request
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function csv_upload(Request $request)
	{
		/* =======================================================================
		 * 事前準備
		 * ======================================================================= */
		//フォーマット用インスタンスの作成
		$upFormat = new XmlFormat;
		
		//ファイル出力用インスタンスの作成
		$outputFile = new OutputFile;
		
		//ユーザー情報の取得
		$userId = Auth::id();
		$user = User::find(Auth::id());
		
		//ショップ情報の取得
		$shop = DB::table('shops')
			->select('id','shop_num', 'shop_api_key', 'updated_at')
			->where('user_id',$userId)
			->get();
		$shopNum = $shop[0]->shop_num;//会員番号
		$shopApikey = $shop[0]->shop_api_key;//APIキー
		
		
		/* --------------------------------
		 * 過去のアップロードファイルを削除
		 * -------------------------------- */
		//アップロードファイル一時格納先directry名
		$dirPath = '/auPay/' .$shopNum .'/upload/';
		
		//$dirPathフォルダが存在しない場合は作成する。
		if(!Storage::disk('local')->exists($dirPath)){
			//local ディレクトリの作成
			Storage::disk('local')->makeDirectory($dirPath);
		}
		$delItemReqCsv = $dirPath .'itemReq*.csv';
		$delStockReqCsv = $dirPath .'stockReq*.csv';
		
		//item.csvの過去のアップロードファイルが存在するとき
		//if(is_file($delItemReqCsv)){
			//ファイルの削除
			Storage::delete($delItemReqCsv);
		//}
		if(is_file($delStockReqCsv)){
			//ファイルの削除
			Storage::delete($delStockReqCsv);
		}
		
		/* =======================================================================
		 * メイン処理
		 * ======================================================================= */
		try {
			/* -----------------------------------------
			 * ファイルの保存
			 * ----------------------------------------- */
			//ファイル名の作成
			$itemCsv = sprintf('itemReq' .'_%s' .'.csv', date('ymdhis'));
			$stockCsv = sprintf('stockReq' .'_%s' .'.csv', date('ymdhis'));
			
			//item.csvがアップロードされていないとき
			if(null == $request->file('itemCsv')){
				$errMsg = 'FILE001：item.csvをアップロードしてください。';
				
// 				$this->stMsgs['status'] = '0';
// 				$this->stMsgs['msg'][] = $errMsg;
				
				throw new Exception($errMsg);
			}else{
				$file['itemCsv'] = $request->file('itemCsv')->storeAs($dirPath, $itemCsv);
			}
			if(!null == $request->file('stockCsv')){
				$file['stockCsv'] = $request->file('stockCsv')->storeAs($dirPath, $stockCsv);
			}
			
			
			
			/* -----------------------------------------------------
			 * 【エラー】
			 * 　未定義である・複数ファイルである・$_FILES Corruption 攻撃を受けた
			 * 　どれかに該当していれば不正なパラメータとして処理する
			 * ----------------------------------------------------- */
			if (!isset($_FILES['itemCsv']['error']) || !is_int($_FILES['itemCsv']['error'])) {
				$errMsg = 'FILE002：item.csvファイルのパラメータが不正です。';
				
				$this->stMsgs['status'] = '0';
				$this->stMsgs['msg'][] = $errMsg;
				
				throw new Exception($errMsg);
			}
			if (!isset($_FILES['stockCsv']['error']) || !is_int($_FILES['stockCsv']['error'])) {
				$errMsg = 'FILE003：stock.csvファイルのパラメータが不正です。';
				
				$this->stMsgs['status'] = '0';
				$this->stMsgs['msg'][] = $errMsg;
				
				throw new Exception($errMsg);
			}
			
			//ファイルの保存場所の調整。+appを行う。
			$dirPath = 'app' .$dirPath ;
			
			
			/* -----------------------------------------
			 * CSVヘッダーのフォーマットチェック
			 * ----------------------------------------- */
			//headerの配列を作成する。
			$itemHeader = $upFormat->get_csv_header($dirPath, $itemCsv);
			
			if(!null == $request->file('stockCsv')){
				$stockHeader = $upFormat->get_csv_header($dirPath, $stockCsv);
			}
			
			//各種csvヘッダーの必須入力チェック
			$itemHeadChk = $upFormat->check_item_h($itemHeader);
			if(!null == $request->file('stockCsv')){
				$stockHeadChk = $upFormat->check_stock_h($stockHeader);
			}
			
			$statusNum = 0;
			//item.csvのヘッダーの必須項目が不足しているとき
			if(!$itemHeadChk['status']){
				$statusNum ++;
			};
			//stock.csvがアップロードされているとき
			if(!null == $request->file('stockCsv')){
				//stock.csvのヘッダーの必須項目が不足しているとき
				if(!$stockHeadChk['status'] ){
					$statusNum = $statusNum +2;
				}
			};
			
			/* -----------------------------------------------------
			 * 【エラー】
			 * 　必須項目が欠けていた場合
			 * 　　1：item.csvの必須項目が不足
			 * 　　2：stock.csvの必須項目が不足
			 * 　　3：item.csvとstock.csvの両方で必須校の項目が不足
			 * ----------------------------------------------------- */
			if($statusNum == 1){
				$errMsg = 'DATA003：item.csvの必須項目が不足しています。';
				
				$this->stMsgs['status'] = '0';
				$this->stMsgs['msg'][] = $errMsg;
				
				throw new Exception($errMsg);
			}elseif($statusNum == 2){
				$errMsg = 'DATA004：stock.csvの必須項目が不足しています。';
				
				$this->stMsgs['status'] = '0';
				$this->stMsgs['msg'][] = $errMsg;
				
				throw new Exception($errMsg);
				
			}elseif($statusNum == 3){
				$errMsg = 'DATA005：item.csvとstock.csvの両方で必須項目が不足しています。';
				
				throw new Exception($errMsg);
			};
			
			
			
			/* -----------------------------------------
			 * 各種CSVファイルのボディをフォーマット
			 * ----------------------------------------- */
			$itemArys = $upFormat->csv_ary($dirPath, $itemCsv);
			if(!null == $request->file('stockCsv')){
				$stockArys = $upFormat->csv_ary($dirPath, $stockCsv);
			}
			
			/* ------------------------------------------------------------------
			 * item.csv（$itemArys）のレコード数だけ繰り返し。リクエストを送信する。
			 * ------------------------------------------------------------------ */
			for( $cntI = 0; $cntI < count($itemArys); $cntI++){
				/* ----------------------------------------------
				 * stockSegment='2'（在庫区分=選択肢在庫）のとき
				 * ---------------------------------------------- */
				if(($itemArys[$cntI]['stockSegment'] === '2') && isset($stockArys) ){
					$stockReArys = array();
					
					//$stockArysの数だけ繰り返す
					for( $cntJ = 0; $cntJ < count($stockArys); $cntJ++){
						/* ------------------------------------------------------------
						 * stockArysの内itemarys[i]と同じitemCodeを持つ要素のみ再格納する
						 * ------------------------------------------------------------ */
						if($itemArys[$cntI]['itemCode'] === $stockArys[$cntJ]['itemCode']){
							$stockReArys[] = $stockArys[$cntJ];
						}
						
						/* ------------------------------------------------------
						 * 【エラー】
						 * 　stockArys繰り返し最終行にて$stockReAryが存在しない場合
						 * ------------------------------------------------------ */
						if( empty($stockReArys) && ($cntJ === count($stockArys) - 1) ){
							$errMsg = 'DATA001：item.csvの商品コード「' .$itemArys[$cntI]['itemCode'] ."」にて、選択肢別在庫（stockSegment='2'）にもかかわらず、
									stock.csvに商品コード「" .$itemArys[$cntI]['itemCode'] ."」のデータが存在しません。";
							
							$this->stMsgs['status'] = '0';
							$this->stMsgs['msg'][] = $errMsg;
							
							throw new Exception($errMsg);
							
						/* --------------------------------------------------------------------------
						 * stock.csv繰り返し最終行にて$stockReAryが存在する場合、XMLボディを作成する。
						 * -------------------------------------------------------------------------- */
						}elseif( isset($stockReArys['0']) && ($cntJ === count($stockArys) - 1)){
							$xmlBody = $upFormat->req_body($shopNum, $itemArys[$cntI], $stockReArys);
						}
						
					}//END：item.csvとstock.csvで共通の商品コード数だけ繰り返す
					
					/* ---------------------------------------------------------------------
					 * 【エラー】
					 * 　stockSegment='2'（在庫区分=選択肢在庫）でstock.csvが存在しないとき。
					 * --------------------------------------------------------------------- */
					if(!isset($stockArys)){
						$errMsg = 'DATA002：item.csvの商品コード「' .$itemArys[$cntI]['itemCode']
									."」にて、選択肢別在庫（stockSegment='2'）にも関わらず、stock.csvがアップロードされていません。";
					
						$this->stMsgs['status'] = '0';
						$this->stMsgs['msg'][] = $errMsg;
						
						throw new Exception($errMsg);
					}
					
				/* -----------------------------------------------------
				 * stockSegment='1'（在庫区分=通常在庫）のとき、XMLボディを作成する。
				 * ----------------------------------------------------- */
				}elseif($itemArys[$cntI]['stockSegment'] === '1'){
					$xmlBody = $upFormat->req_body($shopNum, $itemArys[$cntI]);
				}
				
				/* =====================================================
				 * API通信
				 * stockSegment='1'（在庫区分=通常在庫）のとき
				 * ===================================================== */
				//APIリクエストの送信
				$apiResponse = $this->api_connect($shopApikey, $xmlBody);
				
				
				/* ---------------------------------------------------------------------
				 * resopnseをitemAry['result'],stockAry['result']として配列の末尾に格納
				 * --------------------------------------------------------------------- */
				//ステータス = 0：成功のとき
				if( $apiResponse['result']['status'] == '0' ){
					$itemArys[$cntI]['result'] = '0：商品登録成功';
					
				//ステータス = 1：失敗のとき
				}elseif($apiResponse['result']['status'] == '1' ){
					$itemArys[$cntI]['result'] = $apiResponse['registerResult']['error']['code']
												.'：' .$apiResponse['registerResult']['error']['message'];
				}
				
			}//END：item.csv繰り返し終了。
		
			/* -----------------------------------------------------
			 * responseをファイルへの書き込む。
			 * ----------------------------------------------------- */
			//itemFileNameの作成
			$itemFileName = $dirPath .'itemRes';
			$itemFileName = sprintf($itemFileName .'_%s' .'.csv', date('ymd_his'));
			
			//ヘッダーの取得
// 			$header = $aupayformat->get_aupay_Header();
			foreach ($itemArys[0] as $key => $value) {
				$header[] = $key;
			}
			
			//文字コード変換（SISJIS → UTF8）
			$header = $outputFile->convert_sjis($header);
			
			//ヘッダーをcsvに出力
			$outputFile->out_file($itemFileName, $header);
			
			//値をcsvに出力
			foreach ($itemArys as $itemAry) {
				
				//文字コード変換（SIS-JIS→UTF8）
				$itemAry = $outputFile->convert_utf8($itemAry);
				
				//ファイルへの書き込み
				$outputFile->out_file($itemFileName, $itemAry);
			}
			
			/*
			 * CSVの格納先をDBへ保存する。
			 */
			$userFiles = new User_files;//user_filesモデルのインスタンス化
			
			//ファイルパスからapp/auPay/を除く
			$filepath = str_replace('app/auPay/', '', $itemFileName );
			$userFiles->filepath = $filepath;
			
			//ファイル名のみ抽出
			$filename = basename($filepath);
			
			//DBへ保存
			$userFiles->filename = $filename;
			$userFiles->app_no = 2;//app_no
			$userFiles->user_id = $userId;
			$userFiles->save();
			
			/* --------------------------------------------------------
			 * ファイル保存の履歴を取得する。
			 * item.csvとstock.csv(result追記版)のファイル格納場所を取得
			 * -------------------------------------------------------- */
			$userFiles = DB::table('user_files')
    			->select('id', 'filepath', 'filename', 'created_at')
    			->where('user_id', '=', $userId)
    			->Where('app_no', '=', '2')
    			->latest('created_at')//作成日時で降順
    			->limit(5)
    			->get();
			
		
		} catch (ApiException $e) {
			$this->stMsgs['status'] = '0';
			$this->stMsgs['msg'][] = $e->getMessage();
			
// 		} catch (DataException $e) {
// 			$this->stMsgs['status'] = '0';
// 			$this->stMsgs['msg'][] = $e->getMessage();
		} catch (Exception $e) {
			$this->stMsgs['status'] = '0';
			$this->stMsgs['msg'][] = $e->getMessage();
			
		}finally {
			
			$stMsgs = $this->stMsgs;//メッセージの取得
			return view('user.aupay.csv_upload', compact('stMsgs', 'user', 'userFiles' ));
		}
	}
	
	/**
	 * api_connect
	 * リクエスト送信してAPI通信を行う。
	 * @param $shopApiKey
	 * @param $xmlBody
	 * @return $response
	 */
	public function api_connect(String $shopApiKey, $xmlBody){
		//エンドポイントの作成
		$base_url = config('const.Au_pay.BASE_URL') .'/' .config('const.Au_pay.registerItemInfo') ;
		
		//リクエストヘッダの取得
		$headers = $this->get_headers($shopApiKey);
		
		//オプションの取得
		$options = $this->get_options($base_url, $xmlBody , $headers);
		
		//リクエストを送信
		$response = $this->send_http_request($options);
		
		//xml変換のエラーを解消する
		$response = preg_replace('/[\x00-\x1f]/', '', $response);
		
		//simplexml_load_stringのerror出力ON設定
		libxml_use_internal_errors(true);
		
		// xmlレスポンスを配列に変換する
		$resArray = simplexml_load_string($response);//xmlをjsonに変換する。
		if (!$resArray) {
			echo "Failed loading XML\n";
			foreach(libxml_get_errors() as $error) {
				echo "\t", $error->message;
			}
		}
		$response = json_decode(json_encode($resArray), true);//jsonを配列へ変換する。
		
// 		dd($response);

		return $response;
	}
	
	
	/**
	 * send_http_request
	 * リクエストを送信する。
	 * @param Array $option
	 */
	private function send_http_request($options){
		
		$curl = curl_init();
		curl_setopt_array($curl, $options);
		$response = curl_exec($curl);//レスポンスの取得
		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);// ステータスコード取得
		curl_close($curl);//curl終了
		
		/* -----------------------------------------------------------
		 * 【エラー】
		 * 400以上のステータスコードが返却されたとき
		 * ----------------------------------------------------------- */
		if(strVal($code) >= 400){
			$errMsg = strval($code);
			throw new ApiException($errMsg);
		}
		
		return $response;
	}
	
	/**
	 * get_headers
	 * パラメータヘッダの作成
	 * @param  String  $shop_api_key
	 * @return Array $headers
	 */
	private function get_headers(String $shop_api_key){
		$headers = array(
			"HTTP/1.0",
			"Content-Type:application/xml; charset=utf-8",
			"Authorization:Bearer " .$shop_api_key,
		);
		return $headers;
	}
	
	/**
	 * get_options
	 * オプションの作成
	 * @param  String  $base_url
	 * @param  String  $params
	 */
	protected function get_options($base_url, $data, $headers){
		$options = [
			CURLOPT_URL             => $base_url,
			CURLOPT_CUSTOMREQUEST   => 'POST',//メソッドの指定
			CURLOPT_SSL_VERIFYPEER  => false,// 証明書の検証を行わない
			CURLOPT_RETURNTRANSFER  => true,//実行結果を文字列で返す。
			CURLOPT_FAILONERROR     => false,
			CURLOPT_POSTFIELDS      => $data,
			CURLOPT_HTTPHEADER      => $headers,//headerに値をセット
		];
		return $options;
	}
	
	/**
	 * csv_download()
	 * idをもとにファイルをViewへ返却する。
	 * @param $id //ファイルID
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function result_download($id)
	{
		//ユーザーIDの取得
		$userId = Auth::id();
		
		//ファイル保存の履歴を取得する。
		$userFiles = DB::table('user_files')
			->select('filepath')
			->Where('id', '=', $id)
			->where('user_id', '=', $userId)
			->Where('app_no', '=', '2')
			->get();
		// 		dd($userFiles);
		
		$filepath = $userFiles[0]->filepath;
		
		//すでに存在するpublicのファイルを削除する。
		Storage::disk('public')->delete($filepath);
		
		//ファイルをlocal→publicへコピーする
		// 		Storage::disk('local')->copy('auPay/' .$filepath, 'app/public/' .$filepath);
		
		//ファイルをlocal→publicへコピーする
		Storage::disk('local')->copy('auPay/' .$filepath, 'public/' .$filepath);
		
		return Storage::disk('local')->download('public/' .$filepath);
	}
	
}
