<?php

namespace Database\Seeders;

use App\Models\Image;
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
            'email' => 'jonathanbtellez@gmail.com',
            'email_verified_at' => now(),
            'password' => '12345678', // password
            'remember_token' => Str::random(10),
		]);

		$user->save();

		$users = User::get();

		foreach ($users as $user) {
			$image = new Image(['url'=>'https://res.cloudinary.com/dso0xjfh8/image/upload/v1707697705/meli/456322_kgj76p.webp']);
			$user->image()->save($image);
			if($user->id % 2 === 0){
				$user->assignRole('user');
			}else{
				$user->assignRole('admin');
			}
		}
	}
}
