<?php

    namespace App\Http\Controllers\Business;

    use App\Http\Controllers\Controller;
    use App\Models\Business;
    use App\Models\Subscription;
    use App\Models\SubscriptionHistory;
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    use Illuminate\Support\Facades\Auth;
    use Maksa988\WayForPay\Collection\ProductCollection;
    use Maksa988\WayForPay\Domain\Client;
    use Maksa988\WayForPay\Facades\WayForPay;
    use WayForPay\SDK\Domain\Product;


    class SubscriptionController extends Controller {

        protected $merchantAccount = 'test_merch_n1';
        protected $merchantPassword = "flk3409refn54t54t*FNJRET";
//        protected $merchantPassword = "flk3409refn54t54t*FNJRET";


        protected function gateway($url, $data) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HEADER => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_POSTFIELDS => $data
            ]);

            $response = curl_exec($curl);
            $response = json_decode($response, true);
            curl_close($curl);

            return $response;
        }

        public function index($lang) {
            $businessOwner = User::where('id', \request()->user()->id)->first();
            $subscription = Subscription::where('type', 'package')
                ->where('seller_id', \request()->user()->id)
                ->latest()
                ->first();

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Оформлення підписки' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.business.subscription.index', [
                'metaTags' => $metaTags,
                'businessOwner' => $businessOwner,
                'subscription' => $subscription
            ]);

        }

        public function history($lang) {
            $subscription = Subscription::where('seller_id', \request()->user()->id)
                ->where('type', 'package')
                ->latest()
                ->first();

            $subscriptions = Subscription::with(['items'])
                ->where('type', 'slot')
                ->where('seller_id', \request()->user()->id)
                ->where('active_to', '>', Carbon::now())
                ->get();

            $totalSubscriptionSlot = [];
            foreach($subscriptions as $slots) {
                if($slots->type == 'slot') {
                    $countSlot = $slots->count - count($slots->items);
                    $totalSubscriptionSlot[] = $countSlot;
                }
            }


            $histories = Subscription::with(['items'])
                ->where('seller_id', \request()->user()->id)
                ->orderByDesc('created_at')
                ->get();

            $subscribeArray = Subscription::with(['items'])
                ->where('seller_id', \request()->user()->id)
                ->where('status', 'Approved')
                ->where('active_to', '>=', date('Y-m-d h:i:s'))
                ->orderBy('type')
                ->orderByDesc('active_to')
                ->get();

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Підписка' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.business.settings.subscription.index', [
                'metaTags' => $metaTags,
                'subscription' => $subscription,
                'subscriptionSlot' => array_sum($totalSubscriptionSlot),
                'subscribeArray' => $subscribeArray,
                'histories' => $histories,
            ]);

        }

        public function create(Request $request, $lang) {
            $now = time();
            $request->productPrice = 1;
            if($request->type == 'package') {
                $productPrice = $request->productPrice * (($request->productPrice == '299.99') ? 1 : 12);
            } else {
                $productPrice = ($request->productPrice * $request->count) * $request->period;

            }

            $orderReference = 'XS-'.$now;
            $productName = ($request->type == 'package') ? 'Оплата тарифного пакету Експерт' : 'Оплата додадкового пакету';

            $string = $this->merchantAccount . ';' . env('APP_URL') . ';';
            $string .= $orderReference . ';';
            $string .= $now.';';

            $string .= $productPrice.';UAH;';
            $string .= $productName.';1;';
            $string .= $productPrice;

            $hash = hash_hmac("md5", $string, $this->merchantPassword);

            print '
                <form method="post" action="https://secure.wayforpay.com/pay" accept-charset="utf-8" class="form">
                    <input hidden name="merchantAccount" value="'.$this->merchantAccount.'">
                    <input hidden name="merchantAuthType" value="SimpleSignature">
                    <input hidden name="merchantDomainName" value="'.env('APP_URL').'">
                    <input hidden name="merchantSignature" value="'. $hash .'">
                    <input hidden name="orderReference" value="'.$orderReference.'">
                    <input hidden name="orderDate" value="'.$now.'">
                    <input hidden name="amount" value="' . $productPrice . '">
                    <input hidden name="returnUrl" value="'. route('frontend::subscription.success', ['lang'=>app()->getLocale(), 'type'=>$request->type, 'count'=>$request->count, 'period'=>$request->period ]) .'">
                    <input hidden name="currency" value="UAH">
                    <input hidden name="orderTimeout" value="49000">
                    <input hidden name="productName[]" value="'.$productName.'">
                    <input hidden name="productPrice[]" value="' . $productPrice . '">
                    <input hidden name="productCount[]" value="1">
                    <input hidden name="defaultPaymentSystem" value="card">
                    <input hidden name="clientEmail" value="'.\request()->user()->email .'">
                    <input hidden name="clientPhone" value="'.\request()->user()->phone.'">
                    <button class="btn-pay" type="submit"></button>
                </form>
            <style> .btn-pay { display: none; } </style>
            <script src="/assets/vendor/jquery-3.2.1.min.js"></script> <script> $(".btn-pay").click();</script>';

        }

        public function success(Request $request, $lang) {

            $user = User::where('email', $request->email)->first();
            Auth::guard('business')->login($user);

            $latestOrder = Subscription::get();
            $order_id = time();
            $order_number = str_pad(($latestOrder) ? count($latestOrder) + 1 : 1, 8, "0", STR_PAD_LEFT);

            $paymentResponse = json_encode($request->all());
            $paymentResponseDecode = json_decode($paymentResponse, true);

            $paymentResponseDecode['transactionStatus'] = 'Approved';
            $business = Business::where('user_id', $user->id)->first();


            $period = ($request->type == 'package') ? ($request->amount == '299.99') ? 1 : 12 : $request->period;

            $subscribe = new Subscription();
            $subscribe->seller_id = $user->id;
            $subscribe->business_id = $business->id;
            $subscribe->added_manually = 0;
            $subscribe->order_id = $order_id ?? null;
            $subscribe->status = $paymentResponseDecode['transactionStatus'];
            $subscribe->order_number = 'XS'.$order_number ?? null;
            $subscribe->type = $request->type;

            $subscribe->count = ($request->type == 'slot') ? $request->count : null;

            $subscribe->price = $request->amount;
            $subscribe->period = $period;

            $subscribe->response = $paymentResponse ?? null;
            $subscribe->active_to = ($paymentResponseDecode['transactionStatus'] == 'Approved') ? ($request->amount == '299.99') ? Carbon::now()->addMonth(1) : Carbon::now()->addMonth(12) : null;

            $subscribe->save();

//            if($request->type == 'package') {
//                $data = [
//                    "requestType"=> "CREATE",
//                    "merchantAccount"=> $this->merchantAccount,
//                    "merchantPassword"=> $this->merchantPassword,
//                    "regularMode"=> "once",
//                    "amount"=> $subscribe->price,
//                    "currency"=> "UAH",
//                    "dateBegin"=> Carbon::now()->format('d.m.Y'),
//                    "dateEnd"=> Carbon::now()->addDays(27)->format('d.m.Y'),
//                    "orderReference"=> $paymentResponseDecode['orderReference'],
//                    "email"=> $user->email
//
//                ];
//
//                $this->gateway('https://api.wayforpay.com/regularApi', $data);
//
//            }
            return redirect()->route('business::settings.profile.index', ['lang' => app()->getLocale()])->with('success', 'Success');

        }



        public function renewal() {
            $renewalDate = Carbon::now()->addDays(2)->format('Y-m-d');
            $renewalArray = Subscription::selectRaw("*, DATE_FORMAT(active_to,'%Y-%m-%d') as active_to")
                ->where('status', 'Approved')
                ->whereDate('active_to', $renewalDate)
                ->get();

            foreach($renewalArray as $renewal) {
                $parseResponse = json_decode($renewal->response, true);
                $result['recToken'] = $parseResponse['recToken'];

                $now = time();
                $orderReference = 'XS-'.$now;
                $productName = ($renewal->type == 'package') ? 'Оплата тарифного пакету Експерт' : 'Оплата додадкового пакету';
                $productPrice = $renewal->price;
                $string = $this->merchantAccount . ';' . env('APP_URL') . ';';
                $string .= $orderReference . ';';
                $string .= $now.';';

                $string .= $productPrice.';UAH;';
                $string .= $productName.';1;';
                $string .= $productPrice;

                $hash = hash_hmac("md5", $string, $this->merchantPassword);

                $data = [
                    "transactionType"=>"CHARGE",
                    "merchantAccount"=>$this->merchantAccount,
                    "merchantAuthType"=>"SimpleSignature",
                    "merchantDomainName"=>env('APP_URL'),
                    "merchantTransactionType"=>"AUTH",
                    "merchantTransactionSecureType"=> "NON3DS",
                    "merchantSignature"=>$hash,
                    "apiVersion"=>1,
                    "orderReference"=> $orderReference,
                    "orderDate"=>$now,
                    "amount" => $productPrice,
                    "currency"=>"UAH",
                    "card"=>"4111111111111111",
                    "expMonth"=>"11",
                    "expYear"=>"2020",
                    "cardCvv"=>"111",
                    "cardHolder"=>"TARAS BULBA",
                    "productName"=>["Samsung WB1100F","Samsung Galaxy Tab 4 7.0 8GB 3G Black"],
                    "productPrice"=>[21.1,30.99],
                    "productCount"=>[1,2],
                    "clientFirstName"=>"Bulba",
                    "clientLastName"=>"Taras",
                    "clientCountry"=>"UKR",
                    "clientEmail"=>"rob@mail.com",
                    "clientPhone"=>"380556667788",

                ];
            }




//                $this->gateway('https://api.wayforpay.com/api', $data);

            dd($result);
        }

        public function remove($lang, $subscribe_id) {
            $subscribe = Subscription::find($subscribe_id);
            $subscribe->status = 'Deactivate';
            $subscribe->save();
            return redirect()->back();

        }

    }
