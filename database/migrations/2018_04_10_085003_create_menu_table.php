<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menu', function(Blueprint $table)
		{
			$table->increments('id')->comment('自增索引');
			$table->string('name', 32)->nullable()->comment('菜单名称');
			$table->string('route', 100)->nullable()->comment('路由');
			$table->string('icon', 20)->nullable()->comment('图标');
			$table->integer('pid')->default(0)->comment('父级id');
			$table->boolean('level')->nullable()->comment('菜单等级');
			$table->string('note')->nullable()->comment('菜单说明信息');
			$table->integer('sort')->default(0)->comment('排序');
			$table->boolean('status')->nullable()->default(1)->comment('0:删除；1：正常');
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
		Schema::drop('menu');
	}

}
