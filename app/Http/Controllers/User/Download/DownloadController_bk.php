<?php

namespace App\Http\Controllers\User\Download;

use Exception;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\Download\Format;
use App\Http\Controllers\User\Download\AupayApi;
use App\Http\Controllers\User\Download\OutputFile;
use App\Http\Requests\User\Au_pay_store_validation;
use App\Http\Requests\User\Au_pay_update_validation;
use App\Models\Shop;
use App\Models\User;
use App\Models\User_Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DownloadController extends Controller
{
	//au Payマーケット用のアプリNo
	private const APP_NO = '1';
	
	private $stMsgs = array(
		'status' => '99',
		'msg' => array()
	);

	public function __construct()
	{
		$this->middleware('auth:user');
	}
	
	/** ************************************************************************************
	 * CSV download
	 * au Pay CSV一括ダウンロード
	 *
	 * *************************************************************************************
	 */

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
				->select('id','shop_num', 'shop_api_key', 'updated_at')
				->where('user_id',$userId)
				->get();

			//ファイル保存の履歴を取得する。
			$userFiles = DB::table('user_files')
					->select('id', 'filepath', 'filename', 'created_at')
					->where('user_id', '=', $userId)
					->Where('app_no', '=', self::APP_NO)
					->latest('created_at')//作成日時で降順
					->limit(5)
					->get();

		} catch (Exception $e) {
			$this->stMsgs['status'] = '0';
			$this->stMsgs['msg'][] = strval($e->getCode()) .'：' .$e->getMessage();
		}finally {
			//ステータス
			$stMsgs = $this->stMsgs;
			return view('user.csv_download', compact('stMsgs', 'user' , 'shop' ,'userFiles'));
		}
	}

	
	/**
	 * csv_download()
	 * @param Request request
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function csv_download(Request $request)
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
		$format = new Format();//aupay用のデータフォーマット
		$apiConnect = new ApiConnect(strval($shopNum), $shopApikey);//API通信インスタンス
		$outputFile = new OutputFile();//ファイル出力インスタンス
		
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
			$response = $apiConnect->search_items();
			

			/* ----------------------------------------
			 * XMLを配列へ変換する
			 * ---------------------------------------- */
			$response = $format->xml_format($response);
		

			//auPay API接続に成功した場合
			if($response['result']['status'] == '0'){
				
				//最大取得件数の格納
				$MaxCount = $response['searchResult']['maxCount'];
				$MaxCount = intval($MaxCount);//キャスト（文字列→数値）
			

				/* ----------------------------------------
				 * auPay API通信によりレスポンスを取得する
				 * ---------------------------------------- */
				//最大取得件数が存在する場合
				if(isset($MaxCount)){
					//最大取得件数
					if( $MaxCount < 500 ){
						$response = $apiConnect->search_items('1', $MaxCount);
					}elseif ($MaxCount >= 500){
						$response = $apiConnect->search_items('1', '500');
					}
					
					/* ----------------------------------------
					 * XMLを配列へ変換する
					 * ---------------------------------------- */
					$response = $format->xml_format($response);
					

					/* ----------------------------------------
					 * ファイルへの書き込み
					 * ---------------------------------------- */
					$filename = $dirPath .'/item';
					$filename = sprintf($filename .'_%s' .'.csv', date('ymd_his'));//filenameの作成
					
					//ヘッダーの取得
					$header = $format->get_aupay_Header();
					
					//文字コード変換（SIS-JIS→UTF8）
					$header = $outputFile->convert_utf8($header);
					
					//aupayヘッダーをCSVに書き込む
					$outputFile->out_file($filename, $header);
					
					foreach ($response['searchResult']['resultItems'] as $line) {
						//1アイテム分の配列をaupay用のCSVフォーマットに変換
						$aupayAry = $format->format_searchitems($line);
						
						//文字コード変換（SIS-JIS→UTF8）
						$aupayAry = $outputFile->convert_utf8($aupayAry);
						
						//ファイルへの書き込み
						$outputFile->out_file($filename, $aupayAry);
					}

					//CSVの格納先をDBへ保存する。
					$userFiles = new User_files;

					//ファイルパスからappを除く
					$filepath = str_replace('app/auPay/', '', $filename );
					$userFiles->filepath = $filepath;
					
					//ファイル名のみ抽出
					$filename = basename($filepath);
					$userFiles->filename = $filename;
					$userFiles->app_no = self::APP_NO;
					$userFiles->user_id = $userId;
					$userFiles->save();
				}
				
				//ステータス
				$this->stMsgs['status'] = '1';
				$this->stMsgs['msg'][] = 'データの取得に成功しました。';

			/* ------------------------------------
			 * Au pay APIへの接続に失敗した場合
			 * ------------------------------------ */
			}elseif($response['result']['status'] == '1'){
				//ステータスの格納
				$this->stMsgs['status'] = '0';
				$this->stMsgs['msg'][] = $response['result']['error']['code'] .'：' .$response['result']['error']['message'];
			}
			
		}catch (Exception $e) {
			$this->stMsgs['status'] = '0';
			$this->stMsgs['msg'][] = strval($e->getCode()) .'：' .$e->getMessage();
			echo 'Exception<br>';
		}finally {
			//ステータス
			$stMsgs = $this->stMsgs;

			//ファイル保存の履歴を取得する。
			$userFiles = DB::table('user_files')
					->select('id', 'filepath', 'filename', 'created_at')
					->where('user_id', '=', $userId)
					->Where('app_no', '=', self::APP_NO)
					->latest('created_at')//作成日時で降順
					->limit(5)
					->get();

			return view('user.csv_download', compact('stMsgs', 'user' , 'userFiles' ));
		}
	}
	
	/**
	 * result_download()
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
				->select('id', 'filepath', 'filename', 'created_at')
				->where('user_id', '=', $userId)
				->Where('app_no', '=', self::APP_NO)
				->latest('created_at')//作成日時で降順
				->limit(5)
				->get();
				
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
