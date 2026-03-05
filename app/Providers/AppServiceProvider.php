<?php

    namespace App\Providers;

    use App\Models\Notification;
    use App\Models\Technic;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Blade;
    use Illuminate\Support\Facades\URL;
    use Illuminate\Support\ServiceProvider;
    use App\Models\BusinessProducts;

    class AppServiceProvider extends ServiceProvider {
        /**
         * Register any application services.
         *
         * @return void
         */
        public function register() {
            //
        }

        /**
         * Bootstrap any application services.
         *
         * @return void
         */
        public function boot() {
            if (config('app.env') === 'production') {
                URL::forceScheme('https');
            }

            Blade::directive('getMinPrice', function() {
                $price = Technic::select('price')->min('price');
                return (!empty($price)) ? number_format($price, 0, '', '') : 1;
            });

            Blade::directive('getMaxPrice', function() {
                $price = Technic::select('price')->max('price');
                return (!empty($price)) ? number_format($price, 0, '', '') : 9999;
            });

        }
    }
