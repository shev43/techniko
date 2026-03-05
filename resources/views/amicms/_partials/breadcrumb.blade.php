<span class="me-1 text-gray"><i class="feather icon-home"></i></span>
<div class="breadcrumb-item"><a href="{{ route('amicms::dashboard.index') }}"> Головна </a></div>
@if(!(request()->routeIs('amicms::dashboard.index')))

    @if(request()->routeIs('amicms::profile.*'))
        <div class="breadcrumb-item"><a href="{{ route('amicms::profile.index') }}"> Мій профіль </a></div>
        @if(request()->routeIs('amicms::profile.edit'))
            <div class="breadcrumb-item">Редагувати запис</div>
        @endif

    @elseif(request()->routeIs('amicms::business.*'))
        <div class="breadcrumb-item"><a href="{{ route('amicms::business.index') }}"> {!! $page['title'] !!} </a></div>
        @if(request()->routeIs('amicms::business.create'))
            <div class="breadcrumb-item">Додати запис</div>
        @elseif(request()->routeIs('amicms::business.import.*'))
            <div class="breadcrumb-item">Імпорт</div>
        @elseif(request()->routeIs('amicms::business.profile.*'))
            <div class="breadcrumb-item"><a href="{{ route('amicms::business.profile.index', ['business_id'=>$business->id]) }}"> {{ $business->name }} </a></div>
            <div class="breadcrumb-item"><a href="{{ route('amicms::business.profile.index', ['business_id'=>$business->id]) }}"> Профіль </a></div>
            @if(request()->routeIs('amicms::business.profile.edit'))
                <div class="breadcrumb-item">Редагувати запис</div>
            @endif

        @elseif(request()->routeIs('amicms::business.company.*'))
            <div class="breadcrumb-item"><a href="{{ route('amicms::business.company.index', ['business_id'=>$business->id]) }}"> {{ $business->name }} </a></div>
            <div class="breadcrumb-item"><a href="{{ route('amicms::business.company.index', ['business_id'=>$business->id]) }}"> Представник </a></div>

            @if(request()->routeIs('amicms::business.company.edit'))
                <div class="breadcrumb-item">Редагувати запис</div>
            @endif

        @elseif(request()->routeIs('amicms::business.contacts.*'))
            <div class="breadcrumb-item"><a href="{{ route('amicms::business.contacts.index', ['business_id'=>$business_id]) }}"> {{ \App\Models\Business::find($business_id)->name }} </a></div>
            <div class="breadcrumb-item"><a href="{{ route('amicms::business.contacts.index', ['business_id'=>$business_id]) }}"> Контактні особи </a></div>

            @if(request()->routeIs('amicms::business.contacts.create'))
                <div class="breadcrumb-item">Додати запис</div>
            @endif

            @if(request()->routeIs('amicms::business.contacts.edit'))
                <div class="breadcrumb-item">Редагувати запис</div>
            @endif

        @elseif(request()->routeIs('amicms::business.subscription.*'))
            <div class="breadcrumb-item"><a href="{{ route('amicms::business.subscription.index', ['business_id'=>$business->id]) }}"> {{ $business->name }} </a></div>
            <div class="breadcrumb-item"><a href="{{ route('amicms::business.subscription.index', ['business_id'=>$business->id]) }}"> Преміум підписки </a></div>
        @endif

    @elseif(request()->routeIs('amicms::clients.*'))
        <div class="breadcrumb-item"><a href="{{ route('amicms::clients.index') }}"> Клієнти </a></div>
        @if(request()->routeIs('amicms::clients.create'))
            <div class="breadcrumb-item">Додати запис</div>
        @endif

        @if(request()->routeIs('amicms::clients.edit'))
            <div class="breadcrumb-item">Редагувати запис</div>
        @endif

    @elseif(request()->routeIs('amicms::orders.*'))
        <div class="breadcrumb-item"><a href="{{ route('amicms::orders.index') }}"> Замовлення </a></div>

        @if(request()->routeIs('amicms::orders.view'))
            <div class="breadcrumb-item">{{ ($order->is_tender == 1 ? 'Тендер #' : 'Заявка #') . $order->order_number }}</div>
        @endif

        @if(request()->routeIs('amicms::orders.edit'))
            <div class="breadcrumb-item"><a href="{{ route('amicms::orders.view', ['order_id'=>$order->id]) }}"> {{ ($order->is_tender == 1 ? 'Тендер #' : 'Заявка #') . $order->order_number }} </a></div>
            <div class="breadcrumb-item">Редагувати запис</div>
        @endif

    @elseif(request()->routeIs('amicms::subscription.*'))
        <div class="breadcrumb-item"><a href="{{ route('amicms::subscription.index') }}"> Підписки </a></div>

        @if(request()->routeIs('amicms::subscription.view'))
            <div class="breadcrumb-item">{{ $business->name }}</div>
        @endif

    @elseif(request()->routeIs('amicms::users.*'))
        <div class="breadcrumb-item"><a href="{{ route('amicms::users.index') }}"> Адміністратори </a></div>

        @if(request()->routeIs('amicms::users.create'))
            <div class="breadcrumb-item">Додати запис</div>
        @endif

        @if(request()->routeIs('amicms::users.edit'))
            <div class="breadcrumb-item">Редагувати запис</div>
        @endif

    @elseif(request()->routeIs('amicms::mailing.*'))
        <div class="breadcrumb-item"> Розсилання </div>


    @elseif(request()->routeIs('amicms::settings.*'))
        <div class="breadcrumb-item"><a href="{{ route('amicms::settings.machines.index') }}"> Модерація </a></div>

        @if(request()->routeIs('amicms::settings.machines.*'))
            <div class="breadcrumb-item"><a href="{{ route('amicms::settings.machines.index') }}"> Види техніки </a></div>

            @if(request()->routeIs('amicms::settings.machines.create'))
                <div class="breadcrumb-item">Додати запис</div>
            @endif

            @if(request()->routeIs('amicms::settings.machines.edit'))
                <div class="breadcrumb-item">Редагувати запис</div>
            @endif
        @endif

        @if(request()->routeIs('amicms::settings.machine-categories.*'))
            <div class="breadcrumb-item"><a href="{{ route('amicms::settings.machine-categories.index') }}"> Категорії технік </a></div>

            @if(request()->routeIs('amicms::settings.machine-categories.create'))
                <div class="breadcrumb-item">Додати запис</div>
            @endif

            @if(request()->routeIs('amicms::settings.machine-categories.edit'))
                <div class="breadcrumb-item">Редагувати запис</div>
            @endif
        @endif


    @endif
@endif
