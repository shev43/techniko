@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">

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

                        <div class="row">
                            <div class="col">
                                <div id="chart"></div>
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
                    name: 'Нові користувачі',
                    data: [{
                        x: '',
                        y: '{{ $business_register_views }}',
                    }]
                },

                {
                    name: 'Перехід у пропозицію',
                    data: [{
                        x: '',
                        y: '{{ $offer_views }}',
                    }]
                },

                {
                    name: 'Перехід у профіль представника',
                    data: [{
                        x: '',
                        y: '{{ $business_profile_views }}',
                    }]
                },

                {
                    name: 'Перегляд email',
                    data: [{
                        x: '',
                        y: '{{ $email_views }}',
                    }]
                },

                {
                    name: 'Перегляд номеру тел',
                    data: [{
                        x: '',
                        y: '{{ $phone_views }}',
                    }]
                },

                {
                    name: 'Перехід на сайт',
                    data: [{
                        x: '',
                        y: '{{ $www_views }}',
                    }]
                },

                {
                    name: 'Перегляд контактної особи',
                    data: [{
                        x: '',
                        y: '{{ $contact_person_phone_views }}',
                    }]
                },


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
