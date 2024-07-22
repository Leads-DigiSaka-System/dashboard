$(document).on('click', '.delete-datatable-record', function(e){
    let url  = site_url + "/leads/" + $(this).attr('data-id');
    let tableId = 'farmersTable';
    deleteDataTableRecord(url, tableId);
});

$(document).ready(function() {
    let added_by = window.location.search;
    let result = added_by.replace("?added_by=", "");

    $('#salesTeamTable').DataTable({
        ajax: {
            url: site_url + "/contacts/",
            data: function (d) {
                d.added_by = result;
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'full_name', name: 'full_name'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'role', name: 'role'},
            {data: 'status', name: 'status'},
            {data: 'via_app', name: 'via_app'},
            {data: 'registered_date', name: 'registered_date'},
            {data: 'added_by', name: 'added_by'}, // Added column
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        // dom: 'Bfrtip',
        // buttons: [{
        //     extend: "excel",
        //     className: "btn-sm btn-success",
        //     titleAttr: 'Export in Excel',
        //     text: '<i class="fa fa-file-export"></i>',
        //     exportOptions: {
        //         columns: ':not(:last-child)',
        //     },
        // }],
        ...defaultDatatableSettings
    });

    // $(".buttons-excel").hover(function() {
    //     $(this).attr('title', 'Export all records');
    // });

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