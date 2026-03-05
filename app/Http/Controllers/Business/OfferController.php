<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationMessage;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Technic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller {
    public function create(Request $request, $lang) {
        $validator = Validator::make($request->all(), [
            'count' => 'required|min:1|max:999',
            'person' => 'required|array',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні виникла помилка, деталі дивіться нижче');

        }

        $latestEntry = Offer::get();
        $offer_number = str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);

        $technic = Technic::with('photo')->find($request->technic_id);

        $offer = new Offer();
        $offer->seller_id = \request()->user()->id;
        $offer->order_id = $request->order_id;
        $offer->machine_id = $request->machine_id;
        $offer->technic_id = $technic->id;
        $offer->contact_id = implode(',', $request->person);
        $offer->offer_number = 'XM' . $offer_number;
        $offer->name = $technic->name;
        $offer->photo = $technic->photo[0]->photo;
        $offer->hours = $technic->hours;
        $offer->price = $technic->price;
        $offer->count = $request->count;
        $offer->status = 'new';
        $offer->save();


        $order = Order::find($offer->order_id);

        $notificationText = NotificationMessage::select('id')->where('action',($request->is_tender == 1) ? 'customer.tender.offer.new' : 'customer.offer.new')->first();
        $notification = new Notification;
        $notification->user_id = $order->customer_id;
        $notification->notification_messages_id = $notificationText->id;
        $notification->order_id = $offer->order_id;
        $notification->offer_id = $offer->id;
        $notification->is_customer = 1;
        $notification->is_sendmail = 0;
        $notification->is_new = 1;
        $notification->save();

        return redirect()->route(($request->is_tender == 1) ? 'business::tender.index' : 'business::request.index', ['lang' => $lang])->with('offer_details_status_new', '');

    }

    public function canceled($lang, $offer_id) {
        $offer = Offer::find($offer_id);
        $offer->status = 'canceled';
        $offer->canceled_by = 'seller';
        $offer->save();

        $notificationText = NotificationMessage::select('id')->where('action', 'customer.order.status.canceled_by_seller')->first();
        $notification = new Notification;
        $notification->notification_messages_id = $notificationText->id;
        $notification->user_id = $offer->order->customer_id;
        $notification->order_id = $offer->order_id;
        $notification->offer_id = $offer->id;
        $notification->is_customer = 1;
        $notification->is_sendmail = 0;
        $notification->is_new = 1;
        $notification->save();

        return redirect()->route('business::accepted.index', ['lang'=>$lang])->with('offer_details_status_canceled', '');
    }


}
