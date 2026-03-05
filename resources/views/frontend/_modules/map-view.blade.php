<div class="map">
    <div class="map-body" id="map"></div>
</div>

@if(!empty($objects))
    @php($object = (empty($objects['id']) ) ? $objects[0] : $objects)
@else
    @php($object = $objects)
@endif


@section('map_scripts')
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.6.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.6.0/mapbox-gl.css' rel='stylesheet' />

    <script>
        opencageConfig = @json(Config::get('opencage'), JSON_PRETTY_PRINT);
        mapboxgl.accessToken = '{{ Config::get('map.accessToken') }}';

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [{{ ($object['map_longitude'] ?? Config::get('map.default.map_longitude') ) }}, {{  ($object['map_latitude'] ?? Config::get('map.default.map_latitude')) }}],
            zoom: {{ ($object['map_zoom'] ?? Config::get('map.default.map_zoom') ) }},
            rotate: {{ ($object['map_rotate'] ?? Config::get('map.default.map_rotate') ) }},
        });

        var marker;

        function setMarker(position) {
            if (marker) {
                marker.remove();
            }

            marker = new mapboxgl.Marker()
                .setLngLat(position)
                .addTo(map);
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
                    'countrycode': opencageConfig.countrycode,
                },
                dataType: 'json',
                statusCode: {
                    200: function (response) {  // success
                        input.val(response.results[0].formatted);
                    },
                    402: function () {
                        console.log('hit free trial daily limit');
                    }
                }
            });
        }

        map.on('load', function () {
            @if(($object['marker_latitude'] ?? Config::get('map.default.marker_latitude')) !== '' && ($object['marker_longitude'] ?? Config::get('map.default.marker_longitude')) !== '')
            setMarker({
                'lng': {{ ($object['marker_longitude'] ?? Config::get('map.default.marker_longitude')) }},
                'lat': {{ ($object['marker_latitude'] ?? Config::get('map.default.marker_latitude')) }}
            });
            @endif
        });

        map.addControl(new mapboxgl.NavigationControl());
    </script>
@endsection


