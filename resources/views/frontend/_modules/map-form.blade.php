<style>
    .map {
        margin-bottom: 60px;
    }
    .map-body {
        height: 380px;
    }
    .map-body + .alert {
        margin: 20px 0 0;
    }
    .map iframe {
        width: 100%;
        height: 100%;
        border: none;
    }
    .map.disabled {
        pointer-events: none;
        filter: grayscale(1);
    }

</style>


@if(!empty($objects))
    @php($object = (empty($objects['id']) ) ? $objects[0] : $objects)
@else
    @php($object = $objects)
@endif

@if((request()->routeIs('customer::request.create-duplicate')) || (request()->routeIs('customer::tender.create-duplicate')))
    <div class="map {{ old('type_of_delivery', $object->type_of_delivery) == 'self' ? 'disabled' : '' }}">
        <div class="map-body" id="map"></div>
    </div>
@else
    <div class="map {{old('type_of_delivery', '') == 'self' ? 'disabled' : ''}}">
        <div class="map-body" id="map"></div>
    </div>
@endif

<div id="map-warning" class="alert alert-warning alert-dismissible d-none" role="alert">
    Уточніть адресу, поставивши маркер на карті.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <svg>
            <use xlink:href="#icon-5"></use>
        </svg>
    </button>
</div>

<input type="hidden" name="map_latitude" id="map_latitude"
       value="{{old('map_latitude', ($object['map_latitude'] ?? Config::get('map.default.map_latitude')))}}">
<input type="hidden" name="map_longitude" id="map_longitude"
       value="{{old('map_longitude', ($object['map_longitude'] ?? Config::get('map.default.map_longitude')))}}">
<input type="hidden" name="map_zoom" id="map_zoom"
       value="{{old('map_zoom', ($object['map_zoom'] ?? Config::get('map.default.map_zoom')))}}">
<input type="hidden" name="map_rotate" id="map_rotate"
       value="{{old('map_rotate', ($object['map_rotate'] ?? Config::get('map.default.map_rotate')))}}">

<input type="hidden" name="marker_latitude" id="marker_latitude"
       value="{{old('marker_latitude', ($object['marker_latitude'] ?? Config::get('map.default.marker_latitude')))}}">
<input type="hidden" name="marker_longitude" id="marker_longitude"
       value="{{old('marker_longitude', ($object['marker_longitude'] ?? Config::get('map.default.marker_longitude')))}}">

@foreach(['map_latitude', 'map_longitude', 'map_zoom', 'map_rotate'] as $field)
    @foreach($errors->get($field) as $error)
        <small class="form-text text-danger">{!! $error !!}</small>
    @endforeach
@endforeach

@if($errors->has('marker_latitude') || $errors->has('marker_longitude'))
    <small class="form-text text-danger"> Вкажіть розташування спецтехніки на карті (клікнувши у необхідному місці) </small>
@endif

