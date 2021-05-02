<?php

namespace App\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ResizeNormal implements FilterInterface
{
	public function applyFilter(Image $image)
	{
		return $image->resize(400, 400, function ($constraint) {
			$constraint->aspectRatio();
		})->encode('jpg', 95);
	}
}