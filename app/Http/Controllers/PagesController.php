<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Image, Redirect;
use App\Models\Page;

class PagesController extends Controller
{
    
    public function news_listing()
    {
    	$pages = Page::where('type', 'News')->where('status', 1)->paginate(10);
		return view('pages/news', ['pages'=>$pages]);
    }

    public function blog_listing()
    {
		$pages = Page::where('type', 'Blog')->where('status', 1)->paginate(10);
		return view('pages/blogs', ['pages'=>$pages]);
    }

    public function view($slug)
    {
    	$page = Page::where('slug', $slug)->where('status', 1)->first();
    	if($page)
			return view('pages/index', ['page'=>$page]);
		else
			abort('404');
    }

    public function post_page($slug)
    {
        $page = Page::where('slug', $slug)->where('status', 1)->first();
        if($page)
            return view('pages/post_page', ['page'=>$page]);
        else
            abort('404');
    }
}
