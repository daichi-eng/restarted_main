<?php
namespace App\Http\Controllers\User\Download;

class Format
{
	private $auPayItemHeader = Array(
		'lotNumber',
		'itemName',
		'itemManagementId',
		'itemManagementName',
		'itemCode',
		'itemPrice',
		'sellMethodSegment',
		'releaseDate',
		'reserveRegstDate',
		'makerRetailPrice',
		'makerRetailPriceUrl',
		'taxSegment',
		'postageSegment',
		'postage',
		'deliveryId',
		'deliveryMethodId1',
		'deliveryMethodId2',
		'deliveryMethodId3',
		'deliveryMethodId4',
		'deliveryMethodId5',
		'deliveryMethodName1',
		'deliveryMethodName2',
		'deliveryMethodName3',
		'deliveryMethodName4',
		'deliveryMethodName5',
		'sellStartDate',
		'sellEndDate',
		'publicStartDate',
		'giftPackingSegment',
		'noshiSegment',
		'limitedOrderSegment',
		'limitedOrderCount',
		'description',
		'descriptionForSP',
		'descriptionForPC',
		'detailTitle',
		'detailDescription',
		'specTitle',
		'spec1',
		'spec2',
		'spec3',
		'spec4',
		'spec5',
		'searchKeyword1',
		'searchKeyword2',
		'searchKeyword3',
		'searchTarget',
		'imageName1',
		'imageName2',
		'imageName3',
		'imageName4',
		'imageName5',
		'imageName6',
		'imageName7',
		'imageName8',
		'imageName9',
		'imageName10',
		'imageName11',
		'imageName12',
		'imageName13',
		'imageName14',
		'imageName15',
		'imageName16',
		'imageName17',
		'imageName18',
		'imageName19',
		'imageName20',
		'imageUrl1',
		'imageUrl2',
		'imageUrl3',
		'imageUrl4',
		'imageUrl5',
		'imageUrl6',
		'imageUrl7',
		'imageUrl8',
		'imageUrl9',
		'imageUrl10',
		'imageUrl11',
		'imageUrl12',
		'imageUrl13',
		'imageUrl14',
		'imageUrl15',
		'imageUrl16',
		'imageUrl17',
		'imageUrl18',
		'imageUrl19',
		'imageUrl20',
		'categoryId',
		'tagId',
		'shopCategory1',
		'shopCategory2',
		'shopCategory3',
		'shopCategory4',
		'shopCategory5',
		'shopCategory6',
		'shopCategory7',
		'shopCategory8',
		'shopCategory9',
		'shopCategory10',
		'shopCategoryDispSeq',
		'jan',
		'isbn',
		'itemModel',
		'limitedPasswd',
		'limitedPasswdPageTitle',
		'limitedPasswdPageMessage',
		'saleStatus',
		'itemOption1',
		'itemOption2',
		'itemOption3',
		'itemOption4',
		'itemOption5',
		'itemOption6',
		'itemOption7',
		'itemOption8',
		'itemOption9',
		'itemOption10',
		'itemOption11',
		'itemOption12',
		'itemOption13',
		'itemOption14',
		'itemOption15',
		'itemOption16',
		'itemOption17',
		'itemOption18',
		'itemOption19',
		'itemOption20',
		'itemOptionCommissionTitle1',
		'itemOptionCommissionVal1',
		'itemOptionCommissionNote1',
		'itemOptionCommissionTitle2',
		'itemOptionCommissionVal2',
		'itemOptionCommissionNote2',
		'itemOptionCommissionTitle3',
		'itemOptionCommissionVal3',
		'itemOptionCommissionNote3',
		'itemOptionCommissionTitle4',
		'itemOptionCommissionVal4',
		'itemOptionCommissionNote4',
		'itemOptionCommissionTitle5',
		'itemOptionCommissionVal5',
		'itemOptionCommissionNote5',
		'itemOptionCommissionTitle6',
		'itemOptionCommissionVal6',
		'itemOptionCommissionNote6',
		'itemOptionCommissionTitle7',
		'itemOptionCommissionVal7',
		'itemOptionCommissionNote7',
		'itemOptionCommissionTitle8',
		'itemOptionCommissionVal8',
		'itemOptionCommissionNote8',
		'itemOptionCommissionTitle9',
		'itemOptionCommissionVal9',
		'itemOptionCommissionNote9',
		'itemOptionCommissionTitle10',
		'itemOptionCommissionVal10',
		'itemOptionCommissionNote10',
		'itemOptionCommissionTitle11',
		'itemOptionCommissionVal11',
		'itemOptionCommissionNote11',
		'itemOptionCommissionTitle12',
		'itemOptionCommissionVal12',
		'itemOptionCommissionNote12',
		'itemOptionCommissionTitle13',
		'itemOptionCommissionVal13',
		'itemOptionCommissionNote13',
		'itemOptionCommissionTitle14',
		'itemOptionCommissionVal14',
		'itemOptionCommissionNote14',
		'itemOptionCommissionTitle15',
		'itemOptionCommissionVal15',
		'itemOptionCommissionNote15',
		'itemOptionCommissionTitle16',
		'itemOptionCommissionVal16',
		'itemOptionCommissionNote16',
		'itemOptionCommissionTitle17',
		'itemOptionCommissionVal17',
		'itemOptionCommissionNote17',
		'itemOptionCommissionTitle18',
		'itemOptionCommissionVal18',
		'itemOptionCommissionNote18',
		'itemOptionCommissionTitle19',
		'itemOptionCommissionVal19',
		'itemOptionCommissionNote19',
		'itemOptionCommissionTitle20',
		'itemOptionCommissionVal20',
		'itemOptionCommissionNote20',
		'pointRate',
		'favoriteCount',
		'receiptRequestCount',
		'stockRequestConfig',
		'stockRequestCount',
		'deliveryLeadtimeId',
		'stockSegment',
		'stockShippingDayId',
		'stockShippingDayDispTxt',
		'displayBackorderMessage',
		'stockCount',
		'displayStockSegment',
		'displayStockThreshold',
		'choicesStockHorizontalItemName',
		'choicesStockVerticalItemName',
		'choicesStockUpperDescription',
		'choicesStockLowerDescription',
		'displayChoicesStockSegment',
		'displayChoicesStockThreshold',
	);
	
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
	

