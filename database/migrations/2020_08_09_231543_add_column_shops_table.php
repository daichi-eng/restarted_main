<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnShopsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	*/
	public function up()
	{
		Schema::table('shops', function (Blueprint $table) {
			//
			$table->unsignedInteger('shop_num')->default(0)->after('id')->comment('会員番号');
		});
	}

	/**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down()
	{
		Schema::table('shops', function (Blueprint $table) {
			//
		});
	}
}
