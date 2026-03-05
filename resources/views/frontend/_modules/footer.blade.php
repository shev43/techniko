    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-2 align-self-center text-center text-md-left">
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
            <div class="col-12 col-md-4 align-self-center text-center text-md-left">
                <ul class="footer-nav footer-nav--inline">
                    <li>
                        <a href="tel:+380967790361" class="footer-contact">
                            <svg class="icon">
                                <use xlink:href="#icon-10"></use>
                            </svg>
                            <span>096 779-03-61</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#contact_usModal" class="footer-contact">
                            <svg class="icon">
                                <use xlink:href="#icon-11"></use>
                            </svg>
                            <span>Написати нам</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-3 text-center text-md-left">
                <ul class="footer-nav">
                    <li>
                        <a href="{{ route('frontend::catalog.index', ['lang'=>app()->getLocale()]) }}" class="footer-link">Клієнтам</a>
                    </li>
                    <li>
                        <a href="{{ route('business.profile.register-form', ['lang'=>app()->getLocale()]) }}" class="footer-link">Продавцям</a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-3 text-center text-md-left">
                <ul class="footer-nav">
                    <li>
                        <a href="{{ route('frontend::policy', ['lang'=>app()->getLocale()]) }}" class="footer-link">Політика конфіденційності</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend::policy', ['lang'=>app()->getLocale()]) }}" class="footer-link">Умови використання</a>
                    </li>
                </ul>
            </div>
            <div class="col-12 text-center text-md-right copyright">
                <p>&copy;{{ date("Y") }}. Techniko Ukraine. All Rights Reserved</p>
            </div>
        </div>
    </div>
