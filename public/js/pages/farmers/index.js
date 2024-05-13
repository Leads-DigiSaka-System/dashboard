$(document).on('click', '.delete-datatable-record', function(e){
    let url  = site_url + "/farmers/" + $(this).attr('data-id');
    let tableId = 'farmersTable';
    deleteDataTableRecord(url, tableId);
});

$(document).ready(function() {
    $('#farmersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: site_url + "/farmers/",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'full_name', name: 'full_name' },
            { data: 'phone_number', name: 'phone_number' },
            { data: 'role', name: 'role' },
            { data: 'status', name: 'status' },
            { data: 'via_app', name: 'via_app' },
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        dom: 'Bfrtip',
        buttons: [{
            extend: "excel",
            className: "btn-sm btn-success",
            titleAttr: 'Export in Excel',
            text: '<i class="fa fa-file-export"></i>',
            action: function ( e, dt, button, config ) {
                window.location = site_url + "/farmers/export";
            },
            exportOptions: {
                modifier: {
                    page: 'all'
                },
                columns: ':not(:last-child)',
            },
        }],
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