<div class="tab-pane fade show active" id="content5" style="padding-right: 10px;">
            <div class="row">
                <div class="col-md-8">
                    
                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            <div class="row pb-3">
                                <div class="col-md-6">
                                    <h4>NUMBER OF RECOMMENDATIONS GENERATED</h4>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h2>{{ number_format('140000') }}</h2>
                                </div>
                            </div>
                            <figure class="highcharts-figure">
                                <div id="recommendations"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card rounded-3 shadow-sm">
                                <div class="card-body">
                                    <div class="row pb-3">
                                        <div class="col-md-6">
                                            <h4>TOTAL NUMBER OF FARMERS REGISTERED</h4>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <h2>{{ number_format('2615750') }}</h2>
                                        </div>
                                    </div>
                                    <figure class="highcharts-figure">
                                        <div id="registered_farmers"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card rounded-3 shadow-sm">
                                <div class="card-body">
                                    <div class="row pb-3">
                                        <div class="col-md-6">
                                            <h4>TOTAL NUMBER OF FARMERS WITH ID CARD</h4>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <h2>{{ number_format('8244') }}</h2>
                                        </div>
                                    </div>
                                    <figure class="highcharts-figure">
                                        <div id="farmers_id"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            <div id="map_with_image" style="height: 700px; width: 100%;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="col h-auto">
                        <div class="card rounded-3 shadow-sm">
                            <div class="card-body p-1">
                                <div class="card bg-black m-0">
                                    <div class="text-center pt-1 text-white fw-bold">Total Area Measured</div>
                                    <div class="d-flex justify-content-center pt-1">

                                        <div class="me-2">
                                            <div class="">
                                                <i data-feather="map-pin" style="width: 30px; height: 30px; color:white;"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto text-left">
                                            <p class="mb-0 fw-bolder fs-2 text-white" style="font-size: 20px;">266,504.53</p>
                                            <h1 class="fw-bolder mb-0" style="font-size: 3rem;"></h1>
                                        </div>
                                    </div>
                                    <div class="text-center pt-0 text-white fw-bold">(hectares)</div>

                                    <div class="text-end pt-2 px-1 text-white fw-bold">View Details</div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col h-auto">
                        <div class="card rounded-3 shadow-sm">
                            <div class="card-body p-1">
                                <div class="card bg-success m-0">
                                    <div class="text-center pt-1 text-white fw-bold">Number of SMS Provided To Farmers</div>
                                    <div class="d-flex justify-content-center pt-1">

                                        <div class="me-2">
                                            <div class="">
                                                <i data-feather="mail" style="width: 30px; height: 30px; color:white;"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto text-left">
                                            <p class="mb-0 fw-bolder fs-2 text-white" style="font-size: 20px;">2,084,253</p>
                                            <h1 class="fw-bolder mb-0"  style="font-size: 3rem;"></h1>
                                        </div>
                                    </div>

                                    <div class="text-end pt-2 px-1 text-white fw-bold">View Details</div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col h-auto">
                        <div class="card rounded-3 shadow-sm">
                            <div class="card-body p-1">
                                <div class="card bg-warning m-0">
                                    <div class="text-center pt-1 text-white fw-bold">Total Number of Registered Users</div>
                                    <div class="d-flex justify-content-center pt-1">

                                        <div class="me-2">
                                            <div class="">
                                                <i data-feather="user" style="width: 30px; height: 30px; color:white;"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto text-left">
                                            <p class="mb-0 fw-bolder fs-2 text-white" style="font-size: 20px;">17,487</p>
                                            <h1 class="fw-bolder mb-0" style="font-size: 3rem;"></h1>
                                        </div>
                                    </div>

                                    <div class="text-end pt-2 px-1 text-white fw-bold">View Details</div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initMap2();
        });

        function initMap2() {
            const map = new google.maps.Map(document.getElementById('map_with_image'), {
                center: {
                    lat: 12.8797,
                    lng: 121.7740
                },
                zoom: 6,
            });

            // Variable to keep track of the currently open infoWindow
            let currentInfoWindow = null;

            @foreach ($allFarms as $key => $value)

                @if($key <=30)
                    @php
                        $farmerDetails = $value->farmerDetails;
                        $farmerDetails->full_name = ucwords($farmerDetails->full_name);
                    @endphp

                    var myVar{{ $key }} = '';
                    var polygon{{ $key }} = JSON.parse('{{ $value->area_location }}'.replace("&quot;latLngs&quot;",
                        "\"latLngs\""));
                    coords = toPolygonObj(polygon{{ $key }});

                    var polygonArea = google.maps.geometry.spherical.computeArea(coords);
                    var maxAllowedArea = 1000000; // 1,000,000 square meters
                    var polygonAreaHa = polygonArea / 10000; // Convert square meters to hectares

                    if (polygonArea <= maxAllowedArea) {
                        // Create a polygon for the farm
                        const poly{{ $key }} = new google.maps.Polygon({
                            paths: coords,
                            strokeColor: "#FF0000",
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillColor: "#FF0000",
                            fillOpacity: 0.35,
                        });

                        // Set the polygon on the map
                        poly{{ $key }}.setMap(map);

                        let icon = "";
                        if({{ $key }} % 2 == 0) {
                            icon = 'https://lh6.googleusercontent.com/proxy/-J83WtP9qhWn3NOYCEDDw4ertIC0twCxRBAzfTMrrhHcL1ZISitZKq0ERbY6daOLBphOVdnhaQc'
                        } else {
                            icon = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQx0y1Ensv9-dF8rpNkXhfAEfQnyWF4kXMoE_OyWbI8GQ&s'
                        }

                        // Create a marker for the farm
                        const marker{{ $key }} = new google.maps.Marker({
                            position: coords[0], // Use the first coordinate as the marker position
                            map: map,
                            title: 'Farm ID: {{ $value->farm_id }}',
                            icon: {
                                url : icon,
                                scaledSize: new google.maps.Size(50, 50), // scaled size
                                origin: new google.maps.Point(0,0), // origin
                                anchor: new google.maps.Point(0, 0) // anchor
                            }
                        });

                        @foreach (explode(',', $value->farm_image) as $image)
                            myVar{{ $key }} +=
                                '<a href="{{ asset('') }}{{ $image }}" target="_blank"><img src="{{ asset('') }}{{ $image }}" alt="Farm Image" width="150px" style="padding: 5px;"></a>';
                        @endforeach

                        // Optional: Add an info window for each marker to display additional information
                        var infoWindow{{ $key }} = new google.maps.InfoWindow({
                            content: '<table>' +
                                '<tr><td>Farm ID:</td><td>{{ $value->farm_id }}</td></tr>' +
                                '<tr><td>Area:</td><td>' + formatNumber(polygonAreaHa) + ' ha</td></tr>' +
                                '<tr><td>Farmer:</td><td>{{ $farmerDetails->full_name }}</td></tr>' +
                                '</table>' +
                                '<hr />' +
                                '<div class="map_image">' + myVar{{ $key }} + '</div>',
                            maxWidth: 1200, // Set the maximum width
                            minHeight: 150, // Set the minimum height
                        });

                        // Add click event listener to the marker
                        marker{{ $key }}.addListener('click', function() {
                            // Close the currently open infoWindow, if any
                            if (currentInfoWindow) {
                                //currentInfoWindow.close();
                            }

                            // const params = {
                            //     farm_id : "{{ $value->farm_id }}",
                            //     images: myVar{{ $key }}

                            // }

                            // highlightedFarmer(params)
                            // Open the infoWindow for the clicked marker
                            infoWindow{{ $key }}.open(map, marker{{ $key }});

                            // Update the currentInfoWindow variable
                            currentInfoWindow = infoWindow{{ $key }};
                        });
                    }
                @endif

                
            @endforeach
        }
    </script>
@endpush