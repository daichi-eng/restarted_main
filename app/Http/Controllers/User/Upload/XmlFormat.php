<?php
namespace App\Http\Controllers\User\Upload;

use App\Exceptions\Upload\ApiException;

class XmlFormat
{
	private $ItemHeader = [
		'ctrlCol',
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
		'stockSegment',//在庫区分＝2：選択肢別在庫
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
	];
	
	private $StockHeader  = Array(
		'ctrlCol',
		'lotNumber',
		'itemCode',
		'stockSegment',
		'stockCount',
		'choicesStockHorizontalName',
		'choicesStockHorizontalCode',
		'choicesStockHorizontalSeq',
		'choicesStockVerticalName',
		'choicesStockVerticalCode',
		'choicesStockVerticalSeq',
		'choicesStockCount',
		'choicesStockShippingDayId',
		'choicesStockShippingDayDispTxt',
		'choicesStockImageUrl',
		'choicesStockColorSegment',
	);
	
	/**
	 * get_Item_Header
	 * auPay item.csv用のヘッダーを取得する
	 * @return Array auPayItemHeader
	 */
	public function get_Item_Header(){
		return $this->ItemHeader;
	}
	/**
	 * get_Stcok_Header
	 * auPay stock.csv用のヘッダーを取得する
	 * @return Array auPayItemHeader
	 */
	public function get_Stcok_Header(){
		return $this->StockHeader;
	}
	
	
	/**
	 * check_Item_Header
	 * 配列をitem.csvのフォーマットと比較する。
	 * @param array //CSVヘッダー
	 * @return boolean
	 */
	public function check_Item_Header($header){
		
		return ($this->ItemHeader == $header);
	}
	
	/**
	 * check_Stock_Header
	 * 配列をstock.csvのフォーマットと比較する。
	 * @param array //CSVヘッダー
	 * @return array 
	 */
	public function check_Stock_Header($header){
		
		return ($this->StockHeader == $header);
	}
	
