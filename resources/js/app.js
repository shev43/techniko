require('./bootstrap');

require('jquery-mask-plugin')

require('flatpickr')
require('./flatpickr-locale')
require('./auth')


let wNumb = require('wnumb')
let noUiSlider = require('nouislider')

let Fresco = require('@staaky/fresco/dist/js/fresco')

$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

// PreventDefault
    $('form.form-prevent').on('keyup keypress', function (e) {
        let keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }

    });

        // $('form').submit(function(e){
        //     e.preventDefault();
        //     $('button[type="submit"]').attr('disabled', true);
        //     $("button", this).text("Submitting...");
        //
        //     console.log('Submitting...')
        //     $(this).submit();
        // });


    $('[data-toggle="popover"]').popover();


    initFormPass();
    initMenu();
    initBgPremium();
    initRangeSlider();
    initDatepicker();
    initAutoComlete();
    initGallery();
    initPopover();
    initPhoneMask();
    confirmDelete();
    confirmSubscribeDeactivate();
    confirmCanceled();
    calcOrderPrice();
    calcOrderTenderPrice();
    alphaOnly();
    digitsOnly();
    technicOptionButton();

///////////////////////////////////////

    $('.subscribe a.btn.subscribe-to-package').click(function (e) {
        e.preventDefault();
        scrollToTargetAdjusted('section-3');
    })

    $('.subscribe a.btn.subscribe-to-slot').click(function (e) {
        e.preventDefault();
        scrollToTargetAdjusted('section-5');
    })


// SORT
    $('form#orderByTypeCategory select').change(function () {
        $(this).closest('form').submit();
    });

    $('form.orderType select').change(function () {
        $(this).closest('form').submit();
    });


