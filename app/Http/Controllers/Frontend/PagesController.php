<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller {

    public function index() {
        $metaTags = [
            'metaTitle' => (app()->getLocale() == 'ua') ? 'Головна' : 'Home',
            'metaKeywords' => '',
            'metaDescription' => ''
        ];
        return view('frontend.guest.pages.index', ['metaTags'=>$metaTags]);
    }
}
