<?php

    namespace App\Http\Controllers\Customer;

    use App\Http\Controllers\Controller;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use App\Models\Offer;
    use App\Models\Order;
    use Illuminate\Http\Request;

    class OfferController extends Controller {

        public function index($lang, $order_id) {
            $orderBy = (\request()->get('order') == 'older') ? 'asc' : 'desc';
            $offers = Offer::with(['order', 'seller'])->where('order_id', $order_id)->orderBy('created_at', $orderBy)->paginate(env('PER_PAGE', 20));

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Offers' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.customer.offers.index', [
                'metaTags' => $metaTags,
                'offers' => $offers
            ]);
        }

        public function view($lang, $offer_id) {
            $offer = Offer::with(['order'])->find($offer_id);

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Offer detail' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.customer.offers.view', [
                'metaTags' => $metaTags,
                'lang' => $lang,
                'offer' => $offer
            ]);

        }


    }
