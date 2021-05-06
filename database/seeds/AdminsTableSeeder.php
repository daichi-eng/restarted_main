<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
	/**
     * Run the database seeds.
     *
     * @return void
	 */
	public function run()
	{
		//
		DB::table('admins')->insert([
			[
				'name'              => 'admin',
				'email'             => 'admin@example.com',
				'password'          => Hash::make('12345678'),
				'remember_token'    => Str::random(10),
			],
			[
				'name'              => 'admin2',
				'email'             => 'admin2@example.com',
				'password'          => Hash::make('12345678'),
				'remember_token'    => Str::random(10),
			],
			[
				'name'              => 'admin3',
				'email'             => 'admin3@example.com',
				'password'          => Hash::make('12345678'),
				'remember_token'    => Str::random(10),
			],
			[
				'name'              => 'admin4',
				'email'             => 'admin4@example.com',
				'password'          => Hash::make('12345678'),
				'remember_token'    => Str::random(10),
			],
			[
				'name'              => 'daichi.yamano',
				'email'             => 'ore-yamano-daichi@ezweb.ne.jp',
				'password'          => Hash::make('6kwsg4gq-'),
				'remember_token'    => Str::random(10),
			],
		]);
	}
}
