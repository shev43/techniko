<div class="row seller_profile-persons-item">
    <div class="col-5 col-md-4">
        <div class="seller_profile-persons-img">
            <img src="@if(!empty($contact->photo)){{ asset('storage/users/'.$contact->photo) }}@else{{ asset('img/profile-logo.svg') }}@endif" alt="">
        </div>
    </div>
    <div class="col-7 col-md-8">
        <div class="seller_profile-persons-name">{{$contact->name}}</div>
        <div class="seller_profile-persons-post">{{$contact->position}}</div>
        <div class="seller_profile-persons-phone">
            {{$contact->phoneSmall}}
            <a class="btn-action-contact-person-phone show-phone-number" href="#" data-phone="{{ $contact->phoneFormatted }}">показати</a>

        </div>
    </div>
</div>
