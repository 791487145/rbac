<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permissions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique()->comment('菜单名');
			$table->string('display_name')->nullable()->comment('路由名称');
			$table->string('description')->nullable();
			$table->integer('display_order')->nullable()->default(0)->comment('排序');
			$table->integer('module_type')->nullable()->comment('所属模型');
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
		Schema::drop('permissions');
	}

}
