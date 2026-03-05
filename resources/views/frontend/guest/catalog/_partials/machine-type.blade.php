<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
    @if(Auth::guard('business')->check())
        <a href="{{ route('business::catalog.technic', ['lang'=>app()->getLocale(),'slug'=>$machine->slug]) }}" class="technic">
    @elseif(Auth::guard('customer')->check())
        <a href="{{ route('customer::catalog.technic', ['lang'=>app()->getLocale(),'slug'=>$machine->slug]) }}" class="technic">
    @else
        <a href="{{ route('frontend::catalog.technic', ['lang'=>app()->getLocale(),'slug'=>$machine->slug]) }}" class="technic">
    @endif
        <img class="technic-img" src="{{ asset('img/technic/' . $machine->file) }}" alt="">
        <span class="text-center">{{ $machine->title }}</span>
    </a>
</div>
