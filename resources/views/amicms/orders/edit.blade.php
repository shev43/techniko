@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="col">
                    <div class="card-body">
                        <form action="{{route('amicms::orders.update',['order_id' => $order->id])}}" method="post">
                            @csrf
                            <div class="mb-4 d-md-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Замовлення</h4>
                                    <p>Основна інформація в цьому обліковому записі.</p>
                                </div>
                                <button class="btn btn-outline-primary" type="submit">Зберегти зміни</button>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="row mt-4">
                                        <div class="col-md-6 mb-3">
                                            <h5 class="fw-bold mt-2">Замовлення</h5>

                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <th class="py-4">Дата доставки</th>
                                                    <td class="py-4">
                                                        <input type="text" name="end_date_of_delivery"
                                                               value="{{\Carbon\Carbon::parse($order->end_date_of_delivery)->format('d.m.Y')  ?? old('end_date_of_delivery', '')}}"
                                                               class="form-control">
                                                        @foreach($errors->get('end_date_of_delivery') as $error)
                                                            <small class="form-text text-danger">{!! $error !!}</small>
                                                        @endforeach
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th class="py-4">Кількість</th>
                                                    <td class="py-4">
                                                        <input type="number" name="count" value="{{$order->count ?? old('count', '')}}"
                                                               class="form-control">
                                                        @foreach($errors->get('count') as $error)
                                                            <small class="form-text text-danger">{!! $error !!}</small>
                                                        @endforeach
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th class="py-4">Орієнтовна вартість<br>(від - до)</th>
                                                    <td class="py-4">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <input type="number" name="min_price"
                                                                       value="{{$order->min_price  ?? old('min_price', '')}}"
                                                                       class="form-control" min="1" max="9999" step="1">
                                                                @foreach($errors->get('min_price') as $error)
                                                                    <small class="form-text text-danger">{!! $error !!}</small>
                                                                @endforeach
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <input type="number" name="max_price"
                                                                       value="{{$order->max_price  ?? old('max_price', '')}}"
                                                                       class="form-control" min="1" max="9999" step="1">
                                                                @foreach($errors->get('max_price') as $error)
                                                                    <small class="form-text text-danger">{!! $error !!}</small>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th class="py-4">Тип доставки</th>
                                                    <td class="py-4">
                                                        <select name="type_of_delivery"
                                                                class="form-select">
                                                            <option value="self" {{$order->type_of_delivery == 'self' ? 'selected' : ''}}>Самовивіз</option>
                                                            <option value="business" {{$order->type_of_delivery == 'business' ? 'selected' : ''}}>Доставка
                                                                виробником
                                                            </option>
                                                        </select>
                                                        @foreach($errors->get('type_of_delivery') as $error)
                                                            <small class="form-text text-danger">{!! $error !!}</small>
                                                        @endforeach
                                                    </td>
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
                                                    <td class="py-4">
                                                        <input type="text" id="contact_first_name" name="contact_first_name"
                                                               value="{{$order->first_name ?? old('contact_first_name', '')}}"
                                                               class="form-control">
                                                        @foreach($errors->get('contact_first_name') as $error)
                                                            <small class="form-text text-danger">{!! $error !!}</small>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="py-4">Прізвище</th>
                                                    <td class="py-4">
                                                        <input type="text" id="contact_last_name" name="contact_last_name"
                                                               value="{{$order->last_name ?? old('contact_last_name', '')}}"
                                                               class="form-control">
                                                        @foreach($errors->get('contact_last_name') as $error)
                                                            <small class="form-text text-danger">{!! $error !!}</small>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="py-4">Телефон</th>
                                                    <td class="py-4">
                                                        <input type="text" id="contact_phone" name="contact_phone"
                                                               value="{{$order->phone  ?? old('contact_phone', '')}}"
                                                               class="form-control">
                                                        @foreach($errors->get('contact_phone') as $error)
                                                            <small class="form-text text-danger">{!! $error !!}</small>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="py-4">Адреса</th>
                                                    <td class="py-4">
                                                        <input type="text" id="address" class="autocomplete form-control" name="address" value="{{$order->address  ?? old('address', '')}}">
                                                        <div class="invalid-feedback"></div>

                                                        @foreach($errors->get('address') as $error)
                                                            <small class="form-text text-danger">{!! $error !!}</small>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            @include('frontend._modules.map-form', ['objects'=>$order, 'target'=>'form input[name=address]'])

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




