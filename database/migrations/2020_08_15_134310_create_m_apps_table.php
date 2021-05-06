<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMAppsTable extends Migration
{
	/**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('m_apps', function (Blueprint $table) {
			$table->bigIncrements('id')->nullable(false);
			$table->tinyInteger('app_no')->length(5)->comment('アプリNo')->unique()->nullable(false);
			$table->string('app_name',50)->comment('アプリ名称')->nullable(false);
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
		Schema::dropIfExists('m_apps');
	}
}
