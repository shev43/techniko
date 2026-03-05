<?php

    namespace App\Http\Controllers\Business;

    use App\Helper\UploadFile;
    use App\Http\Controllers\Controller;
    use App\Models\Business;
    use Config;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;

    class CompanyController extends Controller {
        use UploadFile;

        protected $phone;

        public function index() {
            $company = Business::where('user_id', \request()->user()->id)->first();

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Представник' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.business.settings.company.index', [
                'metaTags' => $metaTags,
                'company' => $company
            ]);

        }

        public function update(Request $request) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255', 'phone' => 'required', 'email' => 'required', 'description' => 'required',
                'address' => 'required']);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При сохранении компании произошла ошибка, подробности смотрите ниже');
            }

            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $company = Business::where('user_id', \request()->user()->id)->first();

            if($company->name !== $request->name) {
                $company->name = $request->name;
                $company->slug = Str::slug($company->name);


            }

            $company->phone = $this->phone;
            $company->email = $request->email;
            $company->www = $request->www ?? null;
            $company->description = $request->description;

            if($company->address == null || $company->address !== $request->address ) {
                $company->address = $request->address;
            }

            $company->photo = ($request->photo ?? null);
            $company->map_latitude = ($request->map_latitude ?? Config::get('map.default.map_latitude'));
            $company->map_longitude = ($request->map_longitude ?? Config::get('map.default.map_longitude'));
            $company->map_zoom = ($request->map_zoom ?? Config::get('map.default.map_zoom'));
            $company->map_rotate = ($request->map_rotate ?? Config::get('map.default.map_rotate'));
            $company->marker_latitude = ($request->marker_latitude ?? Config::get('map.default.marker_latitude'));
            $company->marker_longitude = ($request->marker_longitude ?? Config::get('map.default.marker_longitude'));
            $company->save();
            return redirect()->route('business::settings.company.index', ['lang' => app()->getLocale()])->with('success', 'Success');

        }

        public function uploadFile(Request $request) {
            if($file = $request->file('photo')) {
                $photo = $this->uploadPhoto($file, 'business', 300, 300);
                return $photo;

            }
        }

        public function removeFile(Request $request) {
            $srcPath = public_path('storage/business/' . $request->filename);
            if(file_exists($srcPath) && !empty($request->filename)) {
                $user = Business::where('photo', $request->filename)->first();
                if($user) {
                    $user->photo = null;
                    $user->save();
                }
                unlink($srcPath);
                return true;
            }

        }

    }
