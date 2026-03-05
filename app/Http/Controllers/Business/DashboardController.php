<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Technic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class DashboardController extends Controller {
    public function index(Request $request) {
        $technics_query = Technic::with('reports', 'photo')->where('business_id', $request->user()->business->id);

        if(!empty($request->get('period')) && $request->has('period')) {
            $periodExp = explode(' - ', $request->get('period'));
            $startDate = date('Y-m-d 00:00:00', strtotime($periodExp[0]));
            $endDate = date('Y-m-d 23:59:59', strtotime($periodExp[1]));

            $technics_query->whereHas('reports', function($query1) use ($startDate, $endDate) {
                $query1->whereBetween('created_at', [$startDate, $endDate]);
            });




        }

        $technics_array = $technics_query->get();

        $reports_array = [];
        foreach($technics_array as $technic_key => $technic) {
            $reports_array[$technic_key]['id'] = $technic->id;
            $reports_array[$technic_key]['business_id'] = $technic->business_id;
            $reports_array[$technic_key]['name'] = $technic->name;
            $reports_array[$technic_key]['photo'] = $technic->photo[0]->photo;

            $offer_views = 0;
            $business_profile_views = 0;
            $email_views = 0;
            $phone_views = 0;
            $www_views = 0;
            $contact_person_phone_views = 0;

            foreach($technic->reports as $report) {
                if($technic->id == $report->technic_id) {
                    if($report->action == 'offer_views') {
                        $offer_views = $report->count;
                    }
                    if($report->action == 'business_profile_views') {
                        $business_profile_views = $report->count;
                    }
                    if($report->action == 'email_views') {
                        $email_views = $report->count;
                    }

                    if($report->action == 'phone_views') {
                        $phone_views = $report->count;
                    }

                    if($report->action == 'www_views') {
                        $www_views = $report->count;
                    }

                    if($report->action == 'contact_person_phone_views') {
                        $contact_person_phone_views = $report->count;
                    }
                }

            }


            $reports_array[$technic_key]['offer_views'] = $offer_views ?? null;
            $reports_array[$technic_key]['business_profile_views'] = $business_profile_views ?? null;
            $reports_array[$technic_key]['email_views'] = $email_views ?? null;
            $reports_array[$technic_key]['phone_views'] = $phone_views ?? null;
            $reports_array[$technic_key]['www_views'] = $www_views ?? null;
            $reports_array[$technic_key]['contact_person_phone_views'] = $contact_person_phone_views ?? null;

        }

//        dd($reports_array);



        $offer_views_query = Report::where('action', 'offer_views')->where('business_id', $request->user()->business->id);
        $business_profile_views_query = Report::where('action', 'business_profile_views')->where('business_id', $request->user()->business->id);
        $email_views_query = Report::where('action', 'email_views')->where('business_id', $request->user()->business->id);
        $phone_views_query = Report::where('action', 'phone_views')->where('business_id', $request->user()->business->id);
        $www_views_query = Report::where('action', 'www_views')->where('business_id', $request->user()->business->id);
        $contact_person_phone_views_query = Report::where('action', 'contact_person_phone_views')->where('business_id', $request->user()->business->id);

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
        }

        $offer_views = $offer_views_query->sum('count');
        $business_profile_views = $business_profile_views_query->sum('count');
        $email_views = $email_views_query->sum('count');
        $phone_views = $phone_views_query->sum('count');
        $www_views = $www_views_query->sum('count');
        $contact_person_phone_views = $contact_person_phone_views_query->sum('count');



        $metaTags = [
            'metaTitle' => (app()->getLocale() == 'ua') ? 'Статистика' : '',
            'metaKeywords' => '',
            'metaDescription' => ''
        ];

        return view('frontend.business.dashboard.index', [
            'metaTags' => $metaTags,
            'reports_array'=>$reports_array,

            'offer_views' => $offer_views,
            'business_profile_views' => $business_profile_views,
            'email_views' => $email_views,
            'phone_views' => $phone_views,
            'www_views' => $www_views,
            'contact_person_phone_views' => $contact_person_phone_views,

            'startDate'=> $request->has('period') ?  $startDate : null,
            'endDate'=> $request->has('period') ?  $endDate : null,
        ]);

    }

    public function create_pdf() {
        $technics_query = Technic::with('reports', 'photo')->where('business_id', 1);

            $startDate = Carbon::now()->firstOfMonth();
            $endDate = Carbon::now()->endOfMonth();

            $technics_query->whereHas('reports', function($query1) use ($startDate, $endDate) {
                $query1->whereBetween('created_at', [$startDate, $endDate]);
            });


        $technics_array = $technics_query->get();

        $reports_array = [];
        foreach($technics_array as $technic_key => $technic) {
            $reports_array[$technic_key]['id'] = $technic->id;
            $reports_array[$technic_key]['business_id'] = $technic->business_id;
            $reports_array[$technic_key]['name'] = $technic->name;
            $reports_array[$technic_key]['photo'] = $technic->photo[0]->photo;

            $offer_views = 0;
            $business_profile_views = 0;
            $email_views = 0;
            $phone_views = 0;
            $www_views = 0;
            $contact_person_phone_views = 0;

            foreach($technic->reports as $report) {
                if($technic->id == $report->technic_id) {
                    if($report->action == 'offer_views') {
                        $offer_views = $report->count;
                    }
                    if($report->action == 'business_profile_views') {
                        $business_profile_views = $report->count;
                    }
                    if($report->action == 'email_views') {
                        $email_views = $report->count;
                    }

                    if($report->action == 'phone_views') {
                        $phone_views = $report->count;
                    }

                    if($report->action == 'www_views') {
                        $www_views = $report->count;
                    }

                    if($report->action == 'contact_person_phone_views') {
                        $contact_person_phone_views = $report->count;
                    }
                }

            }


            $reports_array[$technic_key]['offer_views'] = $offer_views ?? null;
            $reports_array[$technic_key]['business_profile_views'] = $business_profile_views ?? null;
            $reports_array[$technic_key]['email_views'] = $email_views ?? null;
            $reports_array[$technic_key]['phone_views'] = $phone_views ?? null;
            $reports_array[$technic_key]['www_views'] = $www_views ?? null;
            $reports_array[$technic_key]['contact_person_phone_views'] = $contact_person_phone_views ?? null;

        }


        return view('frontend.business.dashboard.pdf', [
            'reports_array'=>$reports_array,
            'offer_views' => $offer_views,
            'business_profile_views' => $business_profile_views,
            'email_views' => $email_views,
            'phone_views' => $phone_views,
            'www_views' => $www_views,
            'contact_person_phone_views' => $contact_person_phone_views,

        ]);

        $pdf = PDF::loadHTML('frontend.business.dashboard.pdf', [
            'reports_array'=>$reports_array
        ]);

        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('javascript-delay', 15000);
        $pdf->setOption('enable-smart-shrinking', true);
        $pdf->setOption('no-stop-slow-scripts', true);
//                 dd($pdf);
        return $pdf->stream();
    }

}
