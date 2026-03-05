<?php

    namespace App\Http\Controllers\Business;

    use App\Helper\UploadFile;
    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;

    class ProfileController extends Controller {

        use UploadFile;

        protected $phone;

        public function __construct() {

        }

        public function index() {
            $profile = User::find(\request()->user()->id);

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Профіль' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.business.settings.profile.index', [
                'metaTags' => $metaTags,
                'profile' => $profile
            ]);

        }

        public function update(Request $request) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|max:255', 'last_name' => 'required|max:255', 'phone' => 'required',
                'email' => 'required', 'password' => 'nullable|min:8',
                'password_confirmation' => 'nullable|same:password|min:8',]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні виникла помилка, деталі дивіться нижче');

            }

            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $profile = User::find(\request()->user()->id);
            $profile->first_name = $request->first_name;
            $profile->last_name = $request->last_name;

            if($profile->email !== $request->email) {
                $profile->email = $request->email;
            }

            if($profile->phone !== $this->phone) {
                $profile->phone = $this->phone;
            }

            $profile->photo = ($request->photo ?? null);

            if(!empty($request->password)) {
                $profile->password = Hash::make($request->password);
            }

            $profile->save();
            return redirect()->route('business::settings.profile.index', ['lang' => app()->getLocale()])->with('success', 'Success');
        }

        public function uploadFile(Request $request) {
            if($file = $request->file('photo')) {
                $photo = $this->uploadPhoto($file, 'users', 300, 300);
                return $photo;
            }
        }

        public function removeFile(Request $request) {
            $srcPath = public_path('storage/users/' . $request->filename);
            if(file_exists($srcPath) && !empty($request->filename)) {
                $user = User::where('photo', $request->filename)->first();
                if($user) {
                    $user->photo = null;
                    $user->save();
                }
                unlink($srcPath);
                return true;
            }

        }

    }
