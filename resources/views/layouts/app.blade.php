<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>TECHNIKO - {{ $metaTags['metaTitle'] }}</title>
        <meta name="csrf-token" content="{{ @csrf_token() }}">
        <meta name="description" content="{{ $metaTags['metaDescription'] }}">
        <meta name="keywords" content="{{ $metaTags['metaKeywords'] }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="icon" href="{{ asset('favicon.png') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @yield('styles')

        <script src="{{ asset('js/app.js') }}"></script>

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-GKYQHRVN5K"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-GKYQHRVN5K');
        </script>


    </head>
    <body>
        @include('frontend._modules.icons')
        <div class="wrapper">
            <header class="header sticky-top">
                @include('frontend._modules.header')
            </header>

            <div class="content">
                @yield('content')
            </div>

            <footer class="footer">
                @include('frontend._modules.footer')
            </footer>
        </div>

        @include('frontend._modules.auth.auth')
        @include('frontend._modules.confirm-canceled-dialog')
        @include('frontend._modules.confirm-delete-dialog')
        @include('frontend._modules.confirm-subscribe-deactivate-dialog')
        @include('frontend._modules.contact_us')


        @yield('scripts')
        @yield('map_scripts')


        <script>
            var timer = setInterval(showTime, 1000);
        </script>

    </body>
</html>
