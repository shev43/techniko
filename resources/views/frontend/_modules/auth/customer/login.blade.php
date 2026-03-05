<div class="form-step step-1">
    <form method="post" action="{{ route('customer.profile.login.sms', ['lang'=>app()->getLocale()]) }}">
        @csrf
        <div class="invalid-feedback" style="margin-bottom: 20px;display: block"></div>

        <div class="form-group">
            <label for="phone_login">Номер телефону:</label>
            <input type="text" class="form-control bfh-phone" name="phone" placeholder="+38 xxx xxx-xx-xx" autocomplete="off">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Увійти</button>
        </div>
        <div class="form-group">
            <label>Вперше тут?</label>
            <button type="button" class="btn btn-border_dark">Зареєструватися</button>
        </div>
    </form>
</div>

<div class="form-step step-2" style="display: none">
    <form method="post" action="{{ route('customer.profile.login.send', ['lang'=>app()->getLocale()]) }}">
        @csrf

        <input type="hidden" name="phone">
        <input type="hidden" name="code">
        @if(!Auth::guard('customer')->check())
            @if(request()->routeIs('frontend::order.index') || request()->routeIs('business::order.index'))
                <input name="referer" type="hidden" value="{{ route('customer::order.index', ['lang'=>app()->getLocale(), 'slug'=>$technic->slug]) }}">
            @else
                <input name="referer" type="hidden" value="">
            @endif
        @endif

        @include('frontend._modules.auth._partials.sms')

        <div class="form-group">
            <button type="submit" class="btn btn-default">Увійти</button>
        </div>

    </form>

    <div class="form-group text-center">
        <p>{{__('web.RESEND_SMS_COME_MESSAGE')}}
            <span class="timer" data-second="{{Config::get('auth.resend_sms_code.login')}}">{{Config::get('auth.resend_sms_code.login')}}</span>
        </p>
        <a href="#" class="auth-link resend-login-sms" style="display: none">Надіслати код ще раз</a>
    </div>
</div>
