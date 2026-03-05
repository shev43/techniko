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
                            <div class="row mb-4">
                                <div class="col">
                                    <select class="selectpicker" name="machines[]" title="Вид техніки" data-style="form-select" multiple>
                                        @foreach($machines as $machine)
                                        <option value="{{ $machine->id }}" @if(!empty($machinesImp)){{ in_array($machine->id, explode(',', $machinesImp)) ? "selected": "" }}@endif>{{ $machine->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">

                                    <input type="text" id="period" name="period" class="form-control">


{{--                                    <select class="selectpicker" name="period" title="Оберіть період" data-style="form-select">--}}
{{--                                        <option value="{{ \Carbon\Carbon::parse('now')->format('Y-m-d') }} - {{ \Carbon\Carbon::parse('now')->format('Y-m-d') }}" {{  \Carbon\Carbon::parse('now')->format('Y-m-d') .' - '. \Carbon\Carbon::parse('now')->format('Y-m-d') == request()->get('period')  ? "selected": "" }}>за день</option>--}}
{{--                                        <option value="{{ \Carbon\Carbon::now()->subDays(7)->format('Y-m-d') }} - {{ \Carbon\Carbon::parse('now')->format('Y-m-d') }}" {{  \Carbon\Carbon::now()->subDays(7)->format('Y-m-d') .' - '. \Carbon\Carbon::parse('now')->format('Y-m-d') == request()->get('period')  ? "selected": "" }}>за тиждень</option>--}}
{{--                                        <option value="{{ \Carbon\Carbon::now()->subMonth()->format('Y-m-d') }} - {{ \Carbon\Carbon::parse('now')->format('Y-m-d') }}" {{  \Carbon\Carbon::now()->subMonth()->format('Y-m-d') .' - '. \Carbon\Carbon::parse('now')->format('Y-m-d') == request()->get('period')  ? "selected": "" }}>за місяць</option>--}}
{{--                                        <option value="{{ \Carbon\Carbon::now()->subMonth(12)->format('Y-m-d') }} - {{ \Carbon\Carbon::parse('now')->format('Y-m-d') }}" {{  \Carbon\Carbon::now()->subMonth(12)->format('Y-m-d') .' - '. \Carbon\Carbon::parse('now')->format('Y-m-d') == request()->get('period')  ? "selected": "" }}>за рік</option>--}}
{{--                                    </select>--}}
                                </div>
                                <div class="col-1">
                                    <button class="btn" type="submit">
                                        <i class="icon-filter feather"></i>
                                    </button>
                                </div>
                            </div>
                        </form>


                        <div class="row">
                            <div class="col">
                                <div id="chart"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <table class="table table-bordered">
                                    <thead>
                                        <th class="py-4">Вид техніки</th>
                                        <th class="py-4">Створені</th>
                                        <th class="py-4">Підтвердженні</th>
                                        <th class="py-4">Завершені</th>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->machine->title }}</td>
                                            <td>{{ $order->total_new }}</td>
                                            <td>{{ $order->total_accepted }}</td>
                                            <td>{{ $order->total_done }}</td>
                                        </tr>
                                    @endforeach
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
        const basicOptions = {



            series: [
                {
                    name: "Створені",
                    data: [
                            @foreach($orders as $order)
                        {
                            x: '{{ $order->machine->title }}',
                            y: [{{ $order->total_new }}],
                            goals: [
                                {
                                    name: 'Expected',
                                    value: 1400,
                                    strokeHeight: 5,
                                    strokeColor: '#775DD0'
                                }
                            ]
                        },
                        @endforeach
                    ],
                },
                {
                    name: "Підтвердженні",
                    data: [
                            @foreach($orders as $order)
                        {
                            x: '{{ $order->machine->title }}',
                            y: [{{ $order->total_accepted }}],
                            goals: [
                                {
                                    name: 'Expected',
                                    value: 1400,
                                    strokeHeight: 5,
                                    strokeColor: '#775DD0'
                                }
                            ]
                        },
                        @endforeach
                    ],
                },
                {
                    name: "Завершені",
                    data: [
                            @foreach($orders as $order)
                        {
                            x: '{{ $order->machine->title }}',
                            y: [{{ $order->total_done }}],
                            goals: [
                                {
                                    name: 'Expected',
                                    value: 1400,
                                    strokeHeight: 5,
                                    strokeColor: '#775DD0'
                                }
                            ]
                        },
                        @endforeach
                    ],
                },
            ],
            chart: {
                type: 'area',
                stacked: false,
                height: 350,
                zoom: {
                    enabled: true
                },
                animations: {
                    enabled: true
                }
            },


            markers: {
                size: 6,
                hover: {
                    sizeOffset: 2
                }
            },

            dataLabels: {
                enabled: true
            },


            stroke: {
                width: [2,3,4],
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },

            yaxis: {
                title: {
                    text: 'Кількість заявок'
                },
                labels: {
                    formatter: function (val) {
                        return val.toFixed(0)
                    }
                }
            },

            legend: {
                show: false,
            },

            xaxis: {
                title: {
                    text: 'Вид техніки'
                },

            },


            title: {
                text: 'Звіт за період: {{ request()->get('period') ? \Carbon\Carbon::parse($startDate)->format('d-m-Y') . ' - ' . \Carbon\Carbon::parse($endDate)->format('d-m-Y') :  "весь" }}',
                align: 'left',
                offsetX: 20
            },
        };

        // var url = 'http://my-json-server.typicode.com/apexcharts/apexcharts.js/yearly';
        //
        // $.getJSON(url, function(response) {
        //     chart.updateSeries([{
        //         name: 'Sales',
        //         data: response
        //     }])
        // });


        var chart = new ApexCharts(document.querySelector("#chart"), basicOptions);

        chart.render();
    </script>

@endsection
