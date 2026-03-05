<?php

    namespace App\Http\Controllers\Amicms\v1;

    use App\Helper\UploadFile;
    use App\Http\Controllers\AmicmsController;
    use App\Models\Business;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Config;
    use Illuminate\Validation\Rule;

    class BusinessProfileController extends AmicmsController {
        private $layout = [];
        private $phone;

        use UploadFile;


        public function __construct() {
            $this->is_profile_auth();
            $this->layout['title'] = 'Орендодавці';

        }

        public function index($business_id) {
            $business = Business::where('id', $business_id)->withTrashed()->first();
            $business_profile = User::where('id', $business->user_id)->withTrashed()->first();
            return view('amicms.business.profile.index', ['layout' => $this->layout, 'business' => $business, 'business_profile' => $business_profile]);

        }

        public function edit($business_id) {
            $business = Business::where('id', $business_id)->withTrashed()->first();
            $business_profile = User::where('id', $business->user_id)->withTrashed()->first();
            return view('amicms.business.profile.edit', ['layout' => $this->layout, 'business' => $business, 'business_profile' => $business_profile]);

        }

        public function store(Request $request, $business_id) {
            $business = Business::where('id', $business_id)->withTrashed()->first();

            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $request->merge([
                'phone' => $this->phone,
            ]);

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'phone' => ['required', Rule::unique('users')->ignore($business->user_id)],
                'email' => ['required', Rule::unique('users')->ignore($business->user_id)],

            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

            }

            $business_profile = User::where('id', $business->user_id)->withTrashed()->first();
            $business_profile->first_name = $request->first_name;
            $business_profile->last_name = $request->last_name;
            $business_profile->phone = $request->phone;
            $business_profile->email = $request->email;
            if($file = $request->file('photo')) {
                $_photo = json_encode($this->uploadPhoto($file, 'users', 300, 300), true);
                $photo = json_decode($_photo, true);
                $business_profile->photo = $photo['original'];
            }

            $business_profile->save();


            return redirect()->route('amicms::business.profile.index', ['business_id'=>$business_id])->with('success', 'Дані успішно збережені');

        }


        public function removeFile($business_id, $profile_id) {
            $user = User::find($profile_id);
            $srcPath = public_path('storage/users/' . $user->photo);
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
