@extends('layouts.app')

@section('content')
    <section class="subscribe">
        <div class="container">
            <div class="row subscribe-item-top">
                <div class="col-12 col-md-4 d-none d-md-block">
                    <div class="subscribe-item-top-img" style="background-image: url('{{ asset('img/subscribe/img-1.png') }}');"></div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="row align-items-start subscribe-item-top-body">
                        <div class="col-12">
                            <h3><span>///</span>Бетонко Експерт</h3>
                        </div>
                        <div class="col-12 col-md-6 subscribe-item-top-body-txt">
                            <p class="subscribe-item-top-body-txt-p1">Отримайте переваги використання разом з Бетонко Експерт</p>
                        </div>
                        <div class="col-6 col-md-6 subscribe-item-top-body-txt">
                            <p class="subscribe-item-top-body-txt-p2">Не пропустіть можливість відгукуватися на заявки та продавати більше.</p>
                        </div>


                        <div class="col-6 col-md-12 subscribe-item-top-body-txt mb-0">
                            <p class="subscribe-item-top-body-txt-p3">Отримайте Бетонко Експерт лише за {{ config('subscription.price_year') }} грн в місяць</p>
                        </div>

                        <div class="col-12 d-block d-md-none">
                            <div style="width:100%;
                                height:100%;
                                min-height:300px;
                                background-image: url('{{ asset('img/subscribe/img-1.png') }}');
                                background-size: cover;
                                background-position-x: center;
                                background-position-y: 35%;"></div>
                        </div>

                        <div class="col-12 buttons">
                            <button class="btn btn-default price-mount showAuthBusinessModel" data-toggle="modal" data-target="#authModal">Отримати за {{ config('subscription.price_mount') }} грн/місяць</button>
                            <button class="btn btn-default price-year showAuthBusinessModel" data-toggle="modal" data-target="#authModal">Отримати за {{ config('subscription.price_year') }} грн/рік</button>

                            <p>Економія {{ (config('subscription.price_mount') * 12 ) - (config('subscription.price_year') * 12 )  }} грн</p>
                        </div>

                        <div class="col-12 benefits justify-content-start">
                                <div class="benefits-item">
                                    <svg width="100%" height="100%" viewBox="0 0 155 154" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 23C6 13.0589 14.0589 5 24 5H155V136C155 145.941 146.941 154 137 154H6V23Z" fill="#2C2E2F"/>
                                        <path d="M0 18.0001C0 8.05894 8.05887 6.10352e-05 18 6.10352e-05H149V131C149 140.941 140.941 149 131 149H0V18.0001Z" fill="url(#paint0_linear_58_82)"/>
                                        <path d="M50.1205 54.547C50.173 53.1901 50.7493 51.9063 51.7282 50.9652C52.7071 50.0242 54.0126 49.499 55.3705 49.5H59.133C60.4897 49.5008 61.7935 50.0268 62.7709 50.9677C63.7483 51.9086 64.3236 53.1913 64.376 54.547L65.86 93.047C65.8874 93.7533 65.7718 94.4579 65.5202 95.1185C65.2686 95.7791 64.8863 96.382 64.396 96.8912C63.9057 97.4005 63.3177 97.8054 62.6671 98.0819C62.0166 98.3583 61.3169 98.5005 60.61 98.5H53.89C53.1832 98.5005 52.4835 98.3583 51.8329 98.0819C51.1824 97.8054 50.5943 97.4005 50.1041 96.8912C49.6138 96.382 49.2314 95.7791 48.9799 95.1185C48.7283 94.4579 48.6127 93.7533 48.64 93.047L50.1205 54.547ZM55.3705 53C54.9183 52.9996 54.4835 53.1744 54.1572 53.4876C53.831 53.8008 53.6386 54.2281 53.6205 54.68L52.1365 93.18C52.1271 93.4156 52.1654 93.6507 52.2491 93.8712C52.3328 94.0917 52.4602 94.293 52.6237 94.4629C52.7871 94.6329 52.9833 94.7681 53.2003 94.8604C53.4173 94.9527 53.6507 95.0002 53.8865 95H60.6135C60.8494 95.0002 61.0828 94.9527 61.2998 94.8604C61.5168 94.7681 61.7129 94.6329 61.8764 94.4629C62.0398 94.293 62.1673 94.0917 62.251 93.8712C62.3347 93.6507 62.373 93.4156 62.3635 93.18L60.8795 54.68C60.8614 54.2281 60.6691 53.8008 60.3429 53.4876C60.0166 53.1744 59.5818 52.9996 59.1295 53H55.3705V53ZM92.25 98.5C93.6424 98.5 94.9778 97.9469 95.9623 96.9623C96.9469 95.9777 97.5 94.6424 97.5 93.25V61.75C97.5007 61.4034 97.3984 61.0645 97.2061 60.7761C97.0139 60.4878 96.7403 60.263 96.4202 60.1303C96.1 59.9975 95.7476 59.9629 95.4078 60.0307C95.0679 60.0985 94.7558 60.2656 94.511 60.511L83.5 71.5255V61.75C83.5001 61.4127 83.4027 61.0825 83.2195 60.7992C83.0364 60.516 82.7752 60.2917 82.4675 60.1534C82.1599 60.0151 81.8188 59.9686 81.4853 60.0197C81.1519 60.0707 80.8403 60.217 80.588 60.441L68.52 71.1685L68.695 75.6975L80 65.6455V75.75C79.9994 76.0966 80.1017 76.4355 80.294 76.7239C80.4862 77.0123 80.7598 77.237 81.0799 77.3697C81.4001 77.5025 81.7524 77.5371 82.0923 77.4693C82.4322 77.4016 82.7443 77.2344 82.989 76.989L94 65.9745V93.25C94 93.7141 93.8157 94.1592 93.4875 94.4874C93.1593 94.8156 92.7142 95 92.25 95H90.5V84.5C90.5 83.5717 90.1313 82.6815 89.4749 82.0251C88.8185 81.3687 87.9283 81 87 81H76.5C75.5718 81 74.6815 81.3687 74.0252 82.0251C73.3688 82.6815 73 83.5717 73 84.5V95H69.185C68.9266 96.2692 68.3886 97.4649 67.61 98.5H92.25ZM76.5 95V84.5H87V95H76.5Z" fill="white"/>
                                        <defs>
                                            <linearGradient id="paint0_linear_58_82" x1="5.5" y1="6" x2="141.5" y2="145.5" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#3887C7"/>
                                                <stop offset="0.348958" stop-color="#22A456"/>
                                                <stop offset="0.692708" stop-color="#9CC655"/>
                                                <stop offset="1" stop-color="#ECE877"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <p>Більше заводів</p>
                                </div>

                                <div class="benefits-item">
                                    <svg width="100%" height="100%" viewBox="0 0 155 154" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 23C6 13.0589 14.0589 5 24 5H155V136C155 145.941 146.941 154 137 154H6V23Z" fill="#2C2E2F"/>
                                        <path d="M0 18.0001C0 8.05894 8.05887 6.10352e-05 18 6.10352e-05H149V131C149 140.941 140.941 149 131 149H0V18.0001Z" fill="url(#paint0_linear_58_86)"/>
                                        <path d="M51.6666 62.3333C51.6666 61.0956 52.1583 59.9087 53.0335 59.0335C53.9086 58.1583 55.0956 57.6667 56.3333 57.6667H93.6666C94.9043 57.6667 96.0913 58.1583 96.9665 59.0335C97.8416 59.9087 98.3333 61.0956 98.3333 62.3333V85.6667C98.3333 86.9043 97.8416 88.0913 96.9665 88.9665C96.0913 89.8417 94.9043 90.3333 93.6666 90.3333H56.3333C55.0956 90.3333 53.9086 89.8417 53.0335 88.9665C52.1583 88.0913 51.6666 86.9043 51.6666 85.6667V62.3333Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M75 81C78.866 81 82 77.866 82 74C82 70.134 78.866 67 75 67C71.134 67 68 70.134 68 74C68 77.866 71.134 81 75 81Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M51.6666 67C54.142 67 56.516 66.0167 58.2663 64.2663C60.0166 62.516 61 60.142 61 57.6667M89 90.3333C89 87.858 89.9833 85.484 91.7336 83.7337C93.484 81.9833 95.8579 81 98.3333 81" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                        <defs>
                                            <linearGradient id="paint0_linear_58_86" x1="5.5" y1="6" x2="141.5" y2="145.5" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#3887C7"/>
                                                <stop offset="0.348958" stop-color="#22A456"/>
                                                <stop offset="0.692708" stop-color="#9CC655"/>
                                                <stop offset="1" stop-color="#ECE877"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <p>Участь в тендерах</p>

                                </div>

                                <div class="benefits-item">
                                    <svg width="100%" height="100%" viewBox="0 0 155 154" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 23C6 13.0589 14.0589 5 24 5H155V136C155 145.941 146.941 154 137 154H6V23Z" fill="#2C2E2F"/>
                                        <path d="M0 18.0001C0 8.05894 8.05887 6.10352e-05 18 6.10352e-05H149V131C149 140.941 140.941 149 131 149H0V18.0001Z" fill="url(#paint0_linear_58_90)"/>
                                        <path d="M90.1667 55.3333H59.8333C58.5447 55.3333 57.5 56.378 57.5 57.6667V95C57.5 96.2887 58.5447 97.3333 59.8333 97.3333H90.1667C91.4553 97.3333 92.5 96.2887 92.5 95V57.6667C92.5 56.378 91.4553 55.3333 90.1667 55.3333Z" stroke="white" stroke-width="3" stroke-linejoin="round"/>
                                        <path d="M65.6666 86.8334H75M68 50.6667V57.6667V50.6667ZM82 50.6667V57.6667V50.6667ZM65.6666 68.1667H84.3333H65.6666ZM65.6666 77.5H79.6666H65.6666Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                        <defs>
                                            <linearGradient id="paint0_linear_58_90" x1="5.5" y1="6" x2="141.5" y2="145.5" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#3887C7"/>
                                                <stop offset="0.348958" stop-color="#22A456"/>
                                                <stop offset="0.692708" stop-color="#9CC655"/>
                                                <stop offset="1" stop-color="#ECE877"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <p>Більше замовлень</p>
                                </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="row subscribe-item-middle">
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <h3>Заробляй більше з Бетонко Експрет</h3>
                        </div>

                        <div class="col-12 col-sm-6 col-md-12">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                        </div>

                        <div class="col-12 col-sm-6 col-md-12">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                        </div>

                        <div class="col-12 buttons">
                            <button class="btn btn-default price-mount showAuthBusinessModel" data-toggle="modal" data-target="#authModal">Отримати за {{ config('subscription.price_mount') }} грн/місяць</button>
                            <button class="btn btn-default price-year showAuthBusinessModel" data-toggle="modal" data-target="#authModal">Отримати за {{ config('subscription.price_year') }} грн/рік</button>
                        </div>
                    </div>


                </div>
                <div class="col-12 col-md-6">
                    <div class="subscribe-item-middle-img" style="background-image: url('{{ asset('img/subscribe/img-2.png') }}');"></div>
                </div>
            </div>
        </div>

        <div class="subscribe-footer" style="background-image: url('{{ asset('img/subscribe/img-3.png') }}'); margin-top: 60px;">
            <div class="container row">
                <div class="col-md-6 offset-md-3">
                    <h1>Нам немає аналогів.<br>Ми такі тільки одні</h1>
                </div>
            </div>
        </div>
    </section>

@endsection
