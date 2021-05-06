<?php

namespace App\Http\Controllers\User\Download;


use App\Http\Controllers\Controller;
use App\Http\Controllers\User\Download\Format;
use App\Exceptions\ApiException;
use Facade\FlareClient\Api;
use Illuminate\Support\Facades\File;

class ApiConnect
{
	//au Payマーケット用の会員番号
	private $shopNum = '00';
	private $shopApikey = 'aa';

	/**
	 * __construct
	 * @param String $shopNum
	 * @param String $shopApikey
	 */
	public function __construct(String $shopNum, String $shopApikey)
	{
		$this->shopNum = $shopNum;
		$this->shopApikey = $shopApikey;
	}
	
	/**
	 * searchItems
	 * 商品情報（複数）の取得
	 * @param  String  $startCount //取得開始件数
	 * @param  String  $totalCount //最大取得件数
	 * @return Array   $response //レスポンス
	 */
	public function search_items(String $startCount = '1', String $totalCount = '1' )
	{
		
		//エンドポイントの作成
		$base_url = config('const.Au_pay.BASE_URL') .'/' .config('const.Au_pay.searchItemInfos') ;
		
		//リクエストパラメータの取得
		$params = http_build_query($this->getReqParam($this->shopNum, $startCount, $totalCount));
		
		//リクエストヘッダの取得
		$headers = $this->get_headers($this->shopApikey);
		
		//オプションの取得
		$options = $this->get_options($base_url, $params, $headers);
		
		//リクエストを送信
		$response = $this->send_http_req($options);
		
// 		File::put('memo.txt', $response);
// 		dd($response);
		
		return $response;
	}
	
	/**
	 * send_http_req
	 * リクエストを送信しレスポンスを返却する。
	 * @param Array $option
	 * @return $response
	 */
	private function send_http_req($options){
		
		$curl = curl_init();
		curl_setopt_array($curl, $options);
		$response = curl_exec($curl);//レスポンスの取得
		
		
		// ステータスコード取得
		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
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

}
