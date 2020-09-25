<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50)->unique()->comment('banner图名称');
            $table->string('position',30)->nullable()->comment('banner图位置');
            $table->string('image_src',200)->nullable()->comment('图片地址');
            $table->unsignedSmallInteger('type')->index()->default(0)->comment('链接类型打开方式');
            $table->string('open_type',20)->nullable()->comment('链接类型打开方式');
            $table->string('navigator_url')->nullable()->comment('链接地址');
            $table->unsignedTinyInteger('sort')->default(0)->comment('排序');
            $table->boolean('status')->default(true)->comment('状态  0-禁用 1-启用');
            $table->timestamps();
            $table->comment="banner图";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
