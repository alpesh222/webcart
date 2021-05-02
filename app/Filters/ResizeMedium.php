<?php

namespace App\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ResizeMedium implements FilterInterface
{
	public function applyFilter(Image $image)
	{
		return $image->resize(230, 130, function ($constraint) {
			$constraint->aspectRatio();
		})->encode('jpg', 75);
	}
}