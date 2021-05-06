<?php

namespace App\Http\Controllers\User\Au_pay;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\Au_pay\aupayUploadFormat;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ApiException;
use App\Http\Controllers\OutputFile;
use App\Http\Controllers\User\Au_pay\XmlFormat;
use App\Models\Shop;
use App\Models\User;
use App\Models\User_Files;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Constraint;

class CsvUploadController extends Controller
{
// 	private static $stMsg = array();
	
	public function __construct()
	{
		$this->middleware('auth:user');
	}
	
	
	private $header;//フォーマットヘッダー
	
	/** 
	 * show_csv_upload
	 * @param Request $request
	 * @return view();
	 */
	public function show_csv_upload()
	{
		$stMsgs = array();
		
		$userId = Auth::id();
		$user = User::find(Auth::id());
		
		//ショップ情報の取得
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
		
		
		return view('user.aupay.csv_upload', compact('stMsgs', 'user' , 'userFiles' ));
	}
	
	/**
	 * csv_upload
	 * CSVアップロードから一行ずつリクエストを送信する。
	 * @param Request $request
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function csv_upload(Request $request)
	{
		
		/* -----------------------------------------
		 * 事前準備
		 * ----------------------------------------- */
		$stMsgs = array();//メッセージの初期化
		
		//フォーマット用インスタンスの作成
		$upFormat = new aupayUploadFormat;
		
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
		
		//ファイル保存の履歴を取得する。
		$userFiles = DB::table('user_files')
			->select('id', 'filepath', 'filename', 'created_at')
			->where('user_id', '=', $userId)
			->Where('app_no', '=', '2')
			->latest('created_at')//作成日時で降順
			->limit(5)
			->get();
		
		
		/* -----------------------------------------
		 * ファイルの保存
		 * ----------------------------------------- */
		//directry名
		// \storage\app\auPay\会員番号\upload
		$dirPath = '/auPay/' .$shopNum .'/upload';
		
		//directoryふが存在しない場合は作成する。
		if(!Storage::disk('local')->exists($dirPath)){
			//local ディレクトリの作成
			Storage::disk('local')->makeDirectory($dirPath);
		}
		
		//ファイル名の作成
		$itemCsv = sprintf('item' .'_%s' .'.csv', date('ymdhis'));
		$stockCsv = sprintf('stock' .'_%s' .'.csv', date('ymdhis'));
		
		//ファイルの保存
		try {
			$file['itemCsv'] = $request->file('itemCsv')->storeAs($dirPath, $itemCsv);
 			$file['stockCsv'] = $request->file('stockCsv')->storeAs($dirPath, $stockCsv);
		} catch (Exception $e) {
			$stMsgs[] = $e->getMessage();
		}
// 		}finally {
// 			return view('user.aupay.csv_upload', compact('stMsg', 'user', 'file' ));
// 		}
		
		/* ------------------------------------------
		 * ファイルの保存場所の調整。+appを行う。
		 * ----------------------------------------- */
		$dirPath = 'app/auPay/' .$shopNum .'/upload' .'/';


		/* -----------------------------------------
		 * CSVヘッダーのフォーマットチェック
		 * ----------------------------------------- */
		//headerの配列を作成する。
		$itemHeader = $upFormat->get_csv_header($dirPath, $itemCsv);
		$stockHeader = $upFormat->get_csv_header($dirPath, $stockCsv);
		
		//各種CSVファイルのヘッダーのフォーマットのチェック
		$itemHeadChk = $upFormat->check_Item_Header($itemHeader);
		$stockHeadChk = $upFormat->check_Stock_Header($stockHeader);
		
		if(!$itemHeadChk){
			$stMsgs[] = 'item.csvのヘッダーが、フォーマットと一致しません。';
		}
		if(!$stockHeadChk){
			$stMsgs[] = 'stock.csvのヘッダーが、フォーマットと一致しません。';
		}
		//item,stock.csvがフォーマットと不一致の場合
		if(!$itemHeadChk || !$stockHeadChk){
			return view('user.aupay.csv_upload', compact('stMsgs', 'user', 'userFiles' ));
		}
		
		
		/* -----------------------------------------
		 * 各種CSVファイルのボディをフォーマット
		 * ----------------------------------------- */
		$itemArys = $upFormat->csv_ary($dirPath, $itemCsv);
		$stockArys = $upFormat->csv_ary($dirPath, $stockCsv);


