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
            <div class="row justify-content-between">
                <div class="col-12 col-md-6">
                    <h2 class="title">Замовник:</h2>

                    <div class="person">
                        <div class="person-img">
                            <img @if($request->customer->photo) src="{{ asset('storage/users/' . $request->customer->photo) }}" @else src="{{ asset('img/profile-logo.svg') }}" @endif alt="">
                        </div>
                        <div>
                            <div class="person-name">{{ $request->first_name }} {{ $request->last_name }}</div>
                            <div class="person-phone">{{ $request->phone }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    @if($request->offer->status == 'new')
                        @if($request->end_date_of_delivery >= \Carbon\Carbon::now())
                            <div class="seller_cabinet-status">
                                <div @if($request->status == 'accepted' || $request->status == 'executed' || $request->status == 'done') class="ready" @endif><span>Прийнято</span></div>
                                <div @if($request->status == 'executed' || $request->status == 'done') class="ready" @endif>
                                    @if($request->status == 'accepted')
                                        <a href="{{ route('business::accepted.status', ['lang'=>app()->getLocale(), 'status'=>'executed', 'offer_id'=>$request->offer->id]) }}">Виконується</a>
                                    @else
                                        <span>Виконується</span>
                                    @endif
                                </div>
                                <div @if($request->status == 'done') class="ready" @endif>
                                    @if($request->status == 'executed')
                                        <a href="{{ route('business::accepted.status', ['lang'=>app()->getLocale(), 'status'=>'done', 'offer_id'=>$request->offer->id]) }}">Виконано</a>
                                    @else
                                        <span>Виконано</span>
                                    @endif
                                </div>
                            </div>

                            @if($request->status == 'new' || $request->status == 'accepted')
                                <div class="seller_cabinet-timer">
                                    <div class="timer">
                                        <div class="timer__items">
                                            <div class="timer__item timer__days">00</div>
                                            <div class="timer__item timer__hours">00</div>
                                            <div class="timer__item timer__minutes">00</div>
                                            <div class="timer__item timer__seconds">00</div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                        @else
                            <div class="seller_cabinet-status_canceled">
                                <strong>Скасовано</strong> (вийшов час підтвердження)
                            </div>
                        @endif

                    @else
                        <div class="seller_cabinet-status_canceled">
                            <strong>Скасовано</strong>
                        </div>
                    @endif


                        <div class="heading"><span>Вартість: </span> {{ $request->offer->price }} грн/год</div>
                        <div class="order-price">
                            <div class="order-price-count" style="margin: 0 0 10px">
                                <div class="heading"><span>Кількість годин: </span>{{ $request->offer->count }}</div>
                            </div>
                        </div>
                        <div class="heading"><span>Разом: </span> {{ $request->offer->price * $request->offer->count }} грн</div>

                </div>

            </div>

            @if($request->comment)
                <div class="row justify-content-between mt-5">
                    <div class="col-12">
                        <h2 class="title">Коментар до замовлення:</h2>
                        <p>{{ $request->comment }}</p>
                    </div>
                </div>
            @endif



            <div class="row justify-content-between mt-5">
                <div class="col-12 col-md-6">
                    <div class="block">
                        <h2 class="title">Техніка:</h2>
                        <div class="technic_item technic_item--selected">
                            <img class="technic_item-img" @if($request->offer->photo) src="{{ asset('storage/technics/' . $request->offer->photo) }}" @else src="{{ asset('img/profile-logo.svg') }}" @endif alt="">
                            <h3 class="title technic_item-title">{{ $request->offer->name }}</h3>
                            <div class="d-flex align-items-end justify-content-between mt-auto">
                                <div class="heading technic_item-price">{{ $request->offer->price }} грн/год</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="block">
                        <h2 class="title">Контактна особа:</h2>

                        <div class="parameters_person-list">
                            @foreach($request->seller->business->contacts as $contact)
                                @if($contact->id == in_array($contact->id, explode(',', $request->offer->contact_id)))
                                    <div class="parameters">
                                        <div class="person person--edit ">
                                            <div class="person-img">
                                                <img @if($contact->photo) src="{{ asset('storage/users/' . $contact->photo) }}" @else src="{{ asset('img/profile-logo.svg') }}" @endif alt="">
                                            </div>
                                            <div>
                                                <div class="person-name">{{ $contact->name }}</div>
                                                <div class="person-post">{{ $contact->position }}</div>
                                                <div class="person-phone">{{ $contact->phoneFormatted }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

            <div class="row justify-content-between align-items-center mt-5">
                <div class="col-md-6">
                    @include('frontend._modules.map-view', ['objects'=>$request])
                </div>

                <div class="col-lg-5 offset-lg-1 col-md-6" style="margin-bottom: 60px;">
                    <h2 class="title">Час та місце {{ $request->type_of_delivery == 'self' ? 'передачі техніки' : 'доставки техніки' }}:</h2>
                    <div><b>{{ $request->type_of_delivery == 'self' ? 'Адреса передачі:' : 'Адреса доставки:' }}</b> {{ $request->address }}</div>
                    <div class="mt-2"><b>Дата доставки:</b> @if($request->start_date_of_delivery !== $request->end_date_of_delivery) {{ $request->start_date_of_delivery }} - {{ $request->end_date_of_delivery }} @else {{ $request->date_of_delivery }} @endif</div>

                </div>
            </div>

            <div class="row justify-content-center mt-5">
                <div class="@if($request->status == 'accepted') col-sm-5 col-md-6 @else col-12 @endif mb-4 mb-sm-0  text-center text-md-left">
                    <a class="btn btn-icon" href="{{ route('business::accepted.index', ['lang'=>app()->getLocale()]) }}">
                        <svg class="icon">
                            <use xlink:href="#icon-28"></use>
                        </svg>
                        <span>Назад</span>
                    </a>
                </div>
                @if($request->status == 'accepted')

                    <div class="col-12 col-sm-6 col-md-6 text-center text-md-right">
                        <a data-href="{{ route('business::offer.canceled', ['lang'=>app()->getlocale(), 'offer_id'=>$request->offer->id]) }}" class="btn btn-border_dark" data-toggle="modal" data-target="#confirm-canceled">Скасувати</a>
                    </div>
                @endif
            </div>
        </div>


    </main>
@endsection



@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // конечная дата
            let timestamp = Date.parse('{{ $request->end_date_of_delivery }}');
            const deadline = new Date(timestamp);
            // id таймера
            let timerId = null;

            // склонение числительных
            function declensionNum(num, words) {
                return words[(num % 100 > 4 && num % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][(num % 10 < 5) ? num % 10 : 5]];
            }

            // вычисляем разницу дат и устанавливаем оставшееся времени в качестве содержимого элементов
            function countdownTimer() {
                const diff = deadline - new Date();
                if (diff <= 0) {
                    clearInterval(timerId);
                }
                const days = diff > 0 ? Math.floor(diff / 1000 / 60 / 60 / 24) : 0;
                const hours = diff > 0 ? Math.floor(diff / 1000 / 60 / 60) % 24 : 0;
                const minutes = diff > 0 ? Math.floor(diff / 1000 / 60) % 60 : 0;
                const seconds = diff > 0 ? Math.floor(diff / 1000) % 60 : 0;
                $days.textContent = days < 10 ? '0' + days : days;
                $hours.textContent = hours < 10 ? '0' + hours : hours;
                $minutes.textContent = minutes < 10 ? '0' + minutes : minutes;
                $seconds.textContent = seconds < 10 ? '0' + seconds : seconds;
                $days.dataset.title = declensionNum(days, ['дн', 'дн', 'дн']);
                $hours.dataset.title = declensionNum(hours, ['год', 'год', 'год']);
                $minutes.dataset.title = declensionNum(minutes, ['мин', 'мин', 'мин']);
                $seconds.dataset.title = declensionNum(seconds, ['сек', 'сек', 'сек']);
            }

            // получаем элементы, содержащие компоненты даты
            const $days = document.querySelector('.timer__days');
            const $hours = document.querySelector('.timer__hours');
            const $minutes = document.querySelector('.timer__minutes');
            const $seconds = document.querySelector('.timer__seconds');
            // вызываем функцию countdownTimer
            countdownTimer();
            // вызываем функцию countdownTimer каждую секунду
            timerId = setInterval(countdownTimer, 1000);
        });
    </script>
@endsection
