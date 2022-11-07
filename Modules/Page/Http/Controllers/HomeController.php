<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Page\Entities\Page;
use Modules\Media\Entities\File;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('public.home.index');
    }

    public function news()
    {
        $logo = File::findOrNew(setting('storefront_header_logo'))->path;
        $pages = Page::where('category_id', Page::news)->latest()->paginate(10);

        return view('public.pages.list', compact('pages', 'logo'));
    }

    public function show($slug)
    {
        $logo = File::findOrNew(setting('storefront_header_logo'))->path;
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('public.pages.show_detail', compact('page', 'logo'));
    }
}
