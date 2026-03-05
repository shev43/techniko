@extends('layouts.amicms.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="justify-content-md-start">
                        <form action="" autofocus="false" method="get">
                            <div class="input-group mb-3">
                                <input class="form-control" name="q" type="text" placeholder="Пошук за назвою або номером замовлення" autofocus="false" autocomplete="false" value="{{ \request()->get('q') }}">
                                <button class="btn btn-outline-secondary icon-search feather" type="submit" style="max-width: 50px; width: 100%;padding: 10px;"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th width="100">#</th>
                        <th>Замовник</th>
                        <th>Тип</th>
                        <th>Замовлення</th>
                        <th width="100" class="text-center">Пропозицій</th>
                        <th width="100" class="text-center">Статус</th>
                        <th width="50" class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($orders_array as $order)
                        <tr>
                            <td class="text-center">{{ $order->order_number }}</td>
                            <td>
                                <div class="text-dark fw-bold">{{ $order->customer->first_name }} {{ $order->customer->last_name }}</div>
                                <div class="text-muted mt-2">{{ $order->customer->phoneFormatted }}</div>
                                <div class="text-muted mt-2">{{ $order->customer->email }}</div>
                                <div class="text-muted mt-2">{{ ($order->type_of_delivery == 'self') ? 'Самовивіз' : 'Доставка' }}</div>
                                <div class="text-muted mt-2">{{ $order->address }}</div>
                            </td>

                            <td class="text-nowrap">
                                <b>{{ $order->is_tender == 1 ? 'Тендер' : 'Заявка'}}</b>
                            </td>

                            <td class="text-nowrap">
                                <div class="text-dark fw-bold">{{ !is_null($order->name) ? $order->name : 'н/д'}}</div>
                                <div class="text-dark mt-2">{{ $order->machine->title }}</div>

                            </td>

                            <td class="text-center">{{ count($order->offers) }}</td>
                            <td class="text-center">
                                <div style="font-size: 13px">
                                    @switch($order->status)
                                        @case('new')
                                        <span class="badge badge-secondary">Новий</span>
                                        @break

                                        @case('accepted')
                                        <span class="badge badge-secondary">Прийнято</span>
                                        @break

                                        @case('executed')
                                        <span class="badge badge-primary">Викноується</span>
                                        @break

                                        @case('done')
                                        <span class="badge badge-success">Виконано</span>
                                        @break
                                    @endswitch
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <a href="#" class="px-2" data-bs-toggle="dropdown">
                                        <i class="feather icon-more-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="{{ route('amicms::orders.view', ['order_id'=>$order->id]) }}" class="dropdown-item">
                                                    <div class="d-flex align-items-center">
                                                        <i class="feather icon-user-plus"></i>
                                                        <span class="ms-2">Переглянути запис</span>
                                                    </div>
                                                </a>
                                            </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>

                <div class="d-flex justify-content-end pagination">
                    {!! $orders_array->withQueryString()->links('amicms._partials.paginate') !!}
                </div>



            </div>
        </div>
    </div>
@endsection


