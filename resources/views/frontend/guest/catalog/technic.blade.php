@extends('layouts.app')

@section('content')
    <main class="main page">
        <nav class="container mb-5" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend::catalog.index', ['lang'=>app()->getLocale()]) }}">Каталог</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $machine->title }}</li>
            </ol>
        </nav>

        <div class="container">

            <div class="filter-box d-none d-md-block">
                <form id="filter-form" action="">

                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Введіть назву техніки" value="{{ old('name') ?? request()->get('name') }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                {{--                            <input type="text"--}}
                                {{--                                   class="form-control autocomplete_region @error('region') is-invalid @enderror"--}}
                                {{--                                   id="region" name="region"--}}
                                {{--                                   placeholder="Вся Україна" value="{{ request()->get('region') }}">--}}

                                {{--                            <input class="region_location_lat_destination" type="hidden" name="region_location_lat" value="{{ request()->get('region_location_lat') }}" />--}}
                                {{--                            <input class="region_location_lat_destination" type="hidden" name="region_location_lng" value="{{ request()->get('region_location_lng') }}" />--}}

                                <select class="selectpicker" name="region" data-style="form-control" data-title="Вся Україна">
                                    <option value="">Вся Україна</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->name }}" @if(!empty(request()->get('region')) && request()->get('region') == $region->name) selected @endif>{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <select class="selectpicker" name="categories" data-style="form-control" data-title="Вид техніки">
                                    @foreach($machines as $item)
                                        <option value="{{ $item->id }}" {{ (!empty(request()->get('categories') && request()->get('categories') == $item->id) ? 'selected' : ($machine->id === $item->id ? 'selected' : ''))   }} >{{ $item->title }} ({{ count($item->technics) }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <div class="range">
                                    <div class="row align-items-end">
                                        <div class="col-12 col-md-6">
                                            <div class="range-slider"
                                                 data-min="{{ @getMinPrice() }}"
                                                 data-max="{{ @getMaxPrice() }}"
                                                 data-start="@if(request('min_price')){{ request('min_price') }}@else{{ @getMinPrice() }}@endif"
                                                 data-end="@if(request('max_price')){{ request('max_price') }}@else{{ @getMaxPrice() }}@endif"
                                                 data-step="1"
                                                 style="max-width: 100%"
                                            ></div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="order-price-range">
                                                <input type="text" name="min_price" class="form-control start" id="start">
                                                <span>—</span>
                                                <input type="text" name="max_price" class="form-control end" id="end">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex align-items-start">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                @if(Auth::guard('customer')->check())
                                    <input type="text"
                                           class="form-control autocomplete @if(empty(request()->get('orderBy')) || request()->get('orderBy') !== 'distance') disabled @endif"
                                           id="address"
                                           name="address"
                                           placeholder="Введіть адресу для сортування за відстанню"
                                           value="{{ old('address', request()->get('address') ?? request()->user()->address) }}"
                                           @if(empty(request()->get('orderBy')) || request()->get('orderBy') !== 'distance') readonly disabled @endif>
                                @else
                                    <input type="text" class="form-control disabled" id="address" name="address" placeholder="Введіть адресу для сортування за відстанню" value="{{ old('address') }}" readonly disabled>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker" name="orderBy" data-style="form-control">
                                    <option value="low-price" {{ request()->get('orderBy') == 'low-price' ? 'selected' : '' }}>За низькою ціною</option>
                                    <option value="high-price" {{ request()->get('orderBy') == 'high-price' ? 'selected' : '' }}>За високою ціною</option>

                                    @if(Auth::guard('customer')->check() )
                                        <option value="distance" {{ request()->get('orderBy') == 'distance' ? 'selected' : '' }}>За відстанню</option>
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <div class="form-group text-md-right text-center">
                                    <button class="btn btn-default w-100">Фільтрувати</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="btn-filter-box form-group text-md-right text-center d-block d-md-none">
                <button class="btn btn-default w-100">Фільтрувати</button>
            </div>


            <div class="row">
                @forelse($technics_array as $technic)
                    @include('frontend.guest.catalog._partials.product', ['technic'=>$technic])
                @empty
                    <div class="col-12 col-md-8 offset-md-2 justify-content-center">
                        <div class="offer-empty">
                            <svg class="offer-empty-icon">
                                <use xlink:href="#icon-noresult"></use>
                            </svg>
                            <div>
                                <p>Техніка яка би задовільняла критеріям Вашого пошуку не знайдено</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    @include('frontend._modules.pagination.default', ['paginator'=>$technics_array])
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?language=uk-UK&key={{ (env('APP_DEBUG') == true) ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION') }}&libraries=places"></script>

    <script>
        jQuery(function($) {
            google.maps.event.addDomListener(window, 'load', buildAutocomplete());
            // google.maps.event.addDomListener(window, 'load', buildAutocompleteRegion());

        });

    </script>
@endsection
