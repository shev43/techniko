@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="col">
                    <div class="card-body">
                        <div class="mb-4 d-md-flex align-items-center justify-content-between">
                            <div>
                                <h4>Замовлення</h4>
                                <p>Основна інформація в цьому обліковому записі.</p>
                            </div>
                            @if($permission['orders.edit'] == 1)
                                <a class="btn btn-outline-primary" href="{{ route('amicms::orders.edit', ['order_id'=>$order->id]) }}">Редагувати запис</a>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <h5 class="fw-bold mt-2">Замовлення</h5>

                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th class="py-4">Замовлення</th>
                                                <td class="py-4">
                                                    <div>{{ $order->name }}</div>
                                                    <div class="mt-3">{{ $order->machine->title }}</div>
                                                </td>
                                            </tr>

                                            @if($order->is_tender == 0)
                                            <tr>
                                                <th class="py-4">Наявність водія</th>
                                                <td class="py-4">{{ ($order->technic->is_driver == 1) ? 'так' : 'ні' }}</td>
                                            </tr>
                                            @endif

                                            <tr>
                                                <th class="py-4">Дата доставки</th>
                                                <td class="py-4">{{ \Carbon\Carbon::parse($order->end_date_of_delivery)->format('d.m.Y') }}</td>
                                            </tr>

                                            <tr>
                                                <th class="py-4">Кількість</th>
                                                <td class="py-4">{{ $order->count }}</td>
                                            </tr>

                                            <tr>
                                                <th class="py-4">Орієнтовна вартість<br>(від - до)</th>
                                                <td class="py-4">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">{{ $order->min_price }}</div>
                                                        <div class="col-12 col-md-6">{{ $order->max_price }}</div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class="py-4">Тип доставки</th>
                                                <td class="py-4">{{ $order->type_of_delivery == 'self' ? 'Самовивіз' : 'Доставка' }}</td>
                                            </tr>
                                            </tbody>
                                        </table>


                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h5 class="fw-bold mt-2">Контактні дані</h5>

                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th class="py-4">Ім'я</th>
                                                <td class="py-4">{{ $order->first_name }}</td>
                                            </tr>
                                            <tr>
                                                <th class="py-4">Прізвище</th>
                                                <td class="py-4">{{ $order->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <th class="py-4">Телефон</th>
                                                <td class="py-4">{{ $order->phone }}</td>
                                            </tr>
                                            <tr>
                                                <th class="py-4">Адреса</th>
                                                <td class="py-4">{{ $order->address }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>




                                {{-- HISTORY --}}
                                <div class="mt-5">
                                    <h5 class="fw-bold mb-4">Пропозиції</h5>

                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th width="100">#</th>
                                            <th>Орендодавець</th>
                                            <th width="150">Ціна</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @forelse($order->offers as $businessIncomeRequest)
                                            <tr @if($businessIncomeRequest->id == $order->offer_id) class="selected" @endif>
                                                <td><span>{{ $businessIncomeRequest->offer_number }}</span></td>
                                                <td>
                                                    <div class="text-dark fw-bold">
                                                        {{$businessIncomeRequest->seller->first_name}} {{$businessIncomeRequest->seller->last_name}}
                                                    </div>
                                                    <div class="text-muted mt-2">
                                                        {{$businessIncomeRequest->seller->phoneFormatted}}
                                                    </div>
                                                </td>
                                                <td>{{$businessIncomeRequest->price}}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">
                                                    <p><span>Жоден орендодавець не відкликнувся на замовлення.</span></p>
                                                </td>
                                            </tr>
                                        @endforelse


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




