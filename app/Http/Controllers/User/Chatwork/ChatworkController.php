<?php

namespace App\Http\Controllers\User\Chatwork;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatworkController extends Controller
{
	public function post_msg(Request $request){
		$message = array(
			'body' => $request->input('message')
		);
		
		var_dump($request->input('message'));
		var_dump($request->input('api_key'));
		var_dump($request->input('room_id'));
		
		
		
		$token = $request->input('api_key');
		
		$room = $request->input('room_id');
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER,
			array('X-ChatWorkToken: '.$token));
		
		curl_setopt($ch, CURLOPT_URL, "https://api.chatwork.com/v2/rooms/".$room."/messages");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($message, '', '&'));
		$result = curl_exec($ch);
		curl_close($ch);
		
		//dd($result);
		return view('user.home', compact('result'));
		
	}
}
