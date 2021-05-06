<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\M_app;
use App\Models\App_role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	/**
	 *
	 */
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	*/
	public function index_user()
	{
		
		//ユーザーidの全取得
		//$users = User::paginate(10);
		$user_ids = User::select('id','name')
				->orderBy('created_at', 'desc')
				->get();
		
		$user_role_array = array();
		
		foreach($user_ids as $user_id){
			
			//ユーザーごとに登録されているアプリ名称を取得
			$role_m_apps = DB::table('m_apps')
				->select('m_apps.app_name', 'm_apps.app_no', 'app_roles.app_role_id')
				->leftjoin('app_roles', 'm_apps.app_no', '=', 'app_roles.app_no')
				->where('app_roles.user_id', '=', $user_id['id'])
				->orWhereNull('app_roles.user_id')
				->get();
			
			$user_role_array[$user_id['id']] = $role_m_apps;
		}
		//dd($user_role_array);
		
		//ユーザー情報の全取得（paginations）
		$users = User::select('id','name', 'email','created_at','updated_at')
			->orderBy('updated_at', 'desc')
			->paginate(3);
			
		//dd($user_role_array[1]);
			
		return view('admin.user.home_user', compact('users', 'user_role_array'));
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
	public function edit_user($id)
	{
		$user = User::find($id);
		
		//サブクエリを作成
		$sub = DB::table('app_roles')
			->select('app_roles.app_no', 'app_roles.app_role_id')
			->where('app_roles.user_id', '=', $id);
			//->toSql();//この段階では->get()せずにサブクエリとして使用
			//->get();
		//dd($sub_SQL);
		/*
		$role_m_apps = DB::table('m_apps')
			->select('m_apps.id','m_apps.app_name', 'm_apps.app_no', 'sub_SQL.app_role_id')
//			->select('m_apps.app_name', 'm_apps.app_no')
 				->leftJoinSub($sub_SQL, 'sub_SQL', function($join){
 						$join->on('m_apps.app_no', '=', 'sub_SQL.app_no');
 				})
				->get();
		*/
		$query = DB::table('m_apps')
			->select('m_apps.id','m_apps.app_name', 'm_apps.app_no', 'sub.app_role_id')
			->leftJoin(DB::raw('('. $sub->toSql() .') as sub'), 'm_apps.app_no', '=', 'sub.app_no')
			//サブクエリのWHERE句の値をバインド
			->mergeBindings($sub);
			$role_m_apps = $query->get();
		
		
		//return view('admin.user.edit_user', compact('user'));
		return view('admin.user.edit_user', compact( 'user', 'role_m_apps'));
	}


	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update_user_role(Request $request, $id)
	{
		$requests = $request->input();
		
		//trueのapp_noのみ権限として登録
		foreach($requests as $key=>$value){
			if($value == 'true'){
				$t_array[] = $key;
			}elseif ($value=='false'){
				$f_array[] = $key;
			}
		}
		
		if(isset($t_array)){
			foreach($t_array as $value){
				
				//すでに登録されていないかチェック
				$app_roles_cnt = DB::table('app_roles')
				->where('app_roles.app_no',$value)
				->where('app_roles.user_id', $id)
				->exists();
				
				if(!$app_roles_cnt){
					DB::table('app_roles')->insert(
						['app_no' => $value, 'user_id' => $id]
						);
				}
			}
			
		}
		if(isset($f_array)){
			foreach($f_array as $value){
				
				//すでに登録されていないかチェック
				$app_roles_cnt = DB::table('app_roles')
					->where('app_roles.app_no',$value)
					->where('app_roles.user_id', $id)
					->exists();
				
				if($app_roles_cnt){
					//dd($app_roles_cnt);
					DB::table('app_roles')
					->where('app_roles.app_no',$value)
					->where('app_roles.user_id', $id)
					->delete();
				}
			}
		}
		
		return redirect('admin/user/home_user');
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy_user($id)
	{
		/*
		$admin = Admin::find($id);
		
		$admin->delete();
		return redirect('admin/user/home_user');
		*/
	}
}