@section('map_scripts')
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.6.0/mapbox-gl.js'></script>
    <script
        src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.min.js"></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.6.0/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet"
          href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.css"
          type="text/css">


    <script>
        opencageConfig = @json(Config::get('opencage'), JSON_PRETTY_PRINT);
        mapboxgl.accessToken = '{{ Config::get('map.accessToken') }}';

        let setMakerByAddress = function (address) {
            address.removeClass('is-invalid');
            address.parent().find('.invalid-feedback').text('');

            $.ajax({
                url: 'https://api.opencagedata.com/geocode/v1/json',
                method: 'GET',
                data: {
                    'key': opencageConfig.key,
                    'q': address.val(),
                    'pretty': 1,
                    'no_annotations': 1,
                    // "limit": 1,
                    'countrycode': opencageConfig.countrycode,
                    'language': opencageConfig.language
                },
                dataType: 'json',
                statusCode: {
                    200: function (response) {
                        console.log(response.results)
                        if (response.results.length) {
                            goToPositionOnMap(response.results[0].geometry.lng, response.results[0].geometry.lat);
                            $('input#marker_latitude').val(response.results[0].geometry.lat);
                            $('input#marker_longitude').val(response.results[0].geometry.lng);
                            // $('#map-warning').removeClass('d-none');
                        } else {
                            $('input#marker_latitude').val('');
                            $('input#marker_longitude').val('');
                            address.addClass('is-invalid');
                            address.parent().find('.invalid-feedback').text('Адрес не знайдено');
                        }
                    },
                    400: function () {
                        address.addClass('is-invalid');
                        address.parent().find('.invalid-feedback').text('Адрес не знайдено');
                    },
                    402: function () {
                        console.log('hit free trial daily limit');
                    }
                }
            });
        };

        let goToPositionOnMap = function (lng, lat) {
            if (marker) {
                marker.remove();
            }

            marker = new mapboxgl.Marker()
                .setLngLat([lng, lat])
                .addTo(map);

            map.flyTo({
                center: [lng, lat],
                zoom: 14,
                essential: true
            });
        };

        var map = new mapboxgl.Map({
            container: 'map',
            types: 'address',
            country: 'ua',
            language: 'uk',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [{{old('map_longitude', ($object['map_longitude'] ?? Config::get('map.default.map_longitude')))}}, {{old('map_latitude', ($object['map_latitude'] ?? Config::get('map.default.map_latitude')))}}],
            zoom: {{  old('map_zoom', ($object['map_zoom'] ?? Config::get('map.default.map_zoom')) ) }},
            rotate: {{old('map_rotate', ($object['map_rotate'] ?? Config::get('map.default.map_rotate')))}},
        });

        var marker;

        function setMarker(position) {
            if (marker) {
                marker.remove();
            }

            marker = new mapboxgl.Marker()
                .setLngLat(position)
                .addTo(map);

            document.getElementById("marker_longitude").value = position.lng;
            document.getElementById("marker_latitude").value = position.lat;
        }

        let geocode = function geocode(query, input) {
            $.ajax({
                url: 'https://api.opencagedata.com/geocode/v1/json',
                method: 'GET',
                data: {
                    'key': opencageConfig.key,
                    'q': query,
                    'no_annotations': 1,
                    'language': opencageConfig.language,
                    'pretty': 1,
                    "limit": 1,
                    '_type': 'city',
                    'countrycode': opencageConfig.countrycode,
                },
                dataType: 'json',
                statusCode: {
                    200: function (response) {  // success
                        console.log(response.results)

                        if (response.results.length) {
                            input.val(response.results[0].formatted);
                            let geoPrepare = {
                                'lat': response.results[0].geometry.lat,
                                'lng': response.results[0].geometry.lng,
                            }

                            setMarker(geoPrepare);
                        }

                    },
                    402: function () {
                        console.log('hit free trial daily limit');
                    }
                }

            });
        }

        map.on('click', function (e) {
            let address = $('{{ $target }}');
            geocode(e.lngLat.lat + ',' + e.lngLat.lng, address);
            address.removeClass('is-invalid').parent().find('.invalid-feedback').text('');
        });

        map.on('zoomend', function (e) {
            document.getElementById("map_zoom").value = map.getZoom();
        });

        map.on('moveend', function (e) {
            let center = map.getCenter();
            document.getElementById("map_longitude").value = center.lng;
            document.getElementById("map_latitude").value = center.lat;
        });

        map.on('load', function () {
            setTimeout(function () {
                setMakerByAddress($('form input[name=address]'));
            }, 100);

            @if(old('marker_latitude', ($object['marker_latitude'] ?? Config::get('map.default.marker_latitude')) !== '' && old('marker_longitude', ($object['marker_longitude'] ?? Config::get('map.default.marker_longitude'))) !== ''))
            setMarker({
                'lng': {{old('marker_longitude', ($object['marker_longitude'] ?? Config::get('map.default.marker_longitude')))}},
                'lat': {{old('marker_latitude', ($object['marker_latitude'] ?? Config::get('map.default.marker_latitude')))}}
            });
            @endif
        });

        map.on('rotate', function () {
            document.getElementById("map_rotate").value = map.getBearing();
        });

        $('{{ $target }}').change(function () {
            if ($(this).val().length > 0) {
                $(this).removeClass('is-invalid');
                $(this).parent().find('.invalid-feedback').text('');
                setMakerByAddress($(this));
            } else {
                $(this).addClass('is-invalid');
                $(this).parent().find('.invalid-feedback').text('Адрес надто короткий');
            }
        });

        $('{{ $target }}').keypress(function (event) {
            let keycode = (event.keyCode ? event.keyCode : event.which);

            if (keycode == '13') {
                if ($(this).val().length > 0) {
                    setMakerByAddress($(this));
                } else {
                    $(this).addClass('is-invalid');
                    $(this).parent().find('.invalid-feedback').text('Адрес надто короткий');
                }
            }
        });


    </script>

@endsection


