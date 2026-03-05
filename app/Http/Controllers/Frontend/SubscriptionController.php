<?php

    namespace App\Http\Controllers\Frontend;

    use App\Http\Controllers\Controller;
    use App\Models\Business;
    use App\Models\Subscription;
    use App\Models\SubscriptionHistory;
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    use Maksa988\WayForPay\Collection\ProductCollection;
    use Maksa988\WayForPay\Domain\Client;
    use Maksa988\WayForPay\Facades\WayForPay;
    use WayForPay\SDK\Domain\Product;


    class SubscriptionController extends Controller {
        public function index($lang) {
            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Оформлення підписки' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.business.subscription.index', [
                'metaTags' => $metaTags,
            ]);

        }


    }
