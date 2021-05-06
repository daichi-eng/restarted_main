<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class M_app_validation extends FormRequest
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
			 * create_m_app.blade.php
			 * アプリの新規登録画面
			 */
			'app_no' => 'required|max:99999|integer|unique:m_apps,app_no',
			'app_name' => 'required|string|max:50|unique:m_apps,app_name',
		];
	}
}
