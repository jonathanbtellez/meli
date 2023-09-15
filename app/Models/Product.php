<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

	public function image()
	{
		return $this->morphOne(Image::class, 'imageable');
	}

	public function users()
	{
		return $this->belongsToMany(User::class,'product_user','user_id','product_id');
	}
}
