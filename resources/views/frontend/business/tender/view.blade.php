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
                <li class="breadcrumb-item"><a href="{{ route('business::tender.index', ['lang'=>app()->getLocale()]) }}">Тендери</a></li>
{{--                <li class="breadcrumb-item"><a href="{{ route('business::tender.view', ['lang'=>app()->getLocale(), 'order_id'=>$request->id]) }}">Заявки</a></li>--}}
                <li class="breadcrumb-item active" aria-current="page">Пропозиція</li>
            </ol>
        </nav>

        <form id="BusinessIncomeRequest" class="form-prevent order-form" action="{{ route('business::offer.create', ['lang'=>app()->getLocale()]) }}" method="post">
            @csrf

            <input name="is_tender" type="hidden" value="1">
            <input name="order_id" type="hidden" value="{{ $request->id }}">
            <input name="customer_id" type="hidden" value="{{ $request->customer->id }}">
            <input name="machine_id" type="hidden" value="{{ $request->machine_id }}">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-12">
                        <h2 class="title">Замовник:</h2>
                    </div>
                </div>

                <div class="row justify-content-between align-items-center">
                    <div class="col-md-6">
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
                    <div class="col-md-6 col-lg-5 offset-lg-1">
                        <div class="heading"><span>Вартість: </span> {{ $request->min_price }} - {{ $request->max_price }} грн/год</div>
                        <div class="order-price text-center">
                            <div class="order-price-count justify-content-center" style="margin: 0 0 10px">
                                <input name="count" type="number" class="form-control" placeholder="1" value="{{ old('count', $request->count) }}"
                                       min="{{ $request->count }}" max="999" maxlength="3">
                                <div class="heading">годин</div>
                            </div>
                        </div>
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
                            <div class="parameters_technic-list">
                                @foreach($request->technics_by_machine as $technic_key => $technic)
                                    <div class="technic_item technic_item-{{ $technic->id }} technic_item--selected @if($technic_key !== 0) d-none @endif">
                                        <img class="technic_item-img" @if($technic->photo[0]) src="{{ asset('storage/technics/' . $technic->photo[0]->photo) }}" @else src="{{ asset('img/profile-logo.svg') }}" @endif alt="">
                                        <h3 class="title technic_item-title">{{ $technic->name }}</h3>
                                        <div class="d-flex align-items-end justify-content-between mt-auto">
                                            <div class="heading technic_item-price">{{ $technic->price }} грн/год</div>
                                            <svg class="icon technic_item-icon" data-toggle="modal" data-target="#modalParameters">
                                                <use xlink:href="#icon-29"></use>
                                            </svg>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="block">
                            <h2 class="title">Контактна особа:</h2>
                            <a class="seller_cabinet-selection" href="#" data-toggle="modal"
                               data-target="#modalPersons">
                                <svg class="icon">
                                    <use xlink:href="#icon-5"></use>
                                </svg>
                                <span>
                                Виберіть зі списку
                            </span>
                            </a>

                            @error('person')
                                <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror

                            <div class="parameters_person-list">
                                @foreach($contacts as $contact)
                                    <div class="parameters person-item-{{ $contact->id }} d-none" data-person-id="{{ $contact->id }}">
                                        <div class="person person--edit ">
                                            <div class="person-img">
                                                <img @if($contact->photo) src="{{ asset('storage/users/' . $contact->photo) }}" @else src="{{ asset('img/profile-logo.svg') }}" @endif alt="">
                                            </div>
                                            <div>
                                                <div class="person-name">{{ $contact->name }}</div>
                                                <div class="person-post">{{ $contact->position }}</div>
                                                <div class="person-phone">{{ $contact->phoneFormatted }}</div>
                                            </div>
                                            <a class="delete" href="#" data-contact-id="{{ $contact->id }}">
                                                <svg class="icon">
                                                    <use xlink:href="#icon-clear"></use>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
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
                    <div class="col-sm-5 col-md-3 col-lg-2 offset-sm-1 mb-4 mb-sm-0">
                        <a class="btn btn-icon w-100" href="{{ route('business::tender.index', ['lang'=>app()->getLocale()]) }}">
                            <svg class="icon">
                                <use xlink:href="#icon-28"></use>
                            </svg>
                            <span>Назад</span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <button type="submit" class="btn btn-default w-100">Запропонувати</button>
                    </div>
                </div>
            </div>

            <div class="modal fade modal" tabindex="-1" id="modalParameters">
                <div class="modal-dialog modal-dialog-centered modal-parameters">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg>
                                <use xlink:href="#icon-5"></use>
                            </svg>
                        </button>
                        <h2 class="title">Під параметри підходять:</h2>
                        <div class="row">
                            @foreach($request->technics_by_machine as $technic_key => $technic)
                            <div class="col-md-6">
                                <input type="radio" name="technic_id" id="technic-ext-{{ $technic->id }}" class="d-none" value="{{ $technic->id }}" @if($technic_key == 0) checked @endif>
                                <label class="technic_item technic_item--box" for="technic-ext-{{ $technic->id }}">
                                    <img class="technic_item-img" @if($technic->photo) src="{{ asset('storage/technics/' . $technic->photo[0]->photo) }}" @else src="{{ asset('img/profile-logo.svg') }}" @endif alt="">

                                    <span class="technic_item-title">{{ $technic->name }}</span>
                                    <span class="technic_item-price">{{ $technic->price }} грн/год</span>
                                    <svg class="icon icon-check">
                                        <use xlink:href="#icon-check"></use>
                                    </svg>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-default" id="select-parameters-btn">Вибрати</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade modal" tabindex="-1" id="modalPersons">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg>
                                <use xlink:href="#icon-5"></use>
                            </svg>
                        </button>
                        <h2 class="title">Список осіб:</h2>

                        <div class="modal-contacts-list">
                            @foreach($contacts as $contact)
                                <div class="parameters">
                                    <input type="checkbox" name="person[]" id="person-exp-{{ $contact->id }}" class="d-none" value="{{ $contact->id }}">
                                    <label class="person person--box" for="person-exp-{{ $contact->id }}">
                                <span class="person-img">
                                    <img @if($contact->photo) src="{{ asset('storage/users/' . $contact->photo) }}" @else src="{{ asset('img/profile-logo.svg') }}" @endif alt="">
                                </span>

                                        <span>
                                    <span class="person-name">{{ $contact->name }}</span>
                                    <span class="person-post">{{ $contact->position }}</span>
                                    <span class="person-phone">{{ $contact->phoneFormatted }}</span>
                                </span>
                                        <svg class="icon icon-check">
                                            <use xlink:href="#icon-check"></use>
                                        </svg>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-default" id="select-person-btn">Вибрати</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </main>
@endsection
