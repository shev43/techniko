@extends('layouts.amicms.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th width="100">#</th>
                        <th>Бізнес</th>
                        <th>Власник</th>
                        <th width="50" class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($business_array as $business)
                        <tr>
                            <td class="text-center">{{ $business->business_number }}</td>
                            <td>
                                <div class="text-dark fw-bold text-nowrap">{{ $business->name }}</div>
                                <div class="text-muted mt-2">{{ $business->phoneFormatted }}</div>
                                <div class="text-muted mt-2">{{ $business->email }}</div>
                            </td>
                            <td>
                                <div class="text-dark fw-bold">{{ $business->seller->first_name }} {{ $business->seller->last_name }}</div>
                                <div class="text-muted mt-2">{{ $business->seller->phoneFormatted }}</div>
                                <div class="text-muted mt-2">{{ $business->seller->email }}</div>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <a href="#" class="px-2" data-bs-toggle="dropdown">
                                        <i class="feather icon-more-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{ route('amicms::subscription.view', ['business_id'=>$business->id]) }}" class="dropdown-item">
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
                    {!! $business_array->withQueryString()->links('amicms._partials.paginate') !!}
                </div>


            </div>
        </div>
    </div>
@endsection









