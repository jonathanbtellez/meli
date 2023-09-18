<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$categories = [
			array(
				'name' => 'Tecnology',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			),
			array(
				'name' => 'Home',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			),
			array(
				'name' => 'Sports',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			),
			array(
				'name' => 'Kids',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			),
			array(
				'name' => 'Pets',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			)
		];
		DB::table('categories')->insert($categories);
	}
}
