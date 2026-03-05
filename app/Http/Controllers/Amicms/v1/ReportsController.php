<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Models\Business;
use App\Models\Machine;
use App\Models\Order;
use App\Models\Report;
use App\Models\Subscription;
use App\Models\SubscriptionHistory;
use App\Models\Technic;
use Illuminate\Http\Request;

class ReportsController extends AmicmsController {
    private $layout = [];

    private $startDate = '';
    private $endDate = '';

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Статистика';


    }

    public function orders(Request $request) {
        $machines = Machine::with(['reportOrdersByNew'])->orderBy('title_uk', 'asc')->get();

        $orders_array = Order::with('machine')
            ->select("*")
            ->selectRaw("count(case when status = 'new' then 1 end) as total_new")
            ->selectRaw("count(case when status = 'accepted' or status = 'executed' then 1 end) as total_accepted")
            ->selectRaw("count(case when status = 'done' then 1 end) as total_done")

            ;

        $machinesImp = [];
        if(!empty($request->get('machines')) && $request->has('machines')) {
            $machinesImp = implode(',', $request->get('machines'));
            $orders_array->whereIn('machine_id', explode(',', $machinesImp));

        }

        if(!empty($request->get('period')) && $request->has('period')) {
            $periodExp = explode(' - ', $request->get('period'));
            $this->startDate = date('Y-m-d 00:00:00', strtotime($periodExp[0]));


            $this->endDate = date('Y-m-d 23:59:59', strtotime($periodExp[1]));
            $orders_array->whereBetween('created_at', [$this->startDate, $this->endDate]);

        }

        $orders = $orders_array->groupBy('machine_id')->orderBy('created_at')->get();
        return view('amicms.reports.orders', ['layout'=>$this->layout, 'machines'=>$machines, 'machinesImp'=>$machinesImp, 'orders'=>$orders, 'startDate'=>$this->startDate, 'endDate'=>$this->endDate]);

    }

    public function subscription(Request $request) {
        $histories_array = Subscription::whereHas('business')
            ->select("*")
//            ->selectRaw("count(case when type = 'package' then 1 end) as total_package")
//            ->selectRaw("count(case when type = 'slot' then 1 end) as total_slot")
        ;

        $histories_array->where('added_manually', 0);

        if(!empty($request->get('period')) && $request->has('period')) {
            $periodExp = explode(' - ', $request->get('period'));
            $this->startDate = date('Y-m-d 00:00:00', strtotime($periodExp[0]));
            $this->endDate = date('Y-m-d 23:59:59', strtotime($periodExp[1]));
            $histories_array->whereBetween('created_at', [$this->startDate, $this->endDate]);

        }

        $histories = $histories_array->orderBy('added_manually', 'desc')->orderBy('created_at', 'desc')->get();


        $historyPackage = Subscription::selectRaw("sum(price) as paid_package")
            ->selectRaw("count(case when type = 'package' then 1 end) as total_package")
            ->selectRaw("count(case when type = 'package' and status='Approved' and date_format(active_to, '%Y-%m-%d') >= " . date('Y-m-d') . " then 1 end) as total_active_package")
            ->selectRaw("count(case when type = 'package' and status<>'Approved' or date_format(active_to, '%Y-%m-%d') <= " . date('Y-m-d') . " then 1 end) as total_deactive_package")
        ->where('type', 'package');

        $historyPackage->where('added_manually', 0)->orderBy('added_manually', 'desc');

        if(!empty($request->get('period')) && $request->has('period')) {
            $periodExp = explode(' - ', $request->get('period'));
            $this->startDate = date('Y-m-d 00:00:00', strtotime($periodExp[0]));
            $this->endDate = date('Y-m-d 23:59:59', strtotime($periodExp[1]));
            $historyPackage->whereBetween('created_at', [$this->startDate, $this->endDate]);

        }

        $historyPackage = $historyPackage->orderBy('created_at', 'desc')->first();

        $historySlot = Subscription::selectRaw("sum(price) as paid_slot")
            ->selectRaw("sum(count) as total_slot")
            ->selectRaw("sum(case when type = 'slot' and status = 'Approved' and date_format(active_to, '%Y-%m-%d') >= " . date('Y-m-d') . " then count else 0 end) as total_active_slot")
            ->selectRaw ("sum(case when type = 'slot' and status <> 'Approved' or date_format(active_to, '%Y-%m-%d') <= " . date('Y-m-d') . " then count else 0 end) as total_deactive_slot")
            ->where('type', 'slot');

        $historySlot->where('added_manually', 0)->orderBy('added_manually', 'desc');

        if(!empty($request->get('period')) && $request->has('period')) {
            $periodExp = explode(' - ', $request->get('period'));
            $this->startDate = date('Y-m-d 00:00:00', strtotime($periodExp[0]));
            $this->endDate = date('Y-m-d 23:59:59', strtotime($periodExp[1]));
            $historySlot->whereBetween('created_at', [$this->startDate, $this->endDate]);

        }

        $historySlot = $historySlot->orderBy('created_at', 'desc')->first();

        return view('amicms.reports.subscription', ['layout'=>$this->layout, 'histories'=>$histories, 'startDate'=>$this->startDate, 'endDate'=>$this->endDate, 'historyPackage'=>$historyPackage, 'historySlot'=>$historySlot]);

    }

    public function visitors(Request $request, $business_id) {
        $technics_query = Technic::with('reports', 'photo')->where('business_id', $business_id);

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

        return view('amicms.reports.visitors', [
            'layout'=>$this->layout,
            'reports_array'=>$reports_array,
            'startDate'=> $request->has('period') ?  $startDate : null,
            'endDate'=> $request->has('period') ?  $endDate : null,
        ]);

    }
}
