<?php

namespace App\Http\Controllers\Admin\M_app;

use App\Http\Controllers\Controller;
use App\Models\M_app;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\M_app_validation;

class AppController extends Controller
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
	public function index_m_app()
	{
		//アプリマスタの取得
		$m_apps = M_app::paginate(10);
		
		//dd($m_apps);
		
		//shop情報の存在の有無で分岐
		if(isset($m_apps[0])){
			return view('admin.m_app.home_m_app', compact('m_apps'));
		}else{
			//dd($m_apps);
			return view('admin.m_app.home_m_app');
		}
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_m_app()
    {
        return view('admin.m_app.create_m_app');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function store_m_app(M_app_validation $request)
	{
		$m_app = new M_app;
		$m_app->app_no = $request->input('app_no');
		$m_app->app_name = $request->input('app_name');
		
		//dd($m_app->app_no, $m_app->app_name);
		
		$m_app->save();
		
		return redirect('admin/m_app/home_m_app');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show_m_app($id)
	{
	 //
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function edit_m_app($id)
	{
		//dd($id);
		$m_app = M_app::find($id);
		
		//dd($m_app);
		
		return view('admin.m_app.edit_m_app', compact('m_app'));
	}

	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
	 */
	public function update_m_app(M_app_validation $request, $id)
	{
		$m_app = M_app::find($id);
		$m_app->app_no = $request->input('app_no');
		$m_app->app_name = $request->input('app_name');
		$m_app->save();
		
		return redirect('admin/m_app/home_m_app');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy_m_app($id)
	{
		$m_app = M_app::find($id);
		$m_app->delete();
		return redirect('admin/m_app/home_m_app');
		
	}
}
