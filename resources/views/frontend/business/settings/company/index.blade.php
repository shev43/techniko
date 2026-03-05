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
                <li class="breadcrumb-item active" aria-current="page">Представник</li>
            </ol>
        </nav>

        <div class="container">
            <section id="navbar-submenu">
                <div class="row">
                    <div class="col-12 col-sm-12 col-lg-12">
                        @include('frontend.business.settings._partials.navbar')
                    </div>
                </div>
            </section>

            <section id="businessSettingsCompanyPhoto" class="seller_cabinet-settings-profile">
                <h2 class="title text-center">Налаштування підприємства</h2>

                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-4">
                        <div class="form-group text-center">
                            <img class="seller_cabinet-settings-logo" src="@if(!empty($company->photo)){{ asset('storage/business/' . $company->photo) }}@else{{ asset('img/profile-logo.svg') }}@endif" data-empty="{{ asset('img/profile-logo.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-8 d-flex align-items-center justify-content-center">
                        <div class="seller_cabinet-settings-logo_btns">
                            <div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="business-image-loader" class="btn btn-default">Завантажити лого</label>
                                    <input type="file" class="form-control-file" id="business-image-loader" data-upload="{{ route('setting.company.upload-logo') }}" style="display: none;">
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

                <form id="businessSetting" class="form-prevent" action="{{ route('business::settings.company.update', ['lang'=>app()->getLocale()]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="photo" value="{{$company->photo ?? ''}}">

                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="business-name">Назва підприємства</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="business-name" name="name" placeholder="Вкажіть повну назву підприємства" value="{{ old('name', $company->name) }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="business-www">Веб сайт підприємства</label>
                                <input type="text" class="form-control @error('www') is-invalid @enderror" id="business-www" name="www" placeholder="Вкажіть Веб сайт підприємства" value="{{ old('www', $company->www) }}">
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="business-email">Електронна пошта</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="business-email" name="email" placeholder="Введіть email підприємства" value="{{ old('email', $company->email) }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="business-phone">Номер телефону</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="business-phone" name="phone" placeholder="Введіть телефон підприємства" value="{{ old('phone', $company->phone) }}">
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="business-description">Опис</label>

                                <div @error('description') style="border: 1px solid #FC610A;" @enderror>
                                    <textarea class="form-control editor" id="business-description" name="description">{{ old('description', $company->description) }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="business-address">Розташування</label>
                                <input type="text" class="form-control autocomplete @error('address') is-invalid @enderror" id="business-address" name="address" placeholder="Вкажіть повну адресу підприємства" value="{{ old('address', $company->address) }}">
                                <div class="invalid-feedback"></div>
                            </div>

                            @include('frontend._modules.map-form', ['objects'=>$company, 'target'=>'form#businessSetting input[name=address]'])

                        </div>

                        <div class="col-lg-8 text-center text-lg-right">
                            <button class="btn btn-default" type="submit">Зберегти</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>

    <script>
        $(function () {
            $('textarea.editor').each(function (e) {
                CKEDITOR.replace(this.id, {'allowedContent': true});
            });
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?language=uk-UK&key={{ (env('APP_DEBUG') == true) ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION') }}&libraries=places"></script>

    <script>
        jQuery(function($) {
            google.maps.event.addDomListener(window, 'load', buildAutocomplete());
        });
    </script>

@endsection
