    <div class="container">
        <div class="header-body">
            <div class="header-logo">
                @if(Auth::guard('business')->check())
                    <a href="{{ route('business::pages.index', ['lang'=>app()->getLocale()]) }}" class="logo-title">
                        @include('frontend._modules.logo')
                    </a>
                @elseif(Auth::guard('customer')->check())
                    <a href="{{ route('customer::pages.index', ['lang'=>app()->getLocale()]) }}" class="logo-title">
                        @include('frontend._modules.logo')
                    </a>
                @else
                    <a href="{{ route('frontend::pages.index', ['lang'=>app()->getLocale()]) }}" class="logo-title">
                        @include('frontend._modules.logo')
                    </a>
                @endif
            </div>

            @if(Auth::guard('customer')->check() || Auth::guard('business')->check())

                @if(Auth::guard('customer')->check())
                    <button class="burger menuToggle" href="#menu">
                        <svg class="icon">
                            <use xlink:href="#icon-burger"></use>
                        </svg>
                        <span id="notificationBadge1" class="d-none badge badge-pill badge-warning position-absolute" style="margin-top: -32px;margin-left: 28px;font-size: 8px;">&nbsp;</span>
                    </button>
                    <nav class="menu" id="menu">
                        <a class="menu-item {{ (request()->routeIs('customer::catalog.*') || request()->routeIs('customer::order.index')) ? 'active' : '' }}" href="{{route('customer::catalog.index', ['lang'=>app()->getLocale()])}}"><span>Каталог</span></a>
                        <a class="menu-item {{ (request()->routeIs('customer::request.*')) || (request()->routeIs('customer::offer.*')) ? 'active' : '' }}" href="{{route('customer::request.index', ['lang'=>app()->getLocale()])}}"><span>Заявки</span></a>
                        <a class="menu-item {{ (request()->routeIs('customer::tender.*')) ? 'active' : '' }}" href="{{route('customer::tender.index', ['lang'=>app()->getLocale()])}}"><span>Тендери</span></a>
                        <a class="menu-item {{ (request()->routeIs('customer::profile.*') || request()->routeIs('customer::notifications.*')) ? 'active' : '' }}" href="{{route('customer::profile.index', ['lang'=>app()->getLocale()])}}">
                            <svg class="icon">
                                <use xlink:href="#icon-gear"></use>
                            </svg>
                            <span id="notificationBadge3" class="d-none badge badge-pill badge-warning position-absolute" style="margin-top: -30px;margin-left: 28px;font-size: 8px;">&nbsp;</span>

                            @if(!Auth::guest() && Auth::guard('customer')->check())
                                <script>
                                    var showTime = () => {
                                        $.get('/ua/customer/unread-notification').done(function (data) {
                                            if (data > 0) {
                                                $('.notification-alert strong').text(data);
                                                $('.notification-alert').removeClass('d-none');
                                                $('#notificationBadge1').removeClass('d-none');
                                                $('#notificationBadge2').removeClass('d-none');
                                                $('#notificationBadge3').removeClass('d-none');
                                                $('#notificationCount').removeClass('d-none');
                                                $('#notificationCount').text(data);
                                            } else {
                                                $('.notification-alert').addClass('d-none');
                                                $('#notificationBadge1').addClass('d-none');
                                                $('#notificationBadge2').addClass('d-none');
                                                $('#notificationBadge3').addClass('d-none');
                                                $('#notificationCount').addClass('d-none');
                                            }
                                        });

                                    };
                                </script>
                            @endif

                        </a>
                        <button class="close menuToggle" href="#menu">
                            <svg class="icon">
                                <use xlink:href="#icon-5"></use>
                            </svg>
                        </button>
                    </nav>

                    <a href="" class="header-btn" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <span>Вихід</span>
                        <svg class="icon">
                            <use xlink:href="#icon-7-1"></use>
                        </svg>
                    </a>
                    <form id="logout-form" action="{{route('customer::profile.logout', ['lang'=>app()->getLocale()])}}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endif

                @if(Auth::guard('business')->check())
                    <button class="burger menuToggle" href="#menu">
                        <svg class="icon">
                            <use xlink:href="#icon-burger"></use>
                        </svg>
                        <span id="notificationBadge1" class="d-none badge badge-pill badge-warning position-absolute" style="margin-top: -32px;margin-left: 28px;font-size: 8px;">&nbsp;</span>
                    </button>
                    <nav class="menu" id="menu">
                        <a class="menu-item {{ (request()->routeIs('business::dashboard.*')) ? 'active' : '' }}" href="{{route('business::dashboard.index', ['lang'=>app()->getLocale()])}}"><span>Статистика</span></a>
                        <a class="menu-item {{ (request()->routeIs('business::setting*')) ? 'active' : '' }}" href="{{route('business::settings.profile.index', ['lang'=>app()->getLocale()])}}">
                            <span class="d-md-none d-flex pr-2">Налаштування</span>
                            <svg class="icon">
                                <use xlink:href="#icon-gear"></use>
                            </svg>
                        </a>
                        <a href="#" class="menu-item d-md-none d-flex" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <span class="pr-2">Вихід</span>
                            <svg class="icon">
                                <use xlink:href="#icon-7-1"></use>
                            </svg>
                        </a>

                        <button class="close menuToggle" href="#menu">
                            <svg class="icon">
                                <use xlink:href="#icon-5"></use>
                            </svg>
                        </button>

                        <a href="" class="header-btn d-md-flex d-none" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <span>Вихід</span>
                            <svg class="icon">
                                <use xlink:href="#icon-7-1"></use>
                            </svg>
                        </a>

                        <form id="logout-form" action="{{route('business::profile.logout', ['lang'=>app()->getLocale()])}}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </nav>

                @endif
            @else
                <a href="{{ route('frontend::catalog.index', ['lang'=>app()->getLocale()]) }}" class="header-btn d-none d-md-flex">
                    <span>Каталог</span>
                </a>
                <a id="showAuthForm" href="#" data-toggle="modal" data-target="#authModal" class="header-btn">
                    <span>Вхід</span>
                    <svg class="icon">
                        <use xlink:href="#icon-7"></use>
                    </svg>
                </a>
            @endif

        </div>
    </div>


