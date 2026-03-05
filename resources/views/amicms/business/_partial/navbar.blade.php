<div class="columns-panel-item-group">
    @if($permission['business.profile.index'] == 1)
    <a class="columns-panel-item columns-panel-item-link {{ (request()->routeIs('amicms::business.profile.*')) ? 'active' : '' }}" href="{{ route('amicms::business.profile.index', ['business_id'=>$business_id]) }}">
        <div class="d-flex align-items-center">
            <i class="feather font-size-lg icon-user"></i>
            <span class="ms-3">Профіль</span>
        </div>
    </a>
    @endif

    <a class="columns-panel-item columns-panel-item-link {{ (request()->routeIs('amicms::business.company.*')) ? 'active' : '' }}" href="{{ route('amicms::business.company.index', ['business_id'=>$business_id]) }}">
        <div class="d-flex align-items-center">
            <i class="feather font-size-lg icon-bell"></i>
            <span class="ms-3">Представник</span>
        </div>
    </a>

    @if($permission['business.contacts.index'] == 1)
    <a class="columns-panel-item columns-panel-item-link {{ (request()->routeIs('amicms::business.contacts.*')) ? 'active' : '' }}" href="{{ route('amicms::business.contacts.index', ['business_id'=>$business_id]) }}">
        <div class="d-flex align-items-center">
            <i class="feather font-size-lg icon-lock"></i>
            <span class="ms-3">Контакти</span>
        </div>
    </a>
    @endif
    @if($permission['business.subscription.index'] == 1)
    <a class="columns-panel-item columns-panel-item-link {{ (request()->routeIs('amicms::business.subscription.*')) ? 'active' : '' }}" href="{{ route('amicms::business.subscription.index', ['business_id'=>$business_id]) }}">
        <div class="d-flex align-items-center">
            <i class="feather font-size-lg icon-link-2"></i>
            <span class="ms-3">Преміум підписки</span>
        </div>
    </a>
    @endif
</div>
