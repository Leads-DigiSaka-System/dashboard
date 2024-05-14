$(document).ready(function() {
    $('#questionnaire_table').DataTable({
        ajax: site_url + "/questionnaires/",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'created_at', name: 'created_at'},
            { data: 'status', name: 'status'},
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

$(document).on('click', '.delete-datatable-record', function(e){
    let url  = site_url + "/questionnaires/" + $(this).attr('data-id');
    let tableId = 'questionnaire_table'
    
    deleteDataTableRecord(url, tableId);
});
