@extends('layouts.app')

@section('content')
    <main class="main page">
        <nav class="container mb-5" aria-label="breadcrumb">
            <ol class="breadcrumb">
                @if(Auth::guard('business')->check())
                    <li class="breadcrumb-item"><a href="{{ route('business::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
                @elseif(Auth::guard('customer')->check())
                    <li class="breadcrumb-item"><a href="{{ route('customer::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
                @else
                    <li class="breadcrumb-item"><a href="{{ route('frontend::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">Профіль</li>
            </ol>
        </nav>


        <div class="container">
            <section id="navbar-submenu">
                <div class="row">
                    <div class="col-12 col-sm-12 col-lg-12">
                        @include('frontend.customer.settings._partials.navbar')
                    </div>
                </div>
            </section>

            <section id="businessSettingsProfilePhoto" class="seller_cabinet-settings-profile">
                <h2 class="title text-center">Налаштування профілю</h2>
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-3 col-md-4">
                        <div class="form-group text-center">
                            <img class="seller_cabinet-settings-logo" src="@if(!empty($profile->photo)){{ asset('storage/users/' . $profile->photo) }}@else{{ asset('img/profile-logo.svg') }}@endif" data-empty="{{ asset('img/profile-logo.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 col-md-8 d-flex align-items-center justify-content-center">
                        <div class="seller_cabinet-settings-logo_btns">
                            <div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="business-image-loader" class="btn btn-default">Завантажити лого</label>
                                    <input type="file" class="form-control-file" id="business-image-loader" data-upload="{{ route('setting.profile.upload-logo') }}" style="display: none;">
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="form-group" style="margin: auto">
                                    <a class="btn btn-delete p-0">
                                        <span>Видалити</span>
                                        <svg class="icon">
                                            <use xlink:href="#icon-clear"></use>
                                        </svg>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <form id="businessSetting" action="{{ route('customer::profile.update', ['lang'=>app()->getLocale()]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="photo" value="{{$profile->photo ?? ''}}">

                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="first_name">Ваше ім’я:</label>
                                <input name="first_name" type="text" class="form-control js-name @error('first_name') is-invalid @enderror" id="first_name" placeholder="" value="{{ $profile->first_name }}">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="last_name">Ваше прізвище:</label>
                                <input name="last_name" type="text" class="form-control js-name @error('last_name') is-invalid @enderror" id="last_name" placeholder="" value="{{ $profile->last_name }}">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Номер телефону</label>
                                <input type="text" class="form-control placeholder disabled-phone" value="{{ $profile->phone }}" disabled>
                                <div class="mt-1"><a href="#" data-toggle="modal" data-target="#modal">Змінити номер</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="address">Адреса</label>
                                <input name="address" type="text" class="form-control autocomplete @error('address') is-invalid @enderror" id="address" placeholder="" value="{{ $profile->address }}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            @include('frontend._modules.map-form', ['objects'=>$profile, 'target'=>'form#businessSetting input[name=address]'])
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-8 text-center text-lg-right">
                            <button class="btn btn-default" type="submit">Зберегти</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </main>


    <div class="modal fade modal customer_cabinet-person_edit change-phone" tabindex="-1" id="modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg>
                        <use xlink:href="#icon-5"></use>
                    </svg>
                </button>
                <div class="modal-inner">
                    <h2 class="mb-3">Зміна телефону</h2>

                    <div class="send-change-phone">
                        <form id="customerProfileSendChangePhone" method="get" action="{{ route('customer::profile.change-phone.send', ['lang'=>app()->getLocale()]) }}">
                            @csrf
                            <div class="form-group">
                                <label for="e21" class="required">Номер телефону:</label>
                                <input type="text" class="form-control" id="e21" name="phone" placeholder="" value="{{ request()->user()->phone }}" required>
                                <div class="invalid-feedback mt-2"></div>

                            </div>
                            <button id="btnChangePhone" class="btn btn-default">Підтвердити</button>
                        </form>
                    </div>
                    <div class="send-confirm-code" style="display: none">
                        <form id="customerProfileSendSmsCode" method="get" action="{{ route('customer::profile.change-phone.sms', ['lang'=>app()->getLocale()]) }}">
                            @csrf
                            <input type="hidden" name="phone"> <input type="hidden" name="code">

                            <div class="form-group text-center">
                                <label for="code">Код з смс:</label>
                                <div class="form-group-sms">
                                    <input type="text" class="form-control bfh-phone" placeholder="X"
                                           maxlength="1" name="c1">
                                    <input type="text" class="form-control bfh-phone" placeholder="X"
                                           maxlength="1" name="c2">
                                    <input type="text" class="form-control bfh-phone" placeholder="X"
                                           maxlength="1" name="c3">
                                    <input type="text" class="form-control bfh-phone" placeholder="X"
                                           maxlength="1" name="c4">
                                </div>
                                <div class="invalid-feedback uncorrect-sms-code mt-2" style="display: block"></div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-default">Змінити телефон</button>
                            </div>
                        </form>

                        <div class="form-group text-center mb-0">
                            <p>{{__('web.RESEND_SMS_COME_MESSAGE')}}
                                <span class="timer" data-second="{{Config::get('auth.resend_sms_code.login')}}">{{Config::get('auth.resend_sms_code.login')}}</span>
                            </p>
                            <a href="#" class="auth-link resend-change-phone-sms" style="display: none">Надіслати код ще раз</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?language=uk-UK&key={{ (env('APP_DEBUG') == true) ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION') }}&libraries=places"></script>

    <script>
        $(function() {
            google.maps.event.addDomListener(window, 'load', buildAutocomplete());
        });
    </script>

@endsection
