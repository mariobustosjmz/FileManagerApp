<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Files extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('files', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name');
				$table->string('description');
				$table->string('file');
				$table->string('size');

				$table->integer('folder_id')->unsigned();
				$table->integer('extension_id')->unsigned();
				$table->integer('user_id')->unsigned();

				$table->timestamps();

				$table->foreign('folder_id')
				->references('id')->on('folders')
				->onDelete('cascade');

				$table->foreign('extension_id')
				->references('id')->on('extensions')
				->onDelete('cascade');

				$table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('cascade');

			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('files');
	}
}
