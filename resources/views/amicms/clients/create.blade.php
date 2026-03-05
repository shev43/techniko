@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Клієнти</h4>

                </div>
                <div class="col">
                    <div class="card-body">
                        <form action="{{ route('amicms::clients.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4 d-md-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Інформація про клієнта</h4>
                                    <p>Основна інформація в цьому обліковому записі.</p>
                                </div>
                                <button class="btn btn-outline-primary" type="submit">Зберегти зміни</button>
                            </div>
                            <div class="row">
                                <div class="col" style="max-width: 200px;">
                                    <div class="mb-3">
                                        <img class="img-fluid w-100 rounded"
                                             src="{{ asset('img/profile-logo.svg') }}"
                                             alt="upload avatar">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th class="py-3">Ім'я</th>
                                            <td class="py-3">
                                                <input name="first_name" type="text" placeholder="" class="form-control @if($errors->has('first_name')) noty_type_error @endif" value="{{ old('first_name') }}">
                                                @if($errors->has('first_name'))
                                                    @foreach($errors->get('first_name') as $error)
                                                        <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-3">Прізвище</th>
                                            <td class="py-3">
                                                <input name="last_name" type="text" placeholder="" class="form-control @if($errors->has('last_name')) noty_type_error @endif" value="{{ old('last_name') }}">
                                                @if($errors->has('last_name'))
                                                    @foreach($errors->get('last_name') as $error)
                                                        <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-3">Телефон</th>
                                            <td class="py-3">
                                                <input name="phone" type="text" placeholder="" class="form-control" value="{{ old('phone') }}">
                                                @if($errors->has('phone'))
                                                    @foreach($errors->get('phone') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="py-3">Зображення</th>
                                            <td class="py-3">
                                                <input name="photo" type="file" placeholder="" class="form-control" value="">
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="py-3">Адреса</th>
                                            <td class="py-3">
                                                <input name="address" type="text" placeholder="" class="form-control autocomplete @if($errors->has('address')) noty_type_error @endif" value="{{ old('address') }}">
                                                @if($errors->has('address'))
                                                    @foreach($errors->get('address') as $error)
                                                        <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-12">
                                            @include('frontend._modules.map-form', ['objects'=>[], 'target'=>'form input[name=address]'])
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?language=uk-UK&key={{ (env('APP_DEBUG') == true) ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION') }}&libraries=places"></script>

    <script>
        jQuery(function($) {
            google.maps.event.addDomListener(window, 'load', buildAutocomplete());
        });
    </script>

@endsection
