<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FilesRel extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::table('files', function (Blueprint $table) {

			$table->foreign('folder_id')
				->references('id')->on('folders');
			//->onDelete('cascade');

			$table->foreign('extension_id')
				->references('id')->on('extensions');
			//->onDelete('cascade');

			$table->foreign('user_id')
				->references('id')->on('users');
			//->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

	}
}
