<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
	public function getCaptcha() {
		$md5_hash = md5(rand(0,999));
		$captcha_code = substr($md5_hash, 16, 5);

		session(['captcha_code' => $captcha_code]);

		$width = 205;
		$height = 60;
		$image = ImageCreate($width, $height);

		$white = ImageColorAllocate($image, 255, 255, 255);
		$black = ImageColorAllocate($image, 0, 0, 0);
		$grey = ImageColorAllocate($image, 204, 204, 204);

		$font = imageloadfont(public_path('/fonts/hootie.gdf'));
		imagestring($image, $font, 50, 20, $captcha_code, $black);

		ImageRectangle($image,0,0,$width-1,$height-1,$grey);
		imageline($image, 0, $height/2, $width, $height/2, $grey);
		imageline($image, $width/2, 0, $width/2, $height, $grey);

		header("Content-Type: image/jpeg");
		ImageJpeg($image);
		ImageDestroy($image);
	}
}
