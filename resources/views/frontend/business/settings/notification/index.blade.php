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
                <li class="breadcrumb-item active" aria-current="page">Сповіщення</li>
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

            <section class="notification">
                    <div class="row justify-content-center">
                    <div class="col-md-8">
                        @forelse($notification_array as $notification)
                        <div class="row item @if($notification->is_new == 1) new @endif align-items-center">
                            <div class="col-8">
                                @if($notification->order)
                                    <div class="boby">{!! str_replace(':order_number', $notification->order->order_number, $notification->message->message) !!}</div>
                                @else
                                    <div class="boby">{!! $notification->message->message !!}</div>
                                @endif
                            </div>
                            <div class="col-4">
                                <div class="created_at text-right">{{ \Carbon\Carbon::parse($notification->created_at)->format('d.m.Y H:i:s') }}</div>
                            </div>
                        </div>

                        @empty
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="offer-empty">
                                        <svg class="offer-empty-icon">
                                            <use xlink:href="#icon-noresult"></use>
                                        </svg>
                                        <div>
                                            <b>У вас немає сповіщень</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{ $notification_array->withQueryString()->links('frontend._modules.pagination/default') }}

            </section>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        setTimeout(function () {
            $.get('/ua/business/read-notification').done(function (){
                $('.main.page .notification .item').removeClass('new');
                $('#notificationBadge1').addClass('d-none');
                $('.notification-alert').addClass('d-none');
                $('#notificationCount').addClass('d-none');
            });

        }, 4000);
    </script>
@endsection
