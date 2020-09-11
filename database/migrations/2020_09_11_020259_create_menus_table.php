<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',30)->upinue()->comment('菜单名称');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('父类ID');
            $table->string('group',20)->comment('分组名称');
            $table->string('url',50)->comment('URL');
            $table->unsignedTinyInteger('sort')->default(255)->comment('排序');
            $table->boolean('is_show')->default(true)->comment('是否显示 0:不显示 1:显示');
            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
            $table->timestamps();
            $table->comment = '菜单表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
