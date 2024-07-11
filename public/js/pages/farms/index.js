$(document).on('click', '.delete-datatable-record', function(e){
    let url  = site_url + "/farms/" + $(this).attr('data-id');
    let tableId = 'farmsTable';
    deleteDataTableRecord(url, tableId);
});

$(document).ready(function() {
    console.log(site_url, '======site_url');
    $('#farmsTable').DataTable({
        ajax: site_url + "/farms/",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'full_name', name: 'full_name' },
            { data: 'farm_id', name: 'farm_id' },
            { data: 'role', name: 'role' },
            { data: 'area_location', name: 'area_location' },
            { data: 'registered_date', name: 'registered_date' },
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ],
      
        ...defaultDatatableSettings
    });
    $(".buttons-excel").hover(function() {
                $(this).attr('title', 'Export all records');
            });
});

$("#upload_file").change(function(event){
    $("#pageloader").addClass("pageloader");
    $("#import_users").submit();
});


$(document).on('click','.viewMapBtn', async function () {
    const id = this.dataset.id

    const request = await fetch(`farms/getMapCoordinates?id=${id}`)

    const json = await request.json()

    let coordinates = []
    for (const val of json.latLngs) {
        coordinates.push({lat: val[0], lng: val[1]})
    }

    initMap(coordinates)
    
})

const initMap = function (coordinates) {
    const map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 37.774929, lng: -122.419418 }, // Set your initial map center
        zoom: 13, // Adjust the zoom level as needed
        mapTypeId: 'satellite'
    });

    // Construct the polygon using the provided coordinates
    const areaPolygon = new google.maps.Polygon({
        paths: coordinates,
        strokeColor: "#FF0000", // Color of the border
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FF0000", // Color of the fill
        fillOpacity: 0.35,
    });

    // Add the polygon to the map
    areaPolygon.setMap(map);

    let coor = [];

    
    // Optionally, fit the map to the polygon bounds
    const bounds = new google.maps.LatLngBounds();
    coordinates.forEach(({ lat, lng }) => bounds.extend(new google.maps.LatLng(lat, lng)));
    map.fitBounds(bounds);

    $('#viewMapModal').modal('show')
}
// $("#import_users").submit(function(e){

//         e.preventDefault();
//             var formData = new FormData(this);

//     url = site_url + "/import-user";

//       $.ajax({
//     type: "POST",
//     url: url,
//     data:formData,
//         cache:false,
//         contentType: false,
//         processData: false,
//     success: function(response) {


      

//                    },
//      error: function (data) {
      
        

                
//               }
//   });


// });