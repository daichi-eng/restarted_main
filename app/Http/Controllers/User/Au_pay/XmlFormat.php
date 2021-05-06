<?php

namespace App\Http\Controllers\User\Au_pay;

use Exception;

class XmlFormat
{
	/**
	 * xml_format
	 * XML文字列を配列に変換する
	 * @param $response
	 * @return Array $response
	 */
	public function xml_format($response ){
		
		//xml文字列のエラーを解消する
		$response = preg_replace('/[\x00-\x1f]/', '', $response);
		
		/* ---------------------------------
		 * simplexml_load_string
		 * XML文字列のXMLオブジェクトへの変換
		 * -------------------------------- */
		//simplexml_load_stringのerror出力ON設定
		libxml_use_internal_errors(true);
		
		//XML文字列をXMLに変換する
		$response = simplexml_load_string($response);
		
		//simplexml_load_stringのエラーハンドリング
		if (!$response) {
			echo "Failed loading XML\n";
			foreach(libxml_get_errors() as $error) {
				echo "\t", $error->message;
			}
		}
		
		//XML→json→連想配列
		//$response = json_decode(json_encode($response), true);
		$response = json_encode($response);
		$response = json_decode($response, true);
		
		return $response;
	}
	
	
// 	/**
// 	 * createCsvFile
// 	 * ファイル名からファイルを作成しフルパスを返却する。
// 	 * @param String $filepath
// 	 * @param String $filename
// 	 * @param String $filetype
// 	 * @return Array $filedata //filepayh, filename
// 	 */
// 	public function createCsvFile(String $filepath, String $filename ,String $filetype)
// 	{
// 		//sprintf フォーマットを作る
// 		//%sや%dに第荷引数以降の値をそれぞれ代入する。
// 		$filename = sprintf($filename .'_%s' .$filetype, date('ymd_his'));
		
// 		//storage_path ファイルパスを作成する。
// 		$filePath = storage_path($filepath .$filename);
		
// 		//fopen ファイルを開く
// 		//// w 書き込みモードでファイルを開く
// 		$res = fopen($filePath, 'w');
// 		if ($res === FALSE) {
// 			throw new Exception('ファイルの書き込みに失敗しました。');
// 		}
// 		fclose($res);
		
// 		$filedata[] = array($filepath, basename($filePath));
// 		return $filedata;
// 	}
// 	/**
// 	 * writeCsv
// 	 * 配列をCSVファイルに書き出す
// 	 * @param $csvFilePath //ファイル名を含んだフルパスを指定
// 	 * @param $aryLine //1行の配列を指定
// 	 */
// 	public function writeCsv($csvFilePath, $aryLine)
// 	{
// 		//ファイル書き込みモードにて開く。ない場合は新規作成
// 		$res = fopen($csvFilePath, 'a');
		
// 		// ファイルに書き出し
// 		fputcsv($res, $aryLine);
		
// 		fclose($res);
// 	}
}
