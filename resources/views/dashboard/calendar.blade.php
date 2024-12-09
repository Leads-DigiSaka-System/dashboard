<!-- Button to Show Modal -->
<div id="showCalendar" class="rounded-3"></div>
<div id="thumbnail-calendar" style="width: 100%;height:300px"></div>


<!-- Bootstrap Modal for Calendar -->
<div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="calendarModalLabel">Calendar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between mb-3">
                    <!-- Legend on Left -->
                    <div class="">
                        <h6>Event Legend:</h6>
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="legend-item d-flex align-items-center me-4">
                                <div class="legend-color"
                                    style="width: 20px; height: 20px; background-color: #0d6efd; margin-right: 5px;">
                                </div>
                                <span>Farm (Blue)</span>
                            </div>
                            <div class="legend-item d-flex align-items-center me-4">
                                <div class="legend-color"
                                    style="width: 20px; height: 20px; background-color: #6c757d; margin-right: 5px;">
                                </div>
                                <span>Farmer (Gray)</span>
                            </div>
                            <div class="legend-item d-flex align-items-center me-4">
                                <div class="legend-color"
                                    style="width: 20px; height: 20px; background-color: #198754; margin-right: 5px;">
                                </div>
                                <span>Meeting (Green)</span>
                            </div>
                            <div class="legend-item d-flex align-items-center">
                                <div class="legend-color"
                                    style="width: 20px; height: 20px; background-color: #ffc107; margin-right: 5px;">
                                </div>
                                <span>Workshop (Orange)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Add New Event Button on Right -->
                    <div class="text-right">
                        <button id="addEvent" class="btn btn-success mb-3">Add New Event</button>
                    </div>
                </div>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>


<!-- Modal for Adding/Editing Event -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Add Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    @csrf
                    <label>Activity Type:</label>
                    <select name="activity_type" class="form-control">
                        <option value="Farm">Farm</option>
                        <option value="Farmer">Farmer</option>
                        <option value="Meeting">Meeting</option>
                        <option value="Workshop">Workshop</option>
                    </select>
                    <label>Activity Title:</label>
                    <input type="text" name="title" class="form-control" required>
                    <label>Start Date:</label>
                    <input type="datetime-local" name="start_date" class="form-control" id="start_date" required>
                    <label>End Date:</label>
                    <input type="datetime-local" name="end_date" class="form-control" id="end_date" required>
                    <button type="submit" class="btn btn-primary mt-3">Save Event</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Viewing Event Details -->
