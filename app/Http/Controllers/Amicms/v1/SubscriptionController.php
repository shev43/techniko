<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Models\Business;
use App\Models\Subscription;
use App\Models\SubscriptionHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends AmicmsController {
    private $layout = [];

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Підписки';

    }

    public function index() {
        $business_array = Business::with(['seller'])->whereHas('subscription')->paginate(env('AMICMS_PER_PAGE'));

        return view('amicms.subscription.index', ['layout' => $this->layout, 'business_array' => $business_array]);

    }

    public function view($business_id) {
        $business = Business::with(['seller', 'subscription', 'subscriptions'])->find($business_id);

        return view('amicms.subscription.view', ['layout' => $this->layout, 'business' => $business]);

    }
}
