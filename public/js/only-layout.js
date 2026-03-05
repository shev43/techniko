$(function() {$('[data-toggle="popover"]').popover();
    initRangeSlider();
    initDatepicker();
    initAutoComlete();
    initGallery();
    initPopover();
});

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
    $('.gallery-item').on('click', function(event) {
        event.preventDefault();
        Fresco.show([
            { url: 'https://picsum.photos/id/111/1920/1080'},
            { url: 'https://picsum.photos/id/133/1920/1080'},
            { url: 'https://picsum.photos/id/376/1920/1080'},
            { url: 'https://picsum.photos/id/514/1920/1080'},
            { url: 'https://picsum.photos/id/617/1920/1080'},
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