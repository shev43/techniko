<?php

    namespace App\Http\Controllers;
    use Illuminate\Support\Facades\Auth;

    class AmicmsController extends Controller {
        private $permission = [];

        public function is_profile_auth() {
            $this->middleware('auth')->except('logout');

            $this->middleware(function ($request, $next) {
                $this->user = Auth::user();

                foreach($this->user->roles() as $key => $modules) {
                    if($this->user->account_type == 0) {
                        $arr = [$modules->module=>1];
                    } else {
                        $arr = [$modules->module=>$modules->access];
                    }

                    $this->permission = array_merge($this->permission, $arr);

                }

                view()->share('permission', $this->permission);

                return $next($request);
            });

        }

    }
