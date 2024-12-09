<div class="card rounded-3 shadow-sm">
    <div class="card-header py-2">
        <h4 class="">Farm Images</h4>
    </div>
    <div class="card-body">
        <div id="farm_image" style="height: 700px; width: 100%;"></div>
    </div>
</div>
@push('scripts')
    <script>
        // Load the maps when the page has finished loading
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            demoinitMap();
        });

        let counter = 0;



        function toPolygonObj(polygon) {
            let coordsList = [];

            // Check if polygon is not null or undefined
            if (polygon && polygon.latLngs) {
                let polCoords = polygon.latLngs;
                for (let i = 0; i < polCoords.length; i++) {
                    let polObj = {};
                    polObj.lat = polCoords[i][0];
                    polObj.lng = polCoords[i][1];
                    coordsList.push(polObj);
                }
            } else {
                console.error("Invalid or missing polygon object.");
            }

            return coordsList;
        }

        function formatNumber(number) {
            return number.toLocaleString(undefined, {
                maximumFractionDigits: 2
            });
        }

        function initMap() {
            const map = new google.maps.Map(document.getElementById('farm_image'), {
                center: {
                    lat: 12.8797,
                    lng: 121.7740,
                },
                zoom: 6,
            });

            // Variable to keep track of the currently open infoWindow
            let currentInfoWindow = null;

            @foreach ($allFarms as $key => $value)
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

                    // Create a marker for the farm
                    const marker{{ $key }} = new google.maps.Marker({
                        position: coords[0], // Use the first coordinate as the marker position
                        map: map,
                        title: 'Farm ID: {{ $value->farm_id }}',
                    });

                    @foreach (explode(',', $value->farm_image) as $image)
                        myVar{{ $key }} +=
                            '<a href="{{ asset('') }}{{ $image }}" target="_blank"><img src="{{ asset('') }}{{ $image }}" alt="Farm Image" width="150px" style="padding: 5px;"></a>';
                    @endforeach

                    // Add an info window for the marker
                    var infoWindow{{ $key }} = new google.maps.InfoWindow({
                        content: '<table>' +
                            '<tr><td>Farm ID:</td><td>{{ $value->farm_id }}</td></tr>' +
                            '<tr><td>Area:</td><td>' + formatNumber(polygonAreaHa) + ' ha</td></tr>' +
                            '<tr><td>Farmer:</td><td>{{ $farmerDetails->full_name }}</td></tr>' +
                            '<tr><td>Date created:</td><td>{{ date('M d, Y', strtotime($farmerDetails->created_at)) }}</td></tr>' +
                            '</table>' +
                            '<hr />' +
                            '<div class="map_image">' + myVar{{ $key }} + '</div>',
                        maxWidth: 1200,
                        minHeight: 150,
                    });

                    // Add click event listener to the marker
                    marker{{ $key }}.addListener('click', function() {
                        // Close the currently open infoWindow, if any
                        if (currentInfoWindow) {
                            currentInfoWindow.close();
                        }

                        // Open the infoWindow for the clicked marker
                        infoWindow{{ $key }}.open(map, marker{{ $key }});

                        // Update the currentInfoWindow variable
                        currentInfoWindow = infoWindow{{ $key }};
                    });
                }
            @endforeach
        }


        // const highlightedFarmer = function (params) {
        //     let html = "";

        //     const highlighted_farmer = document.getElementById('highlighted_farmer')

        //     const no_of_cards = highlighted_farmer.getElementsByClassName('card').length

        //     if(no_of_cards <= 4) {
        //         html += `
    //             <div class="card hl_farmer${counter}">
    //                 <div class="card-body">
    //                     <div class="row">
    //                         <div class="col-md-5 d-flex justify-content-center align-items-center">
    //                             <div class="row row-cols-1 ">
    //                                 <div class="col text-center h2">
    //                                     Farm Unique ID
    //                                 </div>
    //                                 <div class="col text-center h1 text-danger">
    //                                     ${params.farm_id}
    //                                 </div>
    //                             </div>

    //                         </div>
    //                         <div class="col-md-5 d-flex justify-content-center align-items-center">
    //                             ${params.images}
    //                         </div>
    //                         <div class="col-md-2 d-flex align-items-center">
    //                             <a href="javascript:void(0)" role="button"  class="remove_highlighted_farmer" data-key="${counter}">
    //                                 <i class="fa fa-trash text-danger" style="font-size:24px;"></i>
    //                             </a>
    //                         </div>
    //                     </div>

    //                 </div>
    //             </div>
    //         `;

        //         highlighted_farmer.innerHTML += html
        //         counter++
        //     }

        // }

        // const removeHighlightedFarmer = function(key) {

        // }

        // document.addEventListener("click", function(e){
        //     const target = e.target.closest(".remove_highlighted_farmer"); // Or any other selector.

        //     if(target){
        //         const key = target.dataset.key

        //         const selected_div = target.closest(`.hl_farmer${key}`)

        //         selected_div.remove()
        //     }
        // });
    </script>
@endpush
