@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Профіль</h4>

                    @include('amicms.business._partial.navbar', ['business_id'=>$business->id])


                </div>
                <div class="col">
                    <div class="card-body">
                        <form class="modal-form" method="post"
                              action="{{ route('amicms::business.profile.store', ['business_id'=>$business->id]) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4 d-md-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Персональна інформація</h4>
                                    <p>Основна інформація в цьому обліковому записі.</p>
                                </div>
                                <button class="btn btn-outline-primary" type="submit">Зберегти зміни</button>
                            </div>
                            <div class="row">
                                <div class="col" style="max-width: 200px;">
                                    <div class="mb-3">
                                        <img class="img-fluid w-100 rounded"
                                             src="@if($business_profile->photo){{ asset('storage/users/'.$business_profile->photo) }}@else{{ asset('img/profile-logo.svg') }}@endif"
                                             alt="upload avatar">
                                        @if($business_profile->photo)
                                        <div class="mt-3">
                                            <a class="btn btn-outline-danger" href="{{ route('amicms::business.profile.removeFile', ['business_id'=>$business->id, 'profile_id'=>$business_profile->id]) }}">Видалити</a>
                                        </div>
                                        @endif


                                    </div>
                                </div>
                                <div class="col-md">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th class="py-3">Ім'я</th>
                                            <td class="py-3">
                                                <input name="first_name" type="text" placeholder=""
                                                       class="form-control @if($errors->has('first_name')) noty_type_error @endif"
                                                       value="{{ old('first_name', $business_profile->first_name) }}"
                                                       >
                                                @if($errors->has('first_name'))
                                                    @foreach($errors->get('first_name') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-3">Прізвище</th>
                                            <td class="py-3">
                                                <input name="last_name" type="text" placeholder=""
                                                       class="form-control @if($errors->has('last_name')) noty_type_error @endif"
                                                       value="{{ old('last_name', $business_profile->last_name) }}">
                                                @if($errors->has('last_name'))
                                                    @foreach($errors->get('last_name') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-3">Email</th>
                                            <td class="py-3">
                                                <input name="email" type="text" placeholder=""
                                                       class="form-control @if($errors->has('email')) noty_type_error @endif"
                                                       value="{{ old('email', $business_profile->email) }}">
                                                @if($errors->has('email'))
                                                    @foreach($errors->get('email') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-3">Телефон</th>
                                            <td class="py-3">
                                                <input name="phone" type="text" placeholder=""
                                                       class="form-control @if($errors->has('phone')) noty_type_error @endif"
                                                       value="{{ old('phone', $business_profile->phone) }}">
                                                @if($errors->has('phone'))
                                                    @foreach($errors->get('phone') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        @if(empty($business_profile->photo))
                                            <tr>
                                                <th class="py-3">Зображення</th>
                                                <td class="py-3">
                                                    <input name="photo" type="file" placeholder="" class="form-control" value="{{ old('photo') }}">
                                                    @if($errors->has('photo'))
                                                        @foreach($errors->get('photo') as $error)
                                                            <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
