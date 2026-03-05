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
                <li class="breadcrumb-item"><a href="{{ route('customer::tender.index', ['lang'=>app()->getLocale()]) }}">Тендери</a></li>
                <li class="breadcrumb-item active" aria-current="page">Пропозиції</li>
            </ol>
        </nav>

        <div class="container">


            <section>

                <div class="customer_cabinet-list">
                    <div class="blocklist">


                        @forelse($request->offers as $order_key =>$offer)

                            <div class="customer_cabinet-item  @if($offer->status == 'canceled') disabled @endif">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="application-title">{{ $offer->name }}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img class="" @if($offer->photo) src="{{ asset('storage/technics/' . $offer->photo) }}" @else src="{{ asset('img/company-logo.svg') }}" @endif alt="">                                            </div>
                                            <div class="col-md-9">
                                                <p>Власник: <span class="font-weight-normal">{{ $offer->seller->business->name }}</span></p>
                                                <p class="mb-4">Телефон: <span class="font-weight-normal">{{ $offer->seller->business->phoneFormatted }}</span></p>

                                                <p>Ціна: <span class="font-weight-normal">{{ $offer->price }} грн/год</span></p>
                                                <p>Кількість годин: <span class="font-weight-normal">{{ $offer->count }} год</span></p>



                                            </div>
                                        </div>
                                        @if($offer->status == 'canceled')
                                        <div class="customer_cabinet-item-status mt-3">
                                            <svg class="icon icon-clear">
                                                <use xlink:href="#icon-clear"></use>
                                            </svg>
                                            @if($offer->canceled_by == 'client')
                                                <b>Ви скасували пропозицію</b>
                                            @elseif($offer->canceled_by == 'seller')
                                                <b>Скасовано продавцем</b>
                                            @else
                                                <b>Вийшов час</b>
                                            @endif
                                        </div>
                                        @endif

                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-12">
                                                    <a href="{{ route('customer::tender.view', ['lang'=>app()->getLocale(), 'order_id'=>$offer->order_id, 'offer_id'=>$offer->id]) }}" class="btn btn-default w-100">Переглянути</a>
                                                    <div class="mt-3">
                                                        <a data-href="{{ route('customer::tender.cancel-offer', ['lang'=>app()->getlocale(), 'order_id'=>$offer->order_id, 'offer_id'=>$offer->id]) }}" class="btn btn-border_dark w-100" data-toggle="modal" data-target="#confirm-canceled">Скасувати</a>
                                                    </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>





                            </div>










                        @empty
                            <div class="row justify-content-center" style="margin-top: 60px;">
                                <div class="col-md-8">
                                    <div class="offer-empty">
                                        <svg class="offer-empty-icon">
                                            <use xlink:href="#icon-noresult"></use>
                                        </svg>
                                        <div>
                                            <p>Заявок які би задовільняли критерії Вашої продукції не знайдено</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>

            </section>
        </div>
    </main>
@endsection
