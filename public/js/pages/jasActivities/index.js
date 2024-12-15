'use strict'
$(document).ready(function() {

    $('#jasActivitiesTable').DataTable({
        ajax: {
            url: site_url + "/jasActivities/",
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'title', name: 'title'},
            {data: 'action', name: 'action'},
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
        $('#farmersTable').DataTable().column(index).search(this.value).draw();
    });
});

const handleViewObservations = (encrypted_id) => {
    $.ajax({
        url: site_url + "/getJasActivities/" + encrypted_id,
        method: "GET",
        success: function(response) {
            let html = ""
            if(response.data.length !== 0) {
                

                html += `<table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Timing</th>
                            <th>Observation</th>
                        </tr>
                    </thead>
                    <tbody>
                `
                for(const [key, data] of response.data.entries()) {
                    html += `
                        <tr>
                            <td>${key+1}</td>
                            <td>${data.fullname}</td>
                            <td>${data.timing ? data.timing : 'No answer'}</td>
                            <td>${data.observation ? data.observation : 'No answer'}</td>
                        </tr>
                    `


                }

                html += "</tbody></table>"
            }
            $('#activity_title').html(response.title)
            $('#append_observation').html(html)
            $('#viewObservationModal').modal('show')
        }
    });
}