<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateDouTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dou_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',20)->unique()->comment('豆瓣类型名称');
            $table->timestamps();
            $table->comment = '豆瓣类型表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dou_types');
    }
}
