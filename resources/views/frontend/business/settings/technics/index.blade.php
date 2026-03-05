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

            <section class="seller_cabinet-settings-persons">
                <h2 class="title text-center">Налаштування техніки</h2>

                <div class="row d-flex">
{{--                    <div class="col-lg-3 offset-lg-3 offset-6 col-6">--}}
{{--                        <div class="form-group">--}}
{{--                            <svg class="form-icon">--}}
{{--                                <use xlink:href="#icon-loupe"></use>--}}
{{--                            </svg>--}}
{{--                            <input class="form-control basicAutoComplete" type="text" autocomplete="off" placeholder="Пошук...">--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="row">

                            <div class="col-md-6 d-flex align-items-stretch">
                                <a class="seller_cabinet-selection seller_cabinet-selection--ta" href="{{ route('business::settings.technics.create', ['lang'=>app()->getLocale()]) }}">
                                    <svg class="icon">
                                        <use xlink:href="#icon-5"></use>
                                    </svg>
                                    <span>Додати</span>
                                </a>
                            </div>



                    @foreach($technic_array as $technic)
                        <div class="col-md-6 d-flex align-items-stretch">
                            <div class="technic_item technic_item--edit">
                                <img class="technic_item-img" @if(count($technic->photo) > 0) src="{{ asset('storage/technics/'.$technic->photo[0]->photo) }}" @else @endif alt="">
                                <h3 class="title technic_item-title">{{ $technic->name }}</h3>
                                <div class="d-flex align-items-end justify-content-between mt-auto">
                                    <div class="heading technic_item-price">{{ $technic->price }} грн/год</div>

                                    <a href="{{ route('business::settings.technics.edit', ['lang'=>app()->getLocale(), 'technic_id'=>$technic->id]) }}">
                                        <svg class="icon technic_item-icon">
                                            <use xlink:href="#icon-edit"></use>
                                        </svg>
                                    </a>
                                    <a  href="#" data-href="{{ route('business::settings.technics.destroy', ['lang'=>app()->getLocale(), 'technic_id'=>$technic->id]) }}" data-toggle="modal" data-target="#confirm-delete">
                                        <svg class="icon technic_item-icon">
                                            <use xlink:href="#icon-clear"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </section>

        </div>
    </main>

@endsection
