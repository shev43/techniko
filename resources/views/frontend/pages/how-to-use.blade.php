@extends('layouts.app')

@section('content')
    <nav class="container" aria-label="breadcrumb" style="padding-top: 60px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend::pages.index', ['lang'=>app()->getLocale()]) }}">Як користуватись? - TECHNIKO</a></li>
            <li class="breadcrumb-item active" aria-current="page">Як користуватись?</li>
        </ol>
    </nav>

    <div class="container" style="margin-top: 30px; margin-bottom: 80px;">
        <div class="row">
            <div class="col-12">
                <h3>Як користуватись?</h3>

                <p>Слава Україні! ❤️🇺🇦</p>

            </div>
        </div>

    </div>
@stop
