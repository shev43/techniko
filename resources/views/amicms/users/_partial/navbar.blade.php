<div class="columns-panel-item-group nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <a class="columns-panel-item columns-panel-item-link active" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true" style="cursor: pointer">
        <div class="d-flex align-items-center">
            <i class="feather font-size-lg icon-user"></i>
            <span class="ms-3">Профіль</span>
        </div>
    </a>

    @if($mode == 'edit')
    @if($user->id !== request()->user()->id)
    <a class="columns-panel-item columns-panel-item-link" id="v-pills-role-tab" data-bs-toggle="pill" data-bs-target="#v-pills-role" role="tab" aria-controls="v-pills-role" aria-selected="false" style="cursor: pointer">
        <div class="d-flex align-items-center">
            <i class="font-size-lg feather icon-lock"></i>
            <span class="ms-3">Права доступу</span>
        </div>
    </a>
    @endif
    @else
        <a class="columns-panel-item columns-panel-item-link" id="v-pills-role-tab" data-bs-toggle="pill" data-bs-target="#v-pills-role" role="tab" aria-controls="v-pills-role" aria-selected="false" style="cursor: pointer">
            <div class="d-flex align-items-center">
                <i class="font-size-lg feather icon-lock"></i>
                <span class="ms-3">Права доступу</span>
            </div>
        </a>
    @endif

</div>
