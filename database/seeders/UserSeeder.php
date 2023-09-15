<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		User::factory(10)->create();
		$user =new User([
            'name' => 'Jonathan',
			'last_name'=>'Tellez',
			'role' => 'admin',
            'email' => 'jonathanbtellez@gmail.com',
            'email_verified_at' => now(),
            'password' => '12345678', // password
            'remember_token' => Str::random(10),
		]);

		$user->save();
	}
}
