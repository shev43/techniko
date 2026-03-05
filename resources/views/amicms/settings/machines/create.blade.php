@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Види техніки</h4>

                    @include('amicms.settings._partial.navbar')


                </div>
                <div class="col">
                    <div class="card-body">
                        <form action="{{ route('amicms::settings.machines.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4 d-md-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Вид техніки</h4>
                                </div>
                                <button class="btn btn-outline-primary" type="submit">Зберегти зміни</button>
                            </div>
                            <div class="row">
                                <div class="col" style="max-width: 200px;">
                                    <div class="mb-3">
                                        <img class="img-fluid w-100 rounded"
                                             src="{{ asset('img/company-logo.svg') }}"
                                             alt="upload avatar">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th class="py-3">Назва</th>
                                            <td class="py-3">
                                                <input name="title_uk" type="text" placeholder="" class="form-control" value="{{ old('title_uk') }}">
                                                @if($errors->has('title_uk'))
                                                    @foreach($errors->get('title_uk') as $error)
                                                        <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="py-3">Название</th>
                                            <td class="py-3">
                                                <input name="title_ru" type="text" placeholder="" class="form-control" value="{{ old('title_ru') }}">
                                                @if($errors->has('title_ru'))
                                                    @foreach($errors->get('title_ru') as $error)
                                                        <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="py-3">Зображення</th>
                                            <td class="py-3">
                                                <input name="file" type="file" placeholder="" class="form-control" value="{{ old('file') }}">
                                                @if($errors->has('file'))
                                                    @foreach($errors->get('file') as $error)
                                                        <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection


