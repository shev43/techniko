<?php

use App\Models\Report;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

Route::group(['domain' => env('APP_URL', 'www.techniko.loc')], function () {

    Route::get('/test', function(){
        return view('emails.verify-business', ['request'=>[
            'name' => 1,
            'email' => 1,
            'password' => 1,
            'target' => 1,
        ]]);
    });

    // TEMP: Auto-login for testing (remove before production)
    Route::get('/test-login-customer', function(){
        $customer = \App\Models\User::where('account_type', 2)->first();
        if ($customer) {
            \Illuminate\Support\Facades\Auth::guard('customer')->login($customer);
            return redirect('/ua/customer/request');
        }
        return 'No customer found';
    });

    // UploadFiles
    Route::post('/setting/profile/upload', [App\Http\Controllers\Business\ProfileController::class, 'uploadFile'])->name('setting.profile.upload-logo');
    Route::post('/setting/profile/remove-file', [App\Http\Controllers\Business\ProfileController::class, 'removeFile']);

    Route::post('/setting/company/upload', [App\Http\Controllers\Business\CompanyController::class, 'uploadFile'])->name('setting.company.upload-logo');
    Route::post('/setting/company/remove-file', [App\Http\Controllers\Business\CompanyController::class, 'removeFile']);

    Route::post('/setting/contacts/upload', [App\Http\Controllers\Business\ContactsController::class, 'uploadFile'])->name('setting.contacts.upload-logo');
    Route::post('/setting/contacts/remove-file', [App\Http\Controllers\Business\ContactsController::class, 'removeFile']);

    Route::post('/customer/profile/upload', [App\Http\Controllers\Customer\ProfileController::class, 'uploadFile'])->name('customer.profile.upload-logo');
    Route::post('/customer/profile/remove-file', [App\Http\Controllers\Customer\ProfileController::class, 'removeFile']);

    Route::get('/reviews/store', [App\Http\Controllers\ServiceReviewController::class, 'store'])->name('review.store');
    Route::get('/reviews/discard/{user_id}', [App\Http\Controllers\ServiceReviewController::class, 'discard'])->name('review.discard');

    Route::post('/{lang}/settings/technics/upload-files', [App\Http\Controllers\Business\TechnicController::class, 'uploadFile'])->name('business.settings.technics.upload-files');
    Route::post('/{lang}/settings/technics/delete-files', [App\Http\Controllers\Business\TechnicController::class, 'removeFile'])->name('business.settings.technics.delete-files');

    Route::get('/{lang}/report/{action}/{business_id}/{technic_id}', function($lang, $action, $business_id, $technic_id) {
        $report = Report::where('business_id', $business_id)
            ->where('technic_id', $technic_id)
            ->where('action', $action)->firstOrCreate();

        $report->business_id = $business_id ?? null;
        $report->technic_id = $technic_id ?? null;
        $report->action = $action;
        $report->count = $report->count + 1;
        $report->save();

    });

    // Subscription
    Route::get('/subscribe/renewal', [App\Http\Controllers\Business\SubscriptionController::class, 'renewal']);

    Route::get('/pdf-create',[App\Http\Controllers\Business\DashboardController::class, 'create_pdf']);

    // Auth
    Route::group(['middleware' => ['setLocale'], 'prefix' => '/{lang?}/oauth'], function () {
        Route::post('/customer.login-verified', [App\Http\Controllers\Customer\Auth\LoginController::class, 'loginVerified'])->name('customer.profile.login.sms');
        Route::post('/customer.login', [App\Http\Controllers\Customer\Auth\LoginController::class, 'login'])->name('customer.profile.login.send');
        Route::post('/customer.register-verified', [App\Http\Controllers\Customer\Auth\RegisterController::class, 'registerVerified'])->name('customer.profile.register.sms');
        Route::post('/customer.register', [App\Http\Controllers\Customer\Auth\RegisterController::class, 'store'])->name('customer.profile.register.store');

        Route::get('/business.register', [App\Http\Controllers\Business\Auth\RegisterController::class, 'showRegistrationForm'])->name('business.profile.register-form');
        Route::post('/business.register', [App\Http\Controllers\Business\Auth\RegisterController::class, 'register'])->name('business.profile.register');
        Route::post('/business.login', [App\Http\Controllers\Business\Auth\LoginController::class, 'login'])->name('business.profile.login');

    });

    Route::group(['middleware' => ['setLocale'], 'prefix' => '{lang?}', 'as' => 'frontend::'], function () {
        Route::get('/', [\App\Http\Controllers\Frontend\PagesController::class, 'index'])->name('pages.index');
        Route::get('/catalog', [\App\Http\Controllers\Frontend\CatalogController::class, 'index'])->name('catalog.index');
        Route::get('/catalog/{slug}', [\App\Http\Controllers\Frontend\CatalogController::class, 'technic'])->name('catalog.technic');
        Route::get('/company/{technic_slug}/{slug}', [\App\Http\Controllers\Frontend\CatalogController::class, 'business'])->name('catalog.business');
        Route::get('/order/{slug}', [\App\Http\Controllers\Customer\OrderController::class, 'index'])->name('order.index');

        Route::get('/how-to-use', function() {
            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Як користуватись?' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.pages.how-to-use', ['metaTags'=>$metaTags]);

        })->name('how-to-use');

        Route::get('/about', function() {
            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Про компанію' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.pages.about', ['metaTags'=>$metaTags]);

        })->name('about');

        Route::get('/policy', function() {
            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Політика конфіденційності та умови використання' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.pages.policy', ['metaTags'=>$metaTags]);
        })->name('policy');


        Route::get('/subscribe', [App\Http\Controllers\Frontend\SubscriptionController::class, 'index'])->name('subscription.index');
        Route::post('/subscribe/success', [App\Http\Controllers\Business\SubscriptionController::class, 'success'])->name('subscription.success');

    });

    Auth::routes();

    Route::group(['middleware' => 'setLocale', 'prefix' => '/{lang}/customer', 'as' => 'customer::'], function () {
        Route::middleware(['auth:customer'])->group(function () {
            Route::post('/logout', [App\Http\Controllers\Customer\Auth\LoginController::class, 'logout'])->name('profile.logout');

            Route::get('/', [\App\Http\Controllers\Frontend\PagesController::class, 'index'])->name('pages.index');
            Route::get('/catalog', [\App\Http\Controllers\Frontend\CatalogController::class, 'index'])->name('catalog.index');
            Route::get('/catalog/{slug}', [\App\Http\Controllers\Frontend\CatalogController::class, 'technic'])->name('catalog.technic');
            Route::get('/order/{slug}', [\App\Http\Controllers\Customer\OrderController::class, 'index'])->name('order.index');
            Route::post('/order/create', [\App\Http\Controllers\Customer\OrderController::class, 'create'])->name('order.create');

            Route::get('/how-to-use', function() {
                $metaTags = [
                    'metaTitle' => (app()->getLocale() == 'ua') ? 'Як користуватись?' : 'Home',
                    'metaKeywords' => '',
                    'metaDescription' => ''
                ];

                return view('frontend.pages.how-to-use', ['metaTags'=>$metaTags]);

            })->name('how-to-use');

            Route::get('/about', function() {
                $metaTags = [
                    'metaTitle' => (app()->getLocale() == 'ua') ? 'Про компанію' : 'Home',
                    'metaKeywords' => '',
                    'metaDescription' => ''
                ];

                return view('frontend.pages.about', ['metaTags'=>$metaTags]);

            })->name('about');

            Route::get('/policy', function() {
                $metaTags = [
                    'metaTitle' => (app()->getLocale() == 'ua') ? 'Політика конфіденційності та умови використання' : 'Home',
                    'metaKeywords' => '',
                    'metaDescription' => ''
                ];

                return view('frontend.pages.policy', ['metaTags'=>$metaTags]);
            })->name('policy');


            Route::get('/profile/index', [App\Http\Controllers\Customer\ProfileController::class, 'index'])->name('profile.index');
            Route::post('/profile/update', [App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('profile.update');
            Route::get('/profile/change-phone', [App\Http\Controllers\Customer\ProfileController::class, 'phoneVerified'])->name('profile.change-phone.send');
            Route::get('/profile/phone-verified', [App\Http\Controllers\Customer\ProfileController::class, 'changePhone'])->name('profile.change-phone.sms');


            Route::get('/request', [App\Http\Controllers\Customer\RequestController::class, 'index'])->name('request.index');
            Route::get('/request/{order_id}', [App\Http\Controllers\Customer\RequestController::class, 'view'])->name('request.view');
            Route::post('/request/accepted', [App\Http\Controllers\Customer\RequestController::class, 'accepted'])->name('request.accepted');
            Route::get('/request/cancel-request/{order_id}', [App\Http\Controllers\Customer\RequestController::class, 'cancel'])->name('request.cancel');
            Route::get('/request/cancel-offer/{offer_id}', [App\Http\Controllers\Customer\RequestController::class, 'cancel_offer'])->name('request.cancel-offer');

            Route::get('/tender', [App\Http\Controllers\Customer\TenderController::class, 'index'])->name('tender.index');
            Route::get('/tender/create', [App\Http\Controllers\Customer\TenderController::class, 'create'])->name('tender.create');
            Route::post('/tender/store', [App\Http\Controllers\Customer\TenderController::class, 'store'])->name('tender.store');
            Route::get('/tender/offers/{order_id}', [App\Http\Controllers\Customer\TenderController::class, 'view_offers'])->name('tender.view-offers');
            Route::get('/tender/request/{order_id}/{offer_id}', [App\Http\Controllers\Customer\TenderController::class, 'view'])->name('tender.view');
            Route::post('/tender/accepted', [App\Http\Controllers\Customer\TenderController::class, 'accepted'])->name('tender.accepted');
            Route::get('/tender/canceled/{order_id}', [App\Http\Controllers\Customer\TenderController::class, 'canceled'])->name('tender.canceled');
            Route::get('/tender/cancel-offer/{order_id}/{offer_id}', [App\Http\Controllers\Customer\TenderController::class, 'cancel_offer'])->name('tender.cancel-offer');

            Route::get('/notifications/index', [App\Http\Controllers\Customer\NotificationController::class, 'index'])->name('notifications.index');


            Route::get('/reviews', [App\Http\Controllers\ServiceReviewController::class, 'check'])->name('review.check');

            Route::get('/unread-notification', function () {
                $notification = App\Models\Notification::where('user_id', request()->user()->id)->where('is_new', 1)->where('is_customer', 1)->get();
                return count($notification);
            });

            Route::get('/read-notification', function (){
                $notification_array = App\Models\Notification::where('user_id', request()->user()->id)->where('is_new', 1)->where('is_customer', 1)->get();
                foreach($notification_array as $notification) {
                    $notify = App\Models\Notification::find($notification->id);
                    $notify->is_new = 0;
                    $notify->save();
                }
            });

        });

    });

    Route::group(['middleware' => 'setLocale', 'prefix' => '/{lang?}/business', 'as' => 'business::'], function () {
        Route::get('/forgot-password', function(){
            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Відновлення доступу' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend._modules.auth.business.forgot-password', ['lang'=>app()->getLocale(), 'metaTags'=>$metaTags]);

        })->name('profile.forgot-password');



        Route::post('/forgot-password', function (Request $request) {
            $request->validate(['email' => 'required|email']);

            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);

        })->middleware('guest')->name('profile.password.email');



        Route::get('/reset-password/{token}', function ($lang, $token) {
            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Відновлення доступу' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend._modules.auth.business.passwords.reset', [
                'lang'=>app()->getLocale(),
                'metaTags'=>$metaTags,
                'token' => $token,
            ]);

        })->middleware('guest')->name('password.reset');





        Route::post('/reset-password', function (Request $request) {


//            dd($request->all());

            $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
            ]);

            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));

                    Auth::guard('business')->login($user);
                }
            );

            return $status === Password::PASSWORD_RESET
                ? redirect('/')
                : back()->withErrors(['email' => [__($status)]]);

        })->middleware('guest')->name('password.update');



        Route::get('/activete', [App\Http\Controllers\Business\Auth\RegisterController::class, 'activate'])->name('profile.activate');









        Route::middleware(['auth:business'])->group(function () {
            Route::post('/logout', [App\Http\Controllers\Business\Auth\LoginController::class, 'logout'])->name('profile.logout');

            Route::get('/', [\App\Http\Controllers\Frontend\PagesController::class, 'index'])->name('pages.index');
            Route::get('/dashboard', [App\Http\Controllers\Business\DashboardController::class, 'index'])->name('dashboard.index');
            Route::get('/catalog', [\App\Http\Controllers\Frontend\CatalogController::class, 'index'])->name('catalog.index');
            Route::get('/catalog/{slug}', [\App\Http\Controllers\Frontend\CatalogController::class, 'technic'])->name('catalog.technic');
            Route::get('/order/{slug}', [\App\Http\Controllers\Customer\OrderController::class, 'index'])->name('order.index');

            Route::get('/how-to-use', function() {
                $metaTags = [
                    'metaTitle' => (app()->getLocale() == 'ua') ? 'Як користуватись?' : 'Home',
                    'metaKeywords' => '',
                    'metaDescription' => ''
                ];

                return view('frontend.pages.how-to-use', ['metaTags'=>$metaTags]);

            })->name('how-to-use');

            Route::get('/about', function() {
                $metaTags = [
                    'metaTitle' => (app()->getLocale() == 'ua') ? 'Про компанію' : 'Home',
                    'metaKeywords' => '',
                    'metaDescription' => ''
                ];

                return view('frontend.pages.about', ['metaTags'=>$metaTags]);

            })->name('about');

            Route::get('/policy', function() {
                $metaTags = [
                    'metaTitle' => (app()->getLocale() == 'ua') ? 'Політика конфіденційності та умови використання' : 'Home',
                    'metaKeywords' => '',
                    'metaDescription' => ''
                ];

                return view('frontend.pages.policy', ['metaTags'=>$metaTags]);
            })->name('policy');

            Route::get('/request', [App\Http\Controllers\Business\RequestController::class, 'index'])->name('request.index');
            Route::get('/request/{order_id}', [App\Http\Controllers\Business\RequestController::class, 'view'])->name('request.view');
    //        Route::get('/request/cancel-request/{order_id}', [App\Http\Controllers\Business\RequestController::class, 'cancel'])->name('request.cancel');
    //        Route::get('/request/cancel-offer/{offer_id}', [App\Http\Controllers\Business\RequestController::class, 'cancel_offer'])->name('request.cancel-offer');
            Route::post('/offer', [App\Http\Controllers\Business\OfferController::class, 'create'])->name('offer.create');
            Route::get('/offer/canceled/{offer_id}', [App\Http\Controllers\Business\OfferController::class, 'canceled'])->name('offer.canceled');

            Route::get('/tender', [App\Http\Controllers\Business\TenderController::class, 'index'])->name('tender.index');
            Route::get('/tender/{view_type}/{order_id}', [App\Http\Controllers\Business\TenderController::class, 'view'])->name('tender.view');
            Route::get('/tender/offer/canceled/{offer_id}', [App\Http\Controllers\Business\TenderController::class, 'canceled'])->name('tender.canceled');

            Route::get('/accepted', [App\Http\Controllers\Business\AcceptedController::class, 'index'])->name('accepted.index');
            Route::get('/accepted/{offer_id}', [App\Http\Controllers\Business\AcceptedController::class, 'view'])->name('accepted.view');
            Route::get('/accepted/{status}/{offer_id}', [App\Http\Controllers\Business\AcceptedController::class, 'status'])->name('accepted.status');

            Route::get('/settings/profile', [App\Http\Controllers\Business\ProfileController::class, 'index'])->name('settings.profile.index');
            Route::post('/settings/profile/update', [App\Http\Controllers\Business\ProfileController::class, 'update'])->name('settings.profile.update');

            Route::get('/settings/company', [App\Http\Controllers\Business\CompanyController::class, 'index'])->name('settings.company.index');
            Route::post('/settings/company/update', [App\Http\Controllers\Business\CompanyController::class, 'update'])->name('settings.company.update');

            Route::get('/settings/contacts', [App\Http\Controllers\Business\ContactsController::class, 'index'])->name('settings.contacts.index');
            Route::get('/settings/contacts/create', [App\Http\Controllers\Business\ContactsController::class, 'create'])->name('settings.contacts.create');
            Route::post('/settings/contacts/store', [App\Http\Controllers\Business\ContactsController::class, 'store'])->name('settings.contacts.store');
            Route::get('/settings/contacts/edit/{contact_id}', [App\Http\Controllers\Business\ContactsController::class, 'edit'])->name('settings.contacts.edit');
            Route::post('/settings/contacts/update/{contact_id}', [App\Http\Controllers\Business\ContactsController::class, 'update'])->name('settings.contacts.update');
            Route::get('/settings/contacts/destroy/{contact_id}', [App\Http\Controllers\Business\ContactsController::class, 'destroy'])->name('settings.contacts.destroy');

            Route::get('/settings/technics', [App\Http\Controllers\Business\TechnicController::class, 'index'])->name('settings.technics.index');
            Route::get('/settings/technics/create', [App\Http\Controllers\Business\TechnicController::class, 'create'])->name('settings.technics.create');
            Route::post('/settings/technics/store', [App\Http\Controllers\Business\TechnicController::class, 'store'])->name('settings.technics.store');
            Route::get('/settings/technics/edit/{technic_id}', [App\Http\Controllers\Business\TechnicController::class, 'edit'])->name('settings.technics.edit');
            Route::post('/settings/technics/update/{technic_id}', [App\Http\Controllers\Business\TechnicController::class, 'update'])->name('settings.technics.update');
            Route::get('/settings/technics/destroy/{technic_id}', [App\Http\Controllers\Business\TechnicController::class, 'destroy'])->name('settings.technics.destroy');

            Route::get('/settings/notifications/index', [App\Http\Controllers\Business\NotificationController::class, 'index'])->name('settings.notifications.index');
            Route::get('/settings/subscribe/history', [App\Http\Controllers\Business\SubscriptionController::class, 'history'])->name('settings.subscribe.history');

            Route::get('/subscribe', [App\Http\Controllers\Business\SubscriptionController::class, 'index'])->name('subscription.index');
            Route::post('/subscribe/create', [App\Http\Controllers\Business\SubscriptionController::class, 'create'])->name('subscription.create');
            Route::get('/subscribe/{subscribe_id}/remove', [App\Http\Controllers\Business\SubscriptionController::class, 'remove'])->name('subscription.remove');

            Route::get('/reviews', [App\Http\Controllers\ServiceReviewController::class, 'check'])->name('review.check');
            Route::get('/unread-notification', function () {
                $notification = App\Models\Notification::where('user_id', request()->user()->id)->where('is_new', 1)->where('is_customer', 0)->get();
                return count($notification);
            });

            Route::get('/read-notification', function (){
                $notification_array = App\Models\Notification::where('user_id', request()->user()->id)->where('is_new', 1)->where('is_customer', 0)->get();
                foreach($notification_array as $notification) {
                    $notify = App\Models\Notification::find($notification->id);
                    $notify->is_new = 0;
                    $notify->save();
                }
            });

        });

    });

});





