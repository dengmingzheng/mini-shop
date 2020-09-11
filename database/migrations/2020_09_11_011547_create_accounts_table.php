<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username',30)->unique()->comment('登录用户名');
            $table->string('password')->comment('登录密码');
            $table->unsignedInteger('login_num')->default(0)->comment('登录次数');
            $table->timestamp('last_login_time')->nullable()->comment('上次登陆时间');
            $table->timestamp('login_time')->nullable()->comment('本次登陆时间');
            $table->timestamps();
            $table->softDeletes();
            $table->comment="后台登录用户表";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
