<?php

namespace App\Http\Controllers\Business;

use App\Helper\UploadFile;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\City;
use App\Models\Machine;
use App\Models\Subscription;
use App\Models\SubscriptionSlotItem;
use App\Models\Technic;
use App\Models\TechnicPhoto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Config;
use Illuminate\Support\Str;

class TechnicController extends Controller {
    use UploadFile;

    public function index() {
        $business = Business::where('user_id', request()->user()->id)->first();

        $technic_array = Technic::with('photo')->where('business_id', $business->id)->get();

        $subscription = Subscription::where('seller_id', \request()->user()->id)
            ->where('type', 'package')
            ->latest()
            ->first();

        $subscriptions = Subscription::with(['items'])
            ->where('type', 'slot')
            ->where('seller_id', \request()->user()->id)
            ->where('active_to', '>', Carbon::now())
            ->get();


        $allow_adding_subscription_slot = false;
        $totalSlotItems = [];
        $totalSubscriptionSlot = [];
        if(!empty($subscriptions)) {
            foreach($subscriptions as $slots) {
                $countItems = count($slots->items);
                if($slots->count !== $countItems) {
                    $allow_adding_subscription_slot = true;
                }

                $countSlot = $slots->count - count($slots->items);
                $totalSubscriptionSlot[] = $countSlot;
                $totalSlotItems[] = count($slots->items);

            }
        }

        $metaTags = [
            'metaTitle' => (app()->getLocale() == 'ua') ? 'Техніка' : 'Home',
            'metaKeywords' => '',
            'metaDescription' => ''
        ];

        return view('frontend.business.settings.technics.index', [
            'metaTags' => $metaTags,
            'technic_array'=>$technic_array,
            'subscription' => $subscription,
            'allow_adding_subscription_slot' => $allow_adding_subscription_slot,
            'totalSubscriptionSlot' => array_sum($totalSubscriptionSlot),
            'totalSlotItems' => array_sum($totalSlotItems),


        ]);



    }

    public function create() {
        $machines = Machine::orderBy('title_uk', 'asc')->get();
        $regions = City::with('cities')->get();

        $metaTags = [
            'metaTitle' => (app()->getLocale() == 'ua') ? 'Створення техніки' : 'Home',
            'metaKeywords' => '',
            'metaDescription' => ''
        ];

        return view('frontend.business.settings.technics.create', [
            'metaTags' => $metaTags,
            'machineCategories'=>$this->geMachine(),
            'regions' => $regions,
            'machines'=>$machines
        ]);

    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'machine' => 'required',
            'name' => 'required|max:255',
            'price' => 'required',
            'hours' => 'required',
            'media' => 'required',
            'address' => 'required',
            'type_of_delivery' => 'required',
            'is_driver' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні компанії виникла помилка, деталі дивіться нижче');
        }





        $latestEntry = Technic::get();

        $product_number = str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
        $slug =  $product_number . '-' . Str::slug($request->name);

        $business = Business::where('user_id', \request()->user()->id)->first();
        $technic = new Technic;
        $technic->business_id = $business->id;
        $technic->machine_id = $request->machine;
        $technic->product_number = $product_number;
        $technic->related_categories = ($request->related_categories) ? implode(',', $request->related_categories) : null;
        $technic->is_driver = $request->is_driver;

        $technic->slug = $slug;
        $technic->name = $request->name;
        $technic->price = $request->price;
        $technic->hours = $request->hours;
        $technic->description = $request->description;
        $technic->type_of_delivery = $request->type_of_delivery;
        $technic->address = $request->address;
        $technic->region = $this->address_component($request->marker_latitude, $request->marker_longitude);
        $technic->map_latitude = ($request->map_latitude ?? Config::get('map.default.map_latitude'));
        $technic->map_longitude = ($request->map_longitude ?? Config::get('map.default.map_longitude'));
        $technic->map_zoom = ($request->map_zoom ?? Config::get('map.default.map_zoom'));
        $technic->map_rotate = ($request->map_rotate ?? Config::get('map.default.map_rotate'));
        $technic->marker_latitude = ($request->marker_latitude ?? Config::get('map.default.marker_latitude'));
        $technic->marker_longitude = ($request->marker_longitude ?? Config::get('map.default.marker_longitude'));
        $technic->save();

