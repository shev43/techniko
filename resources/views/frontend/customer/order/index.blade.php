@extends('layouts.app')

@section('content')
    <main class="main page">
        <nav class="container mb-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend::catalog.index', ['lang'=>app()->getLocale()]) }}">Каталог</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $technic->name }}</li>
            </ol>
        </nav>

        <div class="container">
            <h1 class="title mb-4">Деталі заявки:</h1>

            <div class="row">
                <div class="col-md-6">
                    <div class="block">
                        <div class="gallery" @if(count($technic->photo) == 1) style="display: block" @endif>
                            @forelse($technic->photo as $photo_key=>$photo)
                                <div @if($photo_key > 1) style="display: none" @endif>
                                    <a href="{{ asset('/storage/technics/' . $photo->photo) }}"
                                       class="gallery-item fresco"
                                       data-fresco-group="gallery">
                                        <img class="gallery-item-img" src="{{ asset('/storage/technics/' . $photo->photo) }}" alt="">
                                        @if(count($technic->photo) > 2)
                                            @if($photo_key == 1)
                                                <div class="gallery-item-more">
                                                    + {{ count($technic->photo) - 2 }}
                                                </div>
                                            @endif
                                        @endif

                                    </a>
                                </div>
                            @empty
                                <div>
                                    <img class="gallery-item-img" src="{{ asset('img/profile-logo.svg') }}" alt="">
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div id="order-form" class="col-lg-5 offset-lg-1 col-md-6">
                    <div class="block">
                        <h2 class="title">{{ $technic->name }}</h2>
                        <div id="price" class="heading mb-3"><b>{{ $technic->price }}</b> грн/год</div>
                        <div class="order-price">
                            <div class="order-price-count">
                                <div class="heading">Час роботи:</div>
                                <input name="count" type="number" class="form-control" value="{{ $technic->hours }}" min="{{ $technic->hours }}" step="1" max="999" maxlength="3" onchange="imposeMinMax(this)">
                                <div class="heading">год</div>
                            </div>
                            <div class="mb-3" style="color: #0D314F;font-size: 18px;">мінімальний час роботи: {{ $technic->hours }} год</div>
                        </div>
                        <div id="estimated-product-price" class="title"><span class="font-weight-normal">Вартість:</span> <b>{{ $technic->price * $technic->hours }}</b> грн</div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 col-md-6">
                    <div class="block">
                        <h2 class="title">Опис:</h2>
                        <p>{!! $technic->description ?? 'Цей вид транспорту не має опису' !!} </p>
                    </div>
                </div>
                <div class="col-12 col-lg-5 offset-lg-1 col-md-6">
                    <div class="block">
                        <h2 class="title">Власник:</h2>
                        <div class="person">
                            <div class="person-img">
                                <img @if(!empty($technic->business->photo)) src="{{ asset('/storage/business/' . $technic->business->photo) }}" @else src="{{ asset('img/company-logo.svg') }}" @endif alt="{{ $technic->business->name }}">
                            </div>
                            <div>
                                <div class="person-name">
                                    @if(!empty($technic->business->slug))
                                        <a href="{{ route('frontend::catalog.business', ['lang'=>app()->getLocale(), 'technic_slug'=>$technic->slug, 'slug'=>$technic->business->slug]) }}">{{ $technic->business->name }}</a>
                                    @else
                                        {{ $technic->business->name }}
                                    @endif
                                </div>
                                <div class="person-phone">{{ $technic->business->phoneSmall }}
                                    <a class="btn-action-phone show-phone-number" href="#" data-phone="{{ $technic->business->phoneFormatted }}">показати</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(Auth::guard('customer')->check())
                <hr class="my-4">
                <h2 class="title mb-3">Контактні дані:</h2>
                <form id="order-create-form" action="{{ route('customer::order.create', ['lang'=>app()->getLocale()]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="seller_id" value="{{ $technic->business_id }}">
                    <input type="hidden" name="technic_id" value="{{ $technic->id }}">
                    <input type="hidden" name="machine_id" value="{{ $technic->machine_id }}">
                    <input type="hidden" name="name" value="{{ $technic->name }}">
                    <input type="hidden" name="photo" value="{{ $technic->photo->first()->photo ?? '' }}">
                    <input type="hidden" name="hours" value="{{ $technic->hours }}">
                    <input type="hidden" name="count" value="{{ $technic->hours }}">
                    <input type="hidden" name="min_price" value="{{ $technic->price }}">
                    <input type="hidden" name="max_price" value="{{ $technic->price }}">
                    <input type="hidden" name="type_of_delivery" value="delivery">
                    <input type="hidden" name="address" value="{{ $technic->address }}">
                    <input type="hidden" name="map_latitude" value="{{ $technic->map_latitude }}">
                    <input type="hidden" name="map_longitude" value="{{ $technic->map_longitude }}">
                    <input type="hidden" name="map_zoom" value="{{ $technic->map_zoom }}">
                    <input type="hidden" name="map_rotate" value="{{ $technic->map_rotate }}">
                    <input type="hidden" name="marker_latitude" value="{{ $technic->marker_latitude }}">
                    <input type="hidden" name="marker_longitude" value="{{ $technic->marker_longitude }}">

                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="first_name">Ім'я</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Ваше ім'я" value="{{ Auth::guard('customer')->user()->name ?? '' }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="last_name">Прізвище</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Ваше прізвище" value="">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="phone">Номер телефону:</label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="+380 XXX XXXX" value="{{ Auth::guard('customer')->user()->phone ?? '' }}" required>
                            </div>
                        </div>
                    </div>
            @endif
        </div>

        <div class="container-fluid address-container">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-6">
                        @include('frontend._modules.map-view', ['objects'=>$technic])
                    </div>

                    <div class="col-lg-5 offset-lg-1 col-md-6 mt-5 mt-md-0" style="margin-bottom: 60px;">
                        <h2 class="title">Місце проведення робіт:</h2>
                        <div class="mb-3">
                            <strong>Адреса</strong>
                            <div>{{ $technic->address }}</div>
                        </div>
                        <div>
                            <strong>Дата доставки</strong>
                            <div class="d-flex align-items-center">
                                @if(Auth::guard('customer')->check())
                                    <input type="text" class="form-control flatpickr-range" name="date_of_delivery" placeholder="Оберіть дату" value="@if($technic->start_date_of_delivery !== $technic->end_date_of_delivery){{ $technic->start_date_of_delivery }} — {{ $technic->end_date_of_delivery }}@else{{ $technic->date_of_delivery }}@endif" style="max-width: 300px;">
                                @else
                                    <span>@if($technic->start_date_of_delivery !== $technic->end_date_of_delivery) {{ $technic->start_date_of_delivery }} - {{ $technic->end_date_of_delivery }} @else {{ $technic->date_of_delivery }} @endif</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(Auth::guard('customer')->check())
            <div class="container mt-4 mb-5">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="comment"><strong>Коментар до замовлення:</strong></label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Ваш коментар"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <button type="submit" form="order-create-form" class="btn btn-default btn-lg px-5">Замовити</button>
                    </div>
                </div>
                </form>
            </div>
        @endif
    </main>

@endsection

@section('scripts')
    <script>

        function imposeMinMax(el){
            if(el.value != ""){
                if(parseInt(el.value) < parseInt(el.min)){
                    el.value = el.min;
                }
                if(parseInt(el.value) > parseInt(el.max)){
                    el.value = el.max;
                }
            }
        }

        // Sync hours count input to hidden form field
        $('input[name="count"]').on('change input', function() {
            $('#order-create-form input[name="count"]').val($(this).val());
        });

        // Init flatpickr for date range if available
        if ($('.flatpickr-range').length && typeof flatpickr !== 'undefined') {
            flatpickr('.flatpickr-range', {
                mode: 'range',
                dateFormat: 'd.m.Y',
                locale: 'uk',
                allowInput: true
            });
        }

        $('.person .btn-action-phone').click(function() {
            $.get('/{{ app()->getLocale() }}/report/phone_views/{{ $technic->business_id }}/{{ $technic->id }}')
        })

    </script>
@endsection

