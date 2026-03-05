@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="col">
                    <div class="card-body">
                        <form action="{{ route('amicms::mailing.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4 d-md-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Преміум підписки</h4>
                                    <p>Основна інформація в цьому обліковому записі.</p>
                                </div>
                                <button class="btn btn-outline-primary" type="submit">Відправити</button>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="row mt-4">
                                        <div class="col-md-6 mb-3">
                                            <h5 class="fw-bold mt-2">Разослать пользователям</h5>

                                            <div class="mt-3">
                                                <select class="form-select" name="subscribe" data-title="Выберите тип рассылки" data-style="form-control"  data-require="true">
                                                    <option value="1">С подпиской</option>
                                                    <option value="0">Без подписки</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h5 class="fw-bold mt-2">Тема сообщения</h5>
                                            <div class="mt-3">
                                                <input class="form-control" type="text" name="subject" placeholder="Укажите тему для рассылки" value="" minlength="5" maxlength="255" required>
                                            </div>

                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="template" style="width: 100%; height:500px; overflow: auto;background-color: #dddddd;">
                                                @include('emails.subscribe')
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