// CATALOG
    $('input.js-product-image-input').on('change', function (e) {
        let uploader = $(this);

        if (uploader.val() !== '') {
            let form_data = new FormData();
            form_data.append('photo', this.files[0]);



            $.ajax({
                url: uploader.data('upload'),
                data: form_data,
                dataType: 'json',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {

                    $('.js-product-images-block').append(
                        '<div class="col-md-4 js-product-media-item">\n' +
                        '<div class="technic-image position-relative">\n' +
                        '<img src="/storage/technics/'+ data +'" alt="">\n' +
                        '<input id="media-file" type="hidden" name="media[][src]" value="'+ data +'" >\n' +
                        '<a class="delete" href="#" style="position: absolute; top: 0px; right: 0px;">\n' +
                        '<svg class="icon">\n' +
                        '<use xlink:href="#icon-clear"></use>\n' +
                        '</svg>\n' +
                        '</a>' +
                        '</div>\n' +
                        '</div>'
                    );
                },
                error: function (xhr, status, error) {
                    let response = eval(xhr.responseText);

                    console.log(response)
                    console.log(response.errors)

                    $.each(response.errors, function (key, value) {
                        console.log(value)

                        $("form#product-form #request-errors").append('<p>' + value + '</p>');
                    });
                }
            });
        }

    });

    $('body').on('click', '.js-product-media-item .delete', function (ev) {
        ev.preventDefault();

        let form_data = new FormData();
        form_data.append('photo', $(this).parents('.js-product-media-item').find('#media-file').val());

        $.ajax({
            url: '/ua/settings/technics/delete-files',
            data: form_data,
            // dataType: 'json',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
            }

        });
        $(this).parents('.js-product-media-item').remove();
    })


    $('#order-form input[name="count"]').change(function () {
        calcOrderPrice();
        calcOrderTenderPrice();
    });

    $('#dataModal .select-date').click(function () {
        $('form.order-form input[name="date_of_delivery"]').val(
            $('#dataModal input.datepickerStaticValue').val()
        );
    });


    $("#modalPersons input[type=checkbox]").change(function(e) {
        if(($("#modalPersons input[type=checkbox]:checked").length) > 3) {
            $(this).prop( "checked", false );
        }
    });


    $('#select-person-btn').click(function () {
        $('#modalPersons').modal('toggle');
        $('#BusinessIncomeRequest .parameters_person-list > div.parameters').addClass('d-none');
        $('#BusinessIncomeRequest .invalid-feedback').hide();


        if(($("#modalPersons input[type=checkbox]:checked").length) >= 3) {
            $('#BusinessIncomeRequest .seller_cabinet-selection').hide()
        }

        $("#modalPersons input[type=checkbox]:checked").each(function(e) {
            $('#BusinessIncomeRequest .parameters_person-list > .person-item-' + $(this).val()).removeClass('d-none');

        });

    });

    $('#select-parameters-btn').click(function () {
        $('#modalParameters').modal('toggle');
        $('#BusinessIncomeRequest .parameters_technic-list > div.technic_item').addClass('d-none');
        $('#BusinessIncomeRequest .invalid-feedback').hide();

        $("#modalParameters input[type=radio]:checked").each(function(e) {
            $('#BusinessIncomeRequest .parameters_technic-list > .technic_item-' + $(this).val()).removeClass('d-none');

        });

    });




    $('.parameters_person-list .parameters .delete').click(function(e) {
        e.preventDefault();
        let person_item = $(this).parent().parent();
        person_item.addClass('d-none');
        $('#modalPersons').find('#person-exp-'+person_item.data('person-id') ).prop( "checked", false );

        if(($("#modalPersons input[type=checkbox]:checked").length) < 3) {
            $('#BusinessIncomeRequest .seller_cabinet-selection').show()
        }

    })


    $('#reviewServiceModal #reviewForm, #contact_usModal #reviewForm').submit(function(e) {
        e.preventDefault();
        let form = $(this);

        $.get(form.attr('action'), form.serialize()).done(function (response) {
            if(response) {
                $(form).addClass('d-none');
                $('#reviewServiceModal #reviewSuccess, #contact_usModal #reviewSuccess').removeClass('d-none');

                setTimeout(function() {
                    $('#reviewServiceModal, #contact_usModal').find('.close').click();

                }, 3000);
            }
        });

    });


    // BusinessSettingProfile
    $('#businessSettingsProfilePhoto input#business-image-loader').change(function () {
        let uploader = $(this);

        if ($(this).val() !== '') {
            let form_data = new FormData();
            form_data.append('photo', this.files[0]);
            $('#image-input-error').text('');

            $.ajax({
                type:'POST',
                url: uploader.data('upload'),
                data: form_data,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        $('#businessSettingsProfilePhoto img.seller_cabinet-settings-logo').attr('src', '/storage/users/' + response);
                        $('form#businessSetting').find('input[name="photo"]').val(response);
                    }
                }
            });
        }
    });
    $('#businessSettingsProfilePhoto .btn-delete').click(function (e) {
        e.preventDefault();

        $.post('/setting/profile/remove-file?filename='+$('form#businessSetting').find('input[name="photo"]').val() );

        let form = $('#businessSettingsProfilePhoto');

        form.find('input#business-image-loader').val('');
        $('form#businessSetting').find('input[name="photo"]').val('');
        form.find("#request-errors").text('');


        form.find('img.seller_cabinet-settings-logo').attr('src', form.find('img.seller_cabinet-settings-logo').data('empty'));
    });


    // BusinessSettingCompany
    $('#businessSettingsCompanyPhoto input#business-image-loader').change(function () {
        let uploader = $(this);

        if ($(this).val() !== '') {
            let form_data = new FormData();
            form_data.append('photo', this.files[0]);
            $('#image-input-error').text('');

            $.ajax({
                type:'POST',
                url: uploader.data('upload'),
                data: form_data,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        $('#businessSettingsCompanyPhoto img.seller_cabinet-settings-logo').attr('src', '/storage/business/' + response);
                        $('form#businessSetting').find('input[name="photo"]').val(response);
                    }
                }
            });
        }
    });
    $('#businessSettingsCompanyPhoto .btn-delete').click(function (e) {

        // $('#confirm-canceled').modal('toggle');

        e.preventDefault();


        $.post('/setting/company/remove-file?filename='+$('form#businessSetting').find('input[name="photo"]').val() );

        let form = $('#businessSettingsCompanyPhoto');

        form.find('input#business-image-loader').val('');
        $('form#businessSetting').find('input[name="photo"]').val('');
        form.find("#request-errors").text('');

        form.find('img.seller_cabinet-settings-logo').attr('src', form.find('img.seller_cabinet-settings-logo').data('empty'));
    });

    // BusinessSettingContacts
    $('#businessSettingContactsPhoto input#business-image-loader').change(function () {
        let uploader = $(this);

        if ($(this).val() !== '') {
            let form_data = new FormData();
            form_data.append('photo', this.files[0]);
            $('#image-input-error').text('');

            $.ajax({
                type:'POST',
                url: uploader.data('upload'),
                data: form_data,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        $('#businessSettingContactsPhoto img.seller_cabinet-settings-logo').attr('src', '/storage/users/' + response);
                        $('form#businessSetting').find('input[name="photo"]').val(response);
                    }
                }
            });
        }
    });
    $('#businessSettingContactsPhoto .btn-delete').click(function (e) {
        e.preventDefault();

        $.post('/setting/contacts/remove-file?filename='+$('form#businessSetting').find('input[name="photo"]').val() );

        let form = $('#businessSettingContactsPhoto');

        form.find('input#business-image-loader').val('');
        $('form#businessSetting').find('input[name="photo"]').val('');
        form.find("#request-errors").text('');

        form.find('img.seller_cabinet-settings-logo').attr('src', form.find('img.seller_cabinet-settings-logo').data('empty'));
    });

    // ClientProfile
    $('#customerProfilePhoto input#customer-image-loader').change(function () {
        let uploader = $(this);

        if ($(this).val() !== '') {
            let form_data = new FormData();
            form_data.append('photo', this.files[0]);
            $('#image-input-error').text('');

            $.ajax({
                type:'POST',
                url: uploader.data('upload'),
                data: form_data,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        $('#customerProfilePhoto img.customer_cabinet-settings-logo').attr('src', '/storage/users/' + response);
                        $('form#customerProfile').find('input[name="photo"]').val(response);
                    }
                }
            });
        }
    });
    $('#customerProfilePhoto .delete').click(function (e) {
        e.preventDefault();

        $.post('/customer/profile/remove-file?filename='+$('form#customerProfile').find('input[name="photo"]').val() );

        let form = $('#customerProfilePhoto');

        form.find('input#customer-image-loader').val('');
        $('form#customerProfile').find('input[name="photo"]').val('');
        form.find("#request-errors").text('');


        form.find('img.customer_cabinet-settings-logo').attr('src', form.find('img.customer_cabinet-settings-logo').data('empty'));
    });

    $("#filter-form .selectpicker").change(function (){
        if($(this).val() == 'distance') {
            $("#filter-form #address").removeClass('disabled')
            $("#filter-form #address").removeAttr('readonly')
            $("#filter-form #address").removeAttr('disabled')
        } else {
            $("#filter-form #address").addClass('disabled')
            $("#filter-form #address").attr('readonly', true)
            $("#filter-form #address").attr('disabled', true)
        }
    })



    $('.show-phone-number').click(function(e) {
        e.preventDefault();
        let phone = $(this).attr('data-phone');

        $(this).parent().text(phone);
        $(this).addClass('hidden');

    })

    $('.btn-filter-box button').click(function(e) {
        e.preventDefault();
        $('.filter-box').removeClass('d-none');
        $('.filter-box').addClass('d-block');
        $('.filter-box').addClass('show');

        if($('.filter-box').hasClass('show')) {
            $('.btn-filter-box').removeClass('d-block');
            $('.btn-filter-box').addClass('d-none');
        } else {
            $('.btn-filter-box').addClass('d-block');
            $('.btn-filter-box').removeClass('d-none');
        }

    })

    $('.btnStatFilter').click(function(e) {
        e.preventDefault();
        $('#formStatFilter').submit();
    });

});

