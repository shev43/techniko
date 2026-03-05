<div class="col-md-6 d-flex align-items-stretch">
        @if(Auth::guard('business')->check())
            <a href="{{ route('business::order.index', ['lang'=>app()->getLocale(), 'slug' => $technic->slug ]) }}" class="technic_item">
        @elseif(Auth::guard('customer')->check())
            <a href="{{ route('customer::order.index', ['lang'=>app()->getLocale(), 'slug' => $technic->slug ]) }}" class="technic_item">
        @else
            <a href="{{ route('frontend::order.index', ['lang'=>app()->getLocale(), 'slug' => $technic->slug ]) }}" class="technic_item">
        @endif
            <img class="technic_item-img" @if(count($technic->photo) > 0) src="{{ asset('storage/technics/'.$technic->photo[0]->photo) }}" @else src="{{ asset('img/profile-logo.svg') }}" @endif alt="{{ $technic->name }}">
            <h3 class="title technic_item-title">{{ $technic->name }}</h3>

            <div class="technic_item-title technic_item-description mt-1">
                від {{ $technic->hours }} год
            </div>

            <div class="technic_item-title technic_item-description mt-1 mb-3">
                {{ $technic->address }}
            </div>

            <div class="d-flex align-items-end justify-content-between mt-auto">
                <div class="heading technic_item-price">{{ $technic->price }} грн/год</div>
                <span class="btn btn-default btn-sm technic_item-btn">Оформити заявку</span>
            </div>
            </a>
</div>
