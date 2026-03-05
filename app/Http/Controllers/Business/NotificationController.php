<?php

    namespace App\Http\Controllers\Business;

    use App\Http\Controllers\Controller;
    use App\Models\Notification;

    class NotificationController extends Controller {
        public function index() {
            $notification_array = Notification::with('message', 'order')->where('user_id', request()->user()->id)->where('is_customer', 0)->orderByDesc('id')->paginate();

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Сповіщення' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.business.settings.notification.index', [
                'metaTags' => $metaTags,
                'notification_array'=>$notification_array
            ]);
        }

    }
