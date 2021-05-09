<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\M_app;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
	/**
	 * 
	 * 
	 */
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	/**
	 * index()
	 * ホーム画面表示
	 * @return \Illuminate\Http\Response
	*/
	public function index()
	{
		
		// echo phpinfo();
		/*
		* EDIT 2020-08-08
		*/
		//$active_admin = Auth::admin();
		//管理者情報の取得
		$admins = Admin::select('id','name', 'email','created_at','updated_at')->orderBy('created_at', 'desc')->get();
		$admins = $admins->take(3);
		
		//ユーザー情報の取得
		//$users = User::paginate(10);
		$users = User::select('id','name', 'email','created_at','updated_at')->orderBy('created_at', 'desc')->get();
		$users = $users->take(3);
		
		//アプリマスタの取得
		$m_apps = M_app::select('id','app_no', 'app_name','created_at','updated_at')->orderBy('created_at', 'desc')->get();
		$m_apps = $m_apps->take(3);
		
		
		//dd($m_apps);
		
		//shop情報の存在の有無で分岐
		// if(isset($m_apps[0])){
			return view('admin.home', compact('admins', 'users','m_apps'));
		// }else{
		// 	//dd($m_apps);
		// 	$m_apps[0] = 0;
		// 	return view('admin.home', compact('admins', 'users','m_apps'));
		// }
		//return view('admin.home', compact('admins', 'users', 'active_admin'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show_admin($id)
	{
		$admin = Admin::find($id);
		return view('admin.show_admin', compact('admin'));
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show_user($id)
	{
		$user = User::find($id);
		return view('admin.show_user', compact('user'));
	}
	
	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update_admin(Request $request, $id)
	{
		$admin = Admin::find($id);
		
		$admin->name = $request->input('name');
		$admin->email = $request->input('email');
		$admin->save();
		
		return redirect('admin/home');
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update_user(Request $request, $id)
	{
		$user = User::find($id);
		$user->role = $request->input('role');
		$user->save();
		
		return redirect('admin/home');
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy_admin($id)
	{
		$admin = Admin::find($id);
		
		$admin->delete();
		
		return redirect('admin/home');
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy_user($id)
	{
		$admin = Admin::find($id);
		
		
		//$admin->name = $request->input('name');
		//$user->save();
		
		$admin->delete();
		return redirect('admin/home');
	}
}
