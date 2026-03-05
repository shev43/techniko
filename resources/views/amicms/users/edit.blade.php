@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Адміністратори</h4>
                    @include('amicms.users._partial.navbar', ['mode'=>'edit'])

                </div>
                <div class="col">
                    <div class="card-body">
                        <form action="{{ route('amicms::users.update', ['user_id'=>$user->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4 d-md-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Інформація про користувача</h4>
                                    <p>Основна інформація в цьому обліковому записі.</p>
                                </div>
                                <button class="btn btn-outline-primary" type="submit">Зберегти зміни</button>
                            </div>

                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                    <div class="row">
                                        <div class="col" style="max-width: 200px;">
                                            <div class="mb-3">
                                                <img class="img-fluid w-100 rounded"
                                                     src="@if(!empty($user->photo)){{ asset('storage/users/' . $user->photo) }}@else{{ asset('img/profile-logo.svg') }}@endif"
                                                     alt="upload avatar">
                                                @if($user->photo)
                                                    <div class="mt-3">
                                                        <a class="btn btn-outline-danger" href="{{ route('amicms::users.removeFile', ['user_id'=>$user->id]) }}">Видалити</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <table class="table">
                                                <tbody>
                                                @if(request()->user()->account_type == 0)
                                                <tr>
                                                    <th class="py-3">Тип аккаунта</th>
                                                    <td class="py-3">
                                                        <select class="form-select" name="account_type">
                                                            <option value="0" {{ ($user->account_type == 0 ? 'selected' : '') }}>Без обмежень</option>
                                                            <option value="1" {{ ($user->account_type == 1 ? 'selected' : '') }}>З правами доступу</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <th class="py-3">Ім'я</th>
                                                    <td class="py-3">
                                                        <input name="first_name" type="text" placeholder="" class="form-control" value="{{ old('first_name', $user->first_name) }}">
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
                                                        <input name="last_name" type="text" placeholder="" class="form-control @if($errors->has('last_name')) noty_type_error @endif" value="{{ old('last_name', $user->last_name) }}">
                                                        @if($errors->has('last_name'))
                                                            @foreach($errors->get('last_name') as $error)
                                                                <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="py-3">Телефон</th>
                                                    <td class="py-3">
                                                        <input name="phone" type="text" placeholder="" class="form-control" value="{{ old('phone', $user->phone) }}">
                                                        @if($errors->has('phone'))
                                                            @foreach($errors->get('phone') as $error)
                                                                <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th class="py-3">Email</th>
                                                    <td class="py-3">
                                                        <input name="email" type="text" placeholder="" class="form-control" value="{{ old('email', $user->email) }}">
                                                        @if($errors->has('email'))
                                                            @foreach($errors->get('email') as $error)
                                                                <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                </tr>

                                                @if(empty($user->photo))
                                                    <tr>
                                                        <th class="py-3">Зображення</th>
                                                        <td class="py-3">
                                                            <input name="photo" type="file" placeholder="" class="form-control" value="">
                                                            @if($errors->has('photo'))
                                                                @foreach($errors->get('photo') as $error)
                                                                    <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif

                                                <tr>
                                                    <th class="py-3">Пароль</th>
                                                    <td class="py-3">
                                                        <input name="password" type="password" placeholder="" class="form-control" value="">
                                                        @if($errors->has('password'))
                                                            @foreach($errors->get('password') as $error)
                                                                <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th class="py-3">Пароль ще раз</th>
                                                    <td class="py-3">
                                                        <input name="password_confirmation" type="password" placeholder="" class="form-control"  value="">
                                                        @if($errors->has('password_confirmation'))
                                                            @foreach($errors->get('password_confirmation') as $error)
                                                                <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-role" role="tabpanel" aria-labelledby="v-pills-role-tab">
                                    <div class="row">
                                        <div class="col">
                                            @include('amicms.users._partial.access-rights', ['mode'=>'edit'])

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
