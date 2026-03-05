<?php

    namespace App\Http\Controllers\Amicms\v1\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;

    class LoginController extends Controller {
        /*
        |--------------------------------------------------------------------------
        | Login Controller
        |--------------------------------------------------------------------------
        |
        | This controller handles authenticating users for the application and
        | redirecting them to your home screen. The controller uses a trait
        | to conveniently provide its functionality to your applications.
        |
        */
        use AuthenticatesUsers;

        /**
         * Where to redirect users after login.
         *
         * @var string
         */
        protected $redirectTo = '/';

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct() {
            $this->middleware('auth.amicms')->except('logout');
        }

        public function showLoginForm() {
            return view('layouts.amicms.auth');
        }

        public function login(Request $request) {
            $data_array = $request->all();

            $validator = Validator::make($data_array, [
                    'email' => ['required', 'string', 'email'],
                    'password' => ['required', 'string'],
                ]
            );


            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if(Auth::attempt([
                'email' => $data_array['email'], 'password' => $data_array['password'], 'account_type' => [0,1]])) {
                return redirect('/');
            }
            else {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'Ім\'я користувача або пароль вказано неправильно');
            }
        }

        public function logout(Request $request) {
            $this->guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            if($response = $this->loggedOut($request)) {
                return $response;
            }
            return $request->wantsJson() ? new JsonResponse([], 204) : redirect('/');
        }


    }
