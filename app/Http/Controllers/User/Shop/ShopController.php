<?php

namespace App\Http\Controllers\User\Shop;

use Exception;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OutputFile;
// use App\Http\Controllers\User\Au_pay\XmlFormat;
// use App\Http\Controllers\User\Au_pay\AupayApi;
// use App\Http\Controllers\User\Au_pay\auPayFormat;
use App\Http\Controllers\User\Shop\Store_shop_validation;
use App\Models\Shop;
use App\Models\User;
use App\Models\User_Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
	//au Payマーケット用のアプリNo
	private const APP_NO = 10;
	
	//View用ステータスメッセージ
	private $stMsgs = array(
		'status' => '1',//成功
		'msg' => array()
	);
	
	
	public function __construct()
	{
		$this->middleware('auth:user');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$userId = Auth::id();
		$user = User::find(Auth::id());
		
		try {
			//クエリビルダ
			$shop = DB::table('shops')
			->select('id','shop_num', 'shop_api_key', 'created_at', 'updated_at')
				->where('user_id',$userId)
				->get();
		} catch (Exception $e) {
			$this->stMsgs['status'] = '0';//失敗
			$this->stMsgs['msg'][0] = $e->getCode() .'：' .$e->getMessage();
			
		}finally {
			$stMsgs = $this->stMsgs;
			return view('user.shop', compact('stMsgs', 'user' , 'shop'));
		}
	}
	
	/**
	 * store_shop
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store_shop(Store_shop_validation $request)
	{
	    var_dump($request->input('shop_num'));
	    try {
	        //ログイン中のユーザー情報の取得
	        $userId = Auth::id();
	        $user = User::find($userId);
	        
	        //shopの登録
	        $shop = new Shop;
	        $shop->user_id = $userId;
	        $shop->shop_num = $request->input('shop_num');
	        $shop->shop_api_key = $request->input('shop_api_key');
	        
	        $shop->save();
	        
	        //ショップ情報の取得
	        $shop = DB::table('shops')
    	        ->select('id','shop_num', 'shop_api_key', 'updated_at')
    	        ->where('user_id',$userId)
    	        ->get();
	        
	        var_dump($userId);
	    } catch (Exception $e) {
	        $this->stMsgs['status'] = '0';//失敗
	        $this->stMsgs['msg'] = $e->getCode() ;
	        $this->stMsgs['msg'] = $e->getMessage();
	    }finally {
	        // 		return redirect('user/shop/home');
	        $stMsgs = $this->stMsgs;//メッセージの取得
	        
	        // 			dd($stMsgs);
	        return redirect('user/shop/index');
// 	        return view('user.shop.shop', compact('stMsgs', 'user' , 'shop'  ));
	    }
	}


	/**
	 * update_shop
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	// public function update_shop(Store_shop_validation $request, $id)
	public function update_shop(Request $request, $id)
	{
		$shopNum = $request->input('shop_num');
		$shopApikey = $request->input('shop_api_key');
		

		$validatedData = $request->validate([
			'shop_num' => [
				'required',
				'numeric',
				'digits:8',
				'unique:shops'
			],
			'shop_api_key' => [
				'required',
				'alpha_num'
			]
		]);

		$shop = Shop::find($id);
	
		$shop->shop_num = $request->input('shop_num');
		$shop->shop_api_key = $request->input('shop_api_key');
		$shop->save();
		
		return redirect('user/shop/index');
	}

	/* ------------------------------------------------------------
	 * API通信
	 * check API
	 * ------------------------------------------------------------ */
	/**
	//  * check api 店舗情報が正しいか確認する。
	//  * @param  \Illuminate\Http\Request  $request
	//  * @param  int  $id
	//  * @return \Illuminate\Http\Response
	//  */
	// public function check_api()
	// {
	// 	$user = User::find(Auth::id());
		
	// 	//ログインユーザーのIDからショップ情報の取得
	// 	$user_id = Auth::id();
		
	// 	//ショップ情報を取得
	// 	$shop = DB::table('shops')
	// 		->select('id','shop_num', 'shop_api_key', 'updated_at')
	// 		->where('user_id',$user_id)
	// 		->get();
		
	// 	//API連携を利用して商品情報(複数)の取得
	// 	$AupayApi = new AupayApi;
		
	// 	try {
			
	// 		$result = $AupayApi->searchItems($shop[0]->shop_num, $shop[0]->shop_api_key);
	// 		if($result['result']['status'] == '0'){
	// 			$result_status[] = '0';
	// 			$result_status[] = '通信成功';
	// 		}elseif($result['result']['status'] == '1'){
	// 			$result_status[] = '1';
	// 			$result_status[] = $result['result']['error']['code'] .'：' .$result['result']['error']['message'] ;
				
	// 		}else{
	// 			$result_status[] = '2';
	// 			$result_status[] = '通信エラー：せぬエラーが発生しました。';
	// 		}
			
	// 	} catch (Exception $e) {
	// 		$result_status[] = '5';
	// 		$result_status[] = $e->getMessage() ;
	// 	}finally {
	// 		if(!isset($result_status)){
	// 			$result_status[] = '2';
	// 			$result_status[] = '想定外のエラー：システム担当に問い合わせください。';
	// 		}
	// 		return view('user.aupay.edit_shop', compact('user', 'shop', 'result_status'));
	// 	}
	// }

	/** ************************************************************************************
	 * CSV download
	 * au Pay CSV一括ダウンロード
	 *
	 * *************************************************************************************
	 */
	/**
	 * show_csv_download
	 * @return
	 */
	public function show_csv_download()
	{
		$userId = Auth::id();
		$user = User::find(Auth::id());
		$stMsgs = array();//メーセージの初期化
		
		try {
			
			//ファイル保存の履歴を取得する。
			$userFiles = DB::table('user_files')
				->select('id', 'filepath', 'filename', 'created_at')
				->where('user_id', '=', $userId)
				->Where('app_no', '=', '1')
				->latest('created_at')//作成日時で降順
				->limit(5)
				->get();
			
		} catch (Exception $e) {
			$stMsgs[] = $e->getCode() .'<br>' .$e->getMessage();
		}finally {
			return view('user.aupay.csv_download', compact('stMsgs', 'user' , 'userFiles' ));
		}
	}
	
	/**
	 * csv_create()
	 * @param Request request
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function csv_create(Request $request)
	{
		//inputの格納
// 		$totalCount = $request->input('totalCount');//取得件数
		
		$stMsgs[] = array();//メッセージの初期化
		$user = User::find(Auth::id());//ログインユーザー情報の取得
		$userId = Auth::id();//ユーザーIDの取得
		
		//ショップ情報を取得
		$shop = DB::table('shops')
			->select('id','shop_num', 'shop_api_key', 'updated_at')
			->where('user_id', $userId)
			->get();
		$shopNum = $shop[0]->shop_num;//会員番号	
		$shopApikey = $shop[0]->shop_api_key;//APIキー
		
		//インスタンスの生成
		$aupayformat = new AupayFormat();//aupat用のデータフォーマット
		$aupayApi = new AupayApi($shopNum, $shopApikey);//API通信インスタンス
		$outputFile = new OutputFile();//ファイル出力インスタンス
		$xmlFormat = new XmlFormat();//ファイル出力インスタンス
		
		$dirPath = '/auPay/' .$shopNum .'/download';//directry名
		
		//directoryの存在チェック
		if(!Storage::disk('local')->exists($dirPath)){
			//Strageのデフォルトは'loacal' => 'app'
			//local ディレクトリの作成
			Storage::disk('local')->makeDirectory($dirPath);
		}
		if(!Storage::disk('local')->exists($dirPath)){
			//public ディレクトリの作成
			Storage::disk('public')->makeDirectory($dirPath);
		}
		$dirPath = 'app' .$dirPath;
		
		try {
			/* ----------------------------------------
			 * aupayAPI通信により最大取得件数を取得する。
			 * ---------------------------------------- */
			$response = $aupayApi->search_items('1', '1');
			
			/* ----------------------------------------
			 * XMLを配列へ変換する
			 * ---------------------------------------- */
			$response = $xmlFormat->xml_format($response);
			
			//au Pay API接続に成功した場合
			if($response['result']['status'] == '0'){
				//ステータスの格納
				$stMsgs[] = 'データの取得に成功しました。';
				
				//最大取得件数の格納
				$MaxCount = $response['searchResult']['maxCount'];
				$MaxCount = intval($MaxCount);//キャスト（文字列→数値）
			
				/* ----------------------------------------
				 * aupayAPI通信によりレスポンスを取得する
				 * ---------------------------------------- */
				//最大取得件数が存在する場合
				if(isset($MaxCount)){
					if( $MaxCount < 500 ){
						$response = $aupayApi->search_items('1', '1');
					}elseif ($MaxCount >= 500){
						$response = $aupayApi->search_items('1', '500');
					}
					
					/* ----------------------------------------
					 * XMLを配列へ変換する
					 * ---------------------------------------- */
					$response = $xmlFormat->xml_format($response);
					
					/* ----------------------------------------
					 * ファイルへの書き込み
					 * ---------------------------------------- */
					
					//filenameの作成
					$filename = $dirPath .'/item';
					$filename = sprintf($filename .'_%s' .'.csv', date('ymd_his'));
					
					//ヘッダーの取得
					$header = $aupayformat->get_aupay_Header();
					
					//文字コード変換（SIS-JIS→UTF8）
					$header = $outputFile->convert_utf8($header);
					
					//aupayヘッダーをCSVに書き込む
					$outputFile->out_file($filename, $header);
					
					foreach ($response['searchResult']['resultItems'] as $line) {
						//1アイテム分の配列をaupay用のCSVフォーマットに変換
						$aupayAry = $aupayformat->format_searchitems($line);
						
						//文字コード変換（SIS-JIS→UTF8）
						$aupayAry = $outputFile->convert_utf8($aupayAry);
						
						//ファイルへの書き込み
						$outputFile->out_file($filename, $aupayAry);
					}
					//1アイテム分の配列をaupay用のCSVフォーマットに変換
		// 			$aupayAry = $aupayformat->format_searchitems($response['searchResult']['resultItems']);
					
					//CSVの格納先をDBへ保存する。
					$userFiles = new User_files;
					//ファイルパスからappを除く
					$filepath = str_replace('app/auPay/', '', $filename );
					$userFiles->filepath = $filepath;
					
					//ファイル名のみ抽出
					$filename = basename($filepath);
					$userFiles->filename = $filename;
					$userFiles->app_no = 1;
					$userFiles->user_id = $userId;
					$userFiles->save();
				}
				
			/* ------------------------------------
			 * Au pay APIへの接続に失敗した場合
			 * ------------------------------------ */
			}elseif($response['result']['status'] == '1'){
				//ステータスの格納
				$stMsgs[] = $response['result']['error']['code'] .'：' .$response['result']['error']['message'];
			}
			
		} catch (Exception $e) {
			$stMsgs[] = $e->getMessage();
		} catch (ApiException $e) {
			$stMsgs[] = $e->getMessage() .'<br>' .$e->getCode() .'<br>' .$e->getFile() .'<br>' .$e->getLine();
			
		}finally {
			//ファイル保存の履歴を取得する。
			$userFiles = DB::table('user_files')
				->select('id', 'filepath', 'filename', 'created_at')
				->where('user_id', '=', $userId)
				->Where('app_no', '=', '1')
				->latest('created_at')//作成日時で降順
				->limit(5)
				->get();
// 			dd($userFiles);
			
// 			$filesData = array();
// 			foreach($userFiles as $value){
				
// 				array_push($filesData, array(
// 						'filepath' => $value->items[0]['filename'],
// 						'created_at' => $value->items[0]['created_at'],
// 					)
// 				);
// 			}
			
// 			$userFiles = array(
// 				'filepath' => $userFiles->items[0]['filename'],
// 				'created_at' => $userFiles->items[0]['created_at'],
// 			);
			return view('user.aupay.csv_download', compact('stMsgs', 'user' , 'userFiles' ));
		}
	}
	
	/**
	 * csv_download()
	 * idをもとにファイルをViewへ返却する。
	 * @param $id //ファイルID
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function csv_download($id)
	{
		//ユーザーIDの取得
		$userId = Auth::id();
		
		//ファイル保存の履歴を取得する。
		$userFiles = DB::table('user_files')
			->select('filepath')
			->Where('id', '=', $id)
			->where('user_id', '=', $userId)
			->Where('app_no', '=', '1')
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
