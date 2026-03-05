<?php

    namespace App\Http\Controllers\Customer;

    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Frontend\CatalogController;
    use App\Models\Business;
    use App\Models\BusinessContacts;
    use App\Models\BusinessFactories;
    use App\Models\BusinessProducts;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use App\Models\Offer;
    use App\Models\Order;
    use App\Models\Subscription;
    use App\Models\Technic;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class TenderController extends Controller {

        protected $phone;

        public function index() {
            $orderBy = (\request()->get('order') == 'older') ? 'asc' : 'desc';
            $orders = Order::with('offers', 'machine', 'technic')->where('is_tender', 1)->where('customer_id', \request()->user()->id)->orderBy('created_at', $orderBy)->paginate(env('PER_PAGE', 20));

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Тендери' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.customer.tender.index', [
                'metaTags' => $metaTags,
                'orders' => $orders
            ]);

        }

        public function create() {
            $getMachines = new CatalogController;
            $machines = $getMachines->getMachines();

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Створити тендер' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.customer.tender.create', [
                'metaTags' => $metaTags,
                'machines'=>$machines
            ]);

        }

        public function store(Request $request, $lang) {
            $validator = Validator::make($request->all(), [
                'machine_id' => 'required',
                'min_price' => 'required',
                'max_price' => 'required',
                'count' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'date_of_delivery' => 'required',
                'is_driver' => 'required',
            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При сохранении компании произошла ошибка, подробности смотрите ниже');

            }

            $latestEntry = Order::get();
            $order_number = str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);

            $date_of_delivery = explode(' — ', $request->date_of_delivery);

            $start_date_of_delivery = date('Y-m-d', strtotime($date_of_delivery[0]));
            $end_date_of_delivery = date('Y-m-d', strtotime($date_of_delivery[1] ?? $date_of_delivery[0]));

            $order = new Order();
            $order->customer_id = \request()->user()->id;
            $order->seller_id = null;
            $order->offers_id = null;
            $order->machine_id = $request->machine_id ?? null;
            $order->is_tender = 1;
            $order->is_driver = $request->is_driver;
            $order->order_number = 'XT' . $order_number;
            $order->name = null;
            $order->hours = null;
            $order->count = $request->count;
            $order->min_price = $request->min_price;
            $order->max_price = $request->max_price;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->phone = $request->phone;
            $order->comment = $request->comment;
            $order->type_of_delivery = 'business';
            $order->date_of_delivery = $start_date_of_delivery;
            $order->start_date_of_delivery = $start_date_of_delivery;
            $order->end_date_of_delivery = $end_date_of_delivery;
            $order->address = $request->address;
            $order->map_latitude = $request->map_latitude;
            $order->map_longitude = $request->map_longitude;
            $order->map_zoom = $request->map_zoom;
            $order->map_rotate = $request->map_rotate;
            $order->marker_latitude = $request->marker_latitude;
            $order->marker_longitude = $request->marker_longitude;
            $order->status = 'new';
            $order->save();

            $buildBusinessTechnics = Technic::with('business')
                ->where('machine_id', $order->machine_id)
                ->whereBetween('price', [$order->min_price, $order->max_price])
                ->groupBy('business_id')
                ->get();

            foreach($buildBusinessTechnics as $technic) {
                $subscription = Subscription::where('seller_id', $technic->business->user_id)->latest()->first();
                $notificationText = NotificationMessage::select('id')->where('action', (!empty($subscription)) ? 'business.tender.new.subscribed' : 'business.tender.new.unsubscribed')->first();
                $notification = new Notification;
                $notification->user_id = $technic->business->user_id;
                $notification->business_id = $technic->business_id;
                $notification->business_product_id = $technic->id;
                $notification->notification_messages_id = $notificationText->id;
                $notification->order_id = $order->id;
                $notification->is_customer = 0;
                $notification->is_sendmail = 0;
                $notification->is_new = 1;
                $notification->save();

            }



            return redirect()->route('customer::tender.index', ['lang'=>app()->getLocale()])->with('offer_details_status_new', '');

        }


        public function view($lang, $order_id, $offer_id) {
            $order = Order::find($order_id);
            $request = $order->with(['offer'])->find($order_id);

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Деталі пропозиції' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.customer.tender.view', [
                'metaTags' => $metaTags,
                'request' => $request
            ]);

        }

        public function view_offers($lang, $order_id) {
            $order = Order::find($order_id);
            $request = $order->with(['offers'])->find($order_id);

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Пропозиції' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.customer.tender.view-offer', [
                'metaTags' => $metaTags,
                'request' => $request
            ]);

        }

        public function accepted(Request $request, $lang) {
            $order = Order::find($request->order_id);
            $order->offers_id = $request->offer_id;
            $order->seller_id = $request->seller_id;
            $order->technic_id = $request->technic_id;
            $order->status = 'accepted';
            $order->save();


            $rejectOffers = Offer::where('order_id', $order->id)->where('id', '<>', $order->offers_id)->get();
            foreach($rejectOffers as $reject) {
                $rejectOffer = Offer::find($reject->id);
                $rejectOffer->status = 'canceled';
                $rejectOffer->canceled_by = 'client';
                $rejectOffer->canceled_comment = 'Покупець обрав іншого продавця';
                $rejectOffer->save();

                $notificationText = NotificationMessage::select('id')->where('action', 'business.tender.canceled_by_buyer')->first();
                $notification = new Notification;
                $notification->user_id = $rejectOffer->seller_id;
                $notification->notification_messages_id = $notificationText->id;
                $notification->order_id = $order->id;
                $notification->offer_id = $order->offers_id;
                $notification->is_customer = 0;
                $notification->is_sendmail = 0;
                $notification->is_new = 1;
                $notification->save();
            }


            $notificationText = NotificationMessage::select('id')->where('action', 'business.tender.accepted_by_buyer')->first();
            $notification = new Notification;
            $notification->user_id = $order->seller_id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->order_id = $order->id;
            $notification->offer_id = $order->offers_id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();


            return redirect()->route('customer::tender.index', ['lang'=>$lang])->with('offer_details_status_accepted', '');

        }

        public function canceled($lang, $order_id) {
            $order = Order::find($order_id);
            $rejectOffers = Offer::where('order_id', $order->id)->get();
            foreach($rejectOffers as $reject) {
                $rejectOffer = Offer::find($reject->id);
                $rejectOffer->status = 'canceled';
                $rejectOffer->canceled_by = 'client';
                $rejectOffer->canceled_comment = 'Покупець відмінив заявку';
                $rejectOffer->save();

                $notificationText = NotificationMessage::select('id')->where('action', 'business.order.status.canceled_by_buyer')->first();
                $notification = new Notification;
                $notification->user_id = $rejectOffer->seller_id;
                $notification->notification_messages_id = $notificationText->id;
                $notification->order_id = $order->id;
                $notification->offer_id = $rejectOffer->id;
                $notification->is_customer = 0;
                $notification->is_sendmail = 0;
                $notification->is_new = 1;
                $notification->save();
            }
            $order->status = 'canceled';
            $order->save();

            if(!empty($order->seller_id)) {
                $notificationText = NotificationMessage::select('id')->where('action', 'business.tender.canceled_by_buyer')->first();
                $notification = new Notification;
                $notification->notification_messages_id = $notificationText->id;
                $notification->user_id = $order->seller_id;
                $notification->order_id = $order->id;
                $notification->is_customer = 0;
                $notification->is_sendmail = 0;
                $notification->is_new = 1;
                $notification->save();
            }

            return redirect()->route('customer::tender.index', ['lang'=>$lang])->with('offer_details_status_canceled', '');

        }

        public function cancel_offer($lang, $order_id, $offer_id) {
            $offer = Offer::find($offer_id);
            $offer->status = 'canceled';
            $offer->canceled_by = 'client';
            $offer->save();

            return redirect()->route('customer::tender.view-offers', ['lang'=>$lang, 'order_id'=>$order_id])->with('offer_details_status_canceled', '');
        }


    }
