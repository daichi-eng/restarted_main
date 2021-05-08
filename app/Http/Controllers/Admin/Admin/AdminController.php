<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin_store_validation;
use App\Http\Requests\Admin\Admin_update_validation;
use App\Models\Admin;

class AdminController extends Controller
{
	/**
	 *
	 */
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	/**
	 * index_admin
	 * @return \Illuminate\Http\Response
	*/
	public function index_admin()
	{
		//管理者情報の取得
		$admins = Admin::select('id','name', 'email','created_at','updated_at')
				->orderBy('updated_at', 'desc')
				->paginate(10);
		return view('admin.admin.home_admin', compact('admins'));
	}

	/**
	 * create_admin
	 * @return \Illuminate\Http\Response
	 */
	public function create_admin()
	{
		return view('admin.admin.create_admin');
	}
	
	/**
	 * store_admin
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store_admin(Admin_store_validation $request)
	{
		$admin = new Admin;
		$admin->name = $request->input('name');
		$admin->email = $request->input('email');
		
		//dd($m_app->app_no, $m_app->app_name);\
		$admin->save();
		
		return redirect('admin/admin/home_admin');
	}
	
	/**
	 * show_admin
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show_admin($id)
	{
		$admin = Admin::find($id);
		return view('admin.admin.show_admin', compact('admin'));
	}
	
	
	/**
	* edit_admin
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit_admin($id)
	{
		$admin = Admin::find($id);
		return view('admin.admin.edit_admin', compact('admin'));
	}

	/**
	 * Admin_update_validation
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update_admin(Admin_update_validation $request, $id)
	{
		$admin = Admin::find($id);
		$admin->name = $request->input('name');
		$admin->email = $request->input('email');
		$admin->save();
		
		return redirect('admin/admin/home_admin');
	}
	
	/**
	 * destroy_admin($id)
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy_admin($id)
	{
		$admin = Admin::find($id);
		
		$admin->delete();
		
		return redirect('admin/home');
	}
}
