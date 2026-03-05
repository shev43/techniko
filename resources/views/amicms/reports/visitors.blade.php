@extends('layouts.amicms.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="" method="get">
                <div class="row mb-4 justify-content-end">
                    <div class="col-4">
                        <input type="text" id="period" name="period" class="form-control" value="{{ !empty($startDate) ? $startDate : '' }} - {{ !empty($endDate) ? $endDate : '' }}">
                    </div>
                    <div class="col-1">
                        <button class="btn" type="submit">
                            <i class="icon-filter feather"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th width="300"></th>
                        <th ></th>
                    </tr>
                    </thead>
                    <tbody>
                    <script src="/amicms/vendors/apexcharts/dist/apexcharts.min.js"></script>

                    @foreach($reports_array as $report_key => $report)
                        <tr>
                            <td>
                                <div class="mb-3"><h5>{{ $report['name'] }}</h5></div>
                                <img src="{{ asset('storage/technics/' . $report['photo'] ) }}" alt="" style="width:100%;height: auto;"></td>
                            <td>
                                <div id="chart_{{ $report_key }}"></div>


                                <!-- page js -->
                                <script>
                                    var options = {
                                        series: [
                                            {
                                                name: 'Перехід у пропозицію',
                                                data: [{
                                                    x: '',
                                                    y: '{{ $report['offer_views'] }}',
                                                }]
                                            },

                                            {
                                                name: 'Перехід у профіль представника',
                                                data: [{
                                                    x: '',
                                                    y: '{{ $report['business_profile_views'] }}',
                                                }]
                                            },

                                            {
                                                name: 'Перегляд email',
                                                data: [{
                                                    x: '',
                                                    y: '{{ $report['email_views'] }}',
                                                }]
                                            },

                                            {
                                                name: 'Перегляд номеру тел',
                                                data: [{
                                                    x: '',
                                                    y: '{{ $report['phone_views'] }}',
                                                }]
                                            },

                                            {
                                                name: 'Перехід на сайт',
                                                data: [{
                                                    x: '',
                                                    y: '{{ $report['www_views'] }}',
                                                }]
                                            },

                                            {
                                                name: 'Перегляд контактної особи',
                                                data: [{
                                                    x: '',
                                                    y: '{{ $report['contact_person_phone_views'] }}',
                                                }]
                                            },


                                        ],
                                        chart: {
                                            height: 350,
                                            type: 'bar'
                                        },



                                    };

                                    var chart = new ApexCharts(document.querySelector("#chart_{{ $report_key }}"), options);

                                    chart.render();
                                </script>

                            </td>



{{--                            <td>{{ $report['offer_views'] ?? 0 }}</td>--}}
{{--                            <td>{{ $report['business_profile_views'] ?? 0 }}</td>--}}
{{--                            <td>{{ $report['email_views'] ?? 0 }}</td>--}}
{{--                            <td>{{ $report['phone_views'] ?? 0 }}</td>--}}
{{--                            <td>{{ $report['www_views'] ?? 0 }}</td>--}}
{{--                            <td>{{ $report['contact_person_phone_views'] ?? 0 }}</td>--}}

                        </tr>
                    @endforeach

                    </tbody>
                </table>


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


@endsection
