<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$this->call(UsersTableSeeder::class);
	}
}

use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$faker = Faker::create();

		for ($i = 0; $i < 20; $i++) {

			\DB::table('users')->insert(array(
				'name' => $faker->firstName . ' ' . $faker->lastName,
				'email' => $faker->companyEmail,
				'password' => bcrypt($faker->password),
				'rol_id' => $faker->randomElement(['1', '2', '3']),
				//'rememberToken' => $faker->password,
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			));

		}
	}
}
