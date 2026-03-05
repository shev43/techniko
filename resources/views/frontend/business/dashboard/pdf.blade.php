<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<script src="/amicms/vendors/apexcharts/dist/apexcharts.min.js"></script>

<header class="header">
    <div class="container d-flex justify-content-center">
        <div class="header-body">
            <div class="header-logo">
                        @include('frontend._modules.logo')
            </div>

        </div>
    </div>


</header>
    <main class="main page">
        <div class="container">

            <section class="seller_cabinet-proposals">
                <div class="row mb-4 mb-md-auto">
                    <div class="col-12">
                        <h2 class="title">Статистика за період: {{ \Carbon\Carbon::now()->startOfMonth()->format('d.m.Y') }} - {{ \Carbon\Carbon::now()->endOfMonth()->format('d.m.Y') }}</h2>
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






    <script>

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
