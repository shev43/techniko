$(document).ready(function() {

    let startResendTimer = function (timer) {
        timer.text(timer.data('second'));
        timer.parent().show();
        timer.parent().parent().find(".resend-login-sms, .resend-register-sms, .resend-change-phone-sms").hide();

        let timeLeft = parseInt(timer.data('second'));

        let downloadTimer = setInterval(function () {
            if (timeLeft <= 0) {
                clearInterval(downloadTimer);
                timer.parent().hide();
                timer.parent().parent().find(".resend-login-sms, .resend-register-sms, .resend-change-phone-sms").show();
            } else {
                timer.text(timeLeft);
            }
            timeLeft -= 1;
        }, 1000);
    }

    let resetWarning = function() {
        $('#authModal').find('input').removeClass('is-invalid');
        $('#authModal').find('.invalid-feedback').text('');

    }

    let resetFields = function() {
        $('#authModal').find('input').removeClass('is-invalid');
        $('#authModal').find('.invalid-feedback').text('');
        $('#authModal').find('input[type="text"], input[type="email"], input[type="password"], input[name="accept"]').val('');
        $('#authModal').find('input[name="accept"]').prop('checked', false);


    }

    let defaultCustomerTab = function() {
        $('#authModal #customer section').hide();
        $('#authModal #customer section.login').show();
        $('#authModal #customer .form-step').hide();
        $('#authModal #customer .form-step.step-1').show();
        resetFields()
    }

    let defaultBusinessTab = function() {
        $('#authModal #business section').hide();
        $('#authModal #business section.login').show();
        $('#authModal #business .form-step').hide();
        $('#authModal #business .form-step.step-1').show();
        resetFields()

    }

    let showCustomerLoginForm = function() {
        $('#authModal #customer-tab').click();
        $('#authModal #customer').addClass('active');
        $('#authModal #customer').addClass('show');

        $('#authModal #business-tab').parent().hide();
    }

    let showBusinessLoginForm = function() {
        $('#authModal #business-tab').click();
        $('#authModal #business').addClass('active');
        $('#authModal #business').addClass('show');

        $('#authModal #customer-tab').parent().hide();
    }

    $("#authModal .form-group-sms input[type='text']").keyup(function (e) {
        var keyCode = e.keyCode || e.which;

        if (keyCode === 8) {
            if (!this.value.length) {
                $(this).prev('input[type=text]').focus();
            }

        } else {
            if (this.value.length === this.maxLength) {
                $(this).next('input[type=text]').focus();
            }
        }
    });

    $('#authModal #customer-tab').click(function() {
        defaultCustomerTab();

    });

    $('#authModal #business-tab').click(function() {
        defaultBusinessTab()

    });

    $('#authModal').on('hidden.bs.modal', function () {
        resetFields()
        $('#authModal #customer-tab').parent().show();
        $('#authModal #customer-tab').click();
        $('#authModal #business-tab').parent().show();
    })


    $('#authModal #customer button[type="button"]').click(function(e) {
        resetFields()
        $('#authModal #customer section').toggle();
    });

    $("#authModal #customer .login .form-step.step-2 .resend-login-sms, #authModal #customer .register .form-step.step-2 .resend-register-sms").click(function () {
        resetWarning();
        $('#authModal form').find('input[name="code"]').val('')
        $('#authModal form .form-group-sms').find('input[type="text"]').val('')
        $("#authModal #customer .login .form-step.step-1 form, #authModal #customer .register .form-step.step-1 form").submit();
    });


    $('.showAuthBusinessModel').on('click',function(e) {
        e.preventDefault()
        $('#authModal').modal('show');
        showBusinessLoginForm()
    })
    $('.showAuthCustomerModel').submit('click',function(e) {
        e.preventDefault()
        $('#authModal').modal('show');
        showCustomerLoginForm()
    })

    $('.technicItemShowAuthCustomerModel').click(function(e) {
        e.preventDefault()
        $('#authModal').modal('show');
        showCustomerLoginForm()
    })




    $('#authModal #customer .login .form-step.step-1 form').submit(function(e) {
        e.preventDefault()

        let phone = $(this).find('input[name="phone"]').val();

        $.post($(this).attr('action'), $(this).serialize()).done(function (data) {
            $('#authModal #customer .login .form-step').hide();
            $('#authModal #customer .login .form-step.step-2').show();
            $('#authModal #customer .login .form-step.step-2 input[name="c1"]').focus();

            $("#authModal #customer .login .form-step.step-2 form input[name='phone']").val(phone);
            startResendTimer($("#authModal #customer .login .form-step.step-2 .timer"))

        }).fail(function (data) {
            $('#authModal #customer .login .form-step.step-1 .invalid-feedback')
                .text(data.responseJSON.error)
                .parent()
                .parent()
                .find('input[name="phone"]')
                .addClass('is-invalid')

        });


    });

    $('#authModal #customer .login .form-step.step-2 form').submit(function(e) {
        e.preventDefault()
        resetWarning()

        $(this).find('input[name="code"]').val('');
        let c1 = $(this).find('input[name="c1"]').val();
        let c2 = $(this).find('input[name="c2"]').val();
        let c3 = $(this).find('input[name="c3"]').val();
        let c4 = $(this).find('input[name="c4"]').val();

        $(this).find('input[name="code"]').val(c1 + c2 + c3 + c4);

        $.post($(this).attr('action'), $(this).serialize()).done(function (data) {

            let ref = $('#authModal #customer .login .form-step.step-2 form')
                .find('input[name=referer]').val();
            if(ref == '') { ref = '/'; }

            location.href=ref;

            // location.href='/';
            // location.href = '/ua/customer/';

        }).fail(function (data) {
            $('#authModal #customer .login .form-step.step-2 .invalid-feedback')
                .text(data.responseJSON.error)
                .addClass('is-invalid')

        });
    });

    $('#authModal #customer .register .form-step.step-1 form').submit(function(e) {
        e.preventDefault()
        resetWarning()

        let phone = $(this).find('input[name="phone"]').val();
        let first_name = $(this).find('input[name="first_name"]').val();
        let last_name = $(this).find('input[name="last_name"]').val();
        $.post($(this).attr('action'), $(this).serialize()).done(function (data) {
            $('#authModal #customer .register .form-step').hide();
            $('#authModal #customer .register .form-step.step-2').show();
            $('#authModal #customer .register .form-step.step-2 input[name="c1"]').focus();

            $("#authModal #customer .register .form-step.step-2 form input[name='phone']").val(phone);
            $("#authModal #customer .register .form-step.step-2 form input[name='first_name']").val(first_name);
            $("#authModal #customer .register .form-step.step-2 form input[name='last_name']").val(last_name);
            startResendTimer($("#authModal #customer .register .form-step.step-2 .timer"))

        }).fail(function (data) {
            $.each(data.responseJSON.errors, function (key, value) {
                $('#authModal #customer .register .form-step.step-1 form')
                    .find('input[name="' + key + '"]')
                    .addClass('is-invalid')
                    .parent()
                    .find('.invalid-feedback')
                    .text(value);
            });



        });
    });

    $('#authModal #customer .register .form-step.step-2 form').submit(function(e) {
        e.preventDefault()
        resetWarning()

        $(this).find('input[name="code"]').val('');
        let c1 = $(this).find('input[name="c1"]').val();
        let c2 = $(this).find('input[name="c2"]').val();
        let c3 = $(this).find('input[name="c3"]').val();
        let c4 = $(this).find('input[name="c4"]').val();

        $(this).find('input[name="code"]').val(c1 + c2 + c3 + c4);

        $.post($(this).attr('action'), $(this).serialize()).done(function (data) {

            let ref = $('#authModal #customer .register .form-step.step-2 form')
                .find('input[name=referer]').val();
            if(ref == '') { ref = '/'; }

            location.href=ref;


            // location.href='/';
            // location.href = '/ua/customer/';

        }).fail(function (data) {
            $('#authModal #customer .register .form-step.step-2 .invalid-feedback')
                .text(data.responseJSON.error)
                .addClass('is-invalid')

        });
    });

    $('#authModal #business .login .form-step.step-1 form').submit(function(e) {
        e.preventDefault()
        resetWarning()

        let input_login = $('#authModal #business .login .form-step.step-1 form input[name=email]').val();
        let input_password = $('#authModal #business .login .form-step.step-1 form input[name=password]').val();


        $.post($(this).attr('action'), $(this).serialize()).done(function (data) {

            let ref = $('#authModal #business .login .form-step.step-1 form')
                .find('input[name=referer]').val();
            if(ref == '') { ref = '/ua/business/request/'; }

            location.href='/ua/business/dashboard/';

        }).fail(function (data) {
            $.each(data.responseJSON.errors, function (key, value) {
                $('#authModal #business .login .form-step.step-1 form .invalid-feedback').append('<p>'+ value +'</p>')
                    .parent()
                    .find('input[name="' + key + '"]')
                    .addClass('is-invalid')

                if(input_login.length > 0 && input_password.length > 0) {
                    $('#authModal #business .login .form-step.step-1 form .access-recovery').removeClass('hidden')
                }
            });

        });
    });


});
