<?php

namespace App\Http\Controllers\User\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Store_shop_validation extends FormRequest
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
			// Store_shop() ショップの新規登録
			// 'shop_num' => 'required|numeric|digits:8|unique:shops,shop_num',
			// 'shop_api_key' => 'required|alpha_num|max:255',

			'shop_api_key' => 'required|alpha_num|max:255',
			// 'shop_num' => 'required|numeric|digits:8|unique:shops',
            // 'shop_num'     => 'required|numeric|unique:shops,shop_num,' .$this->input('shop_num') .',shop_num',
			
			// Rule::unique('shops')->ignore($this->input('shop_num'))

		];
	}
}
