@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Види техніки</h4>

                    @include('amicms.settings._partial.navbar')

                </div>
                <div class="col">
                    <div class="card-body">
                        <div class="mb-4 d-md-flex align-items-center justify-content-between">
                            <div>
                                <h4>Види техніки</h4>
                            </div>
                            @if($permission['settings.machines.create'] == 1)
                            <a class="btn btn-outline-primary" href="{{ route('amicms::settings.machines.create') }}">Додати запис</a>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th width="30"></th>
                                        <th>Фото</th>
                                        <th>Название</th>
                                        <th>Slug</th>
                                        <th width="50"></th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @foreach($machines as $machine)
                                        <tr>
                                            <td class="text-center">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input visible-category" type="checkbox" value="" id="activ{{ $machine->id }}" data-id="{{ $machine->id }}" @if($machine->visible == 1) checked @endif>
                                                </div>
                                            </td>
                                            <td><img src="{{ asset('img/technic/' . $machine->file) }}" alt=""></td>
                                            <td>{{ $machine->title_uk }}</td>
                                            <td>{{ $machine->slug }}</td>

                                            <td class="text-center">
                                                @if($permission['settings.machines.edit'] == 1 || $permission['settings.machines.destroy'] == 1)

                                                <div class="dropdown">
                                                    <a href="#" class="px-2" data-bs-toggle="dropdown">
                                                        <i class="feather icon-more-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        @if($machine->deleted_at == null)
                                                            @if($permission['settings.machines.edit'] == 1)
                                                                <li>
                                                                <a class="dropdown-item" href="{{ route('amicms::settings.machines.edit', ['machine_id'=>$machine->id]) }}">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="feather icon-user-plus"></i>
                                                                        <span class="ms-2">Редагувати запис</span>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            @endif
                                                            @if($permission['settings.machines.destroy'] == 1)
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-href="{{ route('amicms::settings.machines.destroy', ['machine_id'=>$machine->id]) }}" class="dropdown-item">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="feather icon-trash-2"></i>
                                                                        <span class="ms-2">Видалити запис</span>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            @endif
                                                        @else
                                                        @if($permission['settings.machines.destroy'] == 1)
                                                            <li>
                                                                <a href="{{ route('amicms::settings.machines.restore', ['machine_id'=>$machine->id]) }}" class="dropdown-item">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="feather icon-trash-2"></i>
                                                                        <span class="ms-2">Відновити запис</span>
                                                                    </div>
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-href="{{ route('amicms::settings.machines.destroy-with-trash', ['machine_id'=>$machine->id]) }}" class="dropdown-item">
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
                                    {!! $machines->withQueryString()->links('amicms._partials.paginate') !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
