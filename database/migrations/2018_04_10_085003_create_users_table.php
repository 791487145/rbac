<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('email');
			$table->string('qq', 20)->nullable()->comment('QQ');
			$table->string('py', 25)->nullable()->comment('拼音');
			$table->string('password');
			$table->string('telephone', 21)->nullable()->comment('电话');
			$table->string('remember_token', 100)->nullable()->comment('盐');
			$table->string('birthday', 50)->nullable()->comment('生日');
			$table->integer('status')->nullable()->default(1)->comment('状态-1删除；1：正常;2禁用');
			$table->timestamps();
			$table->string('remark')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
