<?php

    namespace App\Http\Controllers\Customer\Auth;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use App\Models\UserVerifyCode;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use TurboSMS;

    class LoginController extends Controller {

        private $phone;
        private $code;

        public function __construct() {
            $this->middleware('guest')->except('logout');
        }

        public function generateCode($codeLength = 4) {
            if(config('turbosms.test_mode')) {
                return 1111;
            }
            $min = pow(10, ($codeLength - 1));
            $max = $min * 10 - 1;
            return mt_rand($min, $max);
        }

        public function login(Request $request) {
            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $this->code = $request->get('code');
            $client = User::where('phone', $this->phone)->first();
            $authLoginCode = $client->authLoginCode();
            if($authLoginCode->code == $this->code) {
                $authLoginCode->used = true;
                $authLoginCode->save();

                Auth::guard('business')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                Auth::guard('customer')->login($client);
                return true;
            }
            return response()->json(['error' => __('Код невірний')], 403);

        }

        public function loginVerified(Request $request) {
            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $this->code = $this->generateCode();
            $user = User::where('phone', $this->phone)->first();
            if($user == null) {
                return response()->json(['error' => 'Користувач з таким номером не зареєстрований'], 403);
            }
            $sendMessages = TurboSMS::sendMessages($this->phone, 'Betonko Enter to account by code: ' . $this->code, 'sms');
            $clientLoginCode = new UserVerifyCode;
            $clientLoginCode->user_id = $user->id;
            $clientLoginCode->code = $this->code;
            $clientLoginCode->phone = $this->phone;
            $clientLoginCode->message_id = $sendMessages['result'][0]['message_id'] ?? '';
            $clientLoginCode->response_status = $sendMessages['result'][0]['response_status'] ?? '';
            $clientLoginCode->action = 'login';
            return $clientLoginCode->save();

        }

        public function logout(Request $request) {
            $this->guard('client')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            if($response = $this->loggedOut($request)) {
                return $response;
            }
            return $request->wantsJson() ? new JsonResponse([], 204) : redirect('/');
        }

        protected function loggedOut(Request $request) {
            //
        }

        protected function guard() {
            return Auth::guard('customer');
        }

    }
