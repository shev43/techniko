@extends('layouts.app')

@section('content')
    <main class="main page">
        <nav class="container mb-5" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend::catalog.index', ['lang'=>app()->getLocale()]) }}">Каталог</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend::order.index', ['lang'=>app()->getLocale(), 'slug'=>$technic->slug]) }}">{{ $technic->name }}</a></li>

                <li class="breadcrumb-item active" aria-current="page">{{ $business->name }}</li>
            </ol>
        </nav>

        <div class="container">
            <section class="seller_profile-info">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-lg-8">
                        <div class="d-flex align-items-center seller_profile-info-top">
                            <div class="seller_profile-logo mr-4">
                                <img src="@if(!empty($business->photo)){{ asset('storage/business/'.$business->photo) }}@else{{ asset('img/company-logo.svg') }}@endif" alt="">
                            </div>
                            <div>
                                <h2 class="title mb-1">{{ $business->name }}</h2>
                                <div class="seller_profile-contact">{{ $business->address }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 contact-info mb-4 mb-md-0">
                        @if(!empty($business->email))
                        <div><a class="btn-action-email" href="mailto:{{$business->email}}">
                                <svg class="icon icon-email technic_item-icon email">
                                    <use xlink:href="#icon-email"></use>
                                </svg>
                        </a></div>
                        @endif

                        @if(!empty($business->phone))
                        <div><a class="btn-action-phone" href="tel:{{ $business->phone }}">
                                <svg class="icon technic_item-icon">
                                    <use xlink:href="#icon-phone"></use>
                                </svg>
                        </a></div>
                        @endif

                        @if(!empty($business->www))
                        <div><a class="btn-action-www" href="{{ $business->www }}" target="_blank">
                                <svg class="icon technic_item-icon">
                                    <use xlink:href="#icon-language-box"></use>
                                </svg>
                        </a></div>
                        @endif

                    </div>
                </div>
                @if(!empty($business->description))
                    <div class="row mt-3">
                        <div class="col-12">
                            {!! $business->description !!}
                        </div>
                    </div>
                @endif
            </section>

            @if(!empty($business->contacts))
                <section class="seller_profile-persons">
                    <h2 class="title">Контактні особи:</h2>
                    <div class="row">

                        @forelse($business->contacts as $contact)
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                @include('frontend.guest.catalog._partials.contacts', ['contact1'=>$contact])
                            </div>
                        @empty
                            <p>Не вказано</p>
                        @endforelse
                    </div>
                </section>
            @endif

            @if(!empty($business->technics))
                <section class="seller_profile-products">
                    <h2 class="title">Доступна техніка:</h2>
                    <div class="row">
                        @forelse($business->technics as $technics)
                            @include('frontend.guest.catalog._partials.product', ['technic'=>$technics])
                        @empty
                            <p>Не вказано</p>
                        @endforelse
                    </div>
                </section>
            @endif


        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $('.contact-info .btn-action-email').click(function() {
            $.get('/{{ app()->getLocale() }}/report/email_views/{{ $business->id }}/{{ $technic->id }}')
        })

        $('.contact-info .btn-action-phone').click(function() {
            $.get('/{{ app()->getLocale() }}/report/phone_views/{{ $business->id }}/{{ $technic->id }}')
        })

        $('.contact-info .btn-action-www').click(function() {
            $.get('/{{ app()->getLocale() }}/report/www_views/{{ $business->id }}/{{ $technic->id }}')
        })

        $('.seller_profile-persons-item .btn-action-contact-person-phone').click(function() {
            $.get('/{{ app()->getLocale() }}/report/contact_person_phone_views/{{ $business->id }}/{{ $technic->id }}')
        })


    </script>
@endsection

