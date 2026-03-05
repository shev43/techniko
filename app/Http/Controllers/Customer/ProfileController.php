<?php

    namespace App\Http\Controllers\Customer;

    use App\Helper\UploadFile;
    use App\Http\Controllers\Controller;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use App\Models\User;
    use App\Models\UserVerifyCode;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use TurboSMS;
    use Config;


    class ProfileController extends Controller {

        use UploadFile;

        private $phone;
        private $code;

        public function generateCode($codeLength = 4) {
            if(config('turbosms.test_mode')) {
                return 1111;
            }
            $min = pow(10, ($codeLength - 1));
            $max = $min * 10 - 1;
            return mt_rand($min, $max);
        }

        public function index() {
            $profile = User::find(\request()->user()->id);

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Профіль' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.customer.settings.profile.index', [
                'metaTags' => $metaTags,
                'profile' => $profile
            ]);

        }

        public function changePhone(Request $request) {
            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $this->code = $request->get('code');
            $client = User::where('id', \request()->user()->id)->first();
            $authLoginCode = $client->changePhoneCode();
            if($authLoginCode->code == $this->code) {
                $authLoginCode->used = true;
                $authLoginCode->save();
                $client->phone = $this->phone;
                $client->save();

                return true;
            }
            else {
                return response()->json([
                    'message' => __('Щось пішло не так :('), 'errors' => ['code.exists' => __('Код невірний')]], 422);
            }

        }

        public function phoneVerified(Request $request) {
            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $this->code = $this->generateCode();
            $user = User::where('phone', $this->phone)->first();
            if(\request()->user()->phone == $this->phone) {
                return response()->json([
                    'message' => __('Щось пішло не так :('), 'errors' => [
                        'phone' => 'Здається, ви не змінили номер, спробуйте ще раз',]], 422);
            }
            elseif(isset($user) && $user->phone == $this->phone) {
                return response()->json([
                    'message' => __('Щось пішло не так :('), 'errors' => [
                        'phone' => 'Такий номер вже використовується в системі, спробуйте інший номер',]], 422);
            }
            else {
                $sendMessages = TurboSMS::sendMessages($this->phone, 'Betonko Enter to account by code: ' . $this->code, 'sms');
                $clientLoginCode = new UserVerifyCode();
                $clientLoginCode->user_id = \request()->user()->id;
                $clientLoginCode->code = $this->code;
                $clientLoginCode->phone = $this->phone;
                $clientLoginCode->message_id = $sendMessages['result'][0]['message_id'] ?? null;
                $clientLoginCode->response_status = $sendMessages['result'][0]['response_status'] ?? null;
                $clientLoginCode->action = 'change-phone';
                return $clientLoginCode->save();
            }

        }

        public function update(Request $request) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|max:255', 'last_name' => 'required|max:255', 'address' => 'required',]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При сохранении произошла ошибка, подробности смотрите ниже');

            }
            $profile = User::find(\request()->user()->id);
            $profile->first_name = $request->first_name;
            $profile->last_name = $request->last_name;
            $profile->photo = ($request->photo ?? null);

            $profile->address = $request->address;


            $profile->map_latitude = ($request->map_latitude ?? Config::get('map.default.map_latitude'));
            $profile->map_longitude = ($request->map_longitude ?? Config::get('map.default.map_longitude'));
            $profile->map_zoom = ($request->map_zoom ?? Config::get('map.default.map_zoom'));
            $profile->map_rotate = ($request->map_rotate ?? Config::get('map.default.map_rotate'));
            $profile->marker_latitude = ($request->marker_latitude ?? Config::get('map.default.marker_latitude'));
            $profile->marker_longitude = ($request->marker_longitude ?? Config::get('map.default.marker_longitude'));
            $profile->save();
            return redirect()->back()->with('success', 'Success');
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
