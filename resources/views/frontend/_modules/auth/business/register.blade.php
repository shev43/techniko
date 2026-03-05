@extends('layouts.app')

@section('content')
    <main class="main page">
        <div class="container">
            <section class="sign_up">
                <h2 class="title text-center">Заповніть всі поля нижче:</h2>
                <form action="{{ route('business.profile.register-form', ['lang'=>app()->getLocale()]) }}" method="post">
                    @csrf

                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                        @endforeach
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="first_name">Ваше ім’я:</label>
                                <input id="first_name" name="first_name" type="text" class="form-control js-name @error('first_name') is-invalid @enderror" placeholder="Ваше ім’я" value="{{ old('first_name') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="last_name">Ваше прізвище:</label>
                                <input id="last_name" name="last_name" type="text" class="form-control js-name  @error('last_name') is-invalid @enderror" placeholder="Ваше прізвище" value="{{ old('last_name') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">Номер телефону:</label>
                                <input id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="+380 ХХХ ХХХХ" value="{{ old('phone') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Електронна пошта:</label>
                                <input id="email" name="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="sample@email.address" value="{{ old('email') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Пароль:</label>
                                <div class="form-pass">
                                    <input class="form-pass-checkbox" type="checkbox" id="password" value="0">
                                    <label class="form-pass-label" for="password">
                                        <svg>
                                            <use xlink:href="#icon-14"></use>
                                        </svg>
                                    </label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="мінімум 8 символів" autocomplete="off">
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Пароль ще раз:</label>
                                <div class="form-pass">
                                    <input class="form-pass-checkbox" type="checkbox" id="password_confirmation" value="0">
                                    <label class="form-pass-label" for="password_confirmation">
                                        <svg>
                                            <use xlink:href="#icon-14"></use>
                                        </svg>
                                    </label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="мінімум 8 символів" autocomplete="off">
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="representative">Ви представник:</label>
                                <input id="representative" name="representative" type="text" class="form-control @error('representative') is-invalid @enderror" placeholder="Назва підприємства" value="{{ old('representative') }}">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input class="d-none" name="accept" type="checkbox" id="accept">
                                <div class="form-check">
                                    <label for="accept" class="form-check-label">
                                        <svg>
                                            <use xlink:href="#icon-9"></use>
                                        </svg>
                                    </label>
                                    <div class="form-check-text">Я погоджуюся з <a href="{{ route('frontend::policy', ['lang'=>app()->getLocale()]) }}"><b>Умовами використання</b></a> та
                                        <a href="{{ route('frontend::policy', ['lang'=>app()->getLocale()]) }}"><b>Політикою конфіденційності</b></a></div>
                                </div>
                                <div @error('accept') style="display: flex;width:100%;height:1px;border-bottom: 1px solid #FC610A;margin-top: 10px;" @enderror></div>
                            </div>

                            <div class="form-group text-center">
                                <button class="btn btn-default" type="submit">Зареєструватись</button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </main>

@endsection
