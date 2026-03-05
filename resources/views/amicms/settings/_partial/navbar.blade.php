<div class="columns-panel-item-group">
    <a class="columns-panel-item columns-panel-item-link {{ (request()->routeIs('amicms::settings.machines.*')) ? 'active' : '' }}" href="{{ route('amicms::settings.machines.index') }}">
        <div class="d-flex align-items-center">
            <i class="feather font-size-lg icon-user"></i>
            <span class="ms-3">Види техніки</span>
        </div>
    </a>

    @if($permission['settings.machine-categories.index'] == 1)
    <a class="columns-panel-item columns-panel-item-link {{ (request()->routeIs('amicms::settings.machine-categories.*')) ? 'active' : '' }}" href="{{ route('amicms::settings.machine-categories.index') }}">
        <div class="d-flex align-items-center">
            <i class="feather font-size-lg icon-bell"></i>
            <span class="ms-3">Категорії технік</span>
        </div>
    </a>
    @endif
</div>
