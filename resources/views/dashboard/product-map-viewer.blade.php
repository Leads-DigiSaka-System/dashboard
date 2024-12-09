<div id="map_with_product" style="height: 700px; width: 100%;"></div>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initMapProduct(document.getElementById('map_with_product'));
            initMapProduct(document.getElementById('financing_map'));
            initMapProduct(document.getElementById('commercial_map'));
            initMapProduct(document.getElementById('corporate_map'));
            initMapProduct(document.getElementById('provincial_map'));
            initMapProduct(document.getElementById('recipient_map'));
            initMapProduct(document.getElementById('progress_map'));
            initMapProduct(document.getElementById('product_trials_map'));
        });

        function initMapProduct(element) {
            const map = new google.maps.Map(element, {
                center: {
                    lat: 12.8797,
                    lng: 121.7740
                },
                zoom: 6,
            });

            // Variable to keep track of the currently open infoWindow
            let currentInfoWindow = null;
            var legendContent = `<div class="legend-title">Legend</div>
                <div class="legend-entry">
                <img src="http://maps.google.com/mapfiles/ms/icons/green-dot.png" alt="marker" />
                <span>LAV 777</span>
                </div>
                <div class="legend-entry">
                <img src="http://maps.google.com/mapfiles/ms/icons/purple-dot.png" alt="marker" />
                <span>Jackpot 102</span>
                </div>
            `;
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
                        const fullname = "{{ $farmerDetails->full_name }}"
                        const farm_id = "{{ $value->farm_id }}"
                        var infoWindow{{ $key }} = new google.maps.InfoWindow({
                            content: `
                                <table>
                                    <tr>
                                        <td>Operator:</td>
                                        <td>${fullname}</td>
                                    </tr>
                                    <tr>
                                        <td>Area:</td>
                                        <td>${formatNumber(polygonAreaHa)} ha</td>
                                    </tr>
                                    <tr>
                                        <td>Date Sown:</td>
                                        <td> December 5, 2023</td>
                                    </tr>
                                    <tr>
                                        <td>Date Transplanted:</td>
                                        <td>December 27, 2023</td>
                                    </tr>
                                    <tr>
                                        <td>Date Harvested:</td>
                                        <td>April 8, 2024</td>
                                    </tr>
                                </table>
                                <hr>
                                <table width="100%">
                                    <tr>
                                        <td class="text-center">
                                            <a href="https://dummyimage.com/350x200/000/fff&text=No+image+available" target="_blank">
                                                <img src="https://dummyimage.com/350x200/000/fff&text=No+image+available" alt="Farm Image" width="230px" style="padding:5px;"></a>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <a href="https://dummyimage.com/350x200/000/fff&text=No+image+available" target="_blank">
                                                <img src="https://dummyimage.com/350x200/000/fff&text=No+image+available" alt="Farm Image" width="230px" style="padding:5px;"></a>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            `,
                            // content: '<table>' +
                            //     '<tr><td>Farm ID:</td><td>{{ $value->farm_id }}</td></tr>' +
                            //     '<tr><td>Area:</td><td>' + formatNumber(polygonAreaHa) + ' ha</td></tr>' +
                            //     '<tr><td>Farmer:</td><td>{{ $farmerDetails->full_name }}</td></tr>' +
                            //     '</table>' +
                            //     '<hr />' +
                            //     '<div class="map_image">' + myVar{{ $key }} + '</div>',
                            maxWidth: 1200, // Set the maximum width
                            minHeight: 150, // Set the minimum height
                        });

                        // Add click event listener to the marker
                        marker{{ $key }}.addListener('click', function() {
                            // Close the currently open infoWindow, if any
                            if (currentInfoWindow) {
                                currentInfoWindow.close();
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

            document.getElementById('product_legend').innerHTML = legendContent;
        }

    </script>
@endpush