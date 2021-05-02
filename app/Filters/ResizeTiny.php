<?php

namespace App\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ResizeTiny implements FilterInterface
{
	public function applyFilter(Image $image)
	{
		return $image->resize(80, 80, function ($constraint) {
			$constraint->aspectRatio();
		})->encode('jpg', 70);
	}
}