<div class="tab-pane fade active show" id="business" role="tabpanel" aria-labelledby="business-tab">
    <div class="login">
        <div class="form-step step-1">
            <form method="post" action="{{ route('business.profile.login', ['lang'=>app()->getLocale()]) }}">
                @csrf

                <div class="invalid-feedback" style="margin-bottom: 20px;display: block"></div>

{{--                <input name="referer" type="hidden" value="{{ request()->get('referer') ?? (Auth::guard('customer')->check()) ? route('business::subscription.index', ['lang'=>app()->getLocale()])  : '' }}">--}}
                <div class="form-group">
                    <label for="email">Електронна пошта:</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="sample@email.address">
                </div>
                <div class="form-group">
                    <label>Пароль:</label>
                    <div class="form-pass">
                        <input class="form-pass-checkbox" type="checkbox" id="password" value="0">
                        <label class="form-pass-label" for="password">
                            <svg>
                                <use xlink:href="#icon-14"></use>
                            </svg>
                        </label>
                        <input type="password" class="form-control" name="password" placeholder="мінімум 8 символів" autocomplete="off">
                    </div>
                    <small id="exampleInput5HelpBlock" class="access-recovery form-text hidden">
                        Не вдається увійти ? Ви можете
                        <a href="/ua/business/forgot-password"><b>відновити доступ</b></a>
                    </small>

                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-default">Увійти</button>
                </div>
            </form>
            <div class="form-group">
                <label>Ще не зареєстровані?</label>
                <a class="btn btn-border_dark" href="{{ route('business.profile.register', ['lang'=>app()->getLocale()]) }}">Зареєструватись</a>
            </div>

        </div>
    </div>
</div>
