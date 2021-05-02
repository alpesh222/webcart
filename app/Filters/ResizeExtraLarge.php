<?php

namespace App\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ResizeExtraLarge implements FilterInterface
{
	public function applyFilter(Image $image)
	{
		return $image->resize(425, 425, function ($constraint) {
			$constraint->aspectRatio();
		})->encode('jpg', 95);
	}
}