function calcOrderPrice() {
    let count = $('#order-form input[name="count"]').val();
    let price = $('#order-form #price b').text();
    $('#order-form #estimated-product-price b').text(count * price);
    $('#estimated-product-total-price .total_sum').text(count * price);

    technicOptionCalculate(count, price);


}


function technicOptionButton() {
    $(".technic-option").change(function() {
        if ($(this).is(':checked')) {
            $(this).parent().find('label').removeClass('btn-border_dark')
            $(this).parent().find('label').addClass('btn-border_main')
            $(this).parent().find('label').text('Видалити замовлення')
        } else {
            $(this).parent().find('label').addClass('btn-border_dark')
            $(this).parent().find('label').removeClass('btn-border_main')
            $(this).parent().find('label').text('Додати до замовлення')

        }
    });

}

function technicOptionCalculate(count, price) {
    let items = [
        { id:1, quantity: count, amount: price },
    ];

    // items.pop();

    $(".technic-option").change(function() {
        if ($(this).is(':checked')) {
            items.push({id: 2, quantity: 10, amount: 1000});
            // calcOrderPrice();

        } else {
            // calcOrderPrice();
            items.pop();

        }

        let cart = items.reduce((acc = {}, item = {}) => {
            const itemTotal = parseFloat((item.amount * item.quantity).toFixed(2));
            acc.total = parseFloat((acc.total + itemTotal).toFixed(2));

            return acc;
        }, {
            total: 0
        });

        $('#estimated-product-total-price .total_sum').text(cart.total);

    });

    // calcOrderPrice();


}



