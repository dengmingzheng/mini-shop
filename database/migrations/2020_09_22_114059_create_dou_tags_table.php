<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateDouTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dou_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',30)->unique()->comment('豆瓣标签名称');
            $table->timestamps();
            $table->comment = '豆瓣标签表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dou_tags');
    }
}
