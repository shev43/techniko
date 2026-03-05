<div class="columns-panel-item-group">
        <a class="columns-panel-item columns-panel-item-link {{ (request()->routeIs('amicms::reports.orders')) ? 'active' : '' }}" href="{{ route('amicms::reports.orders') }}">
            <div class="d-flex align-items-center">
                <i class="feather icon-bar-chart-line-"></i>
                <span class="ms-3">Динаміка користувачів</span>
            </div>
        </a>
        <a class="columns-panel-item columns-panel-item-link {{ (request()->routeIs('amicms::reports.subscription')) ? 'active' : '' }}" href="{{ route('amicms::reports.subscription') }}">
            <div class="d-flex align-items-center">
                <i class="feather icon-bar-chart-line-"></i>
                <span class="ms-3">Продаж послуг</span>
            </div>
        </a>
</div>