function calcOrderTenderPrice() {
    let count = $('form.order-form input[name="count"]').val();

    $('form.order-form #price-min').text(
        count * $('form.order-form input#start').val()
    );

    $('form.order-form #price-max').text(
        count * $('form.order-form input#end').val()
    );
}



function initFormPass(){
    $(document).on('change', '.form-pass-checkbox', function() {
        $(this).siblings('.form-control').attr('type', function(index, attr){
            return attr == 'password' ? 'text' : 'password';
        });
    });
}

function initPhoneMask(){
    $('input[name=phone], input[name=contact_phone], input.disabled-phone').mask('+38 (099) 999-99-99');
}

function initMenu(){
    $(document).on('click', '.menuToggle', function() {
        $($(this).attr('href')).toggleClass('show');
    });
}

function initBgPremium(){
    $(window).on('load resize orientationchange', function() {
        if ($('.premium-bg').length) {
            if (window.matchMedia('(min-width: 768px)').matches){
                $('.premium-bg').css('right', '50%');
            } else if (window.matchMedia('(max-width: 767.8px)').matches){
                $('.premium-bg').css('right', -$('.premium-bg').parent('.premium-side').offset().left);
            }
            $('.premium-bg').css('left', -$('.premium-bg').parent('.premium-side').offset().left);
        }
    });
}

function initRangeSlider(){
    $('.range').each(function() {
        var obj = $(this);
        var slider = obj.find('.range-slider');
        var start = obj.find('.start');
        var end = obj.find('.end');
        var inputs = [start[0], end[0]];

        noUiSlider.create(slider[0], {
            start: [slider.data('start'), slider.data('end')],
            connect: true,
            range: {
                'min': slider.data('min'),
                'max': slider.data('max')
            },
            step: slider.data('step'),
            format: wNumb({
                decimals: 0
            })
        });

        slider[0].noUiSlider.on('update', function (values, handle) {
            inputs[handle].value = values[handle];
            calcOrderTenderPrice();
        });

        inputs.forEach(function (input, handle) {
            input.addEventListener('change', function () {
                slider[0].noUiSlider.setHandle(handle, this.value);
            });
        });
    });
}

function initDatepicker(){
    $('.datepickerStatic input').flatpickr({
        inline: true,
        mode: 'range',
        minDate: 'today',
        dateFormat: 'd.m.Y',
        monthSelectorType: 'static',
        prevArrow: '<svg><use xlink:href="#icon-left"></use></svg>',
        nextArrow: '<svg><use xlink:href="#icon-right"></use></svg>',
        locale: 'uk'
    });
}

function initAutoComlete() {
    $('.basicAutoComplete').autoComplete({
        resolverSettings: {
            url: '../test.json'
        }
    });
}

function initGallery() {
    $('.gallery .gallery-item').on('click', function(event) {
        event.preventDefault();
        Fresco.show([
            '/storage/technics/1647889645.jpg',
        ]);
    });
}

