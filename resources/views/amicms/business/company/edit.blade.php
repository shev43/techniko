@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Представник</h4>

                    @include('amicms.business._partial.navbar', ['business_id'=>$business->id])


                </div>
                <div class="col">
                    <div class="card-body">
                        <form
                              action="{{ route('amicms::business.company.update', ['business_id'=>$business->id]) }}"
                              method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4 d-md-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Інформація про представника</h4>
                                    <p>Основна інформація в цьому обліковому записі.</p>
                                </div>
                                <button class="btn btn-outline-primary" type="submit">Зберегти зміни</button>
                            </div>
                            <div class="row">
                                <div class="col" style="max-width: 200px;">
                                    <div class="mb-3">
                                        <img class="img-fluid w-100 rounded"
                                             src="@if(!empty($business->photo)){{ asset('storage/business/'.$business->photo) }}@else{{ asset('img/company-logo.svg') }}@endif"
                                             alt="upload avatar">
                                        @if($business->photo)
                                            <div class="mt-3">
                                                <a class="btn btn-outline-danger" href="{{ route('amicms::business.company.removeFile', ['business_id'=>$business->id]) }}">Видалити</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th class="py-4">Назва</th>
                                            <td class="py-4">
                                                <input name="name" type="text" placeholder="" class="form-control"
                                                       value="{{ old('name', $business->name) }}">
                                                @if($errors->has('name'))
                                                    @foreach($errors->get('name') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-4">Телефон</th>
                                            <td class="py-4">
                                                <input name="phone" type="text" placeholder="" class="form-control"
                                                       value="{{ old('phone', $business->phone) }}">
                                                @if($errors->has('phone'))
                                                    @foreach($errors->get('phone') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-4">Email</th>
                                            <td class="py-4">
                                                <input name="email" type="text" placeholder="" class="form-control"
                                                       value="{{ old('email', $business->email) }}">
                                                @if($errors->has('email'))
                                                    @foreach($errors->get('email') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif

                                            </td>
                                        </tr>
                                        @if(empty($business->photo))
                                            <tr>
                                                <th class="py-3">Зображення</th>
                                                <td class="py-3">
                                                    <input name="photo" type="file" placeholder="" class="form-control" value="{{ old('photo') }}">
                                                    @if($errors->has('photo'))
                                                        @foreach($errors->get('photo') as $error)
                                                            <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th class="py-4">Про компанію</th>
                                            <td class="py-4">
                                                <textarea class="form-control ckeditor" name="description"
                                                          id="ckeditor-description">{{ old('description', $business->description) }}</textarea>
                                                @if($errors->has('description'))
                                                    @foreach($errors->get('description') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-4">Адреса</th>
                                            <td class="py-4">
                                                <input name="address" type="text" placeholder=""
                                                       class="form-control autocomplete"
                                                       value="{{ old('address', $business->address) }}">
                                                @if($errors->has('address'))
                                                    @foreach($errors->get('address') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    @include('frontend._modules.map-form', ['objects'=>$business, 'target'=>'form input[name=address]'])
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>

    <script>
        $(function () {
            $('textarea.editor').each(function (e) {
                CKEDITOR.replace(this.id, {'allowedContent': true});
            });
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?language=uk-UK&key={{ (env('APP_DEBUG') == true) ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION') }}&libraries=places"></script>

    <script>
        jQuery(function($) {
            google.maps.event.addDomListener(window, 'load', buildAutocomplete());
        });
    </script>

@endsection
