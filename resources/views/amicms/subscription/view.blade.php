@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="col">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md">
                                <div class="row mt-4">
                                    <div class="col-md-4 mb-3">
                                        <span>Власник:</span>
                                        <h5 class="fw-bold mt-2">{{ $business->seller->first_name }} {{ $business->seller->last_name }}</h5>
                                        <address>
                                            <p><span>{{ $business->seller->email }}</span><br><span>{{ $business->seller->phoneFormatted }}</span></p>
                                        </address>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <span>Бізнес:</span>
                                        <h5 class="fw-bold mt-2">{{ $business->name }}</h5>
                                        <address>
                                            <p><span>{{ $business->address }}</span><br><span>{{ $business->email }}</span><br><span>{{ $business->phoneFormatted }}</span></p>
                                        </address>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <span>План:</span>
                                        <h5 class="fw-bold mt-2">
                                            @if(!empty($business->subscription) && $business->subscription->type == 'package' && $business->subscription->isActive())
                                                Експерт
                                            @else
                                                Базовий
                                            @endif
                                        </h5>
                                        <address>
                                            <p>
                                                <span>
                                                    @if(!empty($business->subscription) && $business->subscription->type == 'package' && $business->subscription->isActive())
                                                        Активний до
                                                    @else
                                                        Активировать на
                                                    @endif

                                                </span>

                                                <br>

                                                @if(!empty($business->subscription) && $business->subscription->type == 'package' && $business->subscription->isActive())
                                                    <span>{{ \Carbon\Carbon::parse($business->subscription->active_to)->format('d.m.Y') }}</span>
                                            @else
                                                <form action="{{ route('amicms::business.subscription.subscribe', ['business_id' => $business->id]) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="type" value="package">

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <select class="form-select" name="period">
                                                                    @for($i=1;$i<=12;$i++)
                                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-1">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-outline-danger">
                                                                    <i class="icon-shopping-cart feather"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </form>
                                                @endif


                                                </p>
                                        </address>
                                    </div>
                                </div>




                                {{-- HISTORY --}}
                                <div class="mt-5">
                                    <div class="">
                                        <form action="{{ route('amicms::business.subscription.subscribe', ['business_id' => $business->id]) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="type" value="slot">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="count" value="" min="1" placeholder="Кількість слотів" required>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <select class="form-select" name="period" required>
                                                            <option value="">Термін дії</option>
                                                            @for($i=1;$i<=12;$i++)
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <button class="btn btn-outline-primary" type="submit">Додати слот</button>
                                                </div>

                                            </div>

                                        </form>
                                    </div>

                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Статус</th>
                                            <th class="text-center">Тип</th>
                                            <th class="text-center">Дійсний</th>
                                            <th class="text-center">Додано</th>
                                            <th class="text-center">Створено</th>
                                            <th width="50" class="text-center"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($business->subscriptions && count($business->subscriptions) > 0)
                                            @foreach($business->subscriptions as $history)
                                                <tr>
                                                    <td>{{ $history->order_number }}</td>
                                                    <td>
                                                        @if($history->type == 'package')
                                                            @if($history->status == 'Approved')
                                                                <span class="text-success">Експерт план активовано</span>
                                                            @else
                                                                <span class="text-danger">Експерт план деактивовано</span>
                                                            @endif
                                                        @else
                                                            @if($history->status == 'Approved')
                                                                <span class="text-success">Додатковий пакет - {{ $history->count }} активовано</span>
                                                            @else
                                                                <span class="text-danger">Додатковий пакет - {{ $history->count }} деактивовано</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ ($history->type == 'package') ? 'Підписка' : 'Слот'  }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($history->activated_to)->format('d.m.Y') }}</td>
                                                    <td class="text-center">
                                                        @if($history->added_manually == '1')
                                                            Вручну
                                                        @else
                                                            Покупка
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($history->created_at)->format('d.m.Y') }}</td>

                                                    <td class="text-center">
                                                        @if($history->added_manually == '1' && $history->status == 'Approved')
                                                        <div class="dropdown">
                                                            <a href="#" class="px-2" data-bs-toggle="dropdown">
                                                                <i class="feather icon-more-vertical"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li>
                                                                    <a href="" data-href="{{ route('amicms::business.subscription.deActivate', ['business_id'=>$history->business_id, 'subscription_id'=>$history->id]) }}" data-href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirm-delete">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="feather icon-trash-2"></i>
                                                                            <span class="ms-2">Деактувати пакет</span>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="py-4 text-center">Немає історії підписок</td>
                                            </tr>
                                        @endif

                                        </tbody>
                                    </table>
                                </div>






                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection




