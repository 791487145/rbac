<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuPermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menu_permissions', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('menu_id');
			$table->integer('permission_id')->unique('permissions_name_unique')->comment('菜单名');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menu_permissions');
	}

}
