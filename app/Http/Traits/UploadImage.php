<?php

namespace App\Http\Traits;

use App\Models\Product;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File as FileSystem;

trait UploadImage
{
	private function uploadImage($model, $request)
	{
		if (!isset($request->file)) return;
		$random = Str::random(20);
		$path = $this->getRoute($model);
		$this->deleteImage($model);
		$imageName = "{$random}.{$request->file->clientExtension()}";
		$request->file->move(storage_path("app/public/{$path}"), $imageName);
		$image = new Image(['url' => "/storage/{$path}/{$imageName}"]);
		$model->image()->save($image);
	}

	private function deleteImage($model)
	{
		$image = Image::where('imageable_id', $model->id)
			->where('imageable_type', get_class($model))
			->first();
		if (!$image) return;
		$imageIsNotDefault = $image->url != "/storage/{$this->getRoute($model)}/default.png";
		$issetFile = FileSystem::exists(public_path($image->url));
		if ($issetFile && $imageIsNotDefault) {
			FileSystem::delete(public_path($image->url));
		}
		$image->delete();
	}

	private function getRoute($model)
	{
		$routes = [
			Product::class => 'images/products',
			User::class => 'images/users'
		];
		return $routes[get_class($model)] ?? 'images';
	}
}
