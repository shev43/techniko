@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Контакти</h4>

                    @include('amicms.business._partial.navbar', ['business_id'=>$business_id])

                </div>
                <div class="col">
                    <div class="card-body">
                        <div class="mb-4 d-md-flex align-items-center justify-content-between">
                            <div>
                                <h4>Контактні особи</h4>
                                <p>Основна інформація в цьому обліковому записі.</p>
                            </div>
                            @if($permission['business.contacts.create'] == 1)
                            <a class="btn btn-outline-primary" href="{{ route('amicms::business.contacts.create', ['business_id'=>$business_id]) }}">Додати контакт</a>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Ім'я</th>
                                        <th>Посада</th>
                                        <th width="200">Телефон</th>
                                        <th width="100">Створено</th>
                                        <th width="50"></th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @foreach($contacts_array as $contact)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-circle avatar-image" style="width: 58px; height: 58px;">
                                                        <img src="@if(!empty($contact->photo)){{ asset('storage/users/'.$contact->photo) }}@else{{ asset('img/profile-logo.svg') }}@endif" alt="">
                                                    </div>
                                                    <div class="ms-3">
                                                        <div class="text-dark fw-bold">{{ $contact->name }}</div>
                                                    </div>
                                                </div>


                                            <td><span>{{ $contact->position }}</span></td>
                                            <td><span>{{ $contact->phoneFormatted }}</span></td>
                                            <td class="text-center">
                                <span>
                                    @if($contact->deleted_at)
                                        <s>
                                            {{ \Carbon\Carbon::parse($contact->created_at)->format('d.m.Y H:i') }}
                                        </s><br>
                                        {{ \Carbon\Carbon::parse($contact->deleted_at)->format('d.m.Y H:i') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($contact->created_at)->format('d.m.Y H:i') }}
                                    @endif
                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if($permission['business.contacts.edit'] == 1 || $permission['business.contacts.destroy'] == 1)
                                                <div class="dropdown">
                                                    <a href="#" class="px-2" data-bs-toggle="dropdown">
                                                        <i class="feather icon-more-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        @if($contact->deleted_at == null)
                                                            @if($permission['business.contacts.edit'] == 1)
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('amicms::business.contacts.edit', ['business_id'=>$business_id, 'contact_id'=> $contact->id ]) }}">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="feather icon-user-plus"></i>
                                                                        <span class="ms-2">Редагувати запис</span>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            @endif
                                                            @if($permission['business.contacts.destroy'] == 1)
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-href="{{ route('amicms::business.contacts.destroy', ['business_id'=>$business_id, 'contact_id'=>$contact->id]) }}" class="dropdown-item">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="feather icon-trash-2"></i>
                                                                        <span class="ms-2">Видалити запис</span>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            @endif
                                                        @else
                                                            @if($permission['business.contacts.destroy'] == 1)
                                                            <li>
                                                                <a href="{{ route('amicms::business.contacts.restore', ['business_id'=>$business_id, 'contact_id'=>$contact->id]) }}" class="dropdown-item">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="feather icon-trash-2"></i>
                                                                        <span class="ms-2">Відновити запис</span>
                                                                    </div>
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-href="{{ route('amicms::business.contacts.destroy-with-trash', ['business_id'=>$business_id, 'contact_id'=>$contact->id]) }}" class="dropdown-item">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="feather icon-trash-2"></i>
                                                                        <span class="ms-2">Видалити запис</span>
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
                                    {!! $contacts_array->withQueryString()->links('amicms._partials.paginate') !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
