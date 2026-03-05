<?php

    namespace App\Http\Controllers\Amicms\v1;

    use App\Helper\UploadFile;
    use App\Http\Controllers\AmicmsController;
    use App\Imports\UsersImport;
    use App\Models\Business;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;
    use Image;
    use Config;
    use Maatwebsite\Excel\Facades\Excel;


    class BusinessCompanyController extends AmicmsController {
        private $layout = [];
        protected $phone;

        use UploadFile;

        public function __construct() {
            $this->is_profile_auth();
            $this->layout['title'] = 'Орендодавці';

        }

        public function index($business_id) {
            $business = Business::where('id', $business_id)->withTrashed()->first();
            return view('amicms.business.company.index', ['layout' => $this->layout, 'business' => $business]);

        }

        public function edit($business_id) {
            $business = Business::where('id', $business_id)->withTrashed()->first();
            return view('amicms.business.company.edit', ['layout' => $this->layout, 'business' => $business]);

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

            if($file = $request->file('photo')) {
                $_photo = json_encode($this->uploadPhoto($file, 'business', 300, 300), true);
                $photo = json_decode($_photo, true);
                $business->photo = $photo['original'];
            }

            $business->save();

            return redirect()->route('amicms::business.company.index', ['business_id'=>$business_id])->with('success', 'Дані успішно збережені');

        }


        public function removeFile($business_id) {
            $user = Business::find($business_id);
            $srcPath = public_path('storage/business/' . $user->photo);
            if(file_exists($srcPath) && !empty($user->photo)) {
                if($user) {
                    $user->photo = null;
                    $user->save();
                }
                unlink($srcPath);

                return redirect()->back()->with('success', 'Зображення успішно видалено');

            }

        }

    }
