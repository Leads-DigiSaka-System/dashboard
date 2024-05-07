$(document).ready(function() {
    $('#question_table').DataTable({
        ajax: site_url + "/questions/",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'field_name', name: 'field_name' },
            { data: 'field_type', name: 'field_type' },
            { data: 'sub_field_type', name: 'sub_field_type' },
            { data: 'created_at', name: 'created_at'},
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

