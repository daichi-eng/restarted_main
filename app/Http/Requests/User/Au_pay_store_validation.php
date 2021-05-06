<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class Au_pay_store_validation extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		//EDIT 20200816
		//return false;
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			/*
			 * create_shop.blade.php
			 * ショップの新規登録画面
			 */
			'user_id' => 'required|max:20|unique:shops,user_id',
			'shop_num' => 'required|numeric|max:8|unique:shops,shop_num',
			'shop_mail' => 'required|email|max:255',
			'shop_pass' => 'required|alpha_num|max:255',
			'shop_api_key' => 'required|alpha_num|max:255',
		];
	}
}
