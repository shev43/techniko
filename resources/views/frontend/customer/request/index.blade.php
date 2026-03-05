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
                        <h3 class="heading">Продавець отримав ваше замовлення</h3>
                        <div class="offer_details-status-text">Скоро з вами зв’яжуться для уточнення деталей замовлення та доставки, очікуйте</div>
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

            <section>
                <div class="row align-items-center mb-3">
                    <div class="col-lg-8">
                        <h2 class="title">Створені заявки:</h2>
                    </div>
                    <div class="col-10 offset-2 col-sm-11 offset-sm-1 offset-md-7 col-md-5 offset-lg-1 col-lg-3">
                        <div class="form-group">
                            <svg class="form-icon">
                                <use xlink:href="#icon-filter"></use>
                            </svg>

                            <form class="orderType" action="{{ route('customer::request.index', ['lang'=>app()->getLocale()]) }}" method="get">
                                @if(request()->get('status'))
                                    <input type="hidden" name="status" value="{{ request()->get('status') }}">
                                @endif
                                <select class="selectpicker" name="order" data-style="form-control" onchange="this.submit()">
                                    <option value="newer" @if(request()->get('order') == 'newer') selected @endif>Спочатку новіші</option>
                                    <option value="older" @if(request()->get('order') == 'older') selected @endif>Спочатку старіші</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs customer_cabinet-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link {{ empty(request()->get('status')) || request()->get('status') == 'all' ? 'active' : '' }}" href="{{ route('customer::request.index', ['lang'=>app()->getLocale(), 'order'=>request()->get('order')]) }}">Всі</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->get('status') == 'new' ? 'active' : '' }}" href="{{ route('customer::request.index', ['lang'=>app()->getLocale(), 'status'=>'new', 'order'=>request()->get('order')]) }}">Пропозиції</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->get('status') == 'accepted' ? 'active' : '' }}" href="{{ route('customer::request.index', ['lang'=>app()->getLocale(), 'status'=>'accepted', 'order'=>request()->get('order')]) }}">Підтверджені</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->get('status') == 'executed' ? 'active' : '' }}" href="{{ route('customer::request.index', ['lang'=>app()->getLocale(), 'status'=>'executed', 'order'=>request()->get('order')]) }}">Виконується</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->get('status') == 'done' ? 'active' : '' }}" href="{{ route('customer::request.index', ['lang'=>app()->getLocale(), 'status'=>'done', 'order'=>request()->get('order')]) }}">Виконано</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->get('status') == 'canceled' ? 'active' : '' }}" href="{{ route('customer::request.index', ['lang'=>app()->getLocale(), 'status'=>'canceled', 'order'=>request()->get('order')]) }}">Скасовано</a>
                    </li>
                </ul>

                <div class="customer_cabinet-list">
                    <hr class="divider">
                    <div class="blocklist">

                    @forelse($orders as $order_key =>$order)
                        <div class="customer_cabinet-item @if($order->status == 'canceled' || (count($order->offers) > 0) && $order->offers[0]->status == 'canceled') disabled @endif">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="application-title">{{ $order->name }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p>Заявка <span class="font-weight-normal">#{{ $order->order_number }}</span></p>
                                        </div>

                                        <div class="col-md-7">
                                            <p>{{ $order->type_of_delivery == 'self' ? 'Самовивіз з' : 'Адреса доставки' }} <span class="font-weight-normal">{{ $order->address }}</span></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p>Ціна: <span class="font-weight-normal">{{ $order->min_price }} грн/год</span></p>
                                            <p>Кількість годин: <span class="font-weight-normal">{{ $order->count }} год</span></p>


                                            @if(count($order->offers) > 0)
                                                @if($order->offers[0]->status == 'new')
                                                    @if($order->status == 'accepted')
                                                        <div class="customer_cabinet-item-status mt-3">
                                                            <svg class="icon">
                                                                <use xlink:href="#icon-clock"></use>
                                                            </svg>
                                                            <b>Ви підтвердили заявку</b>
                                                        </div>
                                                    @elseif($order->status == 'executed')
                                                        <div class="customer_cabinet-item-status mt-3">
                                                            <svg class="icon">
                                                                <use xlink:href="#icon-clock"></use>
                                                            </svg>
                                                            <b>Заявка виконується</b>
                                                        </div>
                                                    @elseif($order->status == 'done')
                                                        <div class="customer_cabinet-item-status mt-3">
                                                            <svg class="icon">
                                                                <use xlink:href="#icon-check"></use>
                                                            </svg>
                                                            <b>Заявка виконана</b>
                                                        </div>
                                                    @elseif($order->status == 'canceled')
                                                        <div class="customer_cabinet-item-status mt-3">
                                                            <svg class="icon icon-clear">
                                                                <use xlink:href="#icon-clear"></use>
                                                            </svg>
                                                            <b>Ви скасували заявку</b>
                                                        </div>
                                                    @else
                                                        <div class="customer_cabinet-item-status mt-3">
                                                            <svg class="icon">
                                                                <use xlink:href="#icon-clock"></use>
                                                            </svg>
                                                            <b>Заявка підтверджена</b>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="customer_cabinet-item-status mt-3">
                                                        <svg class="icon icon-clear">
                                                            <use xlink:href="#icon-clear"></use>
                                                        </svg>
                                                        @if($order->offers[0]->canceled_by == 'client')
                                                            <b>Ви скасували пропозицію</b>
                                                        @elseif($order->offers[0]->canceled_by == 'seller')
                                                            <b>Скасовано продавцем</b>
                                                        @else
                                                            <b>Вийшов час</b>
                                                        @endif
                                                    </div>
                                                @endif
                                            @else
                                                @if($order->status == 'canceled')
                                                    <div class="customer_cabinet-item-status mt-3">
                                                        <svg class="icon icon-clear">
                                                            <use xlink:href="#icon-clear"></use>
                                                        </svg>
                                                        <b>Ви скасували заявку</b>
                                                    </div>
                                                @else
                                                    <div class="customer_cabinet-item-status mt-3">
                                                        <svg class="icon">
                                                            <use xlink:href="#icon-clock"></use>
                                                        </svg>
                                                        <b>Очікує підтвердження</b>
                                                    </div>
                                                @endif

                                            @endif
                                        </div>

                                        <div class="col-md-7">
                                            @if(!empty($order->technic) && $order->type_of_delivery == 'business')<p>Водій <span class="font-weight-normal">{{ $order->technic->is_driver ? 'є' : 'немає' }}</span></p>@endif
                                            <p>Дата доставки <span class="font-weight-normal">@if($order->start_date_of_delivery !== $order->end_date_of_delivery) {{ $order->start_date_of_delivery }} - {{ $order->end_date_of_delivery }} @else {{ $order->date_of_delivery }} @endif</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-12">
                                            @if(count($order->offers) > 0)
                                                    <a href="{{ route('customer::request.view', ['lang'=>app()->getLocale(), 'order_id'=>$order->id]) }}" class="btn btn-default w-100">Переглянути</a>
                                                @if($order->offers[0]->status == 'new' && ($order->status == 'new' || $order->status == 'accepted'))
                                                    <div class="mt-3">
                                                        <a data-href="{{ route('customer::request.cancel', ['lang'=>app()->getLocale(), 'order_id'=>$order->id]) }}" class="btn btn-border_dark w-100" data-toggle="modal" data-target="#confirm-canceled">Скасувати</a>
                                                    </div>
                                                @endif
                                            @else
                                                    <div>
                                                        <a data-href="{{ route('customer::request.cancel', ['lang'=>app()->getLocale(), 'order_id'=>$order->id]) }}" class="btn btn-border_dark w-100" data-toggle="modal" data-target="#confirm-canceled">Скасувати</a>
                                                    </div>
                                            @endif


{{--                                            <a href="{{ route('customer::request.view', ['lang'=>app()->getLocale(), 'order_id'=>$order->id]) }}" class="btn btn-default">Переглянути</a>--}}
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
                                        <p>У вас наразі немає жодних створених заявок</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse

                    </div>

                </div>

                {{ $orders->withQueryString()->links('frontend._modules.pagination/default') }}

            </section>
        </div>
    </main>

@endsection