	/**
	 * getauPayItemHeader
	 * auPay itemcsv用のヘッダーを取得する
	 * @return Array auPayItemHeader
	 */
	public function get_aupay_Header(){
		return $this->auPayItemHeader;
	}
	
	/**
	 * formatAuPay
	 * 配列をauPay用の連想配列に入れ直す
	 * @param Array $line //連想配列
	 * @return $format_line
	 */
	public function format_searchitems($line)
	{
		//var_dump($line);
		$format_line['lotNumber']          = $this->chkArrayData($line,'lotNumber');//1
		$format_line['itemName']           = $this->chkArrayData($line, 'itemName');
		$format_line['itemManagementId']   = $this->chkArrayData($line, 'itemManagementId');
		$format_line['itemManagementName'] = $this->chkArrayData($line, 'itemManagementName');
		$format_line['itemCode']           = $this->chkArrayData($line, 'itemCode');//5
		
		$format_line['itemPrice']          = $this->chkArrayData($line, 'itemPrice');
		$format_line['sellMethodSegment']  = $this->chkArrayData($line, 'sellMethodSegment');
		$format_line['releaseDate']        = $this->chkArrayData($line, 'releaseDate');
		$format_line['reserveRegstDate']   = $this->chkArrayData($line, 'reserveRegstDate');
		$format_line['makerRetailPrice']   = $this->chkArrayData($line, 'makerRetailPrice');//10
		
		$format_line['makerRetailPriceUrl']   = $this->chkArrayData($line, 'makerRetailPriceUrl');
		$format_line['taxSegment']         = $this->chkArrayData($line, 'taxSegment');
		$format_line['postageSegment']     = $this->chkArrayData($line, 'postageSegment');
		$format_line['postage']            = $this->chkArrayData($line, 'postage');
		//$format_line['deliveryId']         = $this->chkArrayData($line['deliveryId']);
		$format_line['deliveryId']         = '';//15
		
		//$format_line['deliveryMethodId1']  = $this->chkArrayData($line['deliveryMethodId1']);
		$format_line['deliveryMethodId1']  = '';//21
		$format_line['deliveryMethodId2']  = '';
		$format_line['deliveryMethodId3']  = '';
		$format_line['deliveryMethodId4']  = '';
		$format_line['deliveryMethodId5']  = '';//20
		$format_line['deliveryMethodName1']  = '';
		$format_line['deliveryMethodName2']  = '';
		$format_line['deliveryMethodName3']  = '';
		$format_line['deliveryMethodName4']  = '';
		$format_line['deliveryMethodName5']  = '';//25
		
		$format_line['sellStartDate']  = '';
		$format_line['sellEndDate']  = '';
		$format_line['publicStartDate']  = '';
		$format_line['giftPackingSegment']  = '1';
		$format_line['noshiSegment'] = $this->chkArrayData($line, 'noshiSegment');//30
		
		$format_line['limitedOrderSegment'] = $this->chkArrayData($line, 'limitedOrderSegment');
		$format_line['limitedOrderCount'] = $this->chkArrayData($line, 'limitedOrderCount');
		$format_line['description'] = $this->chkArrayData($line, 'description');
		$format_line['descriptionForSP'] = $this->chkArrayData($line, 'descriptionForSP');
		$format_line['descriptionForPC'] = $this->chkArrayData($line, 'descriptionForPC');//35
		
		$format_line['detailTitle'] = $this->chkArrayData($line, 'detailTitle');
		$format_line['detailDescription'] = '';
		$format_line['specTitle'] = '';
		$format_line['spec1'] = '';
		$format_line['spec2'] = '';
		
		$format_line['spec3'] = '';
		$format_line['spec4'] = '';
		$format_line['spec5'] = '';
		$format_line['searchKeyword1'] = '';
		$format_line['searchKeyword2'] = '';
		
		$format_line['searchKeyword3'] = '';
		$format_line['searchTarget'] = '';
		
		//imagesの要素数>1のとき
		if(isset($line['images'][0])){
			$cnt = 0;
			for($i = 0; $i < count($line['images']); $i++){
				//for($i = 0; $i < 20; $i++){
				$format_line['imageName' .($i + 1)] = $this->chkArrayData($line['images'][$i],'imageName');
				$cnt = $cnt + 1;
			}
			for($i = 0; $i < 21 - $cnt; $i++){
				//for($i = 0; $i < 20; $i++){
				$format_line['imageName' .($cnt + $i)] = '';
			}
			
			$cnt = 0;
			for($i = 0; $i < count($line['images']); $i++){
				$format_line['imageUrl' .($i + 1)] = $this->chkArrayData($line['images'][$i], 'imageUrl');
				$cnt = $cnt + 1;
			}
			for($i = 0; $i < 21 - $cnt; $i++){
				//for($i = 0; $i < 20; $i++){
				$format_line['imageUrl' .($cnt + $i)] = '';
			}
			
			//imagesの要素数=1のとき
		}else{
			for($i = 0; $i < 20; $i++){
				if($i == 0){
					$format_line['imageName1'] = $this->chkArrayData($line['images'], 'imageName');
				}else{
					$format_line['imageName' .($i + 1)] = '';
				}
			}
			for($i = 0; $i < 20; $i++){
				if($i == 0){
					$format_line['imageUrl1'] = $this->chkArrayData($line['images'], 'imageUrl');
				}else{
					$format_line['imageUrl' .($i + 1)] = '';
				}
			}
			
		}
		
		$format_line['categoryId'] = $this->chkArrayData($line, 'categoryId');
		
		
		$cnt = 0;
		$tagId = '';
		for($i = 0; $i < count($line['tags']); $i++){
			$tagId = $tagId .$this->chkArrayData($line['tags'][$i], 'tagId');
			//var_dump($line['tags']);
		}
		$format_line['tagId'] = $tagId ;
		
		$format_line['shopCategory1'] = '';
		$format_line['shopCategory2'] = '';
		$format_line['shopCategory3'] = '';
		$format_line['shopCategory4'] = '';
		$format_line['shopCategory5'] = '';
		$format_line['shopCategory6'] = '';
		$format_line['shopCategory7'] = '';
		$format_line['shopCategory8'] = '';
		$format_line['shopCategory9'] = '';
		$format_line['shopCategory10'] = '';
		$format_line['shopCategoryDispSeq'] = '';
		$format_line['jan'] = '';
		$format_line['isbn'] = '';
		$format_line['itemModel'] = '';
		$format_line['limitedPasswd'] = '';
		$format_line['limitedPasswdPageTitle'] = '';
		$format_line['limitedPasswdPageMessage'] = '';
		
		$format_line['saleStatus'] = $this->chkArrayData($line, 'saleStatus');
		
		$format_line['itemOption1'] = '';
		$format_line['itemOption2'] = '';
		$format_line['itemOption3'] = '';
		$format_line['itemOption4'] = '';
		$format_line['itemOption5'] = '';
		$format_line['itemOption6'] = '';
		$format_line['itemOption7'] = '';
		$format_line['itemOption8'] = '';
		$format_line['itemOption9'] = '';
		$format_line['itemOption10'] = '';
		$format_line['itemOption11'] = '';
		$format_line['itemOption12'] = '';
		$format_line['itemOption13'] = '';
		$format_line['itemOption14'] = '';
		$format_line['itemOption15'] = '';
		$format_line['itemOption16'] = '';
		$format_line['itemOption17'] = '';
		$format_line['itemOption18'] = '';
		$format_line['itemOption19'] = '';
		$format_line['itemOption20'] = '';
		
		$format_line['itemOptionCommissionTitle1'] = '';
		$format_line['itemOptionCommissionVal1'] = '';
		$format_line['itemOptionCommissionNote1'] = '';
		
		$format_line['itemOptionCommissionTitle2'] = '';
		$format_line['itemOptionCommissionVal2'] = '';
		$format_line['itemOptionCommissionNote2'] = '';
		
		$format_line['itemOptionCommissionTitle3'] = '';
		$format_line['itemOptionCommissionVal3'] = '';
		$format_line['itemOptionCommissionNote3'] = '';
		
		$format_line['itemOptionCommissionTitle4'] = '';
		$format_line['itemOptionCommissionVal4'] = '';
		$format_line['itemOptionCommissionNote4'] = '';
		
		$format_line['itemOptionCommissionTitle5'] = '';
		$format_line['itemOptionCommissionVal5'] = '';
		$format_line['itemOptionCommissionNote5'] = '';
		
		$format_line['itemOptionCommissionTitle6'] = '';
		$format_line['itemOptionCommissionVal6'] = '';
		$format_line['itemOptionCommissionNote6'] = '';
		
		$format_line['itemOptionCommissionTitle7'] = '';
		$format_line['itemOptionCommissionVal7'] = '';
		$format_line['itemOptionCommissionNote7'] = '';
		
		$format_line['itemOptionCommissionTitle8'] = '';
		$format_line['itemOptionCommissionVal8'] = '';
		$format_line['itemOptionCommissionNote8'] = '';
		
		$format_line['itemOptionCommissionTitle9'] = '';
		$format_line['itemOptionCommissionVal9'] = '';
		$format_line['itemOptionCommissionNote9'] = '';
		
		$format_line['itemOptionCommissionTitle10'] = '';
		$format_line['itemOptionCommissionVal10'] = '';
		$format_line['itemOptionCommissionNote10'] = '';
		
		$format_line['itemOptionCommissionTitle11'] = '';
		$format_line['itemOptionCommissionVal11'] = '';
		$format_line['itemOptionCommissionNote11'] = '';
		
		$format_line['itemOptionCommissionTitle12'] = '';
		$format_line['itemOptionCommissionVal12'] = '';
		$format_line['itemOptionCommissionNote12'] = '';
		
		$format_line['itemOptionCommissionTitle13'] = '';
		$format_line['itemOptionCommissionVal13'] = '';
		$format_line['itemOptionCommissionNote13'] = '';
		
		$format_line['itemOptionCommissionTitle14'] = '';
		$format_line['itemOptionCommissionVal14'] = '';
		$format_line['itemOptionCommissionNote14'] = '';
		
		$format_line['itemOptionCommissionTitle15'] = '';
		$format_line['itemOptionCommissionVal15'] = '';
		$format_line['itemOptionCommissionNote15'] = '';
		
		$format_line['itemOptionCommissionTitle16'] = '';
		$format_line['itemOptionCommissionVal16'] = '';
		$format_line['itemOptionCommissionNote16'] = '';
		
		$format_line['itemOptionCommissionTitle17'] = '';
		$format_line['itemOptionCommissionVal17'] = '';
		$format_line['itemOptionCommissionNote17'] = '';
		
		$format_line['itemOptionCommissionTitle18'] = '';
		$format_line['itemOptionCommissionVal18'] = '';
		$format_line['itemOptionCommissionNote18'] = '';
		
		$format_line['itemOptionCommissionTitle19'] = '';
		$format_line['itemOptionCommissionVal19'] = '';
		$format_line['itemOptionCommissionNote19'] = '';
		
		$format_line['itemOptionCommissionTitle20'] = '';
		$format_line['itemOptionCommissionVal20'] = '';
		$format_line['itemOptionCommissionNote20'] = '';
		
		$format_line['pointRate'] = $this->chkArrayData($line, 'pointRate');
		$format_line['favoliteCouint'] = $this->chkArrayData($line, 'pointRate');
		$format_line['receiptRequestCount'] = $this->chkArrayData($line, 'receiptRequestCount');
		$format_line['stockRequestConfig'] = $this->chkArrayData($line, 'stockRequestConfig');
		$format_line['stockRequestCount'] = $this->chkArrayData($line, 'stockRequestCount');
		//$format_line['deliveryLeadtimeId'] = $line['deliveryLeadtimeId'];
		$format_line['deliveryLeadtimeId'] = '';
		
		/*
		 * registerStock
		 */
		$format_line['stockSegment'] = $this->chkArrayData($line['registerStock'], 'stockSegment');
		
		//在庫区分(stockSegment）= 1:通常在庫
		if($this->chkArrayData($line['registerStock'], 'stockSegment') == '1'){
			// 		$format_line['stockShippingDayId'] = $this->chkArrayData($line['registerStock'], 'stockShippingDayId');
			$format_line['stockShippingDayId'] = '';
			// 		$format_line['stockShippingDayDispTxt'] = $this->chkArrayData($line['registerStock'], 'stockShippingDayDispTxt');
			$format_line['stockShippingDayDispTxt'] = '';
			
			$format_line['displayBackorderMessage'] = $this->chkArrayData($line['registerStock'], 'displayBackorderMessage');
			$format_line['stockCount'] = $this->chkArrayData($line['registerStock'], 'stockCount');
			$format_line['displayStockSegment'] = $this->chkArrayData($line['registerStock'], 'displayStockSegment');
			$format_line['displayStockThreshold'] = $this->chkArrayData($line['registerStock'], 'displayStockThreshold');
			$format_line['choicesStockHorizontalItemName'] = '';
			$format_line['choicesStockVerticalItemName'] = '';
			$format_line['choicesStockUpperDescription'] = '';
			$format_line['choicesStockLowerDescription'] = '';
			$format_line['displayChoicesStockSegment'] = '';
			$format_line['displayChoicesStockThreshold'] = '';
			
			//在庫区分(stockSegment）= 2:選択肢別在庫
		}elseif($this->chkArrayData($line['registerStock'], 'stockSegment') == '2') {
			$format_line['stockShippingDayId'] = '';
			$format_line['stockShippingDayDispTxt'] = '';
			$format_line['displayBackorderMessage'] = $this->chkArrayData($line['registerStock'], 'displayBackorderMessage');
			$format_line['stockCount'] = '';
			$format_line['displayStockSegment'] = '';
			$format_line['displayStockThreshold'] = '';
			$format_line['choicesStockHorizontalItemName'] = $this->chkArrayData($line['registerStock'], 'choicesStockHorizontalItemName');
			$format_line['choicesStockVerticalItemName'] = $this->chkArrayData($line['registerStock'], 'choicesStockVerticalItemName');
			$format_line['choicesStockUpperDescription'] = $this->chkArrayData($line['registerStock'], 'choicesStockUpperDescription');
			$format_line['choicesStockLowerDescription'] = $this->chkArrayData($line['registerStock'], 'choicesStockLowerDescription');
			$format_line['displayChoicesStockSegment'] = $this->chkArrayData($line['registerStock'], 'displayChoicesStockSegment');
			$format_line['displayChoicesStockThreshold'] = $this->chkArrayData($line['registerStock'], 'displayChoicesStockThreshold');
		}
		
		//var_dump($format_line);
		
		return $format_line;
	}
	
	/**
	 * chkArrayData
	 * 任意のキーで配列の存在チェック。存在しない場合は''を返却。
	 * 存在する場合は空チェックをし、存在しない場合は''をチェック。
	 * @param array $array
	 * @return String $key
	 */
	private function chkArrayData($value, String $key)
	{
		//存在チェック
		if(!isset($value[$key])){
			$value = '';
			return $value;
		}else{
			if(empty($value[$key]) or (!isset($value[$key]))){
				$value = '';
				return $value;
			}
		}
		
		return $value[$key];
	}
}