<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ServiceReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;


class ServiceReviewController extends Controller {

    public function check() {
        $order = Order::where((Auth::guard('customer')->check()) ? 'client_id' : 'seller_id', \request()->user()->id)->where('status', 'done')->get();
        if(count($order) == 5) {
            return true;
        }
        return false;
    }

    public function store(Request $request) {
        $review = new ServiceReview;
        $review->user_id = $request->user_id;
        $review->question = implode(',', $request->question);
        $review->comment = $request->comment;
        if($review->save()) {
            $user = User::find($request->user_id);
            (Auth::guard('customer')->check()) ? $user->is_customer_service_review = 1 : $user->is_business_service_review = 1;
            $user->save();
            $question = [];
            foreach(explode(',', $review->question) as $_question) {
                switch($_question) {
                    case 'q1':
                        $question[0] = 'Швидкість роботи сайту';
                        break;
                    case 'q2':
                        $question[1] = 'Процедура замовлення';
                        break;
                    case 'q3':
                        $question[2] = 'Інтерфейс зручність';
                        break;
                    case 'q4':
                        $question[3] = 'Служба підтримки';
                        break;
                    case 'q5':
                        $question[4] = 'Знайшли помилку на сайті';
                        break;
                    case 'q6':
                        $question[5] = 'Інше';
                        break;
                }
            }

            $response = [
                'subject'=> 'Відгук про сервіс',
                'personal_code'=> $user->profile_number,
                'name'=> $user->first_name . ' ' . $user->last_name,
                'email'=> $user->email,
                'phone'=> $user->phone,
                'question'=> $question,
                'comment'=> $review->comment,
            ];

            Mail::to('support@techniko.com.ua')
                ->locale('uk')
                ->send(new \App\Mail\ServiceReview($response));



            return $review;
        }

        return false;

    }

    public function discard($user_id) {
        $user = User::find($user_id);
        (Auth::guard('customer')->check()) ? $user->is_customer_service_review = 2 : $user->is_business_service_review = 2;
        $user->save();
    }

}
