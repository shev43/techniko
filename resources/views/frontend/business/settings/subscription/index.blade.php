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
                <li class="breadcrumb-item active" aria-current="page">Підписка</li>
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

            <section class="seller_cabinet-settings-subscribe">

                <h2 class="title text-center">Управління підпискою</h2>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="premium-adding">

                            @if(!empty($subscription) && $subscription->type == 'package' && $subscription->isActive())
                                <div class="premium-adding-header">
                                    <div><b>Користувацький план: </b>{!! __('web.SUBSCRIPTION_PREMIUM_LABEL') !!}</div>
                                    <div><b>Кількість доступних слотів: </b> {{ $subscriptionSlot }}</div>
                                </div>
                                <div class="premium-adding-body py-4">
                                    <a href="{{ route('business::subscription.index', ['lang'=>app()->getLocale()]) }}" class="btn btn-default">Умови Експерту</a>
                                    <div>
                                        Активний до:
                                        <span class="heading">{{ \Carbon\Carbon::parse($subscription->active_to)->format('d.m.Y') }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="premium-adding-header">
                                    <div><b>Користувацький план: </b>{{ __('web.SUBSCRIPTION_FREE_LABEL') }}</div>
                                    <div><b>Кількість доступних слотів: </b> {{ $subscriptionSlot }} </div>
                                </div>
                                <div class="premium-adding-body">
                                    <a href="{{ route('business::subscription.index', ['lang'=>app()->getLocale()]) }}" class="btn btn-default my-3">Вибрати Експерт</a>
                                    <div class="pt-1">
                                        Вартість:
                                        <span class="heading">{{ config('subscription.price_year') }} грн/місяць</span>
                                    </div>
                                </div>
                                <div class="learn_more">
                                    <a href="{{ route('business::subscription.index', ['lang'=>app()->getLocale()]) }}">Дізнатись більше</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <section class="seller_cabinet-settings-subscribe">
                <div class="row justify-content-center">

                    @foreach($subscribeArray as $subscribe)

                    <div class="col-12 col-md-4">
                        <div class="premium-adding">
                            <div class="premium-adding-header">
                                <div><b>@if($subscribe->type == 'package'){!! __('web.SUBSCRIPTION_PREMIUM_LABEL') !!}@else{{ 'Додатковий пакет - ' . $subscribe->count }}@endif</b></div>
                            </div>
                            <div class="premium-adding-body py-4">
                                <p>Ваш план буде автоматично продовжено {{ \Carbon\Carbon::parse($subscribe->active_to)->format('d.m.Y') }}.
                                    Вартість складає {{ $subscribe->price }} грн на {{ $subscribe->period == 1 ? 'міс' : 'рік' }}.
                                </p>
                            </div>
                            <a href="#" data-href="{{ route('business::subscription.remove', ['lang'=>app()->getLocale(), 'subscribe_id'=>$subscribe->id]) }}" data-toggle="modal" data-target="#confirm-subscribe-deactivate">Скасувати підписку</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            <section class="seller_cabinet-settings-profile">
                <h2 class="title text-center">Історія платежів</h2>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <table class="table table-responsive-sm w-100">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Тип замовлення</th>
                                <th scope="col">Дата платежу</th>
                                <th scope="col">Активний до</th>
                                <th scope="col">Статус</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($histories as $history)
                            <tr>
                                <td>{{ $history['order_number'] }}</td>
                                <td>{{ empty($history['count']) ? 'Пакет Експерт' : 'Додатковий пакет - ' . $history['count'] . '' }}</td>
                                <td>{{ \Carbon\Carbon::parse($history['created_at'])->format('d.m.Y H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($history['active_to'])->format('d.m.Y H:i') }}</td>
                                <td>
                                    @if($history->status == 'Approved' && $history['active_to'] >= date('Y-m-d h:i:s'))
                                        <span class="text-success">активовано</span>
                                    @else
                                        <span class="text-danger">деактивовано</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>


        </div>
    </main>
@endsection
