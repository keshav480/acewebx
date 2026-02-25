<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PublicPageController extends Controller
{
     public function show($slug)
    {
        $page = Page::where('slug', $slug)->first();

        if (!$page) {
            abort(404, 'Page not found');
        }

        return view('public.pages.template.default', compact('page'));
    }
    public function shortcode(){
        return 'test';
    }
}
