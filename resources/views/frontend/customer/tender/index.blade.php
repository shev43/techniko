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
                <div class="row">
                    <div class="col-lg-9">
                        <h2 class="title">Створені тендери:</h2>
                    </div>

                    <div class="col-12 col-lg-3 text-right">
                        <div class="form-group">
                            <svg class="form-icon">
                                <use xlink:href="#icon-filter"></use>
                            </svg>

                            <form class="orderType" action="{{ route('customer::tender.index', ['lang'=>app()->getLocale()]) }}" method="get">
                                <select class="selectpicker" name="order" data-style="form-control" onchange="this.submit()">
                                    <option value="newer" @if(request()->get('order') == 'newer') selected @endif>Спочатку новіші</option>
                                    <option value="older" @if(request()->get('order') == 'older') selected @endif>Спочатку старіші</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row pb-4 border-bottom">
                    <div class="col-12 text-center text-md-right">
                        <a class="btn btn-default" href="{{ route('customer::tender.create', ['lang'=>app()->getLocale()]) }}">Створити тендер</a>
                    </div>
                </div>
                <div class="customer_cabinet-list">
                    <div class="blocklist">

                    @forelse($orders as $order_key =>$order)

                        <div class="customer_cabinet-item @if($order->status == 'canceled') disabled @endif">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="application-title">{{ $order->machine->title }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p>Тендер <span class="font-weight-normal">#{{ $order->order_number }}</span></p>
                                        </div>

                                        <div class="col-md-7">
                                            <p>{{ $order->type_of_delivery == 'self' ? 'Самовивіз з' : 'Адреса доставки' }} <span class="font-weight-normal">{{ $order->address }}</span></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p>Ціна: <span class="font-weight-normal">{{ $order->min_price }} - {{ $order->max_price }} грн/год</span></p>
                                            <p>Кількість годин: <span class="font-weight-normal">{{ $order->count }} год</span></p>

                                            @if(count($order->offers) > 0)
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
                                                            <b>Ви скасували пропозицію</b>
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
                                                    <svg class="icon">
                                                        <use xlink:href="#icon-clock"></use>
                                                    </svg>
                                                    <b>Очікує підтвердження</b>
                                                </div>

                                            @endif
                                        </div>

                                        <div class="col-md-7">
                                            <p>Потрібен водій <span class="font-weight-normal">{{ $order->is_driver ? 'так' : 'ні' }}</span></p>
                                            @if(!empty($order->technic) && $order->type_of_delivery == 'business')<p>Водій <span class="font-weight-normal">{{ $order->technic->is_driver ? 'є' : 'немає' }}</span></p>@endif
                                            <p>Дата доставки <span class="font-weight-normal">@if($order->start_date_of_delivery !== $order->end_date_of_delivery) {{ $order->start_date_of_delivery }} - {{ $order->end_date_of_delivery }} @else {{ $order->date_of_delivery }} @endif</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-12">

                                            @if(count($order->offers) > 0)
                                                @if(empty($order->offers_id))
                                                    <a href="{{ route('customer::tender.view-offers', ['lang'=>app()->getLocale(), 'order_id'=>$order->id]) }}" class="btn btn-default w-100">У вас {{ count($order->offers) }} заявок</a>
                                                @else
                                                    <a href="{{ route('customer::tender.view', ['lang'=>app()->getLocale(), 'order_id'=>$order->id, 'offer_id'=>$order->offers_id]) }}" class="btn btn-default w-100">Переглянути</a>
                                                @endif
                                                @if(($order->status == 'new' || $order->status == 'accepted'))
                                                    <div class="mt-3">
                                                        <a data-href="{{ route('customer::tender.canceled', ['lang'=>app()->getLocale(), 'order_id'=>$order->id]) }}" class="btn btn-border_dark w-100" data-toggle="modal" data-target="#confirm-canceled">Скасувати</a>
                                                    </div>
                                                @endif
                                            @else
                                                <div>
                                                    <a data-href="{{ route('customer::tender.canceled', ['lang'=>app()->getLocale(), 'order_id'=>$order->id]) }}" class="btn btn-border_dark w-100" data-toggle="modal" data-target="#confirm-canceled">Скасувати</a>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-12 mt-3">
                                            @if( ($order->is_tender == 1 && $order->status == 'new') || ($order->status == 'new' &&(( count($order->offers) > 0 && $order->offers[0]['status'] !== 'canceled' ) )))
                                                <div class="seller_cabinet-timer-small">
                                                    <div class="timer">
                                                        <div class="timer__items">
                                                            <div id="timer__days{{ $order->id }}" class="timer__item timer__days">00</div>
                                                            <div id="timer__hours{{ $order->id }}" class="timer__item timer__hours">00</div>
                                                            <div id="timer__minutes{{ $order->id }}" class="timer__item timer__minutes">00</div>
                                                            <div id="timer__seconds{{ $order->id }}" class="timer__item timer__seconds">00</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function () {
                                                        // конечная дата
                                                        let timestamp{{ $order->id }} = Date.parse('{{ $order->end_date_of_delivery }}');
                                                        const deadline{{ $order->id }} = new Date(timestamp{{ $order->id }});

                                                        // id таймера
                                                        let timerId{{ $order->id }} = null;

                                                        // склонение числительных
                                                        function declensionNum{{ $order->id }}(num{{ $order->id }}, words{{ $order->id }}) {
                                                            return words{{ $order->id }}[(num{{ $order->id }} % 100 > 4 && num{{ $order->id }} % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][(num{{ $order->id }} % 10 < 5) ? num{{ $order->id }} % 10 : 5]];
                                                        }

                                                        // вычисляем разницу дат и устанавливаем оставшееся времени в качестве содержимого элементов
                                                        function countdownTimer{{ $order->id }}() {
                                                            const diff{{ $order->id }} = deadline{{ $order->id }} - new Date();
                                                            if (diff{{ $order->id }} <= 0) {
                                                                clearInterval(timerId{{ $order->id }});
                                                            }
                                                            const days{{ $order->id }} = diff{{ $order->id }} > 0 ? Math.floor(diff{{ $order->id }} / 1000 / 60 / 60 / 24) : 0;
                                                            const hours{{ $order->id }} = diff{{ $order->id }} > 0 ? Math.floor(diff{{ $order->id }} / 1000 / 60 / 60) % 24 : 0;
                                                            const minutes{{ $order->id }} = diff{{ $order->id }} > 0 ? Math.floor(diff{{ $order->id }} / 1000 / 60) % 60 : 0;
                                                            const seconds{{ $order->id }} = diff{{ $order->id }} > 0 ? Math.floor(diff{{ $order->id }} / 1000) % 60 : 0;
                                                            $days{{ $order->id }}.textContent = days{{ $order->id }} < 10 ? '0' + days{{ $order->id }} : days{{ $order->id }};
                                                            $hours{{ $order->id }}.textContent = hours{{ $order->id }} < 10 ? '0' + hours{{ $order->id }} : hours{{ $order->id }};
                                                            $minutes{{ $order->id }}.textContent = minutes{{ $order->id }} < 10 ? '0' + minutes{{ $order->id }} : minutes{{ $order->id }};
                                                            $seconds{{ $order->id }}.textContent = seconds{{ $order->id }} < 10 ? '0' + seconds{{ $order->id }} : seconds{{ $order->id }};
                                                            $days{{ $order->id }}.dataset.title = declensionNum{{ $order->id }}(days{{ $order->id }}, ['дн', 'дн', 'дн']);
                                                            $hours{{ $order->id }}.dataset.title = declensionNum{{ $order->id }}(hours{{ $order->id }}, ['год', 'год', 'год']);
                                                            $minutes{{ $order->id }}.dataset.title = declensionNum{{ $order->id }}(minutes{{ $order->id }}, ['хв', 'хв', 'хв']);
                                                            $seconds{{ $order->id }}.dataset.title = declensionNum{{ $order->id }}(seconds{{ $order->id }}, ['сек', 'сек', 'сек']);
                                                        }

                                                        // получаем элементы, содержащие компоненты даты
                                                        const $days{{ $order->id }} = document.querySelector('#timer__days{{ $order->id }}');
                                                        const $hours{{ $order->id }} = document.querySelector('#timer__hours{{ $order->id }}');
                                                        const $minutes{{ $order->id }} = document.querySelector('#timer__minutes{{ $order->id }}');
                                                        const $seconds{{ $order->id }} = document.querySelector('#timer__seconds{{ $order->id }}');
                                                        // вызываем функцию countdownTimer
                                                        countdownTimer{{ $order->id }}();
                                                        // вызываем функцию countdownTimer каждую секунду
                                                        timerId{{ $order->id }} = setInterval(countdownTimer{{ $order->id }}, 1000);
                                                    });
                                                </script>

                                            @endif
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
                                        <p>У вас наразі немає жодного створеного тендеру</p>
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
