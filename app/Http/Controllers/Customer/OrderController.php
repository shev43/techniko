<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationMessage;
use App\Models\Order;
use App\Models\Report;
use App\Models\Technic;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function index($lang, $slug) {
        $technic = Technic::with('photo', 'business')->where('slug', $slug)->firstOrFail();
        if (!$technic) {
            throw new ModelNotFoundException();
        }

        $related_categories = Technic::with('photo', 'business')->where('id', '<>', $technic->id)->where('business_id', $technic->business_id)->whereIn('machine_id', explode(',', $technic->related_categories))->get();


        $report = Report::where('business_id', $technic->business_id)
            ->where('technic_id', $technic->id)
            ->where('action', 'offer_views')->firstOrCreate();

        $report->business_id = $technic->business_id ?? null;
        $report->technic_id = $technic->id ?? null;
        $report->action = 'offer_views';
        $report->count = $report->count + 1;
        $report->save();

        $metaTags = [
            'metaTitle' => (app()->getLocale() == 'ua') ? 'Деталі заявки' : 'Home',
            'metaKeywords' => '',
            'metaDescription' => ''
        ];

        return view('frontend.customer.order.index', [
            'metaTags' => $metaTags,
            'technic' => $technic,
            'related_categories' => $related_categories
        ]);

    }

    public function create(Request $request) {
//        dd($request->all());
        $latestEntry = Order::get();
        $order_number = str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);

        $date_of_delivery = explode(' — ', $request->date_of_delivery);

        $start_date_of_delivery = date('Y-m-d', strtotime($date_of_delivery[0]));
        $end_date_of_delivery = date('Y-m-d', strtotime($date_of_delivery[1] ?? $date_of_delivery[0]));

        $order = new Order();
        $order->customer_id = \request()->user()->id;
        $order->seller_id = $request->seller_id;
        $order->offers_id = $request->offers_id ?? null;
        $order->machine_id = $request->machine_id ?? null;
        $order->technic_id = $request->technic_id ?? null;
        $order->is_tender = $request->is_tender ?? 0;
        $order->order_number = 'XF' . $order_number;
        $order->name = $request->name;
        $order->photo = $request->photo;
        $order->hours = $request->hours;
        $order->count = $request->count;
        $order->min_price = $request->min_price;
        $order->max_price = $request->max_price;
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->comment = $request->comment;
        $order->phone = $request->phone;
        $order->type_of_delivery = $request->type_of_delivery;
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

        if(!empty($request->related)) {
            foreach($request->related as $related) {
                if(!empty($related['id'])) {
                    $relatedLatestEntry = Order::get();
                    $related_order_number = str_pad(($relatedLatestEntry) ? count($relatedLatestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);

                    $related_order = new Order();
                    $related_order->customer_id = \request()->user()->id;
                    $related_order->seller_id = $request->seller_id;
                    $related_order->offers_id = $request->offers_id ?? null;
                    $related_order->machine_id = $related['machine_id'] ?? null;
                    $related_order->technic_id = $related['technic_id'] ?? null;
                    $related_order->is_tender = $request->is_tender ?? 0;
                    $related_order->order_number = 'XF' . $related_order_number;
                    $related_order->name = $related['name'];
                    $related_order->photo = $related['photo'];
                    $related_order->hours = $related['hours'];
                    $related_order->count = $related['count'];
                    $related_order->min_price = $related['min_price'];
                    $related_order->max_price = $related['max_price'];
                    $related_order->first_name = $request->first_name;
                    $related_order->last_name = $request->last_name;
                    $related_order->comment = $request->comment;
                    $order->phone = $request->phone;
                    $related_order->type_of_delivery = $related['type_of_delivery'];
                    $related_order->date_of_delivery = $start_date_of_delivery;
                    $related_order->start_date_of_delivery = $start_date_of_delivery;
                    $related_order->end_date_of_delivery = $end_date_of_delivery;
                    $related_order->address = $request->address;
                    $related_order->map_latitude = $request->map_latitude;
                    $related_order->map_longitude = $request->map_longitude;
                    $related_order->map_zoom = $request->map_zoom;
                    $related_order->map_rotate = $request->map_rotate;
                    $related_order->marker_latitude = $request->marker_latitude;
                    $related_order->marker_longitude = $request->marker_longitude;
                    $related_order->status = 'new';
                    $related_order->save();
                }
            }
        }

        $notificationText = NotificationMessage::select('id')->where('action','business.order.status.new')->first();
        $notification = new Notification;
        $notification->user_id = $order->seller_id;
        $notification->notification_messages_id = $notificationText->id;
        $notification->order_id = $order->id;
        $notification->is_customer = 0;
        $notification->is_sendmail = 0;
        $notification->is_new = 1;
        $notification->save();

        return redirect()->route('customer::request.index', ['lang'=>app()->getLocale()])->with('offer_details_status_new', '');
    }
}
