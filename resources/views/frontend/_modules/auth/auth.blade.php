<div class="modal fade" tabindex="-1" id="authModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg>
                    <use xlink:href="#icon-5"></use>
                </svg>
            </button>
            <div class="modal-inner">
                <h3 class="heading">Ввійти в кабінет</h3>
                <ul class="nav nav-tabs" id="authModalTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="customer-tab" data-toggle="tab" href="#customer" role="tab" aria-controls="customer" aria-selected="true">Я клієнт</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="business-tab" data-toggle="tab" href="#business" role="tab" aria-controls="business" aria-selected="false">Я продавець</a>
                    </li>
                </ul>
                <div class="tab-content" id="authModalTabContent">
                    <div class="tab-pane fade active show" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                        <section class="login">
                            @include('frontend._modules.auth.customer.login')
                        </section>
                        <section class="register" style="display:none">
                            @include('frontend._modules.auth.customer.register')
                        </section>
                    </div>
                    <div class="tab-pane fade" id="business" role="tabpanel" aria-labelledby="business-tab">
                        <section class="login">
                            @include('frontend._modules.auth.business.login')
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
