<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class HomeController extends Controller
{
    /**
     * 
     */
    public function __construct()
    {
        $this->middleware('auth:user');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stMsg = '';//メッセージの初期化
        
        $userId = Auth::id();
        $user = User::find(Auth::id());
        
        try {
            //クエリビルダ
            $shop = DB::table('shops')
            ->select('id','shop_num', 'shop_api_key', 'updated_at')
            ->where('user_id',$userId)
            ->get();
        } catch (Exception $e) {
            $stMsg = $e->getCode();
        }finally {
            return view('user.home', compact('stMsg', 'user' , 'shop'  ));
        }
		
	}

}
