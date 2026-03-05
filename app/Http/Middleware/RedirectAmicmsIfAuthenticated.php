<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    /**
     * Class RedirectAdminIfAuthenticated
     *
     * @package Framework\Http\Middleware
     */
    class RedirectAmicmsIfAuthenticated {
        /**
         * Handle an incoming request.
         *
         * @param Request $request
         * @param Closure $next
         * @param string|null $guard
         *
         * @return mixed
         */
        public function handle($request, Closure $next, $guard = null) {
            if(Auth::guard($guard)->check()) {
                return redirect()->route('amicms::dashboard.index');
            }
            return $next($request);
        }
    }
