<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateDouCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dou_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('用户id');
            $table->unsignedBigInteger('movie_id')->index()->comment('影视id');
            $table->float('rate',2,1)->default(0)->comment('评分');
            $table->string('content')->comment('评论内容');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('dou_movies')->onDelete('cascade');
            $table->timestamps();
            $table->comment = '豆瓣评论表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dou_comments');
    }
}
