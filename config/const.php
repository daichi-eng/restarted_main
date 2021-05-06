<?php

return [
	/*
	 * ---------------------------
	 * au Pay用　API使用定数
	 * ---------------------------
	 */
	'Au_pay' => [
		'BASE_URL' => 'https://api.manager.wowma.jp/wmshopapi',
		'Content-Type' => 'application/xml; charset=utf-8',
		
		/*
		 * ---------------------------
		 * メソッドごとのエンドポイント
		 * ---------------------------
		 * 'メソッド' => 'エンドポイント'
		 */
		//在庫情報取得
		'searchStocks' => 'searchStocks',
		
		//商品情報取得（複数）
		'searchItemInfos' => 'searchItemInfos',
		
		//商品情報更新（複数）
		'updateItemInfos' => 'updateItemInfos',
		
		//商品情報登録
		'registerItemInfo' => 'registerItemInfo',
		
		//
		'updateAPIKey' => 'updateAPIKey',
		
	],
	
	

];
