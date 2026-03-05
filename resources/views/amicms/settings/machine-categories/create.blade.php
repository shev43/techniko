@extends('layouts.amicms.app')

@section('content')

    <div class="card machine-categories">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Категорія техніки</h4>

                    @include('amicms.settings._partial.navbar')


                </div>
                <div class="col">
                    <div class="card-body">
                        <form action="{{ route('amicms::settings.machine-categories.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4 d-md-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Категорія техніки</h4>
                                </div>
                                <button class="btn btn-outline-primary" type="submit">Зберегти зміни</button>
                            </div>
                            <div class="row">
                                <div class="col">
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
                                            <th class="py-3">Наявність секції</th>
                                            <td class="py-3">
                                                <select class="selectpicker" name="has_sections" data-flip="false" data-boundary="window" title="Виберіть наявність секції" data-style="form-select">
                                                    <option value="1">Так</option>
                                                    <option value="0">Ні</option>
                                                </select>
                                                @if($errors->has('has_sections'))
                                                    @foreach($errors->get('has_sections') as $error)
                                                        <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="py-3">Основна техніка</th>
                                            <td class="py-3">
                                                <select class="selectpicker" name="basic_technique[]" title="Виберіть основну техніку" data-style="form-select" multiple>
                                                    @foreach($machines as $basic_machine)
                                                        <option value="{{ $basic_machine->id }}">{{ $basic_machine->title_uk }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="py-3">Додаткова техніка</th>
                                            <td class="py-3">
                                                <select class="selectpicker" name="additional_technique[]" title="Виберіть додаткову техніку" data-style="form-select" multiple>
                                                    @foreach($machines as $additional_machine)
                                                        <option value="{{ $additional_machine->id }}">{{ $additional_machine->title_uk }}</option>
                                                    @endforeach
                                                </select>
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

