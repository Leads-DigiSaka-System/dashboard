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
            { data: 'area_location', name: 'area_location' },
            
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