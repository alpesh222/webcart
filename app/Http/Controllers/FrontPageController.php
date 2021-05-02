<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class FrontPageController extends Controller
{
    public function show($slug) {

        $page = Page::where('slug', $slug)->where('is_active', 1)->where('is_active', 1)->firstOrFail();

        return view('front.page', compact('page'));
    }
}
