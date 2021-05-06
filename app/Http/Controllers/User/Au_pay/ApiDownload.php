<?php

namespace App\Http\Controllers\User\Au_pay;


use App\Http\Controllers\Controller;
use App\Http\Controllers\User\Au_pay\auPayFormat;
use Facade\FlareClient\Api;

class ApiDownload
{
	
	private $csvFilePath;
	//private Int $csvFileCnt = 0;
	private Int $maxCount;
	private auPayFormat $auPayFormat;
// 	private CsvController $CsvController;
	
	
	
	public function __construct()
	{
		$this->auPayFormat = new auPayformat;
	}
	
	/**
	 * getMaxCount
	 * setter shop_noを取得する
	 * @return $shop_api_key
	 */
	public function getMaxCount(){
		$maxCount = $this->maxCount;
		return $maxCount;
	}
	
	
	/**
	 * cntItemMax
	 * 登録件数を取得する
	 * @param null
	 * @return boolean
	 */
	public function cntItemMax($shop_no, $shop_api_key){
		$searchItems = $this->searchItems($shop_no, $shop_api_key,'1' ,'1');
		if(isset($searchItems['searchResult']['maxCount'])){
			//登録されている総商品数を取得する
			$this->maxCount = strval($searchItems['searchResult']['maxCount']);
			$result[]= true;
			$result[]= $this->maxCount;
			
		}else{
			$result[]= false;
			$result[]= 'null';
		};
		return $result;
	}
	
	/**
	 * searchItems
	 * 商品情報（複数）の取得
	 * @param  String  $shop_no 会員番号
	 * @param  String  $shop_api_key APIキー
	 * @return Array   $response　//レスポンス
	 */
	public function searchItems(String $shop_no, String $shop_api_key, String $startCount = '1', String $totalCount = '1' )
	{
		//エンドポイントの作成
		$base_url = config('const.Au_pay.BASE_URL') .'/' .config('const.Au_pay.searchItemInfos') ;
		
		//リクエストパラメータの取得
		$params = http_build_query($this->getReqParam($shop_no, $startCount, $totalCount));
		
		//リクエストヘッダの取得
		$headers = $this->get_headers($shop_api_key);
		
		//オプションの取得
		$options = $this->get_options($base_url, $params, $headers);
		
		//リクエストを送信
		$response = $this->SendHttpReq($options);
		
		//xml変換のエラーを解消する
		$response = preg_replace('/[\x00-\x1f]/', '', $response);
		
		/*
		 * simplexml_load_stringのerror出力ON設定
		 */
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
		
		return $response;
	}

	/**
	 * ------------------------------------------------------------------
	 * getItemCsv
	 * CSVファイルの作成
	 * @param  Array $header //csvのヘッダーを指定
	 * @param  Array $records
	 * @param  String $filename strageからのフルパスを指定
	 * @return Boolean
	 * -------------------------------------------------------------------
	 */
	public function getItemCsv($header, $records, $filepath){
		//CSVファイルの作成し、フルパスを取得する。
		$filedata = $this->CsvController->createCsvFile($filepath, '.csv');
		$this->csvFilePath = $filedata[0];
		
		//CSVヘッダーをファイル書き込む
		$this->CsvController->writeCsv($this->csvFilePath, $header);
		
		
		//配列をaupay用のフォーマットに整形する。
		foreach ($records as $line) {
			
			//配列をAuPay用の配列に格納
			$format_line = $this->CsvController->format_searchitems($line);
			
			//CSVへ書き込み
		}
		return $filedata;
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
			"Content-Type:application/x-www-form-urlencoded",
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
	protected function get_options($base_url, $params, $headers){
		$options = [
			CURLOPT_URL             => $base_url .'?' .$params,
			CURLOPT_CUSTOMREQUEST   => 'GET',//メソッドの指定
			CURLOPT_SSL_VERIFYPEER  => false,// 証明書の検証を行わない
			CURLOPT_RETURNTRANSFER  => true,//実行結果を文字列で返す。
			CURLOPT_FAILONERROR     => false,
			CURLOPT_HTTPHEADER      => $headers,//headerに値をセット
		];
		return $options;
	}


}
