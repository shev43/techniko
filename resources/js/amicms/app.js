window._ = require('lodash');

try {
    // window.Popper = require('popper.js').default;

    require('bootstrap');
    require('../bootstrap-select');
    require('bootstrap-autocomplete');
} catch (e) {}




$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function perfectSB() {
    $(".scrollable").perfectScrollbar()
}

function submitModalForm() {
    $('#modalForms button[type=submit]').click(function(e){
        e.preventDefault();

        let url = $('#modalForms').find('form.modal-form').attr('action');
        let formData = $('#modalForms').find('form.modal-form').serialize();

        $('#modalForms').find('.modal-form .invalid-feedback').html('');

        $.ajax({
            url: url,
            method: 'post',
            data: formData,

            success: function(result){
                if(result.errors) {
                    $('#modalForms').find('.modal-form .invalid-feedback').show();
                    $.each(result.errors, function(key, value){
                        $('#modalForms').find('.modal-form .invalid-feedback.'+key+'').append(value);

                    });
                } else {
                    let success = '<div class="container-fluid"><div class="row"><div class="col-12 text-center p-4"><div class="alert alert-success" role="alert"><p class="m-0">'+ result.success +'</p></div></div></div></div>';
                    $('#modalForms').find('.modal-form .invalid-feedback').hide();
                    $('#modalForms').find('.modal-form').hide();
                    $('#modalForms').find('.modal-footer').hide();
                    $('#modalForms').find('.modal-body').fadeIn(2000).html(success);

                    setTimeout(function () {
                        // $('#modalForms').find('button[type=button]').click();
                        window.location.reload()
                    }, 3000);

                }
            }

        });

    });
}

function autoResize(iframe) {
    $(iframe).height($(iframe).contents().find('html').height());
}


function buildModalForm() {
    $('.btn-modal-form').click(function(e){
        e.preventDefault();
        let url = $(this).attr("href");
        $('.modal-title').text($(this).data("title"));
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            datatype: "html",

            success: function(result) {
                $('#modalForms').modal('show');
                $('.modal-body').html(result);
            }
        });
    });

    $('.btn-modal-form-iframe').click(function(e){
        e.preventDefault();
        let url = $(this).attr("href");
        $('.modal-title').text($(this).data("title"));

        $('#modalForms').modal('show');
        $('.modal-body').append('<iframe height="100%" width="100%" src="'+ url +'" onload="autoResize(this);" style="height: calc(100vh - 250px);"></iframe>');
    });
}



function doActivateAccount() {
    $('.activate-account').change(function() {
        let business_id = $(this).data('id');
        $.get('/business/' + business_id + '/activate');
    })
}

function doVisibleCategory() {
    $('.visible-category').change(function() {
        let machine_id = $(this).data('id');
        $.get('/settings/machines/' + machine_id + '/visible');
    })
}

buildAutocomplete = function () {
    const acInputs = $(".autocomplete");
    const options = {
        fields: ["geometry"],
        strictBounds: false,
        componentRestrictions: {country: "ua"}
    };

    const autocomplete = new google.maps.places.Autocomplete(acInputs[0], options);

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        const place = autocomplete.getPlace();

        let location_lat_destination = $('form').find('.location_lat_destination');
        let location_lng_destination = $('form').find('.location_lng_destination');
        if(typeof location_lat_destination.val() !== "undefined" && typeof location_lng_destination.val() !== "undefined") {
            location_lat_destination.remove();
            location_lng_destination.remove();
        }

        $(acInputs).parent().append('<input class="location_lat_destination" type="hidden" name="location_lat" value="' + place.geometry.location.lat() + '" />');
        $(acInputs).parent().append('<input class="location_lng_destination" type="hidden" name="location_lng" value="'+ place.geometry.location.lng() + '" />');

    });


    return buildAutocomplete;
}



function confirmDelete() {
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $('.btn-ok').click(function(b) {
            e.preventDefault();
            $(this).attr("disabled", true);
            let href = $(e.relatedTarget).data('href');

            if(typeof href !== "undefined") {
                location.href = href;
            }
        });
    });

}




$(document).ready(function () {
    setTimeout(function () {
        $("#status-message").fadeOut(500)
    }, 3000);

    $('input[name=phone], input[name=contact_phone], input.disabled-phone').unmask().mask('+38 (099) 999-99-99');


    confirmDelete();
    doActivateAccount();
    doVisibleCategory();
    buildModalForm();
    submitModalForm();


});

