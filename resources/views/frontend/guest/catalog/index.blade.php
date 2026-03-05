@extends('layouts.app')

@section('content')
    <main class="main page">
        <nav class="container mb-5" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
                <li class="breadcrumb-item active" aria-current="page">Каталог</li>
            </ol>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <h2 class="title">{{ __('web.vid_tehniki') }}:</h2>
                </div>
                <div class="col-12 col-lg-8">
                    <form id="orderByTypeCategory" class="form-group" method="get">
                        <svg class="form-icon">
                            <use xlink:href="#icon-filter"></use>
                        </svg>
                        <select class="selectpicker" name="category" data-style="form-control">
                            <option value="" {{ empty(request('category')) ? 'selected' : '' }}>{{ __('web.vsi_vidi_tehniki') }}</option>
                            @foreach($machineCategories as $category)
                                <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
{{--                <div class="col-md-6 col-lg-4">--}}
{{--                    <div class="form-group">--}}
{{--                        <input class="form-control basicAutoComplete" type="text" autocomplete="off" placeholder="{{ __('web.poshuk') }}">--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

            @if(!empty($currentCategory) && $currentCategory->has_sections)

                @if(!empty($machines['main']))
                    <div class="block">
                        <div class="row">
                            <div class="col-12">
                                <h2 class="title">{{ __('web.osnovna_tehnika') }}:</h2>
                            </div>
                            @foreach($machines['main'] as $machine)
                                @include('frontend.guest.catalog._partials.machine-type', ['machine'=>$machine])
                            @endforeach
                        </div>
                    </div>
                @endif
                @if(!empty($machines['other']))
                    <div class="row">
                        <div class="col-12">
                            <h2 class="title">{{ __('web.dodatkova') }}:</h2>
                        </div>
                        @foreach($machines['other'] as $machine)
                            @include('frontend.guest.catalog._partials.machine-type', ['machine'=>$machine])
                        @endforeach
                    </div>
                @endif
            @else
                <div class="row">
                    @foreach($machines as $machine)
                        @include('frontend.guest.catalog._partials.machine-type', ['machine'=>$machine])
                    @endforeach
                </div>
            @endif

        </div>
    </main>

@endsection
