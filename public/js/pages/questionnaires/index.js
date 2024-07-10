$(document).ready(function() {
    $('#questionnaire_table').DataTable({
        ajax: site_url + "/questionnaires/",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'created_at', name: 'created_at'},
            { data: 'date_revised', name: 'date_revised'},
            { data: 'link', name: 'link', className:'text-break copy-link'},
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

$(document).on("click",'.copy-link', function () {
    let text = document.createElement('input');
    text.setAttribute('type', 'text');
    text.value = this.textContent;
    document.body.appendChild(text);
    text.select()
    document.execCommand('copy')
    document.body.removeChild(text);
})

$(document).on('click', '.delete-questionnaire-record', function(e){
    let url  = site_url + "/questionnaires/" + $(this).attr('data-id');
    let tableId = 'questionnaire_table'
    
    deleteDataTableRecord(url, tableId);
});
