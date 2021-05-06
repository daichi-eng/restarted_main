<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppRoleTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('app_roles', function (Blueprint $table) {
			//
			$table->bigIncrements('app_role_id');
			$table->tinyInteger('app_no')->length(5)->comment('アプリNo');
			$table->bigInteger('user_id')->length(20)->comment('ユーザID');
			$table->boolean('app_role')->default(0)->comment('アプリ権限');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('app_roles', function (Blueprint $table) {
			//
		});
	}
}
