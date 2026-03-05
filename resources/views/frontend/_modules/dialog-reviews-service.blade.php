<div class="modal fade" id="reviewServiceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="padding:45px 30px 45px">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg>
                    <use xlink:href="#icon-5"></use>
                </svg>
            </button>

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
                                    <select class="selectpicker" name="question[]" id="" data-style="form-control" data-title="Що нам покращити?" multiple required>
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
    </div>
</div>

    <script>
        @if((Auth::guard('customer')->check()))
            let url_submit = '{{ route('customer::review.check', ['lang'=>app()->getLocale()]) }}'
            let is_service_review = '{{ request()->user()->is_customer_service_review }}'
        @endif
        @if((Auth::guard('business')->check()))
            let url_submit = '{{ route('business::review.check', ['lang'=>app()->getLocale()]) }}'
            let is_service_review = '{{ request()->user()->is_business_service_review }}'
        @endif

        let url_discard = '{{ route('review.discard', ['lang'=>app()->getLocale(), 'user_id'=>request()->user()->id]) }}'


        $('#reviewServiceModal #discard').click(function() {
            if(is_service_review == 0) {
                $.get(url_discard);
            }
        });

        $.get(url_submit, function(response) {
            if(response == true && is_service_review == 0) {
                $('#reviewServiceModal').modal('show');
            }
        })
    </script>
