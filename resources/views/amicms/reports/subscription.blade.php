@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Статистика</h4>
                    @include('amicms.reports._partial.navbar')

                </div>
                <div class="col">
                    <div class="card-body">
                        <form action="" method="get">
                            <div class="row mb-4 justify-content-end">
                                <div class="col-6">
                                    <input type="text" id="period" name="period" class="form-control">
                                </div>
                                <div class="col-1">
                                    <button class="btn" type="submit">
                                        <i class="icon-filter feather"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="row mb-5">
                            <div class="col-6"><strong>Кількість активних пакетів:</strong> {{ $historyPackage['total_active_package'] }}</div>
                            <div class="col-6"><strong>Кількість активних слотів:</strong> {{ $historySlot['total_active_slot'] }}</div>
                            <div class="col-6"><strong>Кількість неактивних пакетів:</strong> {{ $historyPackage['total_deactive_package'] }}</div>
                            <div class="col-6"><strong>Кількість неактивних слотів:</strong> {{ $historySlot['total_deactive_slot'] }}</div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div id="chart"></div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Платник</th>
                                        <th>Статус</th>
                                        <th class="text-center">Сума</th>
                                        <th class="text-center">Створено</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($histories) > 0)
                                        @foreach($histories as $history)
                                            <tr>
                                                <td>{{ $history->order_number }}</td>
                                                <td>
                                                    <div class="text-dark fw-bold"><a href="{{ route('amicms::business.company.index', ['business_id'=>$history->business->id]) }}" target="_blank">{{ $history->business->seller->first_name }} {{ $history->business->seller->last_name }} ({{ $history->business->name }})</a></div>
                                                </td>
                                                <td>
                                                    @if($history->type == 'package')
                                                        @if($history->status == 'Approved')
                                                            <span><strong>Експерт план</strong><div class="text-success mt-2">активовано до {{ \Carbon\Carbon::parse($history->activated_to)->format('d.m.Y') }}</div></span>
                                                        @else
                                                            <span><strong>Експерт план</strong><div class="text-danger mt-2">деактивовано</div></span>
                                                        @endif
                                                    @else
                                                        @if($history->status == 'Approved')
                                                            <span><strong>Додатковий пакет - {{ $history->count }}</strong><div class="text-success mt-2">активовано до {{ \Carbon\Carbon::parse($history->activated_to)->format('d.m.Y') }}</div></span>
                                                        @else
                                                            <span><strong>Додатковий пакет - {{ $history->count }}</strong><div class="text-danger mt-2">деактивовано</div></span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $history->price  }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($history->created_at)->format('d.m.Y H:i') }}</td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="py-4 text-center">Немає історії операцій</td>
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



@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" media="all" href="/amicms/vendors/daterangepicker-master/daterangepicker.css">
@endsection

@section('scripts')
    <script type="text/javascript" src="/amicms/vendors/daterangepicker-master/moment.min.js"></script>
    <script type="text/javascript" src="/amicms/vendors/daterangepicker-master/daterangepicker.js"></script>

    <script>
        $('#period').daterangepicker({
            "timePicker": false,
            "ranges": {
                "за сьогодні": [
                    "{{ \Carbon\Carbon::now()->format('m/d/Y') }}",
                    "{{ \Carbon\Carbon::now()->format('m/d/Y') }}"
                ],
                "за тиждень": [
                    "{{ \Carbon\Carbon::now()->subDays(7)->format('m/d/Y') }}",
                    "{{ \Carbon\Carbon::now()->format('m/d/Y') }}"
                ],
                "за місяць": [
                    "{{ \Carbon\Carbon::now()->subMonth()->format('m/d/Y') }}",
                    "{{ \Carbon\Carbon::now()->format('m/d/Y') }}"
                ],
                "за рік": [
                    "{{ \Carbon\Carbon::now()->subMonth(12)->format('m/d/Y') }}",
                    "{{ \Carbon\Carbon::now()->format('m/d/Y') }}"
                ],

            },
            "startDate": "{{ (request()->get('period')) ? \Carbon\Carbon::parse($startDate)->format('m/d/Y') : \Carbon\Carbon::now()->subDays(7)->format('m/d/Y') }}",
            "endDate": "{{ (request()->get('period')) ? \Carbon\Carbon::parse($endDate)->format('m/d/Y') : \Carbon\Carbon::now()->format('m/d/Y') }}",
        }, function(start, end, label) {
            // $('input[name=period]').val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            // console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
        });

    </script>

    <!-- page js -->
    <script src="/amicms/vendors/apexcharts/dist/apexcharts.min.js"></script>
    <script>
        var options = {
            series: [
                {
                    name: 'Пакети ({{ $historyPackage['total_package'] ?? '0' }})',
                    data: [{
                        x: '',
                        y: '{{ $historyPackage['paid_package'] }}',
                    }

                    ]
                },

                {
                    name: 'Слоти ({{ $historySlot['total_slot'] ?? '0' }})',
                    data: [ {
                        x: '',
                        y: '{{ $historySlot['paid_slot'] }}',

                    }

                    ]
                }

            ],
            chart: {
                height: 350,
                type: 'bar'
            },



        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>

@endsection
