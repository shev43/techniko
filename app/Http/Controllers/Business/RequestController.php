<?php

    namespace App\Http\Controllers\Business;

    use App\Http\Controllers\Controller;
    use App\Models\Order;
    use function request;

    class RequestController extends Controller {
        public function __construct() {

        }

        public function index() {
            $requests = Order::with('technic')
                ->where('seller_id', request()->user()->id)
                ->where('is_tender', '0')
                ->where('status', 'new')
                ->orderBy('created_at', (\request()->get('order') == 'older') ? 'asc' : 'desc')
                ->paginate(env('PER_PAGE', 20));

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Заявки' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.business.request.index', [
                'metaTags' => $metaTags,
                'requests' => $requests
            ]);

        }

        public function view($lang, $order_id) {
            $request = Order::with('offers', 'customer', 'seller', 'technic')
                ->where('id', $order_id)
                ->first();

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Деталі заявки' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.business.request.view', [
                'metaTags' => $metaTags,
                'request' => $request
            ]);

        }


    }
