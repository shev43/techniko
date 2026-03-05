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
                <li class="breadcrumb-item active" aria-current="page">Техніка</li>
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

            <section class="seller_cabinet-settings-technics-create">
                <h2 class="title text-center">Додати техніку</h2>

                <form id="businessProductForm" class="form-prevent"
                      action="{{ route('business::settings.technics.store', ['lang'=>app()->getLocale()]) }}"
                      method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="ex1">Назва техніки:</label>
                                <input class="form-control basicAutoComplete @error('name') is-invalid @enderror"
                                       name="name" type="text" autocomplete="off" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="ex1">Вид техніки:</label>
                                <select class="selectpicker @error('machine') is-invalid @enderror" name="machine"
                                        data-style="form-control" data-title="Виберіть вид техніки">
                                    @foreach($machineCategories as $category)
                                        <option
                                            value="{{ $category->id }}" {{ old('machine') === $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="ex1">Тип доставки:</label>
                                <select class="selectpicker @error('type_of_delivery') is-invalid @enderror" name="type_of_delivery"
                                        data-style="form-control" data-title="Виберіть тип доставки">
                                    <option value="self">Самовивіз</option>
                                    <option value="business">Доставка за адресою</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Супутні види техніки:</label>
                                <select class="selectpicker @error('related_categories') is-invalid @enderror" name="related_categories[]"
                                        data-style="form-control" data-title="Оберіть супутні види техніки" multiple>
                                    @foreach($machines as $machine)
                                        <option value="{{ $machine->id }}" >{{ $machine->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ex1">Вартість:</label>
                                <div class="d-flex align-items-center">
                                    <input class="form-control text-center @error('price') is-invalid @enderror"
                                           name="price" type="number" placeholder="Вкажіть вартість за годину"
                                           min="1" max="9999"
                                           minlength="1" maxlength="4"
                                           step="1"
                                           style="width: calc(100% - 100px);margin-right: 20px;" value="{{ old('price') }}">
                                    <span class="form-info">грн/год</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ex1">Мін годин:</label>
                                <div class="d-flex align-items-center">
                                    <input class="form-control text-center  @error('hours') is-invalid @enderror"
                                           name="hours" type="number" placeholder="Вкажіть мінімальний час оренди"
                                           min="1" max="999"
                                           minlength="1" maxlength="3"
                                           step="1"
                                           value="{{ old('hours') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Наявність водія:</label>
                                <select class="selectpicker @error('is_driver') is-invalid @enderror" name="is_driver"
                                        data-style="form-control" data-title="Наявність водія">
                                    <option value="1" >Так</option>
                                    <option value="0" >Ні</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="ex4">Опис <span>(не обов’язково):</span></label>
                                <div @error('description') style="border: 1px solid #FC610A;" @enderror>
                                    <textarea class="form-control editor" id="business-description"
                                              name="description">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="business-address">Вкажіть адресу</label>
                                <input type="text"
                                       class="form-control autocomplete @error('address') is-invalid @enderror"
                                       id="address" name="address"
                                       placeholder="Вкажіть повну адресу підприємства" value="{{ old('address') }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            @include('frontend._modules.map-form', ['objects'=>[], 'target'=>'form#businessProductForm input[name=address]'])
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Фото:</label>
                    </div>
                    <div class="row js-product-images-block">
                        <div class="col-md-4 d-flex align-items-stretch image-uploader-form"
                             @error('photo') style="background: #f8d9d9; margin-bottom: 30px;" @enderror>
                            <input id="products_uploaded" type="file" class="d-none js-product-image-input "
                                   data-upload="{{ route('business.settings.technics.upload-files', ['lang'=>app()->getLocale()]) }}">
                            <label class="seller_cabinet-selection seller_cabinet-selection--ta"
                                   for="products_uploaded">
                                <svg class="icon">
                                    <use xlink:href="#icon-5"></use>
                                </svg>
                                <span>Додати</span>
                            </label>
                        </div>


                        {{--                            <div class="col-md-4">--}}
                        {{--                                <div class="technic-image">--}}

                        {{--                                </div>--}}
                        {{--                            </div>--}}
                    </div>

                    <div class="text-center">
                        <button class="btn btn-default" type="submit">Додати</button>
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

    <script
        src="https://maps.googleapis.com/maps/api/js?language=uk-UK&key={{ (env('APP_DEBUG') == true) ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION') }}&libraries=places"></script>

    <script>
        jQuery(function ($) {
            google.maps.event.addDomListener(window, 'load', buildAutocomplete());
        });
    </script>

@endsection
