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
                <li class="breadcrumb-item active" aria-current="page">Контактні особи</li>
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

            <section class="seller_cabinet-settings-persons">
                <h2 class="title text-center">Налаштування контактних осіб</h2>
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-6">
                        <div class="seller_profile-persons-item">
                            <a class="seller_cabinet-selection seller_cabinet-selection--ta" href="{{ route('business::settings.contacts.create', ['lang'=>app()->getLocale()]) }}">
                                <svg class="icon">
                                    <use xlink:href="#icon-5"></use>
                                </svg>
                                <span>Додати</span>
                            </a>
                        </div>
                    </div>
                    @foreach($contacts as $contact)
                        <div class="col-md-12 col-lg-6">

                            <div class="row seller_profile-persons-item seller_profile-persons-item--edit">
                                <div class="col-5 col-md-4">
                                    <div class="seller_profile-persons-img">
                                        <img src="@if(!empty($contact->photo)){{ asset('storage/users/'.$contact->photo) }}@else{{ asset('img/profile-logo.svg') }}@endif" alt="">
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="seller_profile-persons-name">{{$contact->name}}</div>
                                    <div class="seller_profile-persons-post">{{$contact->position}}</div>
                                    <div class="seller_profile-persons-phone">+{{$contact->phone}}</div>
                                </div>

                                <div>
                                    <a class="delete" href="#" data-href="{{ route('business::settings.contacts.destroy', ['lang'=>app()->getLocale(), 'contact_id'=>$contact->id]) }}" data-toggle="modal" data-target="#confirm-delete">
                                        <svg class="icon">
                                            <use xlink:href="#icon-clear"></use>
                                        </svg>
                                    </a>

                                    <a class="edit" href="{{ route('business::settings.contacts.edit', ['lang'=>app()->getLocale(), 'contact_id'=>$contact->id]) }}">
                                        <svg class="icon">
                                            <use xlink:href="#icon-edit"></use>
                                        </svg>
                                    </a>
                                </div>

                            </div>



                        </div>
                    @endforeach
                </div>

                {{ $contacts->withQueryString()->links('frontend._modules.pagination.default') }}

            </section>

        </div>
    </main>

@endsection
