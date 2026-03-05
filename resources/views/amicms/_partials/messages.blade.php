@if(Session::has( 'success' ))
    <div id="status-message" class="position-fixed messages top-0 end-0 p-3" style="z-index: 9999">
        <div class="toast show">
            <div class="toast-header">
                <strong class="me-auto">Повідомлення</strong>
                <small class="text-muted">зараз</small>
            </div>
            <div class="toast-body text-success">
                @if( Session::has( 'success' ))
                    {{ Session::get( 'success' ) }}
                @endif
            </div>
        </div>
    </div>

@endif