		/* --------------------------------------------------
		 * item.csvのレコード数だけリクエストを送信する。
		 * -------------------------------------------------- */
		for( $cntI = 0; $cntI < count($itemArys); $cntI++){
			/* ----------------------------------------------
			 * stockSegment='2'（在庫区分=選択肢在庫）のとき
			 * ---------------------------------------------- */
			if(($itemArys[$cntI]['stockSegment'] === '2') && isset($stockArys) ){
				$stockReArys = array();
				
				//stock.csvの数だけ繰り返す
				for( $cntJ = 0; $cntJ < count($stockArys); $cntJ++){
					/* ------------------------------------------------------------
					 * stock.csvのうちitemarys[i]と同じitemCodeを持つものは再格納する
					 * ------------------------------------------------------------ */
					if($itemArys[$cntI]['itemCode'] === $stockArys[$cntJ]['itemCode']){
						$stockReArys[] = $stockArys[$cntJ];
					}

					
					/* ------------------------------------------------------
					 * stock.csv繰り返し最終行にて$stockReAryが存在しない場合
					 * ------------------------------------------------------ */
					if( empty($stockReArys) && ($cntJ === count($stockArys) - 1) ){
						//エラー処理
						$itemArys[$cntI][] = '商品コード：' .$itemArys[$cntI]['itemCode']
										."にて、選択肢別在庫（stockSegment='2'）にもかかわらず、一致するstock.csv行が存在しません。";
						$stMsgs[]  = '商品コード：' .$itemArys[$cntI]['itemCode'] 
								."にて、選択肢別在庫（stockSegment='2'）にもかかわらず、一致するstock.csv行が存在しません。<br>";


					/* -----------------------------------------------------
					 * stock.csv繰り返し最終行にて$stockReAryが存在する場合
					 * ----------------------------------------------------- */
					}elseif( isset($stockReArys['0']) && ($cntJ === count($stockArys) - 1)){
						//XMLボディを作成する。
						$xmlBody = $upFormat->choices_stock_req($shopNum, $itemArys[$cntI], $stockReArys);
						
						//APIリクエストの送信
						$response = $this->api_connect($shopApikey, $xmlBody);
					}
				}//stock.csvの数だけ繰り返す
				
				
			/* ------------------------------------------------------------------
			 * stockSegment='2'（在庫区分=選択肢在庫）でstock.csvが存在しないとき。
			 * ------------------------------------------------------------------ */
			}elseif(($itemArys[$cntI]['stockSegment'] === '2') && !isset($stockArys) ){
				$stMsgs[]  = '商品コード：' .$itemArys[$cntI]['itemCode']
							."にて、選択肢別在庫（stockSegment='2'）でstock.csvデータが存在しません。";
		
			
			/* -----------------------------------------------------
			 * stockSegment='1'（在庫区分=通常在庫）のとき
			 * ----------------------------------------------------- */
			}elseif($itemArys[$cntI]['stockSegment'] === '1'){
				$xmlBody = $upFormat->choices_stock_req($shopNum, $itemArys[$cntI]);
				
				//APIリクエストの送信
				$response = $this->api_connect($shopApikey, $xmlBody);
			}
		}
		return view('user.aupay.csv_upload', compact('$stMsgs', 'user', 'userFiles' ,'response'));
	}
	
	/**
	 * api_connect
	 * リクエスト送信してAPIうう心を行う。
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
		$response = $this->SendHttpReq($options);
		
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
	 * SendHttpReq
	 * リクエストを送信する。
	 * @param Array $option
	 */
	private function SendHttpReq($options){
		
		$curl = curl_init();
		curl_setopt_array($curl, $options);
		$response = curl_exec($curl);//レスポンスの取得
		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);// ステータスコード取得
		echo $code;
		curl_close($curl);//curl終了
		
		return $response;
	}
	
	/**
	 * getReqParam
	 * リクエストパラメータの作成
	 * @param  String  $shop_no
	 * @param  String  $totalCount
	 * @param  String  $startCount
	 */
	private function getReqParam(String $shop_no, String $startCount = '1', String $totalCount = '2'){
		$params = [
			'shopId' => $shop_no,
			'startCount' => $startCount,
			'totalCount' => $totalCount,
		];
		return $params;
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
	
	
}
