<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
			[
				'name'              => 'user',
				'email'             => 'user1@example.com',
				'password'          => Hash::make('12345678'),
				'remember_token'    => Str::random(10),
				'created_at' => time(),
				'updated_at' => time(),
			],
			[
				'name'              => 'user2',
				'email'             => 'user2@example.com',
				'password'          => Hash::make('12345678'),
				'remember_token'    => Str::random(10),
				'created_at' => time(),
				'updated_at' => time(),
			],
			[
				'name'              => 'user3',
				'email'             => 'user3@example.com',
				'password'          => Hash::make('12345678'),
				'remember_token'    => Str::random(10),
				'created_at' => time(),
				'updated_at' => time(),
			],
			[
				'name'              => 'user4',
				'email'             => 'user4@example.com',
				'password'          => Hash::make('12345678'),
				'remember_token'    => Str::random(10),
				'created_at' => time(),
				'updated_at' => time(),
			],
			[
				'name'              => 'user5',
				'email'             => 'user5@example.com',
				'password'          => Hash::make('12345678'),
				'remember_token'    => Str::random(10),
				'created_at' => time(),
				'updated_at' => time(),
			],
			[
				'name'              => 'user6',
				'email'             => 'user6@example.com',
				'password'          => Hash::make('12345678'),
				'remember_token'    => Str::random(10),
				'created_at' => time(),
				'updated_at' => time(),
			],			
			[
				'name'              => 'user7',
				'email'             => 'user7@example.com',
				'password'          => Hash::make('12345678'),
				'remember_token'    => Str::random(10),
				'created_at' => time(),
				'updated_at' => time(),
			],
			[
				'name'              => 'user8',
				'email'             => 'user8@example.com',
				'password'          => Hash::make('12345678'),
				'remember_token'    => Str::random(10),
				'created_at' => time(),
				'updated_at' => time(),
			],
			[
				'name'              => 'user9',
				'email'             => 'user9@example.com',
				'password'          => Hash::make('12345678'),
				'remember_token'    => Str::random(10),
				'created_at' => time(),
				'updated_at' => time(),
			],
		]);
	}
}
