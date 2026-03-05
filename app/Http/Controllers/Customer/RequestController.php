<?php

    namespace App\Http\Controllers\Customer;

    use App\Http\Controllers\Controller;
    use App\Models\BusinessProducts;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use App\Models\Offer;
    use App\Models\Order;
    use Illuminate\Http\Request;

    class RequestController extends Controller {
        protected $phone;

        public function index() {
            $orderBy = (\request()->get('order') == 'older') ? 'asc' : 'desc';
            $status = \request()->get('status');

            $query = Order::with('offers', 'technic')->where('is_tender', 0)->where('customer_id', \request()->user()->id);

            if ($status && $status !== 'all') {
                $query->where('status', $status);
            }

            $orders = $query->orderBy('created_at', $orderBy)->paginate(env('PER_PAGE', 20));

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Заявки' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.customer.request.index', [
                'metaTags' => $metaTags,
                'orders' => $orders
            ]);

        }

        public function view($lang, $order_id) {
            $request = Order::with(['offer'])->find($order_id);

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Деталі заявки' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.customer.request.view', [
                'metaTags' => $metaTags,
                'lang' => $lang,
                'request' => $request
            ]);

        }

        public function accepted(Request $request, $lang) {
            $order = Order::find($request->order_id);
            $order->offers_id = $request->offer_id;
            $order->status = 'accepted';
            $order->save();

            $notificationText = NotificationMessage::select('id')->where('action', 'business.offer.accepted')->first();
            $notification = new Notification;
            $notification->user_id = $order->seller_id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->order_id = $order->id;
            $notification->offer_id = $order->offers_id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            return redirect()->route('customer::request.index', ['lang'=>$lang])->with('offer_details_status_accepted', '');

        }

        public function cancel($lang, $order_id) {
            $order = Order::find($order_id);
            $order->status = 'canceled';
            $order->save();

            $notificationText = NotificationMessage::select('id')->where('action', 'business.order.status.canceled_by_buyer')->first();
            $notification = new Notification;
            $notification->user_id = $order->seller_id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->order_id = $order->id;
            $notification->offer_id = $order->offers_id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            return redirect()->route('customer::request.index', ['lang'=>$lang])->with('offer_details_status_canceled', '');

        }

        public function cancel_offer($lang, $offer_id) {
            $offer = Offer::find($offer_id);
            $offer->status = 'canceled';
            $offer->canceled_by = 'client';
            $offer->save();

            $notificationText = NotificationMessage::select('id')->where('action', 'business.order.status.canceled_by_buyer')->first();
            $notification = new Notification;
            $notification->user_id = $offer->seller_id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->order_id = $offer->order_id;
            $notification->offer_id = $offer->id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            return redirect()->route('customer::request.index', ['lang'=>$lang])->with('offer_details_status_canceled', '');
        }

    }
