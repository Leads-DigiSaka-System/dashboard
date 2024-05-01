<div id="demo_farm_location" style="height: 700px; width: 100%;"></div>

@push('scripts')
    <script>
        function demoinitMap() {
            const map = new google.maps.Map(document.getElementById('demo_farm_location'), {
                center: {
                    lat: 12.8797,
                    lng: 121.7740
                },
                zoom: 6,
            });
        }
    </script>
@endpush
