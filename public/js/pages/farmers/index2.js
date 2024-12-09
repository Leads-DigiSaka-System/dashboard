$(document).on('click', '.delete-datatable-record', function(e){
    let url  = site_url + "/farmers/" + $(this).attr('data-id');
    let tableId = 'farmersTable';
    deleteDataTableRecord(url, tableId);
});

$(document).ready(function() {
    $('#farmersTable').DataTable({
        ajax: {
            url: site_url + "/leads/",
            data: function (d) {
                d.filter_column1 = $('input[name=filter_full_name]').val(); // Full Name
                d.filter_column2 = $('input[name=filter_phone_number]').val(); // Phone Number
                d.filter_column3 = $('input[name=filter_role]').val(); // Role
                d.filter_column4 = $('input[name=filter_status]').val(); // Status
                d.filter_column5 = $('input[name=registered_by]').val(); // Registered via App
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'full_name', name: 'full_name'},
            {data: 'email', name: 'email'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'role', name: 'role'},
            {data: 'status', name: 'status'},
            {data: 'via_app', name: 'via_app'},
            {data: 'registered_date', name: 'registered_date'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        dom: 'Bfrtip',
        buttons: [{
            extend: "excel",
            className: "btn-sm btn-success",
            titleAttr: 'Export in Excel',
            text: '<i class="fa fa-file-export"></i>',
            action: function ( e, dt, button, config ) {
                window.location = site_url + "/leads/export";
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

    // Apply the filter
    $('.filter').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" name="filter_' + title.toLowerCase().replace(/\s/g, '_') + '" />');
    });

    // Apply the filter
    $('input[name^="filter_"]').on('keyup change', function () {
        var index = $(this).attr('name').split('_')[1];
        $('#farmersTable').DataTable().column(index).search(this.value).draw();
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