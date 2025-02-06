'use strict'
$(document).ready(function() {

    $('#jasHarvestTable').DataTable({
        ajax: {
            url: site_url + "/jasHarvest/",
            dataSrc: 'data',
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'fullname', name: 'fullname'},  
            {data: 'farm_location', name: 'farm_location'}, 
            {data: 'planting_date', name: 'planting_date'},  
            {data: 'harvesting_date', name: 'harvesting_date'},  
            {data: 'method_harvesting', name: 'method_harvesting'},  
            {data: 'action', name: 'action', orderable: false, searchable: false},  
        ],
    });

    // Apply the filter
    $('.filter').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" name="filter_' + title.toLowerCase().replace(/\s/g, '_') + '" />');
    });

    // Apply the filter
    $('input[name^="filter_"]').on('keyup change', function () {
        var index = $(this).attr('name').split('_')[1];
        $('#jasHarvestTable').DataTable().column(index).search(this.value).draw();
    });

});


const handleViewHarvest = (encrypted_id) => {
    $.ajax({
        url: site_url + "/getJasHarvest/" + encrypted_id, 
        method: "GET",
        success: function(response) {
            if (response.error) {
                alert(response.error);
                return;
            }

            const fullName = response.jasprofile
            ? `${response.jasprofile.first_name} ${response.jasprofile.middle ? response.jasprofile.middle + ' ' : ''}${response.jasprofile.last_name}`
            : null;


            $('#activity_title').html(response.farm_location);
            $('#planting_date').html(response.planting_date);
            $('#harvesting_date').html(response.harvesting_date);
            $('#method_harvesting').html(response.method_harvesting);
            $('#variety').html(response.variety);
            $('#seeding_rate').html(response.seeding_rate);
            $('#farm_size').html(response.farm_size);
            $('#total_yield_weight_kg').html(response.total_yield_weight_kg);
            $('#total_yield_weight_tons').html(response.total_yield_weight_tons);
            $('#number_of_canvas').html(response.number_of_canvas);
            $('#validator').html(response.validator);
            $('#validator_signature').html(response.validator_signature);
            $('#kgs_per_cavan').html(response.kgs_per_cavan);

            $('#full_name').text(fullName); 

            $('#viewHarvestModal').modal('show');
        },
        error: function() {
            alert("Error fetching harvest details");
        }
    });
};
