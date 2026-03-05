<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Mail\Subscribe;
use App\Models\User;
use Carbon\Carbon;
use Mail;
use Illuminate\Http\Request;

class MailingController extends AmicmsController {
    private $layout = [];

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Розсилання';

    }

    public function index() {
        return view('amicms.mailing.index', ['layout' => $this->layout]);

    }

    public function store(Request $request) {
        $subscribe = $request->subscribe;
        $businessUser = User::with(['subscription'])->where('account_type', 3)->get();

        $response = [];
        $current_date = Carbon::now()->format('Y-m-d H:i:s');

        $key = 0;
        foreach($businessUser as $user) {
            if($subscribe == 1) {
                if(!empty($user->subscription) && strtotime($user->subscription->active_to) >= strtotime($current_date) && $user->subscription->seller_id == $user->id) {
                    $response[] = $user->email;
                    $key++;
                }
            } else {
                if(is_null($user->subscription)) {
                    $response[] = $user->email;
                    $key++;
                }
            }
        }

        if(count($response) > 0) {
            Mail::to($response)
                ->locale('uk')
                ->send(new Subscribe($request->all()));
        }

        if(count($response) == 0) {
            return redirect()->route('amicms::mailing.index')->with('warning', 'Нет пользователей для дассылки, попадающих в эту категорию.');
        } elseif(Mail::failures()) {
            return redirect()->route('amicms::mailing.index')->with('danger', 'Sorry! Please try again latter');
        }else{
            return redirect()->route('amicms::mailing.index')->with('success', 'Great! Successfully send in your mail');
        }
    }
}
