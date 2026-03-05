<div class="modal auth fade" tabindex="-1" id="contact_usModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="padding:45px 30px 45px">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg>
                    <use xlink:href="#icon-5"></use>
                </svg>
            </button>
            <div class="modal-inner auth-inner" style="max-width: 75%;">
                <ul class="nav nav-tabs" id="authModalTab" role="tablist" style="margin-bottom: 30px;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="support-tab" data-toggle="tab" href="#support" role="tab"
                           aria-controls="home" aria-selected="false">Підтримка</a>
                    </li>

                    @if((request()->user()) && (Auth::guard('customer')->check() || Auth::guard('business')->check()))

                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab"
                           aria-controls="profile" aria-selected="true">Відгук</a>
                    </li>
                    @endif
                </ul>

                <div class="tab-content" id="authModalTabContent">
                    <div class="tab-pane fade active show" id="support" role="tabpanel" aria-labelledby="support-tab">
                        <form id="supportForm" action="" method="get">
                            @csrf
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="user-phone">Номер телефону:</label>
                                <input type="text" class="form-control bfh-phone" id="user-phone" name="phone" placeholder="+38 xxx xxx-xx-xx">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="user-email">Email:</label>
                                <input type="email" class="form-control " id="user-email" name="email"
                                       placeholder="E-mail">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group" style="margin-bottom: 35px;">
                                <label for="comment">Коментар:</label>
                                <textarea class="form-control" name="comment" style="max-height:70px;min-height:70px;height:70px;"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group" style="margin-bottom: 0px;">
                                <button type="submit" class="btn btn-default w-100">Надіслати</button>
                            </div>
                        </form>
                    </div>

                    @if((request()->user()) && (Auth::guard('customer')->check() || Auth::guard('business')->check()))
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <form id="reviewForm" action="{{ route('review.store') }}" method="post">
                            @csrf
                            <input name="user_id" type="hidden" value="{{ request()->user()->id }}">

                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Оцініть наш сервіс</h4>
                            </div>
                            <div class="modal-body">
                                <p>Ми постійно працюємо над покращенням сервісу та будемо вдячні, якщо ви допоможете нам у цьому.</p>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select class="selectpicker" name="question[]" id="" data-style="form-control" data-title="Що покращити?" multiple required>
                                                <option value="q1">Швидкість роботи сайту</option>
                                                <option value="q2">Процедура замовлення</option>
                                                <option value="q3">Інтерфейс зручність</option>
                                                <option value="q4">Служба підтримки</option>
                                                <option value="q5">Знайшли помилку на сайті</option>
                                                <option value="q6">Інше</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Ваш коментар</label>
                                            <textarea class="form-control" name="comment"  style="max-height:70px;min-height:70px;height:70px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="discard" type="button" class="btn btn-light" data-dismiss="modal">Ні дякую</button>
                                <button class="btn btn-default">Оцінити</button>
                            </div>
                        </form>

                        <div id="reviewSuccess" class="d-none">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-md-10 text-center py-5">
                                    <svg class="offer-empty-icon">
                                        <use xlink:href="#icon-check"></use>
                                    </svg>
                                    <div>
                                        <b>Дякуємо, що залишили відгук про наш сервіс. Ми обов'язково врахуємо Вашу думку.</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>


            </div>
        </div>
    </div>
</div>

