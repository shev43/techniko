@extends('layouts.app')

@section('content')
    <main class="main">
        <section class="heroslide">
            <figure class="heroslide-video">
                <div class="mobile" style="background-image: url({{ asset('img/layout/homepage/home.jpg') }});" alt=""></div>
            </figure>
            <div class="container position-relative">
                <h1 class="heroslide-title">Betonko</h1>
                <div class="heroslide-text">
                    <p>Якісний бетон від виробників за кращими цінами в твоєму регіоні</p>
                </div>

                @if(Auth::guard('client')->check())
                    <a href="{{ route('customer::catalog.index', ['lang'=>\Illuminate\Support\Facades\App::getLocale()]) }}" class="btn btn-default heroslide-btn">Пошук</a>
                @elseif(Auth::guard('business')->check())
                    <a href="{{ route('business::catalog.index', ['lang'=>\Illuminate\Support\Facades\App::getLocale()]) }}" class="btn btn-default heroslide-btn">Пошук</a>
                @else
                    <a href="{{ route('frontend::catalog.index', ['lang'=>\Illuminate\Support\Facades\App::getLocale()]) }}" class="btn btn-default heroslide-btn">Пошук</a>
                @endif


            </div>
        </section>
        <section class="s_hiw">
            <div class="container">
                <h2 class="title s_hiw-title">Як ми працюємо:</h2>
                <div class="s_hiw-items">
                    <div class="s_hiw-item">
                        <svg class="s_hiw-item-icon">
                            <use xlink:href="#icon-1"></use>
                        </svg>
                        <h3 class="s_hiw-item-title">Виберіть параметри та оформіть замовлення</h3>
                    </div>
                    <img class="s_hiw-item-sep" src="{{ asset('img/layout/icon-right.svg') }}" alt="">
                    <div class="s_hiw-item">
                        <svg class="s_hiw-item-icon">
                            <use xlink:href="#icon-2"></use>
                        </svg>
                        <h3 class="s_hiw-item-title">Підберіть найкращу зустрічну пропозицію від виробників</h3>
                    </div>
                    <img class="s_hiw-item-sep" src="{{ asset('img/layout/icon-right.svg') }}" alt="">
                    <div class="s_hiw-item">
                        <svg class="s_hiw-item-icon s_hiw-item-icon--calendar">
                            <use xlink:href="#icon-3"></use>
                        </svg>
                        <h3 class="s_hiw-item-title">Дочекайтеся виконання замовлення</h3>
                    </div>
                </div>
            </div>
        </section>
        <section class="s_benefits">
            <div class="container">
                <div class="row justify-content-center justify-content-md-start">
                    <div class="col-10 col-md-5 col-lg-4 mr-md-auto mx-lg-auto">
                        <div class="s_benefits-item s_benefits-item--dark">
                            <div class="position-relative">
                                <h2 class="title">Переваги покупця:</h2>
                                <ul class="s_benefits-item-list">
                                    <li>Швидке оформлення</li>
                                    <li>Вибір вигідних пропозицій</li>
                                    <li>Перевірені виробники</li>
                                </ul>
                                <div class="text-center text-md-left">
                                    @if(Auth::guard('business')->check())
                                        <a href="{{ route('business::catalog.index', ['lang'=>app()->getLocale()]) }}" class="btn btn-default">Замовити</a>
                                    @elseif(Auth::guard('client')->check())
                                        <a href="{{ route('customer::catalog.index', ['lang'=>app()->getLocale()]) }}" class="btn btn-default">Замовити</a>
                                    @else
                                        <a href="{{ route('frontend::catalog.index', ['lang'=>app()->getLocale()]) }}" class="btn btn-default">Замовити</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-10 col-md-5 col-lg-4 ml-md-auto mx-lg-auto">
                        <div class="s_benefits-item s_benefits-item--light">
                            <div class="position-relative">
                                <h2 class="title">Переваги продавця:</h2>
                                <ul class="s_benefits-item-list">
                                    <li>Швидкі продажі</li>
                                    <li>Автоматизація процесів</li>
                                    <li>Цифрова документація</li>
                                </ul>
                                <div class="text-center text-md-left">
                                    <a href="{{ route('business::profile.register', ['lang'=>app()->getLocale()]) }}" class="btn btn-border_light" style="color: #fff;">Стати партнером</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="s_faq">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-10">
                        <h2 class="title">Часті запитання:</h2>
                        <div class="s_faq-item">
                            <a class="s_faq-item-title collapsed" data-toggle="collapse" href="#faq1" role="button" aria-expanded="false" aria-controls="faq1">
                                <span>Як замовити?</span>
                                <figure>
                                    <svg class="icon">
                                        <use xlink:href="#icon-5"></use>
                                    </svg>
                                </figure>
                            </a>
                            <div class="collapse s_faq-item-body" id="faq1">
                                <div class="s_faq-item-content">
                                    <p>Все дуже просто! Якщо ви бажаєте придбати бетон варто натиснути кнопку "Пошук" на головній сторінці, обрати за бажанням характеристики, тоді обрати найкращу пропозицію. Для оформлення замовлення треба заповнити контактні дані, зазначити місце доставки або самовивіз, вказати бажану дату отримання та коментар до замовлення. Це все! Ваше замовлення в обробці, очікуйте зворотнього зв'язку від продавця.</p>
                                </div>
                            </div>
                            <div class="s_faq-item-shadow"></div>
                        </div>
                        <div class="s_faq-item">
                            <a class="s_faq-item-title collapsed" data-toggle="collapse" href="#faq2" role="button" aria-expanded="false" aria-controls="faq2">
                                <span>Чому саме у вас?</span>
                                <figure>
                                    <svg class="icon">
                                        <use xlink:href="#icon-5"></use>
                                    </svg>
                                </figure>
                            </a>
                            <div class="collapse s_faq-item-body" id="faq2">
                                <div class="s_faq-item-content">
                                    <p>Бетонко - це платформа для покупки та продажу бетону, тут все так влаштовано, щоб покупець отримав найкращу пропозицію на ринку, а продавець зручно і швидко здійснював продажі, а саме головне - це можливість обирати!</p>
                                </div>
                            </div>
                            <div class="s_faq-item-shadow"></div>
                        </div>
                        <div class="s_faq-item">
                            <a class="s_faq-item-title collapsed" data-toggle="collapse" href="#faq3" role="button" aria-expanded="false" aria-controls="faq3">
                                <span>Чи берете ви комісію?</span>
                                <figure>
                                    <svg class="icon">
                                        <use xlink:href="#icon-5"></use>
                                    </svg>
                                </figure>
                            </a>
                            <div class="collapse s_faq-item-body" id="faq3">
                                <div class="s_faq-item-content">
                                    <p>Платформа є безкоштовною для всіх користувачів! Якщо ви продавець і бажаєте збільшити свої продажі то для вас ми пропонуємо пакет "Бетонко Експерт" - це набір додаткових функцій для виділення вашого продукту серед інших. Детальніше про пакет
                                        @if(Auth::guard('business')->check())
                                            <a href="{{ route('business::subscription.index', ['lang'=>app()->getLocale(), 'referer'=>'true']) }}">"Бетонко Експерт"</a>
                                        @else
                                            <a href="{{ route('frontend::subscription.index', ['lang'=>app()->getLocale(), 'referer'=>'true']) }}">"Бетонко Експерт"</a>
                                        @endif
                                        тут.</p>
                                </div>
                            </div>
                            <div class="s_faq-item-shadow"></div>
                        </div>
                        <div class="s_faq-item">
                            <a class="s_faq-item-title collapsed" data-toggle="collapse" href="#faq4" role="button" aria-expanded="false" aria-controls="faq4">
                                <span>Як стати партнером?</span>
                                <figure>
                                    <svg class="icon">
                                        <use xlink:href="#icon-5"></use>
                                    </svg>
                                </figure>
                            </a>
                            <div class="collapse s_faq-item-body" id="faq4">
                                <div class="s_faq-item-content">
                                    <p>Якщо ви вирішили вивести свої продажі на новий рівень тоді для реєстрації вам потрібно всього електронну адресу! Реєструйтесь, заповніть профіль компанії, контактні дані, заповніть дані про завод(-и), дані контактної(-их) особи(-іб), додайте ваші продукти. Все, ви готові для торгівлі!</p>
                                </div>
                            </div>
                            <div class="s_faq-item-shadow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
