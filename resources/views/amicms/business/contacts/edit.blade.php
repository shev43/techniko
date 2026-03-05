@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Контакти</h4>

                    @include('amicms.business._partial.navbar', ['business_id'=>$business_id])


                </div>
                <div class="col">
                    <div class="card-body">
                        <form action="{{ route('amicms::business.contacts.update', ['business_id'=>$business_id, 'contact_id'=>$contact->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4 d-md-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Контактні особи</h4>
                                    <p>Основна інформація в цьому обліковому записі.</p>
                                </div>
                                <button class="btn btn-outline-primary" type="submit">Зберегти зміни</button>
                            </div>
                            <div class="row">
                                <div class="col" style="max-width: 200px;">
                                    <div class="mb-3">
                                        <img class="img-fluid w-100 rounded"
                                             src="@if(!empty($contact->photo)){{ asset('storage/users/' . $contact->photo) }}@else{{ asset('img/profile-logo.svg') }}@endif"
                                             alt="upload avatar">

                                        @if($contact->photo)
                                            <div class="mt-3">
                                                <a class="btn btn-outline-danger" href="{{ route('amicms::business.contacts.removeFile', ['business_id'=>$business_id, 'contact_id'=>$contact->id]) }}">Видалити</a>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-md">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th class="py-3">Ім'я</th>
                                            <td class="py-3">
                                                <input name="name" type="text" placeholder="" class="form-control" value="{{ old('name', $contact->name) }}">
                                                @if($errors->has('name'))
                                                    @foreach($errors->get('name') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-3">Телефон</th>
                                            <td class="py-3">
                                                <input name="phone" type="text" placeholder="" class="form-control" value="{{ old('phone', $contact->phone) }}">
                                                @if($errors->has('phone'))
                                                    @foreach($errors->get('phone') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>

                                        @if(empty($contact->photo))
                                            <tr>
                                                <th class="py-3">Зображення</th>
                                                <td class="py-3">
                                                    <input name="photo" type="file" placeholder="" class="form-control" value="">
                                                    @if($errors->has('photo'))
                                                        @foreach($errors->get('photo') as $error)
                                                            <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th class="py-3">Посада</th>
                                            <td class="py-3">
                                                <select class="form-select" name="position">
                                                    <option value="Водій" {{ $contact->position == 'Водій' ? 'selected' : '' }}>Водій</option>
                                                    <option value="Підтримка" {{ $contact->position == 'Підтримка' ? 'selected' : '' }}>Підтримка</option>
                                                    <option value="Диспетчер" {{ $contact->position == 'Диспетчер' ? 'selected' : '' }}>Диспетчер</option>
                                                    <option value="Менеджер" {{ $contact->position == 'Менеджер' ? 'selected' : '' }}>Менеджер</option>
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
