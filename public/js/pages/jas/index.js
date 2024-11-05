$(document).ready(function () {
    $('#jasProfilesTable').DataTable({
        ajax: {
            url: site_url + "/jasProfiles/",
            data: function (d) {
                d.filter_column1 = $('input[name=filter_first_name]').val(); // First Name
                d.filter_column2 = $('input[name=filter_last_name]').val(); // Last Name
                d.technician = $('input[name=filter_technician]').val(); // Technician
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'first_name', name: 'first_name' },
            { data: 'last_name', name: 'last_name' },
            { data: 'phone', name: 'phone' },
            { data: 'year', name: 'year' },
            { data: 'technician_name', name: 'users.full_name' },
            { data: 'area', name: 'area' },
            { data: 'created_at', name: 'created_at' },
            { data: 'modified_at', name: 'modified_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        // dom: 'Bfrtip',
        buttons: [{
            // extend: "excel",
            // className: "btn-sm btn-success",
            // titleAttr: 'Export in Excel',
            // text: '<i class="fa fa-file-export"></i>',
            // action: function ( e, dt, button, config ) {
            //     window.location = site_url + "/jasProfiles/export";
            // },
            exportOptions: {
                modifier: {
                    page: 'all'
                },
                columns: ':not(:last-child)',
            },
        }],
        // responsive: true,
        autoWidth: true,
        // scrollX: true,
        ...defaultDatatableSettings
    });

    
    $(".buttons-excel").hover(function () {
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
        $('#jasProfilesTable').DataTable().column(index).search(this.value).draw();
    });
});