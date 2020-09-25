<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateDouRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dou_regions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',60)->unique()->comment('豆瓣地区名称');
            $table->timestamps();
            $table->comment = '豆瓣地区表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dou_regions');
    }
}
