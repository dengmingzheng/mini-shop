<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateDouMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dou_movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ch_title',30)->nullable()->comment('中文名称');
            $table->string('zh_title',30)->nullable()->comment('英文名称');
            $table->string('another_name',100)->nullable()->comment('别名');
            $table->unsignedBigInteger('category_id')->index()->default(0)->comment('豆瓣分类名称');
            $table->string('types',20)->nullable()->comment('类型ID');
            $table->string('types_name',100)->nullable()->comment('类型名称');
            $table->unsignedBigInteger('region_id')->default(0)->comment('地区ID');
            $table->string('region_name',100)->nullable()->comment('地区名称');
            $table->string('tags',20)->nullable()->comment('标签ID');
            $table->string('tags_name',200)->nullable()->comment('标签名称');
            $table->float('rate',2,1)->default(0)->comment('评分');
            $table->unsignedBigInteger('rate_num')->default(0)->comment('评价人数');
            $table->unsignedBigInteger('comment_num')->default(0)->comment('评论人数');
            $table->string('actors',200)->comment('演员');
            $table->string('length_time',60)->comment('时长');
            $table->char('year',4)->comment('发行年份');
            $table->string('is_use',100)->comment('上映时间');
            $table->string('image_path')->comment('主图地址');
            $table->foreign('category_id')->references('id')->on('dou_categories')->onDelete('cascade');
            $table->unique('ch_title','zh_title');
            $table->timestamps();
            $table->comment = '豆瓣电影表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dou_movies');
    }
}
