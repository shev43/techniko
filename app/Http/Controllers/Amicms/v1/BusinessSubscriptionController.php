<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Models\Business;
use App\Models\Subscription;
use App\Models\SubscriptionHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BusinessSubscriptionController extends AmicmsController {
    private $layout = [];

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Орендодавці';

    }

    public function index($business_id) {
        $business = Business::with(['seller', 'subscription', 'subscriptions'])->where('id', $business_id)->withTrashed()->first();

        return view('amicms.business.subscription.index', ['layout' => $this->layout, 'business' => $business]);

    }

    public function subscribe(Request $request, $business_id) {
        $business = Business::with('seller')->where('id', $business_id)->withTrashed()->first();

        $latestOrder = Subscription::get();
        $order_id = time();
        $period = $request->period;
        $order_number = str_pad(($latestOrder) ? count($latestOrder) + 1 : 1, 8, "0", STR_PAD_LEFT);

        $subscribe = new Subscription();
        $subscribe->seller_id = $business->user_id;
        $subscribe->business_id = $business->id;
        $subscribe->added_manually = 1;
        $subscribe->order_id = $order_id ?? null;
        $subscribe->status = 'Approved';
        $subscribe->order_number = $order_number ?? null;
        $subscribe->response = null;
        $subscribe->type = $request->type;
        $subscribe->count = $request->count ?? null;
        $subscribe->price = 0;
        $subscribe->period = $period;
        $subscribe->active_to = Carbon::now()->addMonth( $period );
        $subscribe->save();

        return redirect()->back()->with('success', 'Подписка успешно оформлена');

    }

    public function deActivate(Request $request, $business_id, $subscription_id) {
        $subscription = Subscription::where('id', $subscription_id)->first();
        $subscription->status = 'Deactivate';
        $subscription->save();


        return redirect()->back()->with('success', 'Подписка успешно деативована');
    }


}
