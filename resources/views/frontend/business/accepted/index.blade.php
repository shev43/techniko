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
                <li class="breadcrumb-item active" aria-current="page">Замовлення</li>
            </ol>
        </nav>
        <div class="container">
            <section>
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <h2 class="title">Підтверджені замовлення:</h2>
                    </div>
                    <div class="col-12 col-sm-11 offset-sm-1 offset-md-7 col-md-5 offset-lg-1 col-lg-3">
                        <div class="form-group">
                            <svg class="form-icon">
                                <use xlink:href="#icon-filter"></use>
                            </svg>
                            <form class="orderType" action="{{ route('business::accepted.index', ['lang'=>app()->getLocale()]) }}" method="get">
                                <select class="selectpicker" name="order" data-style="form-control" onchange="this.submit()">
                                    <option value="newer" @if(request()->get('order') == 'newer') selected @endif>Спочатку новіші</option>
                                    <option value="older" @if(request()->get('order') == 'older') selected @endif>Спочатку старіші</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="seller_cabinet-table">
                        @forelse($offers as $offer)
                            <div class="application-item border-bottom">
                                        <div class="row">
                                            <div class="col-12 col-md-9">
                                                <div class="application-title">{{ $offer->name }}</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-9">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <p>@if($offer->order->is_tender == 0)Заявка @else Тендер @endif<span class="font-weight-normal">#{{ $offer->order->order_number }}</span></p>
                                                        <p class="mb-3">Замовник: <span class="font-weight-normal">{{ $offer->order->first_name }} {{ $offer->order->last_name }}</span></p>
                                                    </div>

                                                    <div class="col-md-7">
                                                        <p>{{ $offer->order->type_of_delivery == 'self' ? 'Самовивіз з' : 'Адреса доставки' }} <span class="font-weight-normal">{{ $offer->order->address }}</span></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <p>{{ $offer->order->machine->title }}</p>
                                                        <p>Ціна: <span class="font-weight-normal">
                                                                    {{ $offer->price }}
                                                                     грн/год</span></p>
                                                        <p>Кількість годин: <span class="font-weight-normal">{{ $offer->count }}</span></p>
                                                    </div>

                                                    <div class="col-md-7">
                                                        @if($offer->order->is_tender == 1)<p>Потрібен водій <span class="font-weight-normal">{{ $offer->order->is_driver ? 'так' : 'ні' }}</span></p>@endif
                                                        @if(!empty($offer->order->technic) && $offer->order->type_of_delivery == 'business')<p>Водій <span class="font-weight-normal">{{ $offer->order->technic->is_driver ? 'є' : 'немає' }}</span></p>@endif
                                                        <p>Дата доставки <span class="font-weight-normal">@if($offer->order->start_date_of_delivery !== $offer->order->end_date_of_delivery) {{ $offer->order->start_date_of_delivery }} - {{ $offer->order->end_date_of_delivery }} @else {{ $offer->order->date_of_delivery }} @endif</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="row">
                                                    <div class="col-12 col-md-10 small text-center text-md-right">
                                                        @if($offer->status !== 'canceled')
                                                            @if($offer->order->status == 'new')
                                                                Заявка подана
                                                            @elseif($offer->order->status == 'accepted')
                                                                Прийнято
                                                            @elseif($offer->order->status == 'executed')
                                                                Виконується
                                                            @elseif($offer->order->status == 'done')
                                                                Виконано
                                                            @else
                                                                Покупець<br />відмінив заявку
                                                            @endif
                                                        @else
                                                            @if($offer->canceled_by == 'client')
                                                                Скасовано<br />покупцем
                                                            @elseif($offer->canceled_by == 'seller')
                                                                Скасовано<br />продавцем
                                                            @else
                                                                Минув період<br />подання заявки
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div class="col-12 col-md-2">
                                                        <a href="{{ route('business::accepted.view', ['lang'=>app()->getLocale(), 'offer_id'=>$offer->id]) }}" class="search d-none d-md-inline-flex">
                                                            <svg class="icon">
                                                                <use xlink:href="#icon-right"></use>
                                                            </svg>
                                                        </a>

                                                        <a href="{{ route('business::accepted.view', ['lang'=>app()->getLocale(), 'offer_id'=>$offer->id]) }}" class="btn btn-default d-md-none w-100">Переглянути</a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                        @empty
                        <table>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="row justify-content-center" style="margin-top: 60px;">
                                        <div class="col-md-8">
                                            <div class="offer-empty">
                                                <svg class="offer-empty-icon">
                                                    <use xlink:href="#icon-noresult"></use>
                                                </svg>
                                                <div>
                                                    <p>Замовлення які би задовільняли критерії Вашої продукції не знайдено</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        </tbody>
                        </table>
                        @endforelse
                </div>

                {{ $offers->withQueryString()->links('frontend._modules.pagination/default') }}
            </section>
        </div>
    </main>
@endsection
