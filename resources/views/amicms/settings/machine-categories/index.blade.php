@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Категорії технік</h4>

                    @include('amicms.settings._partial.navbar')

                </div>
                <div class="col">
                    <div class="card-body">
                        <div class="mb-4 d-md-flex align-items-center justify-content-between">
                            <div>
                                <h4>Категорія техніки</h4>
                            </div>
                            @if($permission['settings.machine-categories.create'] == 1)
                                <a class="btn btn-outline-primary" href="{{ route('amicms::settings.machine-categories.create') }}">Додати запис</a>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Назва</th>
                                        <th>Slug</th>
                                        <th width="50"></th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @foreach($machineCategories as $machineCategory)
                                        <tr>
                                            <td>{{ $machineCategory->title_uk }}</td>
                                            <td>{{ $machineCategory->slug }}</td>

                                            <td class="text-center">
                                                @if($permission['settings.machine-categories.edit'] == 1 || $permission['settings.machine-categories.destroy'] == 1)

                                                <div class="dropdown">
                                                    <a href="#" class="px-2" data-bs-toggle="dropdown">
                                                        <i class="feather icon-more-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        @if($machineCategory->deleted_at == null)
                                                            @if($permission['settings.machine-categories.edit'] == 1)
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('amicms::settings.machine-categories.edit', ['machine_categories_id'=>$machineCategory->id]) }}">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="feather icon-user-plus"></i>
                                                                        <span class="ms-2">Редагувати запис</span>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            @endif
                                                            @if($permission['settings.machine-categories.destroy'] == 1)
                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-href="{{ route('amicms::settings.machine-categories.destroy', ['machine_categories_id'=>$machineCategory->id]) }}" class="dropdown-item">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="feather icon-trash-2"></i>
                                                                        <span class="ms-2">Видалити запис</span>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            @endif
                                                        @else
                                                            @if($permission['settings.machine-categories.destroy'] == 1)
                                                            <li>
                                                                <a href="{{ route('amicms::settings.machine-categories.restore', ['machine_categories_id'=>$machineCategory->id]) }}" class="dropdown-item">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="feather icon-trash-2"></i>
                                                                        <span class="ms-2">Відновити запис</span>
                                                                    </div>
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-href="{{ route('amicms::settings.machine-categories.destroy-with-trash', ['machine_categories_id'=>$machineCategory->id]) }}" class="dropdown-item">
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
                                    {!! $machineCategories->withQueryString()->links('amicms._partials.paginate') !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
