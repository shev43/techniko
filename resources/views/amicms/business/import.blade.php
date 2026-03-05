@extends('layouts.amicms.app')

@section('content')
    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Імпорт</h4>

                </div>
                <div class="col">
                    <div class="card-body">

                        <div class="mb-4 d-md-flex align-items-center justify-content-between">
                            <div>
                                <h4>Завантажити приклад шаблону</h4>
                            </div>
                            <a class="btn btn-outline-primary" href="{{ asset('storage/betonko_templete.xlsx') }}" target="_blank">Завантажити</a>
                        </div>


                        <div class="row">
                            <div class="col" style="max-width: 200px;">
                            </div>
                            <div class="col-md">
                                <form action="{{ route('amicms::business.import.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th class="py-4">Файл</th>
                                            <td class="py-4"><input type="file" name="file" value="" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td class="py-4" colspan="2">
                                                <div class="justify-content-end d-flex">
                                                    <button type="submit" class="btn btn-outline-primary">Імпортувати</button>

                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>



                                </form>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
