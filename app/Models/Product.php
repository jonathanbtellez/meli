<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use HasFactory, SoftDeletes;

	protected $fileable = [
		"name",
		"description",
		"stock",
		"price",
		"category_id"
	];
	public function image()
	{
		return $this->morphOne(Image::class, 'imageable');
	}

	public function category(){
		return $this->belongsTo(Category::class, 'category_id','id');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'product_user', 'user_id', 'product_id');
	}
}