function initPopover() {
    $('[popover]').each(function() {
        var obj = $(this);
        obj.popover({
            placement: 'top',
            html: true,
            template: '<div class="popover" role="tooltip"><div class="popover-header"></div><div class="popover-body"></div></div>',
            title: function() {
                return $(this).data('title');
            },
            content: function() {
                return '<a href="'+ $(this).data('link') +'"><b>'+ $(this).data('text') +'</b></a>'
            },
            trigger: 'focus'
        });
    });

    $('[popover]').hover(
        function() {
            $(this).focus();
        }
    );
}

buildAutocomplete = function () {
    const acInputs = $(".autocomplete");
    const options = {
        fields: ["geometry","address_components"],
        strictBounds: false,
        componentRestrictions: {country: "ua"},

    };

    const autocomplete = new google.maps.places.Autocomplete(acInputs[0], options);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        const place = autocomplete.getPlace();


        let location_lat_destination = $('form').find('.location_lat_destination');
        let location_lng_destination = $('form').find('.location_lng_destination');
        let location_region = $('form').find('.location_region');
        let location_city = $('form').find('.location_city');
        location_lat_destination.remove();
        location_lng_destination.remove();
        location_region.remove();
        location_city.remove();


        $.each(place, function(k1,v1) {
            if (k1 == "address_components") {
                for (let i = 0; i < v1.length; i++) {
                    for (k2 in v1[i]) {
                        if (k2 == "types") {
                            let types = v1[i][k2];
                            if(types[0] =="administrative_area_level_1") {
                                county = v1[i].long_name;
                                $(acInputs).parent().append('<input class="location_region" type="hidden" name="location_region" value="'+ county + '" />');
                            }
                            if (types[0] =="locality") {
                                city = v1[i].long_name;
                                $(acInputs).parent().append('<input class="location_city" type="hidden" name="location_city" value="'+ city + '" />');
                            }
                        }

                    }

                }


            }

        });




        $(acInputs).parent().append('<input class="location_lat_destination" type="hidden" name="location_lat" value="' + place.geometry.location.lat() + '" />');
        $(acInputs).parent().append('<input class="location_lng_destination" type="hidden" name="location_lng" value="'+ place.geometry.location.lng() + '" />');




    });


    return buildAutocomplete;
}


function confirmDelete() {
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $('.btn-ok').click(function(data) {
            $(this).attr("disabled", true);
            let href = $(e.relatedTarget).data('href');
            if(typeof href !== "undefined") {
                location.href = href;
            }
        });
    });

}

function confirmSubscribeDeactivate() {
    $('#confirm-subscribe-deactivate').on('show.bs.modal', function(e) {
        $('.btn-ok').click(function(data) {
            $(this).attr("disabled", true);
            let href = $(e.relatedTarget).data('href');
            if(typeof href !== "undefined") {
                location.href = href;
            }
        });
    });

}

function confirmCanceled() {
    $('#confirm-canceled').on('show.bs.modal', function(e) {
        $('.btn-ok').click(function(data) {
            $(this).attr("disabled", true);
            let href = $(e.relatedTarget).data('href');
            if(typeof href !== "undefined") {
                location.href = href;
            }
        });

    });

}

function alphaOnly() {
    $('.js-name').keydown(function (e) {
        if (e.ctrlKey || e.altKey) {
            e.preventDefault();
        } else {
            var key = e.keyCode;
            if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                e.preventDefault();
            }
        }


        // if (/\D/g.test(this.value))
        // {
        //     // Filter non-digits from input value.
        //     this.value = this.value.replace(/\D/g, '');
        // }
    });



}


function digitsOnly() {
    $('input.sms-code').bind('keypress', function(e) {
        // if ( event.keyCode > 31 && (event.keyCode < 48 || event.keyCode > 57) ) {
        //     // Key code is a number, the `keydown` event will fire next
        //     return false;
        // }
        // // Key code is not a number return false, the `keydown` event will not fire
        // return true;
        //

        var charCode = (e.which) ? e.which : event.keyCode;

        if (String.fromCharCode(charCode).match(/[^0-9]/g)) {
            return false;

        }


    });

}




function scrollToTargetAdjusted(el) {
    let element = document.getElementById(el);
    let headerOffset = 72;
    let elementPosition = element.getBoundingClientRect().top;
    let offsetPosition = elementPosition + window.pageYOffset - headerOffset;

    window.scrollTo({
        top: offsetPosition,
        behavior: "smooth"
    });
}



