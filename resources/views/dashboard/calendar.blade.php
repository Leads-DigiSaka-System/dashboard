<!-- Button to Show Modal -->
<button id="showCalendar" class="btn btn-primary">View Calendar</button>

<!-- Bootstrap Modal for Calendar -->
<div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="calendarModalLabel">Calendar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Button to Show Add Event Modal -->
                <div class="text-right">
                    <button id="addEvent" class="btn btn-success mb-3">Add New Event</button>
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
                    <input type="date" name="start_date" class="form-control" required>
                    <label>End Date:</label>
                    <input type="date" name="end_date" class="form-control" required>
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
                        <option value="Meeting">Meeting</option>
                        <option value="Workshop">Workshop</option>
                    </select>
                    <label>Activity Title:</label>
                    <input type="text" name="title" class="form-control" id="editTitle" required>
                    <label>Start Date:</label>
                    <input type="date" name="start_date" class="form-control" id="editStartDate" required>
                    <label>End Date:</label>
                    <input type="date" name="end_date" class="form-control" id="editEndDate" required>
                    <button type="submit" class="btn btn-primary mt-3">Update Event</button>
                </form>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        $(document).ready(function() {
            var calendar;

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
                        events: site_url + '/events', // Fetch events from the server
                        select: function(info) {


                        },
                        eventClick: function(info) {
                            // Show the edit event modal with event details
                            $('#editTitle').val(info.event.title);
                            $('#editActivityType').val(info.event.extendedProps.activity_type);
                            $('#editStartDate').val(info.event.startStr);
                            $('#editEndDate').val(info.event.endStr);

                            // Submit the updated form via AJAX
                            $('#editEventForm').off('submit').on('submit', function(e) {
                                e.preventDefault();
                                let formData = $(this).serialize();

                                $.ajax({
                                    url: `${site_url}/events/${info.event.id}`,
                                    method: 'PUT',
                                    data: formData,
                                    success: function(response) {
                                        calendar
                                            .refetchEvents(); // Reload events
                                        $('#editEventModal').modal(
                                            'hide'); // Hide event modal
                                    }
                                });
                            });

                            // Convert endStr to a Date object
                            var endDate = new Date(info.event.endStr);

                            // Subtract one day from the end date
                            endDate.setDate(endDate.getDate() - 1);

                            // Format the date as "March 31, 1997"
                            var options = {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            };
                            var formattedEndDate = endDate.toLocaleDateString('en-US', options);


                            // Show the event details in the view modal
                            $('#eventActivityType').text(info.event.extendedProps
                                .activity_type);
                            $('#eventTitle').text(info.event.title);
                            $('#eventStartDate').text(info.event.start.toLocaleDateString(
                                'en-US', options));
                            $('#eventEndDate').text(formattedEndDate);
                            $('#viewEventModal').modal('show');
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
    </script>
@endpush