	/**
	 * check_item_h
	 * item.csvのヘッダーのチェック
	 * 戻り値は配列array('status' => boolean, 'data' = array([0] => 'itemheader1', [1] => 'itemheader2'))
	 * @param $itemHeader //CSVヘッダー
	 * @return $array
	 */
	public function check_item_h($itemHeaders){
		//必須項目
		$mustItemHeaders =  array(
			'ctrlCol',
			'itemName',
			'itemCode',
			'itemPrice',
			'taxSegment',
			'postageSegment',
			'description',
			'categoryId',
			'saleStatus',
			'stockSegment',
		);
		
		//リターンデータの定義
		$reAry = array(
			'status' => true,
			'data' => array()
		);
		
		
		foreach($mustItemHeaders as $mustItemHeader ){
			$dataCnt = 0;
			foreach($itemHeaders as $itemHeader){
				if($itemHeader == $mustItemHeader){
					$dataCnt ++;
				}
			}
			//必須項目が存在しないとき
			if($dataCnt == 0){
				$reAry['status'] = false;
				array_push($reAry['data'] , $mustItemHeader);
			}
		}
		return $reAry;
	}
	
	
	/**
	 * check_stock_h
	 * 配列をstock.csvのフォーマットと比較する。
	 * 戻り値は配列array('status' => boolean, 'data' = array([0] => 'itemheader1', [1] => 'itemheader2'))
	 * @param array //CSVヘッダー
	 * @return array
	 */
	public function check_stock_h($stockHeaders){
		//必須入力チェック
		//必須項目
		$mustStockHeaders =  array(
			'itemCode',
			'stockSegment',
		);
		
		//リターンデータの定義
		$reAry = array(
			'status' => true,
			'data' => array()
		);
		
		
		foreach($mustStockHeaders as $mustStockHeader ){
			$dataCnt = 0;
			foreach($stockHeaders as $stockHeader){
				if($stockHeader == $mustStockHeader){
					$dataCnt ++;
				}
			}
			//必須項目が存在しないとき
			if($dataCnt == 0){
				$reAry['status'] = false;
				array_push($reAry['data'] , $mustStockHeader);
			}
		}
		return $reAry;
	}
	
	
	/**
	 * get_csv_header
	 * @param $dirPath //itemcsvのファイル格納場所
	 * @param $filename //ファイル名称
	 * @return Array array //CSVのヘッダーのみ配列として返却する。
	 */
	public function get_csv_header($dirPath, $filename){
		
		$file = new \SplFileObject(storage_path($dirPath .$filename));
		
		$file->setFlags(
			\SplFileObject::READ_CSV |           // CSV 列として行を読み込む
			\SplFileObject::READ_AHEAD |       // 先読み/巻き戻しで読み出す。
			\SplFileObject::SKIP_EMPTY |         // 空行は読み飛ばす
			\SplFileObject::DROP_NEW_LINE    // 行末の改行を読み飛ばす
		);
		
		//$fileオブジェクトを多次元配列に変換する。
		// 読み込んだCSVデータをループ
		$i = 0; //カウンタ
		foreach ($file as $line) {
			if($i == 0){
				// 文字コードを SJIS→UTF-8 へ変換
				mb_convert_variables('UTF-8', 'SJIS', $line);
				$header = $line;
				break;
			}
			$i++;
		}
		
		if(!isset($header)){
			$errMsg = "FILE004：アップロードされたファイルが白紙です。";
			throw new ApiException($errMsg);
		}
		
		return $header;
	}
	/**
	 * csv_ary
	 * csvファイルを連想配列に変換する。
	 * @param $dirPath //csvファイル格納場所
	 * @param $filename //ファイル名称
	 * @return Array array //連想配列の格納先れた多次元配列
	 */
	public function csv_ary($dirPath, $filename){
		$file = new \SplFileObject(storage_path($dirPath .$filename));
		
		$file->setFlags(
			\SplFileObject::READ_CSV |           // CSV 列として行を読み込む
			\SplFileObject::READ_AHEAD |       // 先読み/巻き戻しで読み出す。
			\SplFileObject::SKIP_EMPTY |         // 空行は読み飛ばす
			\SplFileObject::DROP_NEW_LINE    // 行末の改行を読み飛ばす
		);
		
		//$fileオブジェクトを多次元配列に変換する。
		// 読み込んだCSVデータをループ
		$i = 0; //カウンタ
		$ary_s = array();//多次元配列
		foreach ($file as $line) {
			// 文字コードを SJIS→UTF-8 へ変換
			mb_convert_variables('UTF-8', 'SJIS', $line);
			
			if($i == 0){
				$header = $line;
			}else{
				$ary_s[] = $line;
			}
			$i++;
		}
		/*
		 * CSVの値がないとき
		 */
		if(empty($ary_s)){
			$errMsg = "FILE005：ファイルに値が入力されていません。";
			
			throw new ApiException($errMsg);
		}
		
		$ary_m = array();
		for( $i = 0; $i < count($ary_s); $i++){
			//配列を1次元の連想配列に変換する。
			for ($j = 0; $j < count($ary_s[0]); $j++) {
				//1こ目の配列（header）の値をキーとして、2個目からは値として格納するような連想配列を作成。
				$ary_m[$header[$j]] = $this->_h($ary_s[$i][$j]);
			}
			
			//多次元配列に、連想配列を格納する。
			$csvAry[$i] = $ary_m;
		}
		return $csvAry;
	}

