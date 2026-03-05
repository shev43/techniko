@extends('layouts.app')

@section('content')
    <main class="main page">
        <nav class="container mb-5" aria-label="breadcrumb">
            <ol class="breadcrumb">
                @if(Auth::guard('customer')->check())
                    <li class="breadcrumb-item"><a href="{{ route('customer::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
                @else
                    <li class="breadcrumb-item"><a href="{{ route('frontend::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
                @endif
                <li class="breadcrumb-item"><a href="{{ route('customer::request.index', ['lang'=>app()->getLocale()]) }}">Заявки</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $request->name }}</li>
            </ol>
        </nav>

        <div class="container">
            @if($request->status == 'new' || $request->status == 'accepted')
                <div class="offer_details-status mb-5">
                    <div class="offer_details-status-icon">
                        <svg class="icon">
                            <use xlink:href="#icon-clock"></use>
                        </svg>
                    </div>
                    <div class="offer_details-status-body">
                        <h3 class="heading">Продавець отримав ваше замовлення</h3>
                        <div class="offer_details-status-text">Скоро з вами зв'яжуться для уточнення деталей замовлення та доставки, очікуйте</div>
                    </div>
                </div>
            @elseif($request->status == 'executed')
                <div class="offer_details-status offer_details-status--delivery mb-5">
                    <div class="offer_details-status-icon">
                        <svg class="icon">
                            <use xlink:href="#icon-clock"></use>
                        </svg>
                    </div>
                    <div class="offer_details-status-body">
                        <h3 class="heading">Замовлення доставляється</h3>
                    </div>
                </div>
            @elseif($request->status == 'done')
                <div class="offer_details-status offer_details-status--done mb-5">
                    <div class="offer_details-status-icon">
                        <svg class="icon">
                            <use xlink:href="#icon-check"></use>
                        </svg>
                    </div>
                    <div class="offer_details-status-body">
                        <h3 class="heading">Замовлення виконано</h3>
                    </div>
                </div>
            @elseif($request->status == 'canceled')
                <div class="offer_details-status offer_details-status--canceled mb-5">
                    <div class="offer_details-status-icon">
                        <svg class="icon icon-clear">
                            <use xlink:href="#icon-clear"></use>
                        </svg>
                    </div>
                    <div class="offer_details-status-body">
                        <h3 class="heading">Замовлення скасовано</h3>
                    </div>
                </div>
            @endif

            <div class="row justify-content-between">
                <div class="col-12">
                    <h2 class="title">Власник:</h2>
                </div>
            </div>

            <div class="row justify-content-between align-items-center">
                <div class="col-md-6">
                    <div class="person">
                        <div class="person-img">
                            <img @if($request->seller->business->photo) src="{{ asset('storage/business/' . $request->seller->business->photo) }}" @else src="{{ asset('img/company-logo.svg') }}" @endif alt="">
                        </div>
                        <div>
                            <div class="person-name">{{ $request->seller->business->name }}</div>
                            <div class="person-phone">{{ $request->seller->business->phoneFormatted }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 offset-lg-1 text-center">
                    <div class="heading"><span>Вартість: </span> {{ $request->min_price }} грн/год</div>
                    <div class="order-price text-center">
                        <div class="order-price-count justify-content-center" style="margin: 0 0 10px">
                            <div class="heading">{{ $request->count }} годин</div>
                        </div>
                    </div>
                    <div class="heading"><span>Разом: </span> {{ $request->min_price * $request->count }} грн</div>
                </div>
            </div>

            <div class="row justify-content-between mt-5">
                <div class="col-md-6">
                    <div class="block">
                        <h2 class="title">Техніка:</h2>
                        <div class="technic_item technic_item--selected">
                            <img class="technic_item-img" @if($request->photo) src="{{ asset('storage/technics/' . $request->photo) }}" @else src="{{ asset('img/profile-logo.svg') }}" @endif alt="">
                            <h3 class="title technic_item-title">{{ $request->name }}</h3>
                            <div class="d-flex align-items-end justify-content-between mt-auto">
                                <div class="heading technic_item-price">{{ $request->min_price }} грн/год</div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($request->offer) && $request->seller->business->contacts->count() > 0)
                    <div class="col-md-6">
                        <div class="block">
                            <h2 class="title">Контактна особа:</h2>
                            <div class="parameters_person-list">
                                @foreach($request->seller->business->contacts as $contact)
                                    @if($contact->id == in_array($contact->id, explode(',', $request->offer->contact_id)))
                                        <div class="parameters">
                                            <div class="person person--edit">
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
                @endif
            </div>

            <div class="row justify-content-between align-items-center mt-5">
                <div class="col-md-6">
                    @include('frontend._modules.map-view', ['objects'=>$request])
                </div>

                <div class="col-lg-5 offset-lg-1 col-md-6" style="margin-bottom: 60px;">
                    <h2 class="title">Час та місце проведення робіт:</h2>
                    <div class="mb-2"><b>Адреса:</b> {{ $request->address }}</div>
                    <div><b>Дата:</b> @if($request->start_date_of_delivery !== $request->end_date_of_delivery) {{ $request->start_date_of_delivery }} - {{ $request->end_date_of_delivery }} @else {{ $request->date_of_delivery }} @endif</div>
                </div>
            </div>

            @if($request->comment)
                <div class="row mt-5">
                    <div class="col-12">
                        <h2 class="title">Коментар до замовлення:</h2>
                        <p>{{ $request->comment }}</p>
                    </div>
                </div>
            @endif

            <div class="row justify-content-center mt-5 text-center">
                <div class="col-12 mb-4 mb-sm-0">
                    <a class="btn btn-icon" href="{{ route('customer::request.index', ['lang'=>app()->getLocale()]) }}">
                        <svg class="icon">
                            <use xlink:href="#icon-28"></use>
                        </svg>
                        <span>Назад</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
