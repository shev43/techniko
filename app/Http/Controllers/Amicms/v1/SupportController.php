<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use Illuminate\Http\Request;

class SupportController extends AmicmsController {
    private $layout = [];

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Підтримка';

    }

    public function index() {
        return view('amicms.support.index', ['layout' => $this->layout]);

    }

}
