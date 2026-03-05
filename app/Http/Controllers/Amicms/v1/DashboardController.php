<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Models\Business;
use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends AmicmsController {
    private $layout = [];

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Панель інструментів';

    }

    public function index(Request $request) {

        $offer_views_query = Report::where('action', 'offer_views');
        $business_profile_views_query = Report::where('action', 'business_profile_views');
        $email_views_query = Report::where('action', 'email_views');
        $phone_views_query = Report::where('action', 'phone_views');
        $www_views_query = Report::where('action', 'www_views');
        $contact_person_phone_views_query = Report::where('action', 'contact_person_phone_views');
        $business_register_views = Business::query();

        if(!empty($request->get('period')) && $request->has('period')) {
            $periodExp = explode(' - ', $request->get('period'));
            $startDate = date('Y-m-d 00:00:00', strtotime($periodExp[0]));
            $endDate = date('Y-m-d 23:59:59', strtotime($periodExp[1]));

            $offer_views_query->whereBetween('created_at', [$startDate, $endDate]);
            $business_profile_views_query->whereBetween('created_at', [$startDate, $endDate]);
            $email_views_query->whereBetween('created_at', [$startDate, $endDate]);
            $phone_views_query->whereBetween('created_at', [$startDate, $endDate]);
            $www_views_query->whereBetween('created_at', [$startDate, $endDate]);
            $contact_person_phone_views_query->whereBetween('created_at', [$startDate, $endDate]);
            $business_register_views->whereBetween('created_at', [$startDate, $endDate])->get();

        }

        $offer_views = $offer_views_query->sum('count');
        $business_profile_views = $business_profile_views_query->sum('count');
        $email_views = $email_views_query->sum('count');
        $phone_views = $phone_views_query->sum('count');
        $www_views = $www_views_query->sum('count');
        $contact_person_phone_views = $contact_person_phone_views_query->sum('count');
        $business_register_views = $business_register_views->get();


        return view('amicms.dashboard.index', [
            'layout' => $this->layout,
            'offer_views' => $offer_views,
            'business_profile_views' => $business_profile_views,
            'email_views' => $email_views,
            'phone_views' => $phone_views,
            'www_views' => $www_views,
            'business_register_views' => count($business_register_views),

            'contact_person_phone_views' => $contact_person_phone_views,
            'startDate'=> $request->has('period') ?  $startDate : null,
            'endDate'=> $request->has('period') ?  $endDate : null,


        ]);

    }

}
