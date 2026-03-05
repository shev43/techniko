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
                        <div class="mb-4 d-md-flex align-items-center justify-content-between">
                            <div>
                                <h4>Персональна інформація</h4>
                                <p>Основна інформація в цьому обліковому записі.</p>
                            </div>
                            @if($permission['business.profile.edit'] == 1)
                            <a class="btn btn-outline-primary" href="{{ route('amicms::business.profile.edit', ['business_id'=>$business->id]) }}">Редагувати</a>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col" style="max-width: 200px;">
                                <div class="mb-3">
                                    <img class="img-fluid w-100 rounded" src="@if(!empty($business_profile->photo)){{ asset('storage/users/' . $business_profile->photo) }}@else{{ asset('img/profile-logo.svg') }}@endif" alt="upload avatar">
                                </div>
                            </div>
                            <div class="col-md">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th class="py-4">Ім'я</th>
                                        <td class="py-4">{{ $business_profile->first_name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-4">Прізвище</th>
                                        <td class="py-4">{{ $business_profile->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-4">Email</th>
                                        <td class="py-4">{{ $business_profile->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-4">Телефон</th>
                                        <td class="py-4">{{ $business_profile->phoneFormatted }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
