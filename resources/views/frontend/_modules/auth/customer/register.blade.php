<div class="form-step step-1">
    <form method="post" action="{{route('customer.profile.register.sms', ['lang'=>app()->getLocale()])}}">
        @csrf

        <div class="form-group">
            <label for="phone">Номер телефону:</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="+38 xxx xxx-xx-xx" autocomplete="off">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label for="first_name">Ім’я:</label>
            <input type="text" class="form-control js-name" id="first_name" name="first_name" autocomplete="off">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label for="last_name">Прізвище:</label>
            <input type="text" class="form-control js-name" id="last_name" name="last_name" autocomplete="off">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <input class="d-none" name="accepted" type="checkbox" id="accept" value="1">
            <div class="form-check">
                <label for="accept" class="form-check-label">
                    <svg>
                        <use xlink:href="#icon-9"></use>
                    </svg>
                </label>
                <div class="form-check-text">Погоджуюся з
                    <a href="{{ route('frontend::policy', ['lang'=>app()->getLocale()]) }}"><b>Умовами використання</b></a> та
                    <a href="{{ route('frontend::policy', ['lang'=>app()->getLocale()]) }}"><b>Політикою конфіденційності</b></a>
                </div>
            </div>
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group send-register-sms">
            <button type="submit" class="btn btn-default">Зареєструватися</button>
        </div>
        <div class="form-group">
            <label>Вже маєте акаунт?</label>
            <button type="button" class="btn btn-border_dark">Увійти</button>
        </div>
    </form>
</div>
<div class="form-step step-2" style="display: none">
    <form method="post" action="{{route('customer.profile.register.store', ['lang'=>app()->getLocale()])}}">
        @csrf
        <input type="hidden" name="phone">
        <input type="hidden" name="code">
        <input type="hidden" name="first_name">
        <input type="hidden" name="last_name">

        @include('frontend._modules.auth._partials.sms')

        <div class="form-group">
            <button type="submit" class="btn btn-default">Зареєструватися</button>
        </div>

        <div class="form-group text-center send-login-sms">
            <p>{{__('web.RESEND_SMS_COME_MESSAGE')}}
                <span class="timer" data-second="{{Config::get('auth.resend_sms_code.register')}}">{{Config::get('auth.resend_sms_code.register')}}</span>
            </p>
            <a href="#" class="auth-link resend-register-sms" style="display: none">Надіслати код ще раз</a>
        </div>
    </form>
</div>
