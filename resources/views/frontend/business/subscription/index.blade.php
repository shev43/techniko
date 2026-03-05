@extends('layouts.app')

@section('content')

    <section class="subscribe">
        <div class="container-fluid">
            <div class="row section-1">
                <div class="col-12 col-md-6">
                    <div class="container h-100 d-flex">
                        <div class="row align-self-center">
                            <div class="col-12 p-expert">
                                <h3>Пакет Експерт</h3>
                                <p>Всього {{ \Illuminate\Support\Facades\Config::get('subscription.package_price_mount') }} грн/міс при річній підписці після пробного періоду. Скасуй будь- коли. Дізнайся про інші тарифи</p>
                                <div class="buttons">
                                    <a class="btn subscribe-to-package btn-default w-100" href="#section-3">Спробувати 30 днів безкоштовно</a>
                                    <a class="btn subscribe-to-slot btn-border_light w-100 mt-3" href="#section-5">Отримати більше слотів для техніки</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 p-0">
                    <img src="{{ asset('img/subscribe/img-1.jpg') }}" alt="">
                </div>
            </div>
            <div class="row section-2">
                <div class="col-12">
                    <div class="container h-100 d-flex">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <h3 class="mt-2">Настав час заробляти більше</h3>

                                <p class="subscribe-item-top-body-txt-p1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                <p class="subscribe-item-top-body-txt-p1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                            <div class="col-12 col-md-6 p-0">
                                <img src="{{ asset('img/subscribe/img-2.jpg') }}" alt="">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div id="section-3" class="row section-3">
                <div class="col-12">
                    <div class="container h-100 d-flex">
                        <div class="row">
                            <div class="col-12 col-md-6 justify-content-center align-self-center">
                                <h3>Не зволікайте!<br>Розширте свої можливості з Техніко Експерт</h3>
                            </div>
                            <div class="col-12 col-md-6 expert-form justify-content-center align-self-center">

                                <h4>Пакет Експерт</h4>

                                <ul>
                                    <li>приймате участь в тендарах</li>
                                    <li>продавайте додатково</li>
                                    <li>отримайте 2 слота для техніки</li>
                                    <li>знижка 50% на додаткові слоти</li>
                                </ul>

                                <div>

                                    @if(!empty($subscription) && $subscription->isActive() && Auth::guard('business')->check())
                                        <p class="heading">
                                            <span class="font-weight-normal">Активний до: </span><span class="font-weight-bold">{{ \Carbon\Carbon::parse($subscription->active_to)->format('d.m.Y') }}</span>
                                        </p>
                                    @else
                                        @if(Auth::guard('business')->check() && $businessOwner->isBusinessCompleteActive())
                                            <form action="{{ route('business::subscription.create', ['lang'=>app()->getLocale()]) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="type" value="package">

                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <input type="radio" id="price_amount_1" name="productPrice" value="{{ \Illuminate\Support\Facades\Config::get('subscription.package_price_mount') }}">
                                                            <label for="price_amount_1">{{ \Illuminate\Support\Facades\Config::get('subscription.package_price_mount') }} грн/міс</label>
                                                            <div>*при підписці на місяць</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <input type="radio" id="price_amount_12" name="productPrice" value="{{ \Illuminate\Support\Facades\Config::get('subscription.package_price_year') }}" checked>
                                                            <label for="price_amount_12">{{ \Illuminate\Support\Facades\Config::get('subscription.package_price_year') }} грн/міс</label>
                                                            <div>*при підписці на рік ({{ \Illuminate\Support\Facades\Config::get('subscription.package_total_year') }} грн на рік)</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group mb-0">
                                                            <button class="btn btn-default w-100" type="submit">Спробувати 30 днів безкоштовно</button>

                                                        </div>
                                                    </div>
                                                </div>



                                            </form>
                                        @else
                                            @if(Auth::guard('business')->check())
                                                <form action="{{ route('business::subscription.create', ['lang'=>app()->getLocale()]) }}" method="post">
                                            @else
                                                <form class="showAuthBusinessModel" action="{{ route('business::subscription.create', ['lang'=>app()->getLocale()]) }}" method="post">
                                            @endif

                                                @csrf
                                                <input type="hidden" name="type" value="package">
                                                <div class="form-group">

                                                    <input type="radio" id="price_amount_1" name="productPrice" value="{{ \Illuminate\Support\Facades\Config::get('subscription.package_price_mount') }}">
                                                    <label for="price_amount_1">{{ \Illuminate\Support\Facades\Config::get('subscription.package_price_mount') }} грн/міс</label>
                                                    <div>*при підписці на місяць</div>
                                                </div>

                                                <div class="form-group">
                                                    <input type="radio" id="price_amount_12" name="productPrice" value="{{ \Illuminate\Support\Facades\Config::get('subscription.package_price_year') }}" checked>
                                                    <label for="price_amount_12">{{ \Illuminate\Support\Facades\Config::get('subscription.package_price_year') }} грн/міс</label>
                                                    <div>*при підписці на рік ({{ \Illuminate\Support\Facades\Config::get('subscription.package_total_year') }} грн на рік)</div>
                                                </div>

                                                <div class="form-group">
                                                    <button class="btn btn-default w-100" type="submit">Спробувати 30 днів безкоштовно</button>

                                                </div>
                                            </form>
                                        @endif
                                    @endif





                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row section-4">
                <div class="col-12">
                    <div class="container h-100 d-flex">
                        <div class="row">
                            <div class="col-12 col-md-5 order-md-0 order-1">
                                <img src="{{ asset('img/subscribe/img-3.jpg') }}" alt="">
                            </div>
                            <div class="col-12 col-md-7 justify-content-center align-self-center">
                                <h3>Відгукуйтесь на заявки</h3>

                                <p class="subscribe-item-top-body-txt-p1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                <p class="subscribe-item-top-body-txt-p1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                                <p><a class="btn subscribe-to-package btn-default w-100" href="#section-3">Спробувати 30 днів безкоштовно</a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div id="section-5" class="row section-5">
                <div class="col-12">
                    <div class="container h-100 d-flex">
                        <div class="row">
                            <div class="col-12 col-md-6 justify-content-center align-self-center">
                                <h3>Чим більше слотів тим більше продаж</h3>

                                <p class="subscribe-item-top-body-txt-p1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                <p class="subscribe-item-top-body-txt-p1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                                <div>
                                    @if(Auth::guard('business')->check())
                                        <form action="{{ route('business::subscription.create', ['lang'=>app()->getLocale()]) }}" method="post">
                                    @else
                                        <form class="showAuthBusinessModel" action="{{ route('business::subscription.create', ['lang'=>app()->getLocale()]) }}" method="post">
                                    @endif
                                        @csrf
                                        <input type="hidden" name="productPrice" value="{{ \Illuminate\Support\Facades\Config::get('subscription.slot_price_mount') }}">
                                        <input type="hidden" name="type" value="slot">

                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <input class="form-control" type="number" name="count" min="1" max="300" maxlength="3" placeholder="Кількість слотів" required>

                                            </div>
                                            <div class="col-12 col-md-6">
                                                <input class="form-control" type="number" name="period" min="1" max="999" maxlength="3" placeholder="Термін дії (міс)" required>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <strong>Вартість слота:</strong> {{ \Illuminate\Support\Facades\Config::get('subscription.slot_price_mount') }} грн/міс
{{--                                            <div>*при підписці на рік</div>--}}
                                        </div>

                                        <div class="form-group mt-5">
                                                <button class="btn btn-default w-100" type="submit">Збільшити кількість слотів</button>

                                        </div>

                                    </form>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <img src="{{ asset('img/subscribe/img-4.jpg') }}" alt="">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>

@endsection


