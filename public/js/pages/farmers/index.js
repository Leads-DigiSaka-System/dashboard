
const filter_btn = document.querySelector('#filter_btn')
let datatable 
$(document).on('click', '.delete-datatable-record', function(e){
    let url  = site_url + "/farmers/" + $(this).attr('data-id');
    let tableId = 'farmersTable';
    deleteDataTableRecord(url, tableId);
});
$(document).ready(function() {

    loadDatatable()

    $('#region').select2();
});


filter_btn.addEventListener('click', () => {
    dataTable.destroy();
    loadDatatable()
})

$("#upload_file").change(function(event){
    $("#pageloader").addClass("pageloader");
    $("#import_users").submit();
});

$('#region').on('change', async function() {
    const value = $(this).val()

    $('#province').html("")
    if(value != "All") {
        const request = await fetch(`${site_url}/getProvinceByRegion?region_id=${value}`)

        const provinces = await request.json();

        let options = "";

        options+= `<option value="All">All</option>`
        for(const province of provinces) {
            options += `<option value="${province.provcode}">${province.name}</option>`
        }

        $('#province').html(options)
    } else {
        $('#province').html('<option disabled selected>Select region first</option>')
    }
    
})

const loadDatatable = function () {
     dataTable = $('#farmersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: site_url + "/farmers/",
            data: function (d) {
                d.filter_column1 = $('input[name=filter_full_name]').val(); // Full Name
                d.filter_column2 = $('input[name=filter_phone_number]').val(); // Phone Number
                d.filter_column3 = $('input[name=filter_role]').val(); // Role
                d.filter_column4 = $('input[name=filter_status]').val(); // Status
                d.filter_column5 = $('input[name=filter_registered_by]').val(); // Registered via App
                d.region = $('#region').val();
                d.province = $('#province').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'full_name', name: 'full_name'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'role', name: 'role'},
            {data: 'status', name: 'status'},
            {data: 'via_app', name: 'via_app'},
            {data: 'registered_by', name: 'registered_by'},
            {data: 'registered_date', name: 'registered_date'},
            {data: 'region', name:'region'},
            {data: 'province', name: 'province'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
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

    // Apply the filter
    $('.filter').each(function () {
        var title = $(this).text();
       $(this).html('<input type="text" placeholder="Search ' + title + '" name="filter_' + title.toLowerCase().replace(/\s/g, '_') + '" />');
    });

    // Apply the filter
    $('input[name^="filter_"]').on('keyup change', function () {
        var index = $(this).attr('name').split('_')[1];
        dataTable.column(index).search(this.value).draw();
    });
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