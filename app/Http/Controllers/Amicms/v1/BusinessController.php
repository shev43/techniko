<?php

    namespace App\Http\Controllers\Amicms\v1;

    use App\Http\Controllers\AmicmsController;
    use App\Imports\UsersImport;
    use App\Models\Business;
    use App\Models\Subscription;

    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;
    use Image;
    use Config;
    use Maatwebsite\Excel\Facades\Excel;


    class BusinessController extends AmicmsController {
        private $layout = [];
        protected $phone;

        public function __construct() {
            $this->is_profile_auth();
            $this->layout['title'] = 'Орендодавці';

        }

        public function index() {

            $query = \request()->get('q');
            $business_array = Business::with('seller')->withTrashed();

            if(!empty($query)) {
                $business_array->where('name', 'like', '%' . $query . '%')->orWhere('business_number', 'like', '%' . $query . '%');
            }

            $business_array = $business_array->paginate(env('AMICMS_PER_PAGE'));

//            dd($business_array);
            return view('amicms.business.index', ['layout' => $this->layout, 'business_array' => $business_array]);

        }

        public function create() {
            return view('amicms.business.create', ['layout' => $this->layout]);

        }

        public function store(Request $request) {
            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $request->merge([
                'phone' => $this->phone,
            ]);

            $validator = Validator::make($request->all(), [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'representative' => ['required', 'string', 'max:255'],
                'password' => ['required_with:password_confirmation', 'string', 'min:6', 'confirmed'],
                'password_confirmation' => ['required', 'same:password', 'string', 'min:6'],
                ]
            );


            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');
            }


            $latestEntry = User::get();

            $user = new User();
            $user->account_type = 3;
            $user->profile_number = str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $this->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $businessLatestEntry = Business::get();

            $business = new Business;
            $business->user_id = $user->id;
            $business->business_number = str_pad(($businessLatestEntry) ? count($businessLatestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
            $business->name = $request->representative;
            $business->slug = Str::slug($business->name);

            $business->save();

            return redirect()->route('amicms::business.index')->with('success', 'Дані успішно збережені');

        }

        public function show($business_id) {
            $business = Business::where('id', $business_id)->withTrashed()->first();
            return view('amicms.business.edit', ['layout' => $this->layout, 'business' => $business]);

        }

        public function edit($business_id) {
            $business = Business::where('id', $business_id)->withTrashed()->first();
            return view('amicms.business.edit', ['layout' => $this->layout, 'business' => $business]);

        }

        public function update(Request $request, $business_id ) {
            $business = Business::where('id', $business_id)->withTrashed()->first();

            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $request->merge([
                'phone' => $this->phone,
            ]);
            $validator = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'phone' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'address' => ['required', 'string'],
                    'description' => ['string'],
                ]
            );

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');
            }

            $business->name = $request->name;
            $business->slug = Str::slug($business->name);

            $business->phone = $request->phone;
            $business->email = $request->email;
            $business->address = $request->address;
            $business->description = $request->description;
            $business->map_latitude = ($request->map_latitude ?? Config::get('map.default.map_latitude'));
            $business->map_longitude = ($request->map_longitude ?? Config::get('map.default.map_longitude'));
            $business->map_zoom = ($request->map_zoom ?? Config::get('map.default.map_zoom'));
            $business->map_rotate = ($request->map_rotate ?? Config::get('map.default.map_rotate'));
            $business->marker_latitude = ($request->marker_latitude ?? Config::get('map.default.marker_latitude'));
            $business->marker_longitude = ($request->marker_longitude ?? Config::get('map.default.marker_longitude'));
            $business->save();

            return redirect()->back()->with('success', 'Дані успішно збережені');

        }

        public function activate($user_id) {
            $user = User::find($user_id);
            $user->enabled = ($user->enabled == 0) ? 1 : 0;
            $user->save();

        }

        public function destroy($business_id) {
//            $contact = Business::find($business_id);
//            $contact->delete();
//            return redirect()->route('amicms::business.index', ['business_id'=>$business_id])->with('success', 'Дані успішно видалені');            
            $subscriptions = Subscription::where('business_id', $business_id)->get();
            if(count($subscriptions) > 0) {
                Subscription::where('business_id', $business_id)->delete();
            }
            Business::find($business_id)->forceDelete();
            return redirect()->route('amicms::business.index', ['business_id'=>$business_id])->with('success', 'Дані успішно видалені');


        }

        public function destroyWithTrash($business_id) {
            Business::onlyTrashed()->find($business_id)->forceDelete();
            return redirect()->route('amicms::business.index', ['business_id'=>$business_id])->with('success', 'Дані успішно видалені');

        }

        public function restore($business_id) {
            Business::onlyTrashed()->find($business_id)->restore();
            return redirect()->route('amicms::business.index', ['business_id'=>$business_id])->with('success', 'Дані успішно відновлено');

        }

        public function import() {
            return view('amicms.business.import', ['layout' => $this->layout]);
        }

        public function importStore(Request $request) {
            ini_set('max_execution_time', 60000000000);

            $validator = Validator::make($request->file(), [
                    'file' => ['required'],
                ]
            );

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');
            }

            $import = new UsersImport;
            Excel::import($import, $request->file('file'));

            return redirect()->route('amicms::business.import.index')->with('success', 'Импорт успешно завершен');
        }

    }
