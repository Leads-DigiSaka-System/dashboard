<div class="tab-pane fade " id="content8" style="padding-right: 10px;">
    <div class="row">
        <div class="col-md-7">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <h4 class="mb-1">Field Tour</h4>
                    <div id="field_tour_map" style="height: 700px; width: 100%;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="col h-auto">
                <div class="card rounded-3 shadow-sm">
                    <div class="d-flex py-2 px-5">
                        <div class="me-2">
                            <div class="p-2 rounded-circle" style="background-color: #28c76f;">
                                <i data-feather="calendar" style="width: 30px; height: 30px; color:white;"></i>
                            </div>
                        </div>
                        <div class="my-auto text-left">
                            <p class="mb-0" style="font-size: 20px;">Number of Activity</p>
                            <h1 class="fw-bolder mb-0" style="font-size: 3rem;">6</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col h-auto">
                <div class="card rounded-3 shadow-sm">
                    <div class="d-flex py-2 px-5">
                        <div class="me-2">
                            <div class="p-2 rounded-circle" style="background-color: #28c76f;">
                                <i data-feather="package" style="width: 30px; height: 30px; color:white;"></i>
                            </div>
                        </div>
                        <div class="my-auto text-left">
                            <p class="mb-0" style="font-size: 20px;">Farmers Attended</p>
                            <h1 class="fw-bolder mb-0"  style="font-size: 3rem;">56</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col h-auto">
                <div class="card rounded-3 shadow-sm">
                    <div class="d-flex py-2 px-5">
                        <div class="me-2">
                            <div class="p-2 rounded-circle" style="background-color: #28c76f;">
                                <i data-feather="package" style="width: 30px; height: 30px; color:white;"></i>
                            </div>
                        </div>
                        <div class="my-auto text-left">
                            <p class="mb-0" style="font-size: 20px;">DigiSaka Surveys</p>
                            <h1 class="fw-bolder mb-0"  style="font-size: 3rem;">32</h1>
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
            initMapProduct3();
        });

        function initMapProduct3() {
            const map = new google.maps.Map(document.getElementById('field_tour_map'), {
                center: {
                    lat: 12.8797,
                    lng: 121.7740
                },
                zoom: 6,
            });
        }

    </script>
@endpush