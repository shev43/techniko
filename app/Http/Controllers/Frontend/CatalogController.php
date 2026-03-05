<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\City;
use App\Models\Machine;
use App\Models\MachineCategory;
use App\Models\Report;
use App\Models\Technic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller {

    private $category = null;

    public function index(Request $request) {
        $metaTags = [
            'metaTitle' => (app()->getLocale() == 'ua') ? 'Каталог' : 'Catalog',
            'metaKeywords' => '',
            'metaDescription' => ''
        ];

        $this->category = $this->getCategoryBySlug($request->get('category')) ?? null;


        $machines = $this->getMachines() ?? [];
        $machineCategories = MachineCategory::get();

        return view('frontend.guest.catalog.index', [
            'metaTags'=>$metaTags,
            'machines'=>$machines,
            'machineCategories'=>$machineCategories,
            'currentCategory'=>$this->category,
        ]);
    }

    public function technic($lang, $slug) {
        $machine = $this->getMachinesBySlug($slug);

        if(!$machine) {
            return abort(404);
        }

        if(!empty(request()->get('categories')) ) {
            $getMachineById = Machine::find(request()->get('categories'));
            if(!empty($getMachineById)) {
                return redirect()->route('frontend::catalog.technic', [
                    'lang'=> app()->getLocale(),
                    'slug'=> $getMachineById->slug,
                    'min_price'=> \request()->get('min_price'),
                    'max_price'=> \request()->get('max_price'),
                    'name'=> \request()->get('name'),
                    'orderBy'=> \request()->get('orderBy'),
                    'region'=> \request()->get('region'),



                ]);
            }
        }


        if(Auth::guard('customer')->check()) {
            if(request()->user()->map_latitude && request()->user()->map_longitude) {
                $location_lat = ((!empty(request()->location_lat)) ? request()->location_lat : request()->user()->map_latitude);
                $location_lng = ((!empty(request()->location_lng)) ? request()->location_lng : request()->user()->map_longitude);
            } else {
                $location_lat = ((!empty(request()->location_lat)) ? request()->location_lat : '');
                $location_lng = ((!empty(request()->location_lng)) ? request()->location_lng : '');
            }
        }


//        dd(request()->location_lat);

        $buildDistanceQuery = (
            Auth::guard('customer')->check() &&
            request()->orderBy == 'distance' &&
            !empty($location_lat) &&
            !empty($location_lng) ) ?
            "technics.*, GETDISTANCE( '". $location_lat ."', '". $location_lng ."', technics.map_latitude, technics.map_longitude) AS orderDistance" :
            'technics.*';

        $technics = Technic::selectRaw($buildDistanceQuery)->with('photo', 'business');

//        if(!empty(request()->get('categories')) ) {
//            $technics->where('machine_id', request()->get('categories'));
//        } else {
            $technics->where('machine_id', $machine->id);
//        }

        if(!empty(request()->get('min_price')) && !empty(request()->get('max_price'))) {
            $technics->whereBetween('price', [
                request()->get('min_price'), request()->get('max_price')]);
        }

        if(!empty(request()->get('name')) ) {
            $technics->where('name', 'like', '%'.request()->get('name').'%');
        }
//
//        $lat = "47.9675419";
//        $long = "33.7846957";
//
//        $key = env('APP_DEBUG') == true ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION');
//        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$long."&sensor=false&language=uk-UK&key=".$key;
//
//        $json = file_get_contents($url);
//        $json = json_decode($json, true);
//
//        foreach($json['results'] as $results) {
//            if($results['types'][0] == 'locality') {
//                foreach($results['address_components'] as $address_component) {
//                    $address_components[] = $address_component['long_name'];
//                }
//            }
//        }
//
//        $result = [
//            'city' => $address_components[0],
//            'destrict' => $address_components[1],
//            'region' => $address_components[2],
//            'country' => $address_components[3],
//            'zip' => $address_components[4]
//        ];
//
//        dd($result);


        if(!empty(request()->get('region'))) {
            $technics->where('region', 'like', '%' . request()->get('region') . '%');

        }

        if(request()->has('orderBy') && request()->get('orderBy') == 'low-price') {
            $technics->orderBy('price', 'asc');
        } else if(request()->has('orderBy') && request()->get('orderBy') == 'high-price') {
            $technics->orderBy('price', 'desc');
        } else if(
            (request()->has('orderBy') && request()->get('orderBy') == 'distance') &&

            Auth::guard('customer')->check() &&
            (request()->user()->map_latitude && request()->user()->map_longitude) ||
            (!empty(request()->location_lat[0]) && !empty(request()->location_lng[0]))

        ) {
            $technics->orderBy('orderDistance', 'asc');

        } else {
            $technics->orderBy('price', 'asc');
        }



        $technics_array = $technics->paginate();

        $metaTags = [
            'metaTitle' => (app()->getLocale() == 'ua') ? 'Каталог - ' . $machine->title : 'Home',
            'metaKeywords' => '',
            'metaDescription' => ''
        ];

        $regions = City::get();

        return view('frontend.guest.catalog.technic', [
            'metaTags' => $metaTags,
            'regions' => $regions,
            'machine' => $machine,
            'machines' => $this->getMachines(),
            'technics_array' => $technics_array,
        ]);
    }

    public function business($lang, $technic_slug, $slug) {
        $business = Business::with([
            'contacts', 'technics'])->where('slug', $slug)->orderByDesc('id')->first();

        $technic = Technic::where('slug', $technic_slug)->first();

        $report = Report::where('business_id', $technic->business_id)
            ->where('technic_id', $technic->id)
            ->where('action', 'business_profile_views')->firstOrCreate();

        $report->business_id = $technic->business_id ?? null;
        $report->technic_id = $technic->id ?? null;
        $report->action = 'business_profile_views';
        $report->count = $report->count + 1;
        $report->save();

        $metaTags = [
            'metaTitle' => (app()->getLocale() == 'ua') ? $business->name : 'Home',
            'metaKeywords' => '',
            'metaDescription' => ''
        ];

        return view('frontend.guest.catalog.business', [
            'metaTags' => $metaTags,
            'lang' => $lang,
            'technic' => $technic,
            'business' => $business
        ]);
    }

    public function getMachinesBySlug($slug) {
        $machine = Machine::where('slug', $slug)->where('visible', 1)->first();

        return $machine;

    }

    public function getCategoryBySlug($slug) {
        $category = MachineCategory::where('slug', $slug)->first();

        return $category;

    }

    public function getMachines() {
        $machine = Machine::with('technics')->where('visible', 1)->orderBy('title_uk', 'asc')->get();

        if (!empty($this->category)) {
            $machines = $this->category->machines()->orderBy('pivot_order')->get();

            if ($this->category->has_sections) {
                $mainMachines = $machines->where('pivot.is_main', 1)->all();
                $otherMachines = $machines->where('pivot.is_main', 0)->all();

                return ['main' => $mainMachines, 'other' => $otherMachines];
            }

            return $machines->all();

        }

        return $machine;
    }

}
