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
                <li class="breadcrumb-item active" aria-current="page">Тендери</li>
            </ol>
        </nav>

        <div class="container">
            <h2 class="title">Створити тендер:</h2>

            <form class="form-prevent order-form"
                  action="{{ route('customer::tender.store', ['lang'=>app()->getLocale()] ) }}" method="post">
                @csrf
                <input name="is_tender" type="hidden" value="1">

                <div class="block">
                    <div class="row align-items-start">
                        <div class="col-md-4">
                            <div class="block-item">
                                <div class="heading">Вид техніки:</div>
                                <p>Яка техніка Вам потрібна?</p>
                                <div class="block-item--tender">
                                    <select class="selectpicker @error('is_driver') is-invalid @enderror" name="machine_id" data-style="form-control" data-title="Вид техніки">
                                        @foreach($machines as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="block-item">
                                <div class="heading">Ціна за м3:</div>
                            </div>
                            <div class="range">
                                <div class="range-slider" data-min="1" data-max="9999" data-start="1" data-end="6000" data-step="1"></div>
                                <div class="order-price-range">
                                    <input id="start" class="form-control start" name="min_price" type="text">
                                    <span>—</span>
                                    <input id="end" class="form-control end" name="max_price" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="order-price">
                                <div class="order-price-count">
                                    <div class="heading">Час роботи:</div>
                                    <input class="form-control" name="count" type="number" step="1" min="1" max="999" maxlength="3" value="1">
                                    <div class="heading">год</div>
                                </div>
                            </div>
                            <div class="heading">Орієнтовна вартість:</div>
                            <div id="estimated-product-price" class="title"><b id="price-min"></b> - <b id="price-max"></b> грн</div>
                        </div>
                    </div>
                </div>
                <h2 class="title">Контактні дані:</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="first_name">Ім’я</label>
                            <input name="first_name" type="text" class="form-control js-name" id="first_name" placeholder="Вкажіть ім'я" value="{{ old('first_name', (request()->user()->first_name) ?? '' ) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="last_name">Прізвище</label>
                            <input name="last_name" type="text" class="form-control js-name" id="last_name" placeholder="Вкажіть прізвище" value="{{ old('last_name', (request()->user()->last_name) ?? '' ) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block">
                            <div class="form-group">
                                <label for="phone">Номер телефону:</label>
                                <input name="phone" type="text" class="form-control" id="phone" placeholder="+38 (xxx) xxx-xx-xx" value="{{ old('phone', (request()->user()->phone) ?? '' ) }}">
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="title">Час та місце робіт:</h2>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="block">
                            @include('frontend._modules.map-form', ['objects'=> Auth::guest() ? [] : request()->user(), 'target'=>'form input[name=address]'])
                        </div>
                    </div>
                    <div class="col-lg-5 offset-lg-1 col-md-6">
                        <div class="block">



                            <div class="form-group">
                                <label for="address">Наявність водія</label>
                                <select class="selectpicker @error('is_driver') is-invalid @enderror" name="is_driver"
                                        data-style="form-control" data-title="Наявність водія">
                                    <option value="1" >Так</option>
                                    <option value="0">Ні</option>
                                </select>

                            </div>

                            <div class="form-group">
                                <label for="address">Адреса доставки</label>
                                <input id="address" class="form-control autocomplete" name="address" type="text" placeholder="Вкажіть адресу доставки" @if(Auth::guard('customer')->check() ) value="{{ old('address', request()->user()->address) }}" @else value="{{ old('address') }}" @endif >

                            </div>

                            <div class="form-group">
                                <label for="date_of_delivery">Дата доставки</label>
                                <div class="form-date" data-toggle="modal" data-target="#dataModal">
                                    <input type="text" class="form-control" id="date_of_delivery" name="date_of_delivery"
                                           value="{{old('date_of_delivery', \Carbon\Carbon::now()->addDays(7)->format('d.m.Y'))}}" readonly required>
                                    <svg class="icon">
                                        <use xlink:href="#icon-23"></use>
                                    </svg>
                                </div>
                                @foreach($errors->get('date_of_delivery') as $error)
                                    <small class="invalid-feedback d-block">{!! $error !!}</small>
                                @endforeach
                                @foreach($errors->get('start_date_of_delivery') as $error)
                                    <small class="invalid-feedback d-block">{!! $error !!}</small>
                                @endforeach
                                @foreach($errors->get('end_date_of_delivery') as $error)
                                    <small class="invalid-feedback d-block">{!! $error !!}</small>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="form-group">
                        <label>Коментар до замовлення:</label>
                        <input name="comment" type="text" class="form-control" placeholder="Додайте коментар до замовлення">
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-default">Замовити</button>
                </div>
            </form>

        </div>
    </main>

    <div class="modal auth fade" tabindex="-1" id="dataModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg>
                        <use xlink:href="#icon-5"></use>
                    </svg>
                </button>
                <h3 class="heading">Дата доставки</h3>
                <div class="datepickerStatic">
                    <div class="datepickerStaticBody"></div>
                    <input type="hidden" class="datepickerStaticValue" value="{{ \Carbon\Carbon::now()->addDays(7)->format('d.m.Y') }}">
                </div>
                <div class="modal-inner auth-inner">
                    <div class="form-group">
                        <a href="#" class="btn btn-default select-date" data-dismiss="modal"
                           aria-label="Close">Вибрати</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?language=uk-UK&key={{ (env('APP_DEBUG') == true) ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION') }}&libraries=places"></script>

    <script>
        jQuery(function($) {
            google.maps.event.addDomListener(window, 'load', buildAutocomplete());

        });

    </script>


@endsection
