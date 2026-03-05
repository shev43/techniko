<span class="d-lg-none" style="font-size: 20px;">
    @if(request()->routeIs('business::settings.profile.*'))<strong>Профіль</strong>@endif
    @if(request()->routeIs('business::settings.company.*'))<strong>Представник</strong>@endif
    @if(request()->routeIs('business::settings.contacts.*'))<strong>Контактні особи</strong>@endif
    @if(request()->routeIs('business::settings.technics.*'))<strong>Техніка</strong>@endif
</span>

<button class="submenu-burger menuToggle" href="#submenu" style="float: right">
    <svg class="icon">
        <use xlink:href="#icon-gear"></use>
    </svg>
    <span id="notificationBadge2" class="d-none badge badge-pill badge-warning position-absolute" style="margin-top: -32px;margin-left: 28px;font-size: 8px;">&nbsp;</span>
</button>
<nav class="submenu justify-content-center" id="submenu">
    <a class="submenu-item py-2 {{ (request()->routeIs('business::settings.profile.*')) ? 'active' : '' }}" href="{{route('business::settings.profile.index', ['lang'=>app()->getLocale()] )}}"><span>Профіль</span></a>
    <a class="submenu-item py-2 {{ (request()->routeIs('business::settings.company.*')) ? 'active' : '' }}" href="{{route('business::settings.company.index', ['lang'=>app()->getLocale()] )}}"><span>Представник</span></a>
    <a class="submenu-item py-2 {{ (request()->routeIs('business::settings.contacts.*')) ? 'active' : '' }}" href="{{route('business::settings.contacts.index', ['lang'=>app()->getLocale()] )}}"><span>Контактні особи</span></a>
    <a class="submenu-item py-2 {{ (request()->routeIs('business::settings.technics.*')) ? 'active' : '' }}" href="{{route('business::settings.technics.index', ['lang'=>app()->getLocale()] )}}">Техніка</a>
    <button class="close menuToggle" href="#submenu">
        <svg class="icon">
            <use xlink:href="#icon-5"></use>
        </svg>
    </button>

</nav>
