<?php

namespace App\Http\Controllers;

use Exception;

class OutputFile
{
	/**
	 * convert_utf8
	 * 文字コードをSISJIS→UTF8に変換する。
	 * @param Array csvAry
	 * @return Array cscAry
	 * 
	 */
	public function convert_utf8(Array $csvAry){
		//配列をカンマ区切りの文字列に変換
		//$csv_line = implode(',', array_values($format_line));
		$csvAry = implode(',', $csvAry);
		
		//文字コードSJIS→UTF8へ変換する。
		$csvAry = mb_convert_encoding($csvAry,"SJIS", "UTF-8");
		
		//文字列から配列へ再変換
		$csvAry = explode(',', $csvAry);
		
		return $csvAry;	
	}
	
	/**
	 * out_file
	 * ファイル名からファイルを作成しフルパスを返却する。
	 * @param String $filepath
	 * @param Array $array
	 * @return Array $filedata //filepayh, filename
	 */
	public function out_file(String $filename, Array $array)
	{
		
		$filename = storage_path($filename);
		
		//fopen ファイルを開く
		//// w 書き込みモードでファイルを開く
		$fp = fopen($filename, 'a');
		if ($fp === FALSE) {
			throw new Exception('ファイルの書き込みに失敗しました。');
		}
		$reslut = fputcsv($fp, $array);
		fclose($fp);
		
		return $reslut;
	}
}
