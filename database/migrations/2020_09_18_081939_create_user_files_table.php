<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filepath',200)->comment('ファイルパス')->nullable(false);
            $table->string('filename',50)->comment('ファイル名')->nullable(false);
            $table->tinyInteger('app_no')->length(5)->comment('アプリNo')->nullable(false);
            $table->bigInteger('user_id')->length(20)->comment('ユーザID');
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
        Schema::dropIfExists('user_files');
    }
}
