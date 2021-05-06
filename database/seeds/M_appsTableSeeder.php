<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class M_appsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//
		DB::table('m_apps')->insert([
			[
				'app_no'    => 10,
				'app_name'  => 'CSVアップロード au PAYマーケット（旧wowma!）',
				'created_at' => time(),
				'updated_at' => time(),
			],
			[
				'app_no'    => 20,
				'app_name'  => 'テストアプリ2',
				'created_at' => time(),
				'updated_at' => time(),
			],
			[
				'app_no'    => 30,
				'app_name'  => 'テストアプリ3',
				'created_at' => time(),
				'updated_at' => time(),
			],
			[
				'app_no'    => 40,
				'app_name'  => 'テストアプリ4',
				'created_at' => time(),
				'updated_at' => time(),
			],
			[
				'app_no'    => 50,
				'app_name'  => 'テストアプリ5',
				'created_at' => time(),
				'updated_at' => time(),
			],
			[
				'app_no'    => 60,
				'app_name'  => 'テストアプリ6',
				'created_at' => time(),
				'updated_at' => time(),
			],
			[
				'app_no'    => 70,
				'app_name'  => 'テストアプリ7',
				'created_at' => time(),
				'updated_at' => time(),
			],
		]);
	}
}
	