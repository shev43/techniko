<?php

    namespace App\Http\Controllers\Business;

    use App\Http\Controllers\Controller;
    use App\Models\Business;
    use App\Models\BusinessContacts;
    use App\Models\Order;
    use App\Models\Subscription;

    class TenderController extends Controller {
        public function index() {
            $requests = Order::with('offers')
                ->whereHas('technics_by_machine', function ($q) {
                    $q->whereRaw('technics.price >= orders.min_price');
                    $q->whereRaw('technics.price <= orders.max_price');
                })
                ->whereNull('offers_id')
                ->where('is_tender', '1')
                ->where('status', 'new')
                ->orderBy('created_at', (\request()->get('order') == 'older') ? 'asc' : 'desc')
                ->paginate(env('PER_PAGE', 20));

            $subscription = Subscription::where('seller_id', \request()->user()->id)
                ->where('type', 'package')
                ->latest()
                ->first();



            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Тендери' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.business.tender.index', [
                'metaTags'=>$metaTags,
                'requests' => $requests,
                'subscription' => $subscription,

            ]);

        }

        public function view($lang, $view_type, $order_id) {
            $order = Order::find($order_id);
            $request = $order->with(['offer', 'customer', 'technics_by_machine' => function($q) use ($order) {
                    $q->where('price', '>', $order->min_price);
                    $q->where('price', '<', $order->max_price);
                    $q->orderBy('price');
                }
            ])->find($order_id);

            $business = Business::where('user_id', request()->user()->id)->first();
            $contacts = BusinessContacts::where('business_id', $business->id)->get();

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Деталі пропозиції' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view(($view_type == 'request') ? 'frontend.business.tender.view' : 'frontend.business.tender.view-offer', [
                'metaTags'=>$metaTags,
                'request' => $request,
                'contacts'=>$contacts
            ]);

        }

        public function canceled($lang, $order_id) {
            $order = Order::find($order_id);
            $order->status = 'canceled';
            $order->save();

            return redirect()->route('business::tender.index', ['lang'=>$lang])->with('offer_details_status_canceled', '');

        }



    }
