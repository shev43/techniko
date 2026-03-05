@extends('layouts.app')

@section('content')
    <script src="/amicms/vendors/apexcharts/dist/apexcharts.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

    <main class="main page">
        <nav class="container mb-5" aria-label="breadcrumb">
            <ol class="breadcrumb">
                @if(Auth::guard('business')->check())
                    <li class="breadcrumb-item"><a href="{{ route('business::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
                @elseif(Auth::guard('customer')->check())
                    <li class="breadcrumb-item"><a href="{{ route('customer::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
                @else
                    <li class="breadcrumb-item"><a href="{{ route('frontend::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">Статистика</li>
            </ol>
        </nav>

        <div class="container">

            <section class="seller_cabinet-proposals">
                <div class="row mb-4 mb-md-auto">
                    <div class="col-12 col-md-4">
                        <h2 class="title">Статистика:</h2>
                    </div>
                    <div class="col-12 col-md-8">
                        <form id="formStatFilter" action="" method="get">
                            <div class="row mb-4 d-flex justify-content-end">
                                <div class="col-12 col-md-5">
                                    <input type="text" id="period" name="period" class="form-control" value="{{ !empty($startDate) ? $startDate : '' }} - {{ !empty($endDate) ? $endDate : '' }}">
                                    <a class="btnStatFilter" href="#">
                                        <svg class="form-icon" style="left: initial; right: 0px;">
                                            <use xlink:href="#icon-filter"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="blocklist">
                    <div class="row border-bottom mb-5">
                        <div class="col-12">
                            <div id="chart_total"></div>
                        </div>
                    </div>

                    @foreach($reports_array as $report_key => $report)

                        <div class="row border-bottom pb-4 mb-4">
                            <div class="col-12 col-md-4">
                                <div class="mb-3"><h5>{{ $report['name'] }}</h5></div>
                                <img src="{{ asset('storage/technics/' . $report['photo'] ) }}" alt="" style="width:100%;height: auto;">
                            </div>
                            <div class="col-12 col-md-8">
                                <div id="chart_{{ $report_key }}" style="min-width: 100%"></div>

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

                            </div>
                        </div>


                        @endforeach

                </div>

            </section>
        </div>
    </main>
@endsection





@section('styles')
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('amicms/vendors/daterangepicker-master/daterangepicker.css') }}">
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



        var options_total = {
            series: [
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

        var chart = new ApexCharts(document.querySelector("#chart_total"), options_total);

        chart.render();

    </script>


@endsection
