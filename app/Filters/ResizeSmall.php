<?php

namespace App\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ResizeSmall implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 70);
    }
}