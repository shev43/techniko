<?php

    namespace App\Http\Controllers\Business\Auth;

    use App\Http\Controllers\Controller;
    use App\Mail\ForgotPassword;
    use App\Models\User;
    use App\Providers\RouteServiceProvider;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;
    use Mail;

    class LoginController extends Controller {
        use AuthenticatesUsers;

        protected $redirectTo = RouteServiceProvider::HOME;

        public function __construct() {
            $this->middleware('guest')->except('logout');
        }

        public function login(Request $request) {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user = User::where('email', $request->email)->first();

            if($user && Hash::check($request->password, $user->password)) {
                if($user->enabled == 0) {
                    return response()->json(['errors' => [__('web.BUSINESS_ACTIVATION_LOGIN_ERROR')]], 422);

                }
                Auth::guard('business')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $credentials = $request->only('email', 'password');
                Auth::guard('business')->attempt($credentials);

                return true;
            }

            return response()->json(['errors' => [__('web.BUSINESS_LOGIN_ERROR')]], 422);

        }

        public function forgotPassword(Request $request) {
            $user = User::where('email', $request->email)->first();

            if($user) {
                Auth::guard('business')->logout();

                $generatePassword = Str::random();
                $user->password = Hash::make($generatePassword);
                $user->save();


                $response = [
                    'subject'=> 'Відновлення паролю',
                    'name'=> $user->first_name . ' ' . $user->last_name,
                    'email'=> $request->email,
                    'password'=> $generatePassword,
                ];

                Mail::to($request->email)
                    ->locale('uk')
                    ->send(new ForgotPassword($response));

                return redirect()->route('business::settings.profile.index', [
                    'lang' => app()->getLocale()
                ]);
            }

            return false;

        }

        public function logout(Request $request) {
            $this->guard()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return $request->wantsJson() ? new JsonResponse([], 204) : redirect('/');

        }

        protected function guard() {
            return Auth::guard('business');

        }

    }

