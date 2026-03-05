@extends('layouts.amicms.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-grid gap-3 mb-4 d-md-flex justify-content-md-end">
                        @if($permission['users.create'] == 1)
                            <a class="btn btn-outline-primary" href="{{ route('amicms::users.create') }}">Додати запис</a>
                        @endif
                    </div>
                </div>
            </div>
            <div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
{{--                        <th width="100">#</th>--}}
                        <th>Ім'я</th>
                        <th width="190">Телефон</th>
                        <th width="200">E-mail</th>
                        <th width="100" class="text-center">Створено</th>
                        <th width="50" class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users_array as $user)
                        <tr>
{{--                            <td>{{ $user->profile_number }}</td>--}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-circle avatar-image" style="width: 58px; height: 58px;">
                                        <img src="@if(!empty($user->photo)){{ asset('storage/users/'.$user->photo) }}@else{{ asset('img/profile-logo.svg') }}@endif" alt="">
                                    </div>
                                    <div class="ms-3">
                                        <div class="text-dark fw-bold">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->phone ? $user->phoneFormatted : 'н/д' }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                <span>
                                    @if($user->deleted_at)
                                        <s>
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('d.m.Y H:i') }}
                                        </s><br>
                                        {{ \Carbon\Carbon::parse($user->deleted_at)->format('d.m.Y H:i') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('d.m.Y H:i') }}
                                    @endif
                                </span>
                            </td>

                            <td class="text-center">
                                @if($permission['users.edit'] == 1 || $permission['users.destroy'] == 1)

                                <div class="dropdown">
                                    <a href="#" class="px-2" data-bs-toggle="dropdown">
                                        <i class="feather icon-more-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if($user->deleted_at == null)
                                            @if($permission['users.edit'] == 1)
                                            <li>
                                                <a href="{{ route('amicms::users.edit', ['user_id'=>$user->id]) }}" class="dropdown-item">
                                                    <div class="d-flex align-items-center">
                                                        <i class="feather icon-user-plus"></i>
                                                        <span class="ms-2">Редагувати запис</span>
                                                    </div>
                                                </a>
                                            </li>
                                            @endif
                                            @if($permission['users.destroy'] == 1)
                                            <li>
                                                <a href="" data-href="{{ route('amicms::users.destroy', ['user_id'=>$user->id]) }}" data-bs-toggle="modal" data-bs-target="#confirm-delete" class="dropdown-item">
                                                    <div class="d-flex align-items-center">
                                                        <i class="feather icon-trash-2"></i>
                                                        <span class="ms-2">Видалити запис</span>
                                                    </div>
                                                </a>
                                            </li>
                                            @endif
                                        @else
                                            @if($permission['users.destroy'] == 1)
                                            <li>
                                                <a href="{{ route('amicms::users.restore', ['user_id'=>$user->id]) }}" class="dropdown-item">
                                                    <div class="d-flex align-items-center">
                                                        <i class="feather icon-trash-2"></i>
                                                        <span class="ms-2">Відновити запис</span>
                                                    </div>
                                                </a>
                                            </li>
                                            @endif
                                        @endif


                                    </ul>
                                </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

                <div class="d-flex justify-content-end pagination">
                    {!! $users_array->withQueryString()->links('amicms._partials.paginate') !!}
                </div>


            </div>
        </div>
    </div>
@endsection