	/**
	 * req_body
	 * 配列をリクエスト用のxmlボディに作り変える。
	 * @param Array $itemAry
	 * @param Array $stockReArys = null
	 * @return Array $reqAry
	 */
	public function req_body($shopNum, $itemAry, $stockReArys = null){
		
		/* --------------------------
		 * XMLの作成 START
		 * -------------------------- */
		$xml1st = new \SimpleXMLElement("<?xml version='1.0' encoding='UTF-8' standalone='yes'?><request></request>" );
		
		$xml2nd = $xml1st->addChild('shopId', $shopNum);//1stの下の階層に2ndを作る。
		
		$xml2nd = $xml1st->addChild('registerItem');//1stの下の階層に2ndを作る。
		$xml2nd->addChild('itemName', ($itemAry['itemName']));
		$xml2nd->addChild('itemManagementId', ($itemAry['itemManagementId']));
		$xml2nd->addChild('itemManagementName', ($itemAry['itemManagementName']));
		$xml2nd->addChild('itemCode', ($itemAry['itemCode']));
		$xml2nd->addChild('itemPrice', ($itemAry['itemPrice']));
			
			if($itemAry['sellMethodSegment'] != ''){
				$xml2nd->addChild('sellMethodSegment', ($itemAry['sellMethodSegment']));
			}
			if($itemAry['releaseDate'] != ''){
				$xml2nd->addChild('releaseDate', ($itemAry['releaseDate']));
			}
			if($itemAry['makerRetailPrice'] != ''){
				$xml2nd->addChild('makerRetailPrice', ($itemAry['makerRetailPrice']));
			}
			if($itemAry['taxSegment'] != ''){
				$xml2nd->addChild('taxSegment', ($itemAry['taxSegment']));
			}
			if($itemAry['makerRetailPriceUrl'] != ''){
				$xml2nd->addChild('makerRetailPriceUrl', ($itemAry['makerRetailPriceUrl']));
			}
// 			if($itemAry['reducedTax'] != ''){
// 				$xml2nd->addChild('reducedTax', $itemAry['reducedTax']);
// 			}
			if($itemAry['postageSegment'] != ''){
				$xml2nd->addChild('postageSegment', ($itemAry['postageSegment']));
			}
			if($itemAry['postage'] != ''){
				$xml2nd->addChild('postage', ($itemAry['postage']));
			}
			
			//旧配送方法は使用不可とする。
// 			$xml3rd = $xml2nd->addChild('deliverys');//<delivery>タグのオブジェクト
// 				$xml3rd->addChild('deliveryId', $itemAry['deliveryId']);
// 				$xml3rd->addChild('deliverySeq', '1');
			
			
// 			$xml3rd = $xml2nd->addChild('deliveryMethod');
// 				$xml3rd->addChild('deliveryMethodId', $itemAry['deliveryMethodId']);
// 				$xml3rd->addChild('deliveryMethodSeq', '1');
		
			
			if($itemAry['sellEndDate'] != ''){
				$xml2nd->addChild('sellEndDate', $itemAry['sellEndDate']);
			}
// 			$xml2nd->addChild('countdownTimerConfig', $itemAry['countdownTimerConfig']);
// 			$xml2nd->addChild('sellNumberDispConfig', $itemAry['sellNumberDispConfig']);
// 			$xml2nd->addChild('buyNumLimtConfig', $itemAry['buyNumLimtConfig']);
// 			$xml2nd->addChild('buyNumMax', $itemAry['buyNumMax']);

			if($itemAry['publicStartDate'] != ''){
				$xml2nd->addChild('publicStartDate', ($itemAry['publicStartDate']));
			}
			if($itemAry['giftPackingSegment'] != ''){
				$xml2nd->addChild('giftPackingSegment', ($itemAry['giftPackingSegment']));
			}
			if($itemAry['noshiSegment'] != ''){
				$xml2nd->addChild('noshiSegment', ($itemAry['noshiSegment']));
			}
			if($itemAry['limitedOrderSegment'] != ''){
				$xml2nd->addChild('limitedOrderSegment', ($itemAry['limitedOrderSegment']));
			}
			if($itemAry['limitedOrderCount'] != ''){
				$xml2nd->addChild('limitedOrderCount', ($itemAry['limitedOrderCount']));
			}
			$xml2nd->addChild('description', ($itemAry['description']));
			$xml2nd->addChild('descriptionForSP', ($itemAry['descriptionForSP']));
			$xml2nd->addChild('descriptionForPC', ($itemAry['descriptionForPC']));
			
			if($itemAry['detailTitle'] != ''){
				$xml2nd->addChild('detailTitle', ($itemAry['detailTitle']));
			}
			if($itemAry['detailDescription'] != ''){
				$xml2nd->addChild('detailDescription', ($itemAry['detailDescription']));
			}
			
			
			//specの数だけ繰り返し処理
			if( (isset($itemAry['specTitle'])) && ($itemAry['specTitle'] != '') ){
				$xml3rd = $xml2nd->addChild('specs');
				for ($i = 0; $i < 5; $i++) {
					if(isset($itemAry['specTitle' .strVal($i + 1)])){
						$xml4th = $xml3rd->addChild('detailSpecs');
						$xml4th->addChild('specName', ($itemAry['spec' .strVal($i + 1)]));
						$xml4th->addChild('spec', ($itemAry['spec' .strVal($i + 1)]));
						$xml4th->addChild('specSeq', (strVal($i + 1)));
					}
				}
			}
					
			//検索キーワードの数だけ繰り返し処理
			for ($i = 0; $i < 10; $i++) {
				if(isset($itemAry['searchKeyword' .strVal($i + 1)])){
					if($itemAry['searchKeyword' .strVal($i + 1)] != ''){
						$xml3rd = $xml2nd->addChild('searchKeywords');
						$xml2nd->addChild('searchKeyword', ($itemAry['searchKeyword' .strVal($i + 1)]));
						$xml2nd->addChild('searchSeq', (strVal($i + 1)));
					}
				}
			}
			
			if( (isset($itemAry['specTitle'])) && ($itemAry['specTitle'] != '') ){
				$xml2nd->addChild('searchTarget', ($itemAry['searchTarget']));
			}
			
			
			//image 画像の数だけ繰り返し処理
			for ($i = 0; $i < 20; $i++) {
				if(isset($itemAry['imageUrl' .strVal($i + 1)])){
					if($itemAry['imageUrl' .strVal($i + 1)] != ''){
						$xml3rd = $xml2nd->addChild('images');
						$xml3rd->addChild('imageUrl', ($itemAry['imageUrl' .strVal($i + 1)]));
						if( (isset($itemAry['imageName'])) && ($itemAry['imageName'] != '') ){
							$xml3rd->addChild('imageName', ($itemAry['imageName' .strVal($i + 1)]));
						}
						$xml3rd->addChild('imageSeq', strVal($i + 1));
					}
				}
			}
			
			if($itemAry['categoryId'] != ''){
				$xml2nd->addChild('categoryId', ($itemAry['categoryId']));
			}
			if($itemAry['tagId'] != ''){
				$xml2nd->addChild('tagId', ($itemAry['tagId']));
			}
			
			//カテゴリーの数だけ繰り返し処理
			for ($i = 0; $i < 10; $i++) {
				if(isset($itemAry['shopCategory' .strVal($i + 1)])){
					if($itemAry['shopCategory' .strVal($i + 1)] != ''){
						$xml3rd = $xml2nd->addChild('shopCategory');
						$xml3rd->addChild('shopCategoryName', ( $itemAry['shopCategory'. strVal($i + 1)]));
						$xml3rd->addChild('shopCategoryDispSeq', strVal($i + 1));
					}
				}
			}
			
			if($itemAry['jan'] != ''){
				$xml2nd->addChild('jan', ($itemAry['jan']));
			}
			if($itemAry['isbn'] != ''){
				$xml2nd->addChild('isbn', ($itemAry['isbn']));
			}
			if($itemAry['itemModel'] != ''){
				$xml2nd->addChild('itemModel', ($itemAry['itemModel']));
			}
			if($itemAry['limitedPasswd'] != ''){
				$xml2nd->addChild('limitedPasswd', ($itemAry['limitedPasswd']));
			}
			if($itemAry['limitedPasswdPageTitle'] != ''){
				$xml2nd->addChild('limitedPasswdPageTitle', ($itemAry['limitedPasswdPageTitle']));
			}
			if($itemAry['limitedPasswdPageMessage'] != ''){
				$xml2nd->addChild('limitedPasswdPageMessage', ($itemAry['limitedPasswdPageMessage']));
			}
			if($itemAry['saleStatus'] != ''){
				$xml2nd->addChild('saleStatus', ($itemAry['saleStatus']));
			}
			
			
			//オプションの数だけ繰り返し処理
			for ($i = 0; $i < 10; $i++) {
				if(isset($itemAry['itemOption' .strVal($i + 1)])){
					if($itemAry['itemOption' .strVal($i + 1)] != ''){
						$xml3rd = $xml2nd->addChild('itemOption' .strVal($i + 1));
						$xml3rd->addChild('itemOption', ($itemAry['itemOption' .strVal($i + 1)]));
						$xml3rd->addChild('itemOptionTitle', ($itemAry['itemOption' .strVal($i + 1)]));
						$xml3rd->addChild('itemOptionSeq', strVal($i + 1));
					}
				}
			}
			
			/*
			 * 購入オプション（手数料型）
			 * 	
			$xml3rd = $xml2nd->addChild('itemOptionCommissions');
				
			$xml2nd->addChild('itemOptionCommissionTitle1', $itemAry['itemOptionCommissionTitle1']);
			$xml2nd->addChild('itemOptionCommissionVal1', $itemAry['itemOptionCommissionVal1']);
			$xml2nd->addChild('itemOptionCommissionNote1', $itemAry['itemOptionCommissionNote1']);
			$xml2nd->addChild('itemOptionCommissionTitle2', $itemAry['itemOptionCommissionTitle2']);
			$xml2nd->addChild('itemOptionCommissionVal2', $itemAry['itemOptionCommissionVal2']);
			$xml2nd->addChild('itemOptionCommissionNote2', $itemAry['itemOptionCommissionNote2']);
			...20まで繰り返し
			 */
			
			$xml2nd->addChild('pointRate', ($itemAry['pointRate']));
// 			$xml2nd->addChild('favoriteCount', $itemAry['favoriteCount']);
// 			$xml2nd->addChild('receiptRequestCount', $itemAry['receiptRequestCount']);
			if($itemAry['stockRequestConfig'] != ''){
				$xml2nd->addChild('stockRequestConfig', ($itemAry['stockRequestConfig']));
			}
// 			$xml2nd->addChild('stockRequestCount', $itemAry['stockRequestCount']);

			if($itemAry['deliveryLeadtimeId'] != ''){
				$xml2nd->addChild('deliveryLeadtimeId', ($itemAry['deliveryLeadtimeId']));
			}
			
			$xml2nd = $xml1st->addChild('registerStock');
			$xml2nd->addChild('stockSegment', ($itemAry['stockSegment']));
			
			
			/* -----------------------------------------------
			 * stockSegment='1'（通常在庫のとき）
			 * ----------------------------------------------- */
			if($itemAry['stockSegment'] =='1'){
				$xml2nd->addChild('stockCount', ($itemAry['stockCount']));
				
			/* -----------------------------------------------
			 * stockSegment='2'（選択肢別在庫のとき）
			 * ----------------------------------------------- */
			}elseif($itemAry['stockSegment'] =='2'){
				//choicesStockHorizontalItemName
				if($itemAry['choicesStockHorizontalItemName'] != ''){
					$xml2nd->addChild('choicesStockHorizontalItemName', $itemAry['choicesStockHorizontalItemName']);
				}
				//choicesStockVerticalItemName
				if($itemAry['choicesStockVerticalItemName'] != ''){
					$xml2nd->addChild('choicesStockVerticalItemName', $itemAry['choicesStockVerticalItemName']);
				}
				
				for( $cntI = 0; $cntI < count($stockReArys); $cntI++){
					
					//繰り返し数を作成
					$reCnt = 0;
					if($cntI + 1 <= count($stockReArys)){
						$reCnt = $cntI + 1;
					}elseif($cntI + 1 < count($stockReArys)){
						$reCnt = count($stockReArys);
					}
					
					/* --------------------------------------
					 * choicesStockHorizontals
					 -------------------------------------- */
					//重複しないものだけ格納する
					$doubleCnt = 0;
					for( $cntJ = 1; $cntJ < $reCnt; $cntJ++){
						if($stockReArys[$cntI]['choicesStockHorizontalSeq'] == $stockReArys[$cntI - $cntJ]['choicesStockHorizontalSeq'] && $cntI != 0){
							$doubleCnt++;
						}
					}
					//重複しない場合、XMLノードの追加を行う
					if($doubleCnt == 0 ){
						$xml3rd = $xml2nd->addChild('choicesStockHorizontals');
							$xml3rd->addChild('choicesStockHorizontalCode', $stockReArys[$cntI]['choicesStockHorizontalCode']);
							$xml3rd->addChild('choicesStockHorizontalName', $stockReArys[$cntI]['choicesStockHorizontalName']);
							$xml3rd->addChild('choicesStockHorizontalSeq', $stockReArys[$cntI]['choicesStockHorizontalSeq']);
					}
					
					
					/* --------------------------------------
					 * choicesStockVerticals
					 -------------------------------------- */
					//重複しないものだけ格納する
					$doubleCnt = 0;
					for( $cntJ = 1; $cntJ < $reCnt; $cntJ++){
						if($stockReArys[$cntI]['choicesStockVerticalSeq'] == $stockReArys[$cntI - $cntJ]['choicesStockVerticalSeq'] && $cntI != 0){
							$doubleCnt++;
						}
					}
					//重複しない場合、XMLノードの追加を行う
					if($doubleCnt == 0 ){
						$xml3rd = $xml2nd->addChild('choicesStockVerticals');
							$xml3rd->addChild('choicesStockVerticalCode', $stockReArys[$cntI]['choicesStockVerticalCode']);
							$xml3rd->addChild('choicesStockVerticalName', $stockReArys[$cntI]['choicesStockVerticalName']);
							$xml3rd->addChild('choicesStockVerticalSeq', $stockReArys[$cntI]['choicesStockVerticalSeq']);
					}
					
					/* --------------------------------------
					 * choicesStocks
					 -------------------------------------- */
					$xml3rd = $xml2nd->addChild('choicesStocks');
					$xml3rd->addChild('choicesStockVerticalCode', $stockReArys[$cntI]['choicesStockVerticalCode']);
					$xml3rd->addChild('choicesStockHorizontalCode', $stockReArys[$cntI]['choicesStockHorizontalCode']);
					$xml3rd->addChild('choicesStockCount', $stockReArys[$cntI]['choicesStockCount']);
					$xml3rd->addChild('choicesStockShippingDayId', $stockReArys[$cntI]['choicesStockShippingDayId']);
				}
				
			
				if($itemAry['choicesStockUpperDescription'] != ''){
					$xml2nd->addChild('choicesStockUpperDescription', $itemAry['choicesStockUpperDescription']);
				}
				if($itemAry['choicesStockLowerDescription'] != ''){
					$xml2nd->addChild('choicesStockLowerDescription', $itemAry['choicesStockLowerDescription']);
				}
				if($itemAry['displayChoicesStockSegment'] != ''){
					$xml2nd->addChild('displayChoicesStockSegment', $itemAry['displayChoicesStockSegment']);
				}
				if($itemAry['displayChoicesStockThreshold'] != ''){
					$xml2nd->addChild('displayChoicesStockThreshold', $itemAry['displayChoicesStockThreshold']);
				}
				if($itemAry['displayBackorderMessage'] != ''){
					$xml2nd->addChild('displayBackorderMessage', $itemAry['displayBackorderMessage']);
				}
			}
			/* -----------------------------------------------
			 * stock.csvが存在する場合
			 * ----------------------------------------------- */
			
		/* ----------------------------------------------
		 * XMLの作成 END
		 * ---------------------------------------------- */
		//DOMDocument生成 encodingは任意で
		$dom = new \DOMDocument('1.0', 'utf-8');
		
		//DOMNodeをコピーして返す。第2引数trueで属性もコピー
		//DOMElementはDOMNodeを継承している
		//この$xmlは上記で作ったSimpleXMLElement
		$node = $dom->importNode(dom_import_simplexml($xml1st), true);
		
		//コピーしたDOMNodeを追加
		$dom->appendChild($node);
		
		//余分な空白を取り除く
		$dom->preserveWhiteSpace = false;
		
		//きれいに整形した出力を行う
		$dom->formatOutput = true;
		
		//ファイルに出力
		$dom->save('./sample.xml');
		
		//dd($xml1st);
// 		dd($xml1st->asXML());
		return $xml1st->asXML();
	}

	/**
	 * エスケープ処理
	 * XMLの値の中に&が入ってるとエラーで落ちるので
	 *
	 * @param String
	 * @return String
	 */
	public function _h($value)
	{
		return htmlspecialchars($value, ENT_QUOTES);
	}
	
	/**
	 * 
	 * 空文字のチェックを行う
	 * 配列の中身が''の場合は''を返却し、存在する場合はその値を返却する
	 * @param array $array
	 * @return String $data
	 */
	private function check_empty($aryData)
	{
		//存在チェック
		if(!empty($aryData)){
			$chkData = $aryData;
		}elseif(empty($aryData)){
			$chkData = '';
		}else{
			dd($aryData);
		}
		
		return $chkData;
	}
	
	/**
	 * chkArrayData
	 * 任意のキーで配列の存在チェック。
	 * 存在する場合は空チェックをし、存在しない場合は''をチェック。
	 * @param array $array
	 * @return String $key
	 */
	private function chkArrayData($array, String $key)
	{
		//存在チェック
		if(!isset($array[$key])){
			$array = '';
			return $array;
		}else{
			if(empty($array[$key]) or (!isset($array[$key]))){
				$array = '';
				return $array;
			}
		}
		
		return $array[$key];
	}
}