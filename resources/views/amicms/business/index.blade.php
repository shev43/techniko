@extends('layouts.amicms.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="d-md-flex justify-content-md-start">
                        <form action="" autofocus="false" method="get">
                            <div class="input-group mb-3">
                                <input class="form-control" name="q" type="text" placeholder="Пошук за назвою або номером" autofocus="false" autocomplete="false" value="{{ \request()->get('q') }}">
                                <button class="btn btn-outline-secondary icon-search feather" type="submit" style="max-width: 50px; width: 100%;padding: 10px;"></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-grid gap-3 mb-4 d-md-flex justify-content-md-end">
                        @if($permission['business.create'] == 1)
                            <a class="btn btn-outline-primary" href="{{ route('amicms::business.create') }}">Додати запис</a>
                        @endif

                        @if($permission['business.import'] == 1)
                            <a class="btn btn-outline-dark" href="{{ route('amicms::business.import.index') }}">Імпортувати</a>
                        @endif
                    </div>
                </div>
            </div>
            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th width="30"></th>
                        <th width="100">#</th>
                        <th>Компанія</th>
                        <th width="100" class="text-center">Продуктів</th>
                        <th width="100" class="text-center">Створено</th>
                        <th width="50"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($business_array as $business)
                        <tr>
                            <td class="text-center">
                                <div class="form-check mb-0">
                                    <input class="form-check-input activate-account" type="checkbox" value="" id="activ{{ $business->id }}" data-id="{{ $business->user_id }}" {{ !empty($business->seller) && $business->seller->enabled == 1 ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>
                                <span>
                                    {{ $business->business_number }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-circle avatar-image" style="width: 58px; height: 58px;">
                                        <img src="@if(!empty($business->photo)){{ asset('storage/business/'.$business->photo) }}@else{{ asset('img/company-logo.svg') }}@endif" alt="">
                                    </div>
                                    <div class="ms-3">
                                        <div class="text-dark fw-bold">{{ $business->name }}</div>
                                        <div class="text-muted mt-2">{{ $business->phone }}</div>
                                        <div class="text-muted">{{ $business->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span>{{ count($business->technics) }}</span>
                            </td>
                            <td class="text-center">
                                <span>
                                    @if($business->deleted_at)
                                        <s>
                                            {{ \Carbon\Carbon::parse($business->created_at)->format('d.m.Y H:i') }}
                                        </s><br>
                                        {{ \Carbon\Carbon::parse($business->deleted_at)->format('d.m.Y H:i') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($business->created_at)->format('d.m.Y H:i') }}
                                    @endif
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <a href="#" class="px-2" data-bs-toggle="dropdown">
                                        <i class="feather icon-more-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if($business->deleted_at == null)
                                            <li>
                                                <a href="{{ route('amicms::reports.visitors', ['business_id'=>$business->id]) }}" class="dropdown-item">
                                                    <div class="d-flex align-items-center">
                                                        <i class="icon-bar-chart-line- feather"></i>
                                                        <span class="ms-2">Статистика</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('amicms::business.company.index', ['business_id'=>$business->id]) }}" class="dropdown-item">
                                                    <div class="d-flex align-items-center">
                                                        <i class="feather icon-user-plus"></i>
                                                        <span class="ms-2">Переглянути запис</span>
                                                    </div>
                                                </a>
                                            </li>
                                            @if($permission['business.destroy'] == 1)
                                            <li>
                                                <a href="#" data-href="{{ route('amicms::business.destroy', ['business_id'=>$business->id]) }}" data-bs-toggle="modal" data-bs-target="#confirm-delete" class="dropdown-item">
                                                    <div class="d-flex align-items-center">
                                                        <i class="feather icon-trash-2"></i>
                                                        <span class="ms-2">Видалити запис</span>
                                                    </div>
                                                </a>
                                            </li>
                                            @endif
                                        @else
                                            @if($permission['business.destroy'] == 1)
                                            <li>
                                                <a href="{{ route('amicms::business.restore', ['business_id'=>$business->id]) }}" class="dropdown-item">
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
                            </td>
                        </tr>


                    @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-end pagination">
                    {!! $business_array->withQueryString()->links('amicms._partials.paginate') !!}
                </div>


            </div>
        </div>
    </div>
@endsection
