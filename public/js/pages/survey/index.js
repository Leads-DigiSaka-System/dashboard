$(document).ready(function() {
    console.log(site_url, '======site_url');
    $('#surveyTable').DataTable({
        ajax: site_url + "/survey/",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'full_name', name: 'full_name' },
            { data: 'farm_id', name: 'farm_id' },
            { data: 'status', name: 'status' },
            
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        dom: 'Bfrtip',
         buttons: [{
            extend: "excel",
            className: "btn-sm btn-success",
            titleAttr: 'Export in Excel',
            text: '<i class="fa fa-file-export"></i>',
            exportOptions: {
            columns: ':not(:last-child)',
             },
            
          }],
        ...defaultDatatableSettings
    });
});

