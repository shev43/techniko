@extends('layouts.app')

@section('content')

    <main class="main">
        <section class="heroslide">
            <figure class="heroslide-video">
                <div class="mobile" style="background-image: url({{ asset('img/homepage/heroslide.png') }});" alt=""></div>
            </figure>
            <div class="container position-relative">
                <h1 class="heroslide-title">
                    <span>ТехніКо</span>
                </h1>
                <div class="heroslide-text">
                    <p>Оренда техніки за кращими цінами в твоєму регіоні</p>
                </div>
                @if(Auth::guard('business')->check())
                    <a href="{{ route('business::catalog.index', ['lang'=>app()->getLocale()]) }}" class="btn btn-default">Замовити</a>
                @elseif(Auth::guard('customer')->check())
                    <a href="{{ route('customer::catalog.index', ['lang'=>app()->getLocale()]) }}" class="btn btn-default">Замовити</a>
                @else
                    <a href="{{ route('frontend::catalog.index', ['lang'=>app()->getLocale()]) }}" class="btn btn-default">Замовити</a>
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
                    <svg class="s_hiw-item-sep">
                        <use xlink:href="#icon-right"></use>
                    </svg>
                    <div class="s_hiw-item">
                        <svg class="s_hiw-item-icon">
                            <use xlink:href="#icon-2"></use>
                        </svg>
                        <h3 class="s_hiw-item-title">Підберіть найкращу зустрічну пропозицію</h3>
                    </div>
                    <svg class="s_hiw-item-sep">
                        <use xlink:href="#icon-right"></use>
                    </svg>
                    <div class="s_hiw-item">
                        <svg class="s_hiw-item-icon s_hiw-item-icon--calendar">
                            <use xlink:href="#icon-3"></use>
                        </svg>
                        <h3 class="s_hiw-item-title">Дочекайтесь виконання замовлення</h3>
                    </div>
                </div>
            </div>
        </section>
        <section class="s_ww" style="background-image: linear-gradient(90deg, rgba(0,0,0,.65), rgba(0,0,0,.65) 100%), url({{ asset('img/homepage/bg.jpg') }});">
            <div class="container">
                <h2 class="title">Чому саме ТехніКо?</h2>
                <div class="row justify-content-center justify-content-md-between">
                    <div class="col-10 col-md-4 col-xl-3">
                        <div class="s_ww-item">
                            <h3 class="heading">
                                Орендуйте за вигідними цінами
                            </h3>
                            <div class="text-justify">
                                <p>Платформа створена як бізнес-площадка для всіх хто здає в оренду спецтехніку в межах України. Це створить відкриту цінову політику, що є прерогативою кращих пропозицій.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-10 col-md-4 col-xl-3">
                        <div class="s_ww-item">
                            <h3 class="heading">
                                Тільки перевірені продавці
                            </h3>
                            <div class="text-justify">
                                <p>Сайт створений як каталог пропозицій оренди спецтехніки що робить його зрозумілим інструментом для орендарів — весь ринок оренди спецтехніки України на одній платформі.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-10 col-md-4 col-xl-3">
                        <div class="s_ww-item">
                            <h3 class="heading">
                                Продавець сам знайде вас
                            </h3>
                            <div class="text-justify">
                                <p>На сайті в кожній пропозиції є всі необхідні шляхи для контактування з орендодавцем, тому шлях до бажаного є максимально швидким.</p>
                            </div>
                        </div>
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
                                <h2 class="title">Вигоди покупця:</h2>
                                <ul class="s_benefits-item-list">
                                    <li>Швидке оформлення</li>
                                    <li>Вибір вигідних пропозицій</li>
                                    <li>Перевірені виробники</li>
                                </ul>
                                <div class="text-center text-md-left">
                                    <a href="{{ route('frontend::catalog.index', ['lang'=>app()->getLocale()]) }}" class="btn btn-default">Замовити</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-10 col-md-5 col-lg-4 ml-md-auto mx-lg-auto">
                        <div class="s_benefits-item s_benefits-item--light">
                            <div class="position-relative">
                                <h2 class="title">Вигоди продавця:</h2>
                                <ul class="s_benefits-item-list">
                                    <li>Швидке оформлення</li>
                                    <li>Вибір вигідних пропозицій</li>
                                    <li>Перевірені виробники</li>
                                </ul>
                                <div class="text-center text-md-left">
                                    <a href="{{ route('business.profile.register-form', ['lang'=>app()->getLocale()]) }}" class="btn btn-border_light">Здавати в оренду</a>
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
                            <div class="collapse" id="faq1">
                                <div class="s_faq-item-body">
                                    <p>
                                        <ol>
                                            <li><b>Головна сторінка</b> — натисніть кнопку "Замовити"</li><br>
                                            <li><b>Каталог</b> — оберіть вид спецтехніки за параметрами</li><br>
                                            <li><b>Деталі пропозиції</b> — якщо умови оренди техніки влаштовують, оформіть замовлення або скористайтесь контактами власника техніки.</li><br>
                                        </ol>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="s_faq-item">
                            <a class="s_faq-item-title collapsed" data-toggle="collapse" href="#faq2" role="button" aria-expanded="false" aria-controls="faq2">
                                <span>А чому в вас?</span>
                                <figure>
                                    <svg class="icon">
                                        <use xlink:href="#icon-5"></use>
                                    </svg>
                                </figure>
                            </a>
                            <div class="collapse" id="faq2">
                                <div class="s_faq-item-body">
                                    <p>
                                        <b>Techniko</b> — це сайт-платформа для оренди спецтехніки. Швидкий та зручний моніторинг асортименту та цін, проведення замовлення без додаткових комісій.<br><br>
                                        Ми визначили потребу в глобальному маркетплейсі де можна стежити за асортиментом спецтехніки, актуальними цінами й отримувати швидкий доступ до послуг оренди.<br><br>
                                        Понад 10,000 одиниць спецтехніки з цілої України на одній платформі. На основі роботи з фідбеком користувачів сервіс буде покращуватись і оптимізовуватись, щоб стати найзручнішим хабом для орендодавців та орендаторів.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="s_faq-item">
                            <a class="s_faq-item-title collapsed" data-toggle="collapse" href="#faq3" role="button" aria-expanded="false" aria-controls="faq3">
                                <span>Ви берете комісію?</span>
                                <figure>
                                    <svg class="icon">
                                        <use xlink:href="#icon-5"></use>
                                    </svg>
                                </figure>
                            </a>
                            <div class="collapse" id="faq3">
                                <div class="s_faq-item-body">
                                    <p><b>Основні послуги сайту є безкоштовні для всіх користувачів.</b> Невдовзі будуть доступні додаткові послуги на сайті (виключно для власників спецтехніки) які не є обов'язковими, однак можуть служити допоміжними інструментами в просуванні бізнесу та збільшенні заявок на оренду.</p>
                                </div>
                            </div>
                        </div>
                        <div class="s_faq-item">
                            <a class="s_faq-item-title collapsed" data-toggle="collapse" href="#faq4" role="button" aria-expanded="false" aria-controls="faq4">
                                <span>Як замовити?</span>
                                <figure>
                                    <svg class="icon">
                                        <use xlink:href="#icon-5"></use>
                                    </svg>
                                </figure>
                            </a>
                            <div class="collapse" id="faq4">
                                <div class="s_faq-item-body">
                                    <p>
                                        <ul>
                                            <li>Сайт-платформа реалізований таким чином щоб створити зручний сервіс для моніторингу цін на оренду спецтехніки.</li><br>
                                            <li>Сервіс служить площадкою для ведення бізнесу в галузі оренди спецтехніки.</li><br>
                                            <li>Користувач з легкістю отримує інформацію про асортимент, ціни та контакт з орендодавцями.</li><br>
                                            <li>Сайт-платформа допоможе знаходити спецтехніку для будь-яких робіт в декілька кліків.</li>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


@endsection