// ADMIN

//Route::group(['middleware' => 'setLocale', 'prefix' => '/{lang?}/business', 'as' => 'business::'], function () {


Route::group([ 'domain' => env('APP_AMICMS_URL', 'amicms.techniko.loc'), 'as' =>'amicms::'], function() {
    Auth::routes();

    Route::get('/', function() { return redirect(route('amicms::profile.login.form')); });

    Route::get('profile/login', [App\Http\Controllers\Amicms\v1\Auth\LoginController::class, 'showLoginForm'])->name('profile.login.form');
    Route::post('profile/login', [App\Http\Controllers\Amicms\v1\Auth\LoginController::class, 'login'])->name('profile.login');
    Route::post('profile/logout', [App\Http\Controllers\Amicms\v1\Auth\LoginController::class, 'logout'])->name('profile.logout');

    Route::get('profile', [App\Http\Controllers\Amicms\v1\ProfileController::class, 'index'])->name('profile.index');
    Route::get('profile/edit', [App\Http\Controllers\Amicms\v1\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile/update', [App\Http\Controllers\Amicms\v1\ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/removeFile/{user_id}', [App\Http\Controllers\Amicms\v1\ProfileController::class, 'removeFile'])->name('profile.removeFile');

    Route::get('support', [App\Http\Controllers\Amicms\v1\SupportController::class, 'index'])->name('support.index');

    Route::get('dashboard', [App\Http\Controllers\Amicms\v1\DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('business', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'index'])->name('business.index');
    Route::get('business/create', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'create'])->name('business.create');
    Route::post('business/store', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'store'])->name('business.store');

    Route::get('business/restore/{business_id}', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'restore'])->name('business.restore');
    Route::get('business/destroy/{business_id}', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'destroy'])->name('business.destroy');
    Route::get('business/destroy-with-trash/{business_id}', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'destroyWithTrash'])->name('business.destroy-with-trash');

    Route::get('business/{business_id}/activate', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'activate']);
    Route::get('business/import', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'import'])->name('business.import.index');
    Route::post('business/import/store', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'importStore'])->name('business.import.store');


    Route::get('business/{business_id}/company', [App\Http\Controllers\Amicms\v1\BusinessCompanyController::class, 'index'])->name('business.company.index');
    Route::get('business/{business_id}/company/edit', [App\Http\Controllers\Amicms\v1\BusinessCompanyController::class, 'edit'])->name('business.company.edit');
    Route::post('business/{business_id}/company/update', [App\Http\Controllers\Amicms\v1\BusinessCompanyController::class, 'update'])->name('business.company.update');
    Route::get('business/{business_id}/company/removeFile', [App\Http\Controllers\Amicms\v1\BusinessCompanyController::class, 'removeFile'])->name('business.company.removeFile');



    Route::get('business/{business_id}/profile', [App\Http\Controllers\Amicms\v1\BusinessProfileController::class, 'index'])->name('business.profile.index');
    Route::get('business/{business_id}/profile/edit', [App\Http\Controllers\Amicms\v1\BusinessProfileController::class, 'edit'])->name('business.profile.edit');
    Route::post('business/{business_id}/profile/store', [App\Http\Controllers\Amicms\v1\BusinessProfileController::class, 'store'])->name('business.profile.store');
    Route::get('business/{business_id}/profile/{profile_id}/removeFile', [App\Http\Controllers\Amicms\v1\BusinessProfileController::class, 'removeFile'])->name('business.profile.removeFile');

    Route::get('business/{business_id}/contacts', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'index'])->name('business.contacts.index');
    Route::get('business/{business_id}/contacts/create', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'create'])->name('business.contacts.create');
    Route::post('business/{business_id}/contacts/store', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'store'])->name('business.contacts.store');
    Route::get('business/{business_id}/contacts/edit/{contact_id}', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'edit'])->name('business.contacts.edit');
    Route::post('business/{business_id}/contacts/update/{contact_id}', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'update'])->name('business.contacts.update');

    Route::get('business/{business_id}/contacts/{contact_id}/removeFile', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'removeFile'])->name('business.contacts.removeFile');

    Route::get('business/{business_id}/contacts/restore/{contact_id}', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'restore'])->name('business.contacts.restore');
    Route::get('business/{business_id}/contacts/destroy/{contact_id}', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'destroy'])->name('business.contacts.destroy');
    Route::get('business/{business_id}/contacts/destroy-with-trash/{contact_id}', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'destroyWithTrash'])->name('business.contacts.destroy-with-trash');

    Route::get('business/{business_id}/subscription', [App\Http\Controllers\Amicms\v1\BusinessSubscriptionController::class, 'index'])->name('business.subscription.index');
    Route::post('business/{business_id}/subscription/subscribe', [App\Http\Controllers\Amicms\v1\BusinessSubscriptionController::class, 'subscribe'])->name('business.subscription.subscribe');
    Route::get('business/{business_id}/subscription/{subscription_id}/deactivate', [App\Http\Controllers\Amicms\v1\BusinessSubscriptionController::class, 'deActivate'])->name('business.subscription.deActivate');


    Route::get('orders', [App\Http\Controllers\Amicms\v1\OrdersController::class, 'index'])->name('orders.index');
    Route::get('orders/{order_id}', [App\Http\Controllers\Amicms\v1\OrdersController::class, 'view'])->name('orders.view');
    Route::get('orders/{order_id}/edit', [App\Http\Controllers\Amicms\v1\OrdersController::class, 'edit'])->name('orders.edit');
    Route::post('orders/{order_id}/update', [App\Http\Controllers\Amicms\v1\OrdersController::class, 'update'])->name('orders.update');

    Route::get('subscription', [App\Http\Controllers\Amicms\v1\SubscriptionController::class, 'index'])->name('subscription.index');
    Route::get('subscription/{business_id}', [App\Http\Controllers\Amicms\v1\SubscriptionController::class, 'view'])->name('subscription.view');

    Route::get('reports/orders', [App\Http\Controllers\Amicms\v1\ReportsController::class, 'orders'])->name('reports.orders');
    Route::get('reports/subscription', [App\Http\Controllers\Amicms\v1\ReportsController::class, 'subscription'])->name('reports.subscription');

    Route::get('reports/visitors/{business_id}', [App\Http\Controllers\Amicms\v1\ReportsController::class, 'visitors'])->name('reports.visitors');

    Route::get('clients', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'index'])->name('clients.index');
    Route::get('clients/create', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'create'])->name('clients.create');
    Route::post('clients/store', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'store'])->name('clients.store');
    Route::get('clients/edit/{client_id}', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'edit'])->name('clients.edit');
    Route::post('clients/update/{client_id}', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'update'])->name('clients.update');

    Route::get('clients/removeFile/{client_id}', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'removeFile'])->name('clients.removeFile');

    Route::get('clients/restore/{client_id}', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'restore'])->name('clients.restore');
    Route::get('clients/destroy/{client_id}', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'destroy'])->name('clients.destroy');
    Route::get('clients/destroy-with-trash/{client_id}', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'destroyWithTrash'])->name('clients.destroy-with-trash');

    Route::get('users', [App\Http\Controllers\Amicms\v1\UsersController::class, 'index'])->name('users.index');
    Route::get('users/create', [App\Http\Controllers\Amicms\v1\UsersController::class, 'create'])->name('users.create');
    Route::post('users/store', [App\Http\Controllers\Amicms\v1\UsersController::class, 'store'])->name('users.store');
    Route::get('users/edit/{user_id}', [App\Http\Controllers\Amicms\v1\UsersController::class, 'edit'])->name('users.edit');
    Route::post('users/update/{user_id}', [App\Http\Controllers\Amicms\v1\UsersController::class, 'update'])->name('users.update');
    Route::get('users/restore/{user_id}', [App\Http\Controllers\Amicms\v1\UsersController::class, 'restore'])->name('users.restore');
    Route::get('users/destroy/{user_id}', [App\Http\Controllers\Amicms\v1\UsersController::class, 'destroy'])->name('users.destroy');
    Route::get('users/destroy-with-trash/{user_id}', [App\Http\Controllers\Amicms\v1\UsersController::class, 'destroyWithTrash'])->name('users.destroy-with-trash');
    Route::get('users/removeFile/{user_id}', [App\Http\Controllers\Amicms\v1\UsersController::class, 'removeFile'])->name('users.removeFile');

    Route::get('mailing', [App\Http\Controllers\Amicms\v1\MailingController::class, 'index'])->name('mailing.index');
    Route::post('mailing/store', [App\Http\Controllers\Amicms\v1\MailingController::class, 'store'])->name('mailing.store');

    Route::get('settings/machines', [App\Http\Controllers\Amicms\v1\SettingsMachinesController::class, 'index'])->name('settings.machines.index');
    Route::get('settings/machines/create', [App\Http\Controllers\Amicms\v1\SettingsMachinesController::class, 'create'])->name('settings.machines.create');
    Route::post('settings/machines/store', [App\Http\Controllers\Amicms\v1\SettingsMachinesController::class, 'store'])->name('settings.machines.store');
    Route::get('settings/machines/edit/{machine_id}', [App\Http\Controllers\Amicms\v1\SettingsMachinesController::class, 'edit'])->name('settings.machines.edit');
    Route::post('settings/machines/update/{machine_id}', [App\Http\Controllers\Amicms\v1\SettingsMachinesController::class, 'update'])->name('settings.machines.update');
    Route::get('settings/machines/restore/{machine_id}', [App\Http\Controllers\Amicms\v1\SettingsMachinesController::class, 'restore'])->name('settings.machines.restore');
    Route::get('settings/machines/destroy/{machine_id}', [App\Http\Controllers\Amicms\v1\SettingsMachinesController::class, 'destroy'])->name('settings.machines.destroy');
    Route::get('settings/machines/destroy-with-trash/{machine_id}', [App\Http\Controllers\Amicms\v1\SettingsMachinesController::class, 'destroyWithTrash'])->name('settings.machines.destroy-with-trash');

    Route::get('settings/machines/remove-file/{machine_id}', [App\Http\Controllers\Amicms\v1\SettingsMachinesController::class, 'removeFile'])->name('settings.machines.removeFile');

    Route::get('settings/machines/{machine_id}/visible', [App\Http\Controllers\Amicms\v1\SettingsMachinesController::class, 'visible']);


    Route::get('settings/machine-categories', [App\Http\Controllers\Amicms\v1\SettingsMachineCategoriesController::class, 'index'])->name('settings.machine-categories.index');
    Route::get('settings/machine-categories/create', [App\Http\Controllers\Amicms\v1\SettingsMachineCategoriesController::class, 'create'])->name('settings.machine-categories.create');
    Route::post('settings/machine-categories/store', [App\Http\Controllers\Amicms\v1\SettingsMachineCategoriesController::class, 'store'])->name('settings.machine-categories.store');
    Route::get('settings/machine-categories/edit/{machine_categories_id}', [App\Http\Controllers\Amicms\v1\SettingsMachineCategoriesController::class, 'edit'])->name('settings.machine-categories.edit');
    Route::post('settings/machine-categories/update/{machine_categories_id}', [App\Http\Controllers\Amicms\v1\SettingsMachineCategoriesController::class, 'update'])->name('settings.machine-categories.update');
    Route::get('settings/machine-categories/restore/{machine_categories_id}', [App\Http\Controllers\Amicms\v1\SettingsMachineCategoriesController::class, 'restore'])->name('settings.machine-categories.restore');
    Route::get('settings/machine-categories/destroy/{machine_categories_id}', [App\Http\Controllers\Amicms\v1\SettingsMachineCategoriesController::class, 'destroy'])->name('settings.machine-categories.destroy');
    Route::get('settings/machine-categories/destroy-with-trash/{machine_categories_id}', [App\Http\Controllers\Amicms\v1\SettingsMachineCategoriesController::class, 'destroyWithTrash'])->name('settings.machine-categories.destroy-with-trash');

});

