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
			$table->string('mime')->nullable();

			$table->integer('folder_id')->unsigned();
			$table->integer('extension_id')->unsigned();
			$table->integer('user_id')->unsigned();

			$table->timestamps();

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
