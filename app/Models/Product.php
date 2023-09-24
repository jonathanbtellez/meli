<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
	use HasFactory, SoftDeletes;

	// protected $fileable = [
	// 	"name",
	// 	"description",
	// 	"stock",
	// 	"price",
	// 	"category_id"
	// ];

	protected $guarded = [];

	protected $appends = ['format_description'];

	/**
	 * Accessory method thar return the short description
	 */
	public function FormatDescription(): Attribute
	{
		return Attribute::make(
			get: function ($value, $attributes) {
				return Str::limit($attributes['description'], 50,  '...');
			}

		);
	}

	public function image()
	{
		return $this->morphOne(Image::class, 'imageable');
	}

	public function category(){
		return $this->belongsTo(Category::class, 'category_id','id');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'product_users', 'user_id', 'product_id');
	}
}