        if(!empty($request->media)) {
            foreach($request->media as $photo) {
                $technicPhoto = new TechnicPhoto();
                $technicPhoto->technic_id = $technic->id;
                $technicPhoto->photo = $photo['src'];
                $technicPhoto->save();

            }

        }







        $is_subscription = Subscription::with(['items'])
            ->where('type', 'package')
            ->where('seller_id', \request()->user()->id)
            ->where('active_to', '>', Carbon::now())
            ->latest()
            ->first();


        $subscriptions = Subscription::with(['items'])
            ->where('type', 'slot')
            ->where('seller_id', \request()->user()->id)
            ->where('active_to', '>', Carbon::now())
            ->orderBy('id', 'desc')
            ->get();

        if(!empty($subscriptions)) {
            $allow_to_add = false;
            foreach($subscriptions as $slots) {
                $countItems = count($slots->items);
                if($slots->count !== $countItems) {
                    $itemParams = [
                        'slot_id' => $slots->id,
                        'technics_id' => $technic->id,
                    ];

                    $allow_to_add = true;

                }

            }

            $checkTechnics = Technic::where('business_id', $business->id)->get();
            if(!empty($is_subscription)) {
                if(count($checkTechnics) >= 6) {
                    if($allow_to_add == true) {
                        $slotItem = new SubscriptionSlotItem();
                        $slotItem->slot_id = $itemParams['slot_id'];
                        $slotItem->technics_id = $itemParams['technics_id'];
                        $slotItem->save();
                    }
                }
            } else {
                if(count($checkTechnics) >= 3) {
                    if($allow_to_add == true) {
                        $slotItem = new SubscriptionSlotItem();
                        $slotItem->slot_id = $itemParams['slot_id'];
                        $slotItem->technics_id = $itemParams['technics_id'];
                        $slotItem->save();
                    }
                }
            }




        }


