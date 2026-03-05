<?php

    namespace App\Http\Controllers\Business;

    use App\Http\Controllers\Controller;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use App\Models\Offer;
    use App\Models\Order;


    class AcceptedController extends Controller {
        public function index() {
            $orderBy = (\request()->get('order') == 'older') ? 'asc' : 'desc';
            $offers = Offer::whereHas('order', function($q) {
                $q->whereNotNull('offers_id');
            })->where('seller_id', \request()->user()->id)->orderBy('created_at', $orderBy)->paginate(env('PER_PAGE', 20));

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Замовлення' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.business.accepted.index', [
                'metaTags' => $metaTags,
                'offers' => $offers
            ]);

        }

        public function view($lang, $offer_id) {
            $request = Order::with('offers', 'customer', 'seller', 'technic')
                ->where('offers_id', $offer_id)
                ->first();

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Деталі замовлення' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.business.accepted.view', [
                'metaTags' => $metaTags,
                'request' => $request
            ]);

        }

        public function status($lang, $status, $offer_id) {
            $request = Order::where('offers_id', $offer_id)->first();
            $request->status = $status;
            $request->save();


            if($request->status == 'accepted') {
                $customer_action = 'customer.order.status.accepted';
            } elseif($request->status == 'executed') {
                $customer_action = 'customer.order.status.executed';
            } else {
                $customer_action = 'customer.order.status.done';
            }

            $notificationText = NotificationMessage::select('id')->where('action', $customer_action)->first();
            $notification = new Notification;
            $notification->user_id = $request->customer_id;
            $notification->business_id = $request->seller->business->id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->order_id = $request->id;
            $notification->is_customer = 1;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            return redirect()->route('business::accepted.index', ['lang'=>$lang]);

        }

    }
