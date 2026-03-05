<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;

    class SetLocale {
        /**
         * Handle an incoming request.
         *
         * @param Request $request
         * @param Closure $next
         *
         * @return mixed
         */
        public function handle($request, Closure $next) {
            $locale = $request->segment(1);
            $array = ['ua', 'ru'];

            if(!in_array($locale, $array)) {
                return redirect()->route('frontend::pages.index', ['lang'=>'ua']);
            }

            ($locale) ? app()->setLocale($locale) : 'ua';
            return $next($request);
        }
    }
