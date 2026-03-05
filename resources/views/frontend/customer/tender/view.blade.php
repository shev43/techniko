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
                <li class="breadcrumb-item"><a href="{{ route('customer::tender.index', ['lang'=>app()->getLocale()]) }}">Тендери</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customer::tender.view-offers', ['lang'=>app()->getLocale(), 'order_id'=>$request->id]) }}">Заявки</a></li>
                <li class="breadcrumb-item active" aria-current="page">Пропозиція</li>
            </ol>
        </nav>

        <form id="BusinessIncomeRequest" class="form-prevent order-form" action="{{ route('customer::tender.accepted', ['lang'=>app()->getLocale()]) }}" method="post">
            @csrf

            <input name="order_id" type="hidden" value="{{ $request->id }}">
            <input name="offer_id" type="hidden" value="{{ $request->offer->id }}">
            <input name="seller_id" type="hidden" value="{{ $request->offer->seller->id }}">
            <input name="technic_id" type="hidden" value="{{ $request->offer->technic_id }}">

            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-12">
                        <h2 class="title">Власник:</h2>
                    </div>
                </div>

                <div class="row justify-content-between align-items-center">
                    <div class="col-md-6">
                        <div class="person">
                            <div class="person-img">
                                <img @if(!empty($request->offer->seller->business->photo)) src="{{ asset('storage/business/' . $request->offer->seller->business->photo) }}" @else src="{{ asset('img/company-logo.svg') }}" @endif alt="">
                            </div>
                            <div>
                                <div class="person-name">{{ $request->offer->seller->business->name }}</div>
                                <div class="person-phone">{{ $request->offer->seller->business->phoneFormatted }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5 offset-lg-1 text-center">
                        <div class="heading"><span>Вартість: </span> {{ $request->offer->price }} грн/год</div>
                        <div class="order-price text-center">
                            <div class="order-price-count justify-content-center" style="margin: 0 0 10px">

                                <div class="heading">{{ $request->offer->count }} годин</div>
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
                    <div class="col-md-6">
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

                    <div class="col-md-6">
                        <div class="block">
                            <h2 class="title">Контактна особа:</h2>

                            <div class="parameters_person-list">
                                @foreach($request->offer->seller->business->contacts as $contact)
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
                        <div><b>Адреса:</b> {{ $request->address }}</div>
                        <div class="mt-2"><b>Дата:</b> @if($request->start_date_of_delivery !== $request->end_date_of_delivery) {{ $request->start_date_of_delivery }} - {{ $request->end_date_of_delivery }} @else {{ $request->date_of_delivery }} @endif</div>
                    </div>
                </div>


                <div class="row justify-content-center mt-5">
                    <div class="@if($request->status == 'new') col-sm-5 col-md-6 @else col-12 @endif mb-4 mb-sm-0">
                        <a class="btn btn-icon" href="{{ route('customer::tender.index', ['lang'=>app()->getLocale()]) }}">
                            <svg class="icon">
                                <use xlink:href="#icon-28"></use>
                            </svg>
                            <span>Назад</span>
                        </a>
                    </div>
                    @if($request->status == 'new')

                        <div class="col-sm-6 col-md-3">
                            <button type="submit" class="btn btn-default w-100">Підтвердити</button>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a data-href="{{ route('customer::tender.cancel-offer', ['lang'=>app()->getlocale(), 'order_id'=>$request->id, 'offer_id'=>$request->offer->id]) }}" class="btn btn-border_dark w-100 mt-3 mt-md-auto" data-toggle="modal" data-target="#confirm-canceled">Скасувати</a>
                        </div>
                    @endif
                </div>
            </div>


        </form>
    </main>
@endsection