<div class="modal fade" id="viewEventModal" tabindex="-1" aria-labelledby="viewEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewEventModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-right">
                    <button id="deleteEvent" class="btn btn-danger mb-3">Delete Event</button>
                    <button id="updateEvent" class="btn btn-info mb-3">Update Event</button>
                </div>
                <p><strong>Activity Type:</strong> <span id="eventActivityType"></span></p>
                <p><strong>Activity Title:</strong> <span id="eventTitle"></span></p>
                <p><strong>Start Date:</strong> <span id="eventStartDate"></span></p>
                <p><strong>End Date:</strong> <span id="eventEndDate"></span></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Event -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEventForm">
                    @csrf
                    @method('PUT')
                    <label>Activity Type:</label>
                    <select name="activity_type" class="form-control" id="editActivityType">
                        <option value="Farm">Farm</option>
                        <option value="Farmer">Farmer</option>
                        <option value="Meeting">Meeting</option>
                        <option value="Workshop">Workshop</option>
                    </select>
                    <label>Activity Title:</label>
                    <input type="text" name="title" class="form-control" id="editTitle" required>
                    <label>Start Date:</label>
                    <input type="datetime-local" name="start_date" class="form-control" id="editStartDate" required>
                    <label>End Date:</label>
                    <input type="datetime-local" name="end_date" class="form-control" id="editEndDate" required>
                    <button type="submit" class="btn btn-primary mt-3">Update Event</button>
                </form>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {
            var calendar;
            const flatpickrOptions = {
                enableTime: true,
                dateFormat: "Y-m-d H:i:s", // Set input format for storage
                altInput: true,
                altFormat: "F j, Y H:i", // Display format
                time_24hr: true
            }
            $('#start_date').flatpickr(flatpickrOptions);

            $('#end_date').flatpickr(flatpickrOptions);

            const editStartDateInput = $('#editStartDate').flatpickr(flatpickrOptions);

            const editEndDateInput = $('#editEndDate').flatpickr(flatpickrOptions);

            // Show Bootstrap modal and initialize FullCalendar when modal is shown
            $('#calendarModal').on('shown.bs.modal', function() {
                if (!calendar) {
                    calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        selectable: true,
                        events: {
                            url: site_url + '/events',
                            failure: function() {
                                alert('There was an error while fetching events!');
                            },
                            // Define colors based on the event type
                            success: function(data) {
                                return data.map(event => {
                                    let eventColor;
                                    switch (event.extendedProps.activity_type) {
                                        case 'Farm':
                                            eventColor = '#0d6efd';
                                            break;
                                        case 'Farmer':
                                            eventColor = '#6c757d';
                                            break;
                                        case 'Meeting':
                                            eventColor = '#198754';
                                            break;
                                        case 'Workshop':
                                            eventColor =
                                                '#ffc107';
                                            break;
                                    }
                                    return {
                                        ...event,
                                        backgroundColor: eventColor,
                                        borderColor: eventColor
                                    };
                                });
                            }
                        },
                        select: function(info) {


                        },
                        eventClick: function(info) {
                            // Convert endStr to a Date object and subtract one day

                            var startDate = flatpickr.formatDate(new Date(info.event.startStr),
                                "F j, Y H:i");
                            var endDate = flatpickr.formatDate(new Date(info.event.extendedProps
                                    .end_date),
                                "F j, Y H:i");


                            // Show the event details in the view modal
                            $('#eventActivityType').text(info.event.extendedProps
                                .activity_type);
                            $('#eventTitle').text(info.event.title);
                            $('#eventStartDate').text(startDate);
                            $('#eventEndDate').text(endDate);
                            $('#viewEventModal').modal('show');

                            // Show the edit event modal with event details
                            $('#editTitle').val(info.event.title);
                            $('#editActivityType').val(info.event.extendedProps.activity_type);
                            editStartDateInput.setDate(info.event.startStr);
                            editEndDateInput.setDate(info.event.extendedProps.end_date);

                            // Submit the updated form via AJAX
                            $('#editEventForm').off('submit').on('submit', function(e) {
                                e.preventDefault();
                                let formData = $(this).serialize();

                                $.ajax({
                                    url: `${site_url}/events/${info.event.id}`,
                                    method: 'PUT',
                                    data: formData,
                                    success: function(response) {
                                        calendar.refetchEvents();
                                        $('#editEventModal').modal('hide');
                                        $('#viewEventModal').modal('hide');
                                        toastr.success(
                                            'Event updated successfully',
                                            'Success!', toastCofig);
                                    }
                                });
                            });

                            $('#deleteEvent').on('click', function() {
                                if (confirm(
                                        'Are you sure you want to delete this event?'
                                    )) {
                                    // User clicked "OK", proceed with AJAX request
                                    $.ajax({
                                        url: `${site_url}/events/${info.event.id}`,
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]')
                                                .attr('content')
                                        },
                                        success: function(response) {
                                            $('#viewEventModal').modal(
                                                'hide');
                                            calendar.refetchEvents();
                                            toastr.success(
                                                'Event deleted successfully!',
                                                'Success!', toastCofig);

                                        },
                                        error: function(xhr, status, error) {
                                            // Handle the error case
                                            alert('An error occurred while deleting the event: ' +
                                                error);
                                        }
                                    });
                                }
                            });
                        }
                    });

                    // Render the calendar after the modal is shown
                    calendar.render();
                } else {
                    calendar.render(); // Ensure re-rendering if calendar already exists
                }
            });



            // Submit the event form via AJAX
            $('#eventForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize()

                $.ajax({
                    url: site_url + '/events',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        calendar
                            .refetchEvents(); // Reload events
                        $(this).trigger("reset");
                        $('#eventModal').modal(
                            'hide'); // Hide event modal
                    }
                });
            });
            // Show calendar modal when button is clicked
            $('#showCalendar').on('click', function() {
                $('#calendarModal').modal('show');
            });

            // Show Add Event Modal when "Add New Event" button is clicked
            $('#addEvent').on('click', function() {
                $('#eventModal').modal('show');
            });

            $('#updateEvent').on('click', function() {
                // Show the modal
                $('#editEventModal').modal('show');
            });


        });

        $(document).ready(function() {

            var calendarThumb = new FullCalendar.Calendar(document.getElementById(
                'thumbnail-calendar'), {
                headerToolbar: {
                    left: '', // No navigation for the thumbnail calendar
                    center: 'title',
                    right: ''
                },
                initialView: 'dayGridMonth', // Month view for the thumbnail
                height: 400, // Set height to match the provided style
                contentHeight: 'auto',
                events: {
                    url: site_url + '/events', // Fetch events from your API
                    failure: function() {
                        alert('There was an error while fetching events!');
                    },
                    success: function(data) {
                        return data.map(event => {
                            let eventColor;
                            switch (event.extendedProps.activity_type) {
                                case 'Farm':
                                    eventColor = '#0d6efd';
                                    break;
                                case 'Farmer':
                                    eventColor = '#6c757d';
                                    break;
                                case 'Meeting':
                                    eventColor = '#198754';
                                    break;
                                case 'Workshop':
                                    eventColor = '#ffc107';
                                    break;
                            }
                            return {
                                ...event,
                                backgroundColor: eventColor,
                                borderColor: eventColor
                            };
                        });
                    }
                }
            });

            calendarThumb.render();

        });
    </script>
@endpush
