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
                        <h2 class="title">Останні тендери:</h2>
                    </div>
                    <div class="col-10 offset-2 col-sm-11 offset-sm-1 offset-md-7 col-md-5 offset-lg-1 col-lg-3">
                        <div class="form-group">
                            <svg class="form-icon">
                                <use xlink:href="#icon-filter"></use>
                            </svg>

                            <form class="orderType" action="{{ route('business::tender.index', ['lang'=>app()->getLocale()]) }}" method="get">
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

                    @if(!empty($subscription) && $subscription->isActive())
                        @forelse($requests as $request)
                            <div class="application-item border-bottom">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="application-title">{{ $request->machine->title }}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <p>Тендер <span class="font-weight-normal">#{{ $request->order_number }}</span></p>

                                            </div>

                                            <div class="col-md-7">
                                                <p>{{ $request->type_of_delivery == 'self' ? 'Самовивіз з' : 'Адреса доставки' }} <span class="font-weight-normal">{{ $request->address }}</span></p>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <p>Ціна: <span class="font-weight-normal">
                                                @if($request->min_price == 1 && $request->max_price == 9999)
                                                            {{ 'довільна ціна' }}
                                                        @elseif($request->min_price >= 2 && $request->max_price < 9999)
                                                            до {{ $request->max_price }}
                                                        @elseif($request->min_price >= 2 && $request->max_price == 9999)
                                                            від {{ $request->min_price }}
                                                        @else
                                                            {{ $request->min_price }} - {{ $request->max_price }}
                                                        @endif

                                                 грн/год
                                            </span></p>
                                                <p>Кількість годин: <span class="font-weight-normal">{{ $request->count }} год</span></p>



                                                @if(count($request->offers) > 0 && is_null($request->offers_id))
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
                                                <p>Потрібен водій <span class="font-weight-normal">{{ $request->is_driver ? 'так' : 'ні' }}</span></p>
                                                @if(!empty($request->technic) && $request->type_of_delivery == 'business')<p>Водій <span class="font-weight-normal">{{ $request->technic->is_driver ? 'є' : 'немає' }}</span></p>@endif
                                                <p>Дата доставки <span class="font-weight-normal">@if($request->start_date_of_delivery !== $request->end_date_of_delivery) {{ $request->start_date_of_delivery }} - {{ $request->end_date_of_delivery }} @else {{ $request->date_of_delivery }} @endif</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">

                                        <div class="row">
                                            <div class="col-12">
                                                <a href="{{ route('business::tender.view', ['lang'=>app()->getLocale(), 'view_type' => (count($request->offers) > 0) ? 'offer' : 'request', 'order_id'=>$request->id]) }}" class="btn btn-default w-100">Переглянути</a>
                                            </div>

                                            @if(count($request->offers) > 0)
                                                <div class="col-12 mt-3">
                                                    <a data-href="{{ route('business::tender.canceled', ['lang'=>app()->getLocale(), 'offer_id'=>$request->offer->id]) }}" class="btn btn-border_dark w-100" data-toggle="modal" data-target="#confirm-canceled">Скасувати</a>
                                                </div>
                                            @endif

                                            <div class="col-12 mt-3">
                                                @if( ($request->is_tender == 1 && $request->status == 'new') || ($request->status == 'new' &&(( count($request->offers) > 0 && $request->offers[0]['status'] !== 'canceled' ) )))
                                                    <div class="seller_cabinet-timer-small">
                                                        <div class="timer">
                                                            <div class="timer__items">
                                                                <div id="timer__days{{ $request->id }}" class="timer__item timer__days">00</div>
                                                                <div id="timer__hours{{ $request->id }}" class="timer__item timer__hours">00</div>
                                                                <div id="timer__minutes{{ $request->id }}" class="timer__item timer__minutes">00</div>
                                                                <div id="timer__seconds{{ $request->id }}" class="timer__item timer__seconds">00</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
                                                            // конечная дата
                                                            let timestamp{{ $request->id }} = Date.parse('{{ $request->end_date_of_delivery }}');
                                                            const deadline{{ $request->id }} = new Date(timestamp{{ $request->id }});

                                                            // id таймера
                                                            let timerId{{ $request->id }} = null;

                                                            // склонение числительных
                                                            function declensionNum{{ $request->id }}(num{{ $request->id }}, words{{ $request->id }}) {
                                                                return words{{ $request->id }}[(num{{ $request->id }} % 100 > 4 && num{{ $request->id }} % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][(num{{ $request->id }} % 10 < 5) ? num{{ $request->id }} % 10 : 5]];
                                                            }

                                                            // вычисляем разницу дат и устанавливаем оставшееся времени в качестве содержимого элементов
                                                            function countdownTimer{{ $request->id }}() {
                                                                const diff{{ $request->id }} = deadline{{ $request->id }} - new Date();
                                                                if (diff{{ $request->id }} <= 0) {
                                                                    clearInterval(timerId{{ $request->id }});
                                                                }
                                                                const days{{ $request->id }} = diff{{ $request->id }} > 0 ? Math.floor(diff{{ $request->id }} / 1000 / 60 / 60 / 24) : 0;
                                                                const hours{{ $request->id }} = diff{{ $request->id }} > 0 ? Math.floor(diff{{ $request->id }} / 1000 / 60 / 60) % 24 : 0;
                                                                const minutes{{ $request->id }} = diff{{ $request->id }} > 0 ? Math.floor(diff{{ $request->id }} / 1000 / 60) % 60 : 0;
                                                                const seconds{{ $request->id }} = diff{{ $request->id }} > 0 ? Math.floor(diff{{ $request->id }} / 1000) % 60 : 0;
                                                                $days{{ $request->id }}.textContent = days{{ $request->id }} < 10 ? '0' + days{{ $request->id }} : days{{ $request->id }};
                                                                $hours{{ $request->id }}.textContent = hours{{ $request->id }} < 10 ? '0' + hours{{ $request->id }} : hours{{ $request->id }};
                                                                $minutes{{ $request->id }}.textContent = minutes{{ $request->id }} < 10 ? '0' + minutes{{ $request->id }} : minutes{{ $request->id }};
                                                                $seconds{{ $request->id }}.textContent = seconds{{ $request->id }} < 10 ? '0' + seconds{{ $request->id }} : seconds{{ $request->id }};
                                                                $days{{ $request->id }}.dataset.title = declensionNum{{ $request->id }}(days{{ $request->id }}, ['дн', 'дн', 'дн']);
                                                                $hours{{ $request->id }}.dataset.title = declensionNum{{ $request->id }}(hours{{ $request->id }}, ['год', 'год', 'год']);
                                                                $minutes{{ $request->id }}.dataset.title = declensionNum{{ $request->id }}(minutes{{ $request->id }}, ['хв', 'хв', 'хв']);
                                                                $seconds{{ $request->id }}.dataset.title = declensionNum{{ $request->id }}(seconds{{ $request->id }}, ['сек', 'сек', 'сек']);
                                                            }

                                                            // получаем элементы, содержащие компоненты даты
                                                            const $days{{ $request->id }} = document.querySelector('#timer__days{{ $request->id }}');
                                                            const $hours{{ $request->id }} = document.querySelector('#timer__hours{{ $request->id }}');
                                                            const $minutes{{ $request->id }} = document.querySelector('#timer__minutes{{ $request->id }}');
                                                            const $seconds{{ $request->id }} = document.querySelector('#timer__seconds{{ $request->id }}');
                                                            // вызываем функцию countdownTimer
                                                            countdownTimer{{ $request->id }}();
                                                            // вызываем функцию countdownTimer каждую секунду
                                                            timerId{{ $request->id }} = setInterval(countdownTimer{{ $request->id }}, 1000);
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
                                            <p>Тендери які би задовільняли критерії Вашої продукції не знайдено</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    @else
                        <div class="row justify-content-center" style="margin-top: 60px;">
                            <div class="col-md-8">
                                <div class="offer-empty">
                                    <svg class="offer-empty-icon">
                                        <use xlink:href="#icon-noresult"></use>
                                    </svg>
                                    <div>
                                        <p>Для участі у тендерах перейдіть на преміум план</p>

                                        <a href="{{ route('business::subscription.index', ['lang'=>app()->getLocale()]) }}" class="btn btn-default">Детальніше</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>



                {{ $requests->withQueryString()->links('frontend._modules.pagination/default') }}

            </section>
        </div>
    </main>
@endsection