        return redirect()->route('business::settings.technics.index', ['lang'=>app()->getLocale()]);
    }

    public function edit($lang, $technic_id) {
        $technic = Technic::with('photo')->find($technic_id);
        $machines = Machine::orderBy('title_uk', 'asc')->get();
        $regions = City::with('cities')->get();

        $metaTags = [
            'metaTitle' => (app()->getLocale() == 'ua') ? 'Редагування техніки' : 'Home',
            'metaKeywords' => '',
            'metaDescription' => ''
        ];

        return view('frontend.business.settings.technics.edit', [
            'metaTags'=>$metaTags,
            'technic'=>$technic,
            'regions' => $regions,
            'machineCategories'=>$this->geMachine(),
            'machines'=>$machines
        ]);

    }


    protected function address_component($latitude, $longitude) {
        $key = env('APP_DEBUG') == true ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION');
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$latitude.",".$longitude."&sensor=false&language=uk-UK&key=".$key;

        $json = file_get_contents($url);

        $json = json_decode($json, true);
        $parse_address_component = [];

        foreach($json['results'][0]['address_components'] as $results) {
            if(!empty($results['long_name'])) {
                $pos = strpos($results['long_name'], 'Київ');
                if($pos) {
                    $_parse_address_component = 'Київська область';
                } else {
                    $_parse_address_component = $results['long_name'];
                }

                if($results['types'][0] == 'administrative_area_level_1') {
                    $parse_address_component = $_parse_address_component;

                } else if($results['types'][0] == 'locality') {
                    $parse_address_component = $_parse_address_component;

                }
            }
        }

        return $parse_address_component;
    }

    public function update(Request $request, $lang, $technic_id) {
        $validator = Validator::make($request->all(), [
            'machine' => 'required',
            'name' => 'required|max:255',
            'price' => 'required',
            'hours' => 'required',
            'media' => 'required',
            'address' => 'required',
            'type_of_delivery' => 'required',
            'is_driver' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При сохранении компании произошла ошибка, подробности смотрите ниже');
        }

//        dd(json_encode($this->address_component($request->marker_latitude, $request->marker_longitude)));


        $technic = Technic::with('photo')->find($technic_id);


        $technic->machine_id = $request->machine;
        $slug =  $technic->product_number . '-' . Str::slug($request->name);

        $technic->slug = $slug;
        $technic->name = $request->name;
        $technic->price = $request->price;
        $technic->hours = $request->hours;
        $technic->description = $request->description;
        $technic->type_of_delivery = $request->type_of_delivery;

        $technic->related_categories = ($request->related_categories) ? implode(',', $request->related_categories) : null;
        $technic->is_driver = $request->is_driver;

        $technic->address = $request->address;
        $technic->region = $this->address_component($request->marker_latitude, $request->marker_longitude);
        $technic->map_latitude = ($request->map_latitude ?? Config::get('map.default.map_latitude'));
        $technic->map_longitude = ($request->map_longitude ?? Config::get('map.default.map_longitude'));
        $technic->map_zoom = ($request->map_zoom ?? Config::get('map.default.map_zoom'));
        $technic->map_rotate = ($request->map_rotate ?? Config::get('map.default.map_rotate'));
        $technic->marker_latitude = ($request->marker_latitude ?? Config::get('map.default.marker_latitude'));
        $technic->marker_longitude = ($request->marker_longitude ?? Config::get('map.default.marker_longitude'));
        $technic->save();



        if(!empty($request->media)) {
            foreach($request->media as $photo) {
                $technicPhoto = TechnicPhoto::where('photo', $photo['src'])->first();

                if(!$technicPhoto) {
                    $technicPhoto = new TechnicPhoto;
                    $technicPhoto->technic_id = $technic->id;
                    $technicPhoto->photo = $photo['src'];
                    $technicPhoto->save();
                }

            }

        }

        return redirect()->route('business::settings.technics.index', ['lang'=>app()->getLocale()]);
    }

    public function destroy($lang, $technic_id) {
        $subscriptions = Subscription::with(['items'])
            ->where('type', 'slot')
            ->where('seller_id', \request()->user()->id)
            ->where('active_to', '>', Carbon::now())
            ->orderBy('id', 'desc')
            ->get();

        if(!empty($subscriptions)) {
            foreach($subscriptions as $slots) {
                $slotItems = SubscriptionSlotItem::where('slot_id', $slots->id)->where('technics_id', $technic_id)->first();
                if($slotItems) {
                    $slotItems->delete();
                }
            }
        }

        $technic = Technic::find($technic_id);
        $technic->delete();

        return redirect()->route('business::settings.technics.index', ['lang'=>app()->getLocale()]);
    }


    private function geMachine() {
        return Machine::orderBy( (app()->getLocale() == 'ua') ? 'title_uk' : 'title_ru', 'asc' )->get();
    }

    public function uploadFile(Request $request) {
        if($file = $request->file('photo')) {
            $photo = $this->uploadPhoto($file, 'technics', 900, 900);

            if(!$photo) {
                $response = [
                    'errors' => 'Ошибка при загрузке файла',
                ];
                return response()->json($response, 422);
            }

            return $photo;

        }
    }

    public function removeFile(Request $request) {
        $srcPath = public_path('storage/technics/' . $request->photo);
        if(file_exists($srcPath) && !empty($request->photo)) {
            $photo = TechnicPhoto::where('photo', $request->photo)->first();
            if($photo) {
                $photo->delete();
            }
            unlink($srcPath);
            return 1;
        }

        return 0;

    }
}
