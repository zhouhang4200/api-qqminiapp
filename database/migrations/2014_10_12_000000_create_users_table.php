<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid')->comment('用户唯一标识');
            $table->string('unionid')->comment('用户在开放平台的唯一标识符');
            $table->string('name')->nullable();
            $table->string('phone')->unique()->nullable()->comment('手机号');
            $table->string('password')->nullable();
            $table->string('qq')->nullable()->comment('用户qq');
            $table->string('nickname')->nullable()->comment('小程序昵称');
            $table->string('email')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
