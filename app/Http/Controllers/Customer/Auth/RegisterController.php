<?php

    namespace App\Http\Controllers\Customer\Auth;

    use App\Http\Controllers\Controller;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use App\Models\User;
    use App\Models\UserVerifyCode;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;
    use TurboSMS;

    class RegisterController extends Controller {
        private $phone;
        private $code;

        public function __construct() {
            $this->middleware('guest');
        }

        public function generateCode($codeLength = 4) {
            if(config('turbosms.test_mode')) {
                return 1111;
            }
            $min = pow(10, ($codeLength - 1));
            $max = $min * 10 - 1;
            return mt_rand($min, $max);
        }

        public function registerVerified(Request $request) {
            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $client = User::where('phone', $this->phone)->first();
            if($client) {
                return response()->json([
                    'message' => __('Щось пішло не так :('), 'errors' => [
                        'phone' => 'Корсистувач з таким номером уже зареєстрований',]], 422);

            }


            $validator = Validator::make($request->all(), [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'max:255'],
                'accepted' => ['required']

            ]);


            if($validator->fails()) {
                return response()->json([
                    'errors' => $validator->validate()], 422);
            }

            $this->code = $this->generateCode();
            $sendMessages = TurboSMS::sendMessages($this->phone, 'Betonko Enter to account by code: ' . $this->code, 'sms');
            $clientLoginCode = new UserVerifyCode;
            $clientLoginCode->code = $this->code;
            $clientLoginCode->phone = $this->phone;
            $clientLoginCode->message_id = $sendMessages['result'][0]['message_id'] ?? '';
            $clientLoginCode->response_status = $sendMessages['result'][0]['response_status'] ?? '';
            $clientLoginCode->action = 'register';
            return $clientLoginCode->save();

        }

        public function store(Request $request) {


            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $request_code = $request->get('code');
            $authLoginCode = UserVerifyCode::where('phone', $this->phone)->where('action', 'register')->where('used', 0)->latest()->first();

            if($authLoginCode->code !== $request_code) {
                return response()->json([
                    'error' =>  __('Код невірний')
                    ], 422);
            }


            $latestEntry = User::get();

            $client = new User();
            $client->account_type = 2;
            $client->profile_number = 'UC' . str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
            $client->profile_number_seller = null;
            $client->first_name = $request->get('first_name');
            $client->last_name = $request->get('last_name');
            $client->phone = $this->phone;
            if($client->save()) {
                $notificationText = NotificationMessage::select('id')->where('action','customer.register')->first();
                $notification = new Notification;
                $notification->user_id = $client->id;
                $notification->notification_messages_id = $notificationText->id;
                $notification->is_customer = 1;

                $notification->is_sendmail = 0;
                $notification->is_new = 1;
                $notification->save();

                $this->disableRegisterCode($client, $request_code);
                $this->loginClient($client);

                return $client;
            }
            return null;
        }

        private function loginClient(User $client) {
            Auth::guard('customer')->login($client);
        }

        private function disableRegisterCode(User $client, $code) {
            $clientCode = UserVerifyCode::where('phone', $client->phone)->where('used', 0)->where('action', 'register')->where('code', $code)->first();
            $clientCode->used = 1;
            $clientCode->user_id = $client->id;
            return $clientCode->save();
        }

    }
