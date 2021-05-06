<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Admin_update_validation extends FormRequest
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
			 * create_admin.blade.php
			 * アプリの更新画面
			 */
			'name' => [
				'required',
				'max:255',
				'string',
			],
			'email' => [
				'required',
				'email',
				'max:255',
				Rule::unique('App\Models\Admin')->ignore($this->id),
			],
		];
	}
}
