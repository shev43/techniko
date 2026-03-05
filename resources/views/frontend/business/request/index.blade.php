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
                <li class="breadcrumb-item active" aria-current="page">Заявки</li>
            </ol>
        </nav>

        <div class="container">
            @if(Session::has( 'offer_details_status_accepted' ) || Session::has( 'offer_details_status_new' ))
                <div id="offer_details_status" class="offer_details-status">
                    <div class="offer_details-status-icon">
                        <svg class="icon">
                            <use xlink:href="#icon-clock"></use>
                        </svg>
                    </div>
                    <div class="offer_details-status-body">
                        <h3 class="heading">Покупець отримав вашу пропозицію</h3>
                        <div class="offer_details-status-text">Скоро з вами зв’яжуться для уточнення деталей замовлення, очікуйте</div>
                    </div>
                </div>
            @endif

            @if(Session::has( 'offer_details_status_canceled' ))
                <div id="offer_details_status" class="offer_details-status">
                    <div class="offer_details-status-icon">
                        <svg class="icon">
                            <use xlink:href="#icon-clear"></use>
                        </svg>
                    </div>
                    <div class="offer_details-status-body">
                        <h3 class="heading">Вашу заявку успішно скасовано</h3>
                    </div>
                </div>
            @endif

            <section class="seller_cabinet-proposals">
                <div class="row">
                    <div class="col-lg-8">
                        <h2 class="title">Останні заявки:</h2>
                    </div>
                    <div class="col-10 offset-2 col-sm-11 offset-sm-1 offset-md-7 col-md-5 offset-lg-1 col-lg-3">
                        <div class="form-group">
                            <svg class="form-icon">
                                <use xlink:href="#icon-filter"></use>
                            </svg>

                            <form class="orderType" action="{{ route('business::request.index', ['lang'=>app()->getLocale()]) }}" method="get">
                                <select class="selectpicker" name="order" data-style="form-control" onchange="this.submit()">
                                    <option value="newer" @if(request()->get('order') == 'newer') selected @endif>Спочатку новіші</option>
                                    <option value="older" @if(request()->get('order') == 'older') selected @endif>Спочатку старіші</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="blocklist">
                    <hr class="divider">

                    @forelse($requests as $request)
                        <div class="customer_cabinet-item border-bottom ">
                                <div class="row">
                                    <div class="col-12 col-md-9">
                                        <div class="application-title">{{ $request->name }}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <p>Заявка <span class="font-weight-normal">#{{ $request->order_number }}</span></p>
                                            </div>

                                            <div class="col-md-7">
                                                <p>{{ $request->type_of_delivery == 'self' ? 'Самовивіз з' : 'Адреса доставки' }} <span class="font-weight-normal">{{ $request->address }}</span></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <p>Ціна: <span class="font-weight-normal">{{ $request->min_price }} грн/год</span></p>
                                                <p>Кількість годин: <span class="font-weight-normal">{{ $request->count }} год</span></p>

                                                @if(count($request->offers) > 0)
                                                    @if($request->status == 'canceled')
                                                        <div class="customer_cabinet-item-status mt-3">
                                                            <svg class="icon icon-clear">
                                                                <use xlink:href="#icon-clear"></use>
                                                            </svg>
                                                            <b>Покупець скасував пропозицію</b>
                                                        </div>
                                                    @elseif($request->offers[0]->status == 'canceled')
                                                        <div class="customer_cabinet-item-status mt-3">
                                                            <svg class="icon icon-clear">
                                                                <use xlink:href="#icon-clear"></use>
                                                            </svg>
                                                            <b>Покупець скасував пропозицію</b>
                                                        </div>
                                                    @else
                                                        <div class="customer_cabinet-item-status mt-3">
                                                            <svg class="icon">
                                                                <use xlink:href="#icon-clock"></use>
                                                            </svg>
                                                            <b>Ви підтвердили заявку</b>
                                                        </div>
                                                    @endif

                                                @else
                                                    <div class="customer_cabinet-item-status mt-3">
                                                        <svg class="icon">
                                                            <use xlink:href="#icon-clock"></use>
                                                        </svg>
                                                        <b>Очікує підтвердження</b>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-md-7">
                                                @if(!empty($request->technic) && $request->type_of_delivery == 'business')<p>Водій <span class="font-weight-normal">{{ $request->technic->is_driver ? 'є' : 'немає' }}</span></p>@endif
                                                <p>Дата доставки <span class="font-weight-normal">@if($request->start_date_of_delivery !== $request->end_date_of_delivery) {{ $request->start_date_of_delivery }} - {{ $request->end_date_of_delivery }} @else {{ $request->date_of_delivery }} @endif</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <a href="{{ route('business::request.view', ['lang'=>app()->getLocale(), 'order_id'=>$request->id]) }}" class="btn btn-default w-100">Переглянути</a>
{{--                                                <div class="mt-3">--}}
{{--                                                    <a href="{{ route('business::request.cancel', ['lang'=>app()->getLocale(), 'order_id'=>$request->id]) }}" class="btn btn-border_dark">Скасувати</a>--}}
{{--                                                </div>--}}
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
                {{ $requests->withQueryString()->links('frontend._modules.pagination/default') }}

            </section>
        </div>
    </main>
@endsection
