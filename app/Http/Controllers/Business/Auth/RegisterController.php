<?php

    namespace App\Http\Controllers\Business\Auth;

    use App\Http\Controllers\Controller;
    use App\Models\Business;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use App\Models\User;
    use App\Providers\RouteServiceProvider;

    use App\Mail\VerifyBusiness;

    use Illuminate\Foundation\Auth\RegistersUsers;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;
    use Mail;


    class RegisterController extends Controller {
        use RegistersUsers;

        protected $redirectTo = RouteServiceProvider::HOME;
        protected $phone;

        public function __construct() {
            $this->middleware('guest');
        }

        public function showRegistrationForm() {
            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Реєстрація партнера' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

//             $response = [
//                 'subject'=> 'Активація аккаунту',
//                 'name'=> 'erwerwer werwerwer',
//                 'target'=> route('business::profile.activate', ['lang'=>app()->getLocale(), 'token'=>'erwerwerwerwer']),
//             ];

//             Mail::to('info@art-delight.com')
//                 ->locale('uk')
//                 ->send(new VerifyBusiness($response));

            return view('frontend._modules.auth.business.register', [
                'metaTags'=>$metaTags
            ]);
        }

        public function register(Request $request) {
            $request->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));

            $validator = Validator::make(
                [
                    'first_name'=>$request->first_name,
                    'last_name'=>$request->last_name,
                    'phone'=>$request->phone,
                    'email'=>$request->email,
                    'representative'=>$request->representative,
                    'password'=>$request->password,
                    'password_confirmation'=>$request->password_confirmation,
                    'accept'=>$request->accept
                ]
            , [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],

                'phone' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

                'representative' => ['required', 'string', 'max:255'],
                'password' => ['required_with:password_confirmation', 'string', 'min:8', 'confirmed'],
                'password_confirmation' => ['required', 'same:password', 'string', 'min:8'],
                'accept' => ['required']
            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }


            $latestEntry = User::get();

            $user = new User;

            $user->profile_number = null;
            $user->profile_number_seller = 'UE' . str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
            $user->account_type = 3;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->verify_token = Str::random(60);
            $user->save();


            $response = [
                'subject'=> 'Активація аккаунту',
                'name'=> $request->first_name . ' ' . $request->last_name,
                'email'=> $request->email,
                'password'=> $request->password,
                'target'=> route('business::profile.activate', ['lang'=>app()->getLocale(), 'token'=>$user->verify_token]),
            ];

            Mail::to($request->email)
                ->locale('uk')
                ->send(new VerifyBusiness($response));


//
//            $notificationText = NotificationMessage::select('id')->where('action','business.register')->first();
//            $notification = new Notification;
//            $notification->user_id = $user->id;
//            $notification->notification_messages_id = $notificationText->id;
//            $notification->is_customer = 0;
//            $notification->is_sendmail = 0;
//            $notification->is_new = 1;
//            $notification->save();


            $business = Business::where('user_id', $user->id)->first();
            if($business == null) {
                $businessLatestEntry = Business::get();
                $business = new Business;
                $business->business_number = 'UE' . str_pad(($businessLatestEntry) ? count($businessLatestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
            }

            $business->user_id = $user->id;
            $business->name = $request->representative;
            $business->slug = Str::slug($business->name);
            $business->save();
            $this->guard()->login($user);


            if($response = $this->registered($request, $user)) {
                return $response;
            }
                return $request->wantsJson() ? new JsonResponse([], 201) : redirect()->route('business::settings.profile.index', ['lang' => app()->getLocale()]);
        }

        public function activate(Request $request) {
            $user = User::where('verify_token', $request->token)->first();
            if(!is_null($user)) {
                $user->enabled = 1;
                $user->verify_token = 'confirmed';
                $user->save();

                $this->guard()->login($user);

            } else {
                Auth::guard('business')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

            }

            if($response = $this->registered($request, $user)) {
                return $response;
            }

            return $request->wantsJson() ? new JsonResponse([], 201) : redirect()->route('business::settings.profile.index', ['lang' => app()->getLocale()]);

        }

        protected function guard() {
            return Auth::guard('business');
        }

    }
