$(document).ready(function () {
    $('#webinarTable').DataTable({
        ajax: {
            url: site_url + "/webinars",
            data: function (d) {
                d.filter_title = $('input[name=filter_title]').val();
                d.filter_type = $('select[name=filter_type]').val();
                d.filter_status = $('select[name=filter_status]').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            { data: 'type', name: 'type' },
            {
                data: 'link', name: 'link', orderable: false, searchable: false,
                // render: function(datum, type, row) {
                //     return `<a href=" ${row.link} " target="_blank" title="View Webinar">${row.link.substring(0, 50) + '...'}</a>`

                // }
            },
            { data: 'status', name: 'status' },
            { data: 'start_date', name: 'start_date' },
            { data: 'image_source', name: 'image_source' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        autoWidth: true,
        ...defaultDatatableSettings
    });

    // Apply filters
    $('input[name^="filter_"], select[name^="filter_"]').on('keyup change', function () {
        $('#webinarTable').DataTable().draw();
    });

    let isEdit = false;

    // Show modal for creating a new webinar
    $('#createWebinar').on('click', function () {
        isEdit = false;
        $('#webinarForm')[0].reset();
        $('#webinarModalLabel').text('Add Webinar');
        $('#webinarModal').modal('show');
    });

    $('#webinarForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let url = isEdit ? '/webinars/' + $('#webinarId').val() : '/webinars';

        // If editing, include the method spoofing
        // if (isEdit) {
        //     formData += '&_method=PATCH';
        // }

        $.ajax({
            url: url,
            type: 'POST', // Always use POST; Laravel will handle the method spoofing
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {


                $('#webinarModal').modal('hide');
                $('#webinarTable').DataTable().ajax.reload();
                // Optional: Show success message
            },
            error: function (error) {
                console.log(error);
            },
            complete: function (xhr) {

                if(xhr.responseJSON.status == 'success'){
                    toastr.success(xhr.responseJSON.message, 'Success!', toastCofig);
                }
                if(xhr.responseJSON.status == 'error'){
                    toastr.error(xhr.responseJSON.message, 'Error!',  toastCofig);
                }
                   

            }
        });
    });

    $('#start_date').flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true
    });

    $('#webinarTable').on('click', '.editWebinar', function () {
        isEdit = true;
        const webinarId = $(this).data('id');
        const title = $(this).data('title');
        const type = $(this).data('type');
        const link = $(this).data('link');
        const status = $(this).data('status');
        const startDate = $(this).data('start_date');

        // Set the values in the modal
        $('#webinarId').val(webinarId);
        $('#title').val(title);
        $('#type').val(type);
        $('#link').val(link);
        $('#status').val(status);

        // Set Flatpickr date and time
        $('#start_date').flatpickr({
            defaultDate: startDate,
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });

        // Show modal
        $('#webinarModalLabel').text('Edit Webinar');
        $('#webinarModal').modal('show');
    });
});
