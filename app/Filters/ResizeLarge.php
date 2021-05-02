<?php

namespace App\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ResizeLarge implements FilterInterface
{
	public function applyFilter(Image $image)
	{
		return $image->resize(305, 350, function ($constraint) {
			$constraint->aspectRatio();
		});
	}
}