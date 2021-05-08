<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return redirect()->route('user.home');
});

/* 
 * **************************************************
 * 管理者権限
 * **************************************************
 */
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
	
	Auth::routes([
		'register' => false, // デフォルトの登録機能OFF
		'verify'   => false, // メール確認機能OFF（※5.7系以上のみ）
		'reset'    => false  // メールリマインダー機能ON
	]);
	
	
	Route::get('login',     'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login',    'Auth\LoginController@login');
	
	/*
	 * 管理者認証後に使用可能
	 */
	Route::middleware('auth:admin')->group(function () {
		Route::get('home', 'HomeController@index')->name('home');
		
		//認証ページ
		Route::post('logout',   'Auth\LoginController@logout')->name('logout');
		Route::post('register',   'Auth\RegisterController@register');
		Route::get('register',   'Auth\RegisterController@showRegistrationForm')->name('register');
	

		
		/*
		 * ********************************************************
		 * システム担当者管理
		 * Admin詳細と編集へのルーティング
		 * ********************************************************
		 */
		Route::namespace('admin')->prefix('admin')->name('admin.')->group(function () {
			Route::get('home_admin', 'AdminController@index_admin')->name('home_admin');

			/*
			 * EDIT 20200816
			 * 登録画面は既存の仕組みで用意されているため不要
			 */
			//Route::get('create_admin', 'AdminController@create_admin')->name('create_admin');
			//Route::post('store_admin', 'AdminController@store_admin')->name('store_admin');

			Route::get('show_admin/{id}', 'AdminController@show_admin')->name('show_admin');
			Route::get('edit_admin/{id}', 'AdminController@edit_admin')->name('edit_admin');
			Route::post('update_admin/{id}', 'AdminController@update_admin')->name('update_admin');
		});
		
		/*
		 * ********************************************************
		 * ユーザ管理
		 * User詳細と編集へのルーティング
		 * ********************************************************
		 */
		Route::namespace('User')->prefix('user')->name('user.')->group(function () {
			Route::get('home_user', 'UserController@index_user')->name('home_user');
			Route::get('show_user/{id}', 'UserController@show_user')->name('show_user');
			Route::get('edit_user/{id}', 'UserController@edit_user')->name('edit_user');
			Route::post('update_user/{id}', 'UserController@update_user_role')->name('update_user');
			
			//EDIT 2020-08-13 削除機能の廃止
			//Route::post('destroy_admin/{id}', 'HomeController@destroy_admin')->name('destroy_admin');
			//Route::post('destroy_user/{id}', 'HomeController@destroy_user')->name('destroy_user');
		});
		
		/* 
		 * ********************************************************
		 * APPマスタ管理
		 * Show Update Destroy
		 * ********************************************************
		 */
		Route::namespace('M_app')->prefix('m_app')->name('m_app.')->group(function () {
			Route::get('home_m_app', 'AppController@index_m_app')->name('home_m_app');
			Route::get('create_m_app', 'AppController@create_m_app')->name('create_m_app');
			Route::post('store_m_app', 'AppController@store_m_app')->name('store_m_app');
			Route::get('edit_m_app/{id}', 'AppController@edit_m_app')->name('edit_m_app');
			Route::post('update_m_app/{id}', 'AppController@update_m_app')->name('update_m_app');
			Route::post('destroy_m_app/{id}', 'AppController@destroy_m_app')->name('destroy_m_app');
			
		});
	});
});

/* 
 * ************************************************************
 * 一般ユーザ
 * namespace(User) App\Http\Controllers\Userを省略できる
 * prefix() ルーティングのXXX/yyyのxxxを省略できる。
 * name() ルーティング名称のXXX/yyyのxxxを省略できる。
 * ->group()上記の条件でまとめて省略できる
 * ************************************************************
 */
Route::namespace('User')->prefix('user')->name('user.')->group(function () {
	Auth::routes([
		'register' => true, // デフォルトの登録機能ON	
		'verify'   => false, // メール確認機能OFF（※5.7系以上のみ）
		'reset'    => false  // メールリマインダー機能ON
	]);
	
	/*
	 * ユーザ認証後に使用可能
	 */
	Route::middleware('auth:user')->group(function () {
		/* -----------------------------
		 *	TOPメニュー
		 * -----------------------------
		 */
		Route::get('home', 'HomeController@index')->name('home');
		
		
		
		/* ---------------------------------
		 *	店舗情報
		 * --------------------------------- */
		Route::namespace('Shop')->prefix('shop')->name('shop.')->group(function () {
			Route::get('index/', 'ShopController@index')->name('index');
			Route::post('store_shop/', 'ShopController@store_shop')->name('store_shop');
			Route::post('update_shop/{id}', 'ShopController@update_shop')->name('update_shop');
			
			Route::get('edit_shop/{id}', 'AupayController@edit_shop')->name('edit_shop');
			// Route::post('update_shop/{id}', 'AupayController@update_shop')->name('update_shop');
		});
		
		
		
		/* ---------------------------------
		 *	CSVアップロード
		 * --------------------------------- */
		Route::namespace('Upload')->prefix('upload')->name('upload.')->group(function () {
			/*
			 * csv_upload
			 */
			Route::get('index/', 'UploadController@index')->name('index');
			Route::post('csv_upload/', 'UploadController@csv_upload')->name('csv_upload');
			Route::get('result_download/{id}', 'UploadController@result_download')->name('result_download');
			
		});
		/* ---------------------------------
		 *	CSVダウンロード
		 * --------------------------------- */
		Route::namespace('Download')->prefix('download')->name('download.')->group(function () {
			/*
			 * csv_download
			 */
			Route::get('index/', 'DownloadController@index')->name('index');
			Route::post('csv_download/', 'DownloadController@csv_download')->name('csv_download');
			Route::get('result_download/{id}', 'DownloadController@result_download')->name('result_download');
			
			// Route::get('show_csv_download/', 'AupayController@show_csv_download')->name('show_csv_download');
			Route::post('csv_create/', 'AupayController@csv_create')->name('csv_create');
			// Route::get('csv_download/{id}', 'AupayController@csv_download')->name('csv_download');
			
		});		
		
	});
	
	
});
