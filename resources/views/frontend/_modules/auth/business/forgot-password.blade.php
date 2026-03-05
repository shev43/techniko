@extends('layouts.app')

@section('content')
    <main class="main page">
        <div class="container">
            <section class="order">
                <h2 class="title text-center mb-5">Відновлення доступу</h2>
                <form action="{{ route('business::profile.password.email', ['lang'=>app()->getLocale()]) }}" method="post">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="form-group col-lg-4 col-md-6 text-md-left text-center">
                            <label for="phone_login">Email власника бізнесу:</label>
                            <input type="email" class="form-control text-md-left text-center" required="" name="email" id="email" placeholder="sample@email.address">
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-default">Відновити</button>
                    </div>
                </form>
            </section>
        </div>
    </main>
@endsection
