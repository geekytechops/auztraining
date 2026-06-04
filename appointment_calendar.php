<?php include('includes/dbconnect.php'); ?>
<?php 
session_start();
if(@$_SESSION['user_type']!=''){

$calendarUsers = mysqli_query($connection, "SELECT user_id, user_name FROM users WHERE user_status != 1 ORDER BY user_name");
$currentUserId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$currentUserType = isset($_SESSION['user_type']) ? (int)$_SESSION['user_type'] : 0;
?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Appointment Calendar</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/logo-dark.png">
        <?php include('includes/app_includes.php'); ?>
        
        <!-- FullCalendar CSS -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.css" rel="stylesheet" />
        
        <style>
            .fc-event {
                cursor: pointer;
            }
            /* Month view: readable event chips */
            .fc-daygrid-event {
                display: flex;
                align-items: center;
                gap: 4px;
                color: #000 !important;
                font-size: 0.85rem;
            }
            .fc-daygrid-event .fc-event-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                margin-right: 4px;
                flex-shrink: 0;
            }
            .fc-daygrid-event .fc-event-time {
                color: #000 !important;
                font-weight: 500;
            }
            .fc-daygrid-event .fc-event-title {
                color: #000 !important;
                font-weight: 600;
            }
            /* Week / day time grid: compact blocks, no squished columns */
            .fc-timegrid-event {
                border-radius: 4px;
                box-shadow: 0 1px 2px rgba(0,0,0,0.12);
            }
            .fc-timegrid-event .fc-event-main {
                padding: 2px 4px;
                overflow: hidden;
            }
            .fc-ev-compact {
                line-height: 1.2;
                overflow: hidden;
                min-width: 0;
            }
            .fc-ev-compact-time {
                font-size: 0.68rem;
                font-weight: 700;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .fc-ev-compact-title {
                font-size: 0.72rem;
                font-weight: 500;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                opacity: 0.95;
            }
            /* "+N more" in time slots */
            .fc-timegrid-more-link {
                font-size: 0.72rem !important;
                font-weight: 600;
                background: rgba(13, 110, 253, 0.14) !important;
                color: #0d6efd !important;
                border-radius: 4px;
                padding: 2px 6px !important;
                margin: 1px 2px;
            }
            .fc-timegrid-more-link:hover {
                background: rgba(13, 110, 253, 0.28) !important;
            }
            /* Blocked slots: background band (appointments stay readable on top) */
            .fc-bg-event.fc-event-blocked-bg {
                opacity: 0.22;
            }
            .fc-bg-event.fc-event-blocked-bg .fc-event-title,
            .fc-blocked-bg-label {
                font-size: 0.7rem;
                font-weight: 700;
                letter-spacing: 0.02em;
                color: #b02a37;
            }
            .appointment-actions {
                margin-bottom: 20px;
            }
            .status-badge {
                padding: 5px 10px;
                border-radius: 4px;
                font-size: 12px;
                font-weight: 600;
            }
            .status-scheduled { background: #0bb197; color: white; }
            .status-completed { background: #0ac074; color: white; }
            .status-cancelled { background: #ff3d60; color: white; }
            .status-no-show { background: #fcb92c; color: white; }
            .status-missed { background: #74788d; color: white; }
            .more-events-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                display: inline-block;
                margin-right: 6px;
            }
            #moreEventsList .more-event-item {
                cursor: pointer;
            }
            #moreEventsList .more-event-item:hover {
                background: #f8f9fa;
            }
            /* Ensure list view text is readable */
            .fc-list-event-title, .fc-list-event-time, .fc-list-event-title a {
                color: #000 !important;
            }
        </style>
    </head>

    <body>

        <!-- Begin page -->
        <div class="main-wrapper">

            
            <?php include('includes/header.php'); ?>
            <?php include('includes/sidebar.php'); ?>
            
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <div class="content pb-0">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Appointment Calendar</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                            <li class="breadcrumb-item active">Appointments</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="appointment-actions mb-3 d-flex flex-wrap align-items-center justify-content-between">
                                            <div class="mb-2">
                                            <a href="appointment_booking.php" class="btn btn-primary waves-effect waves-light">
                                                <i class="mdi mdi-plus"></i> Book New Appointment
                                            </a>
                                            <a href="appointment_reports.php" class="btn btn-info waves-effect waves-light">
                                                <i class="mdi mdi-chart-bar"></i> View Reports
                                            </a>
                                            <a href="appointment_blocks.php" class="btn btn-warning waves-effect waves-light">
                                                <i class="mdi mdi-block-helper"></i> Manage Blocked Slots
                                            </a>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label me-2 mb-0">Filter by Staff:</label>
                                                <select class="form-select d-inline-block w-auto" id="calendar_staff_filter">
                                                    <option value="0" <?php echo $currentUserType===1 ? 'selected' : ''; ?>>All Staff</option>
                                                    <?php 
                                                    mysqli_data_seek($calendarUsers, 0);
                                                    while($u = mysqli_fetch_array($calendarUsers)){
                                                        $uid = (int)$u['user_id'];
                                                        $selected = ($currentUserType!==1 && $uid===$currentUserId) ? 'selected' : '';
                                                        echo '<option value="'.$uid.'" '.$selected.'>'.htmlspecialchars($u['user_name']).'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div> <!-- container-fluid -->
                </div>
            </div>

        </div>

        <!-- Appointment Details Modal -->
        <div class="modal fade" id="appointmentDetailsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Appointment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="appointment_details_content">
                        <!-- Content loaded via AJAX -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="edit_appointment_btn">Edit</button>
                        <button type="button" class="btn btn-success" id="mark_completed_btn" style="display:none;">Mark as Completed</button>
                        <button type="button" class="btn btn-warning" id="mark_no_show_btn" style="display:none;">Mark as No-Show</button>
                        <button type="button" class="btn btn-danger" id="cancel_appointment_btn" style="display:none;">Cancel</button>
                        <button type="button" class="btn btn-info" id="time_in_btn" style="display:none;">Time In</button>
                        <button type="button" class="btn btn-info" id="time_out_btn" style="display:none;">Time Out</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancel confirmation modal -->
        <div class="modal fade" id="cancelConfirmModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cancel Appointment?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to cancel this appointment?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-danger" id="confirm_cancel_btn">Yes, cancel it</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- More events modal for day with many appointments -->
        <div class="modal fade" id="moreEventsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Appointments on <span id="moreEventsDate"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group" id="moreEventsList">
                            <!-- Filled via JS -->
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/footer_includes.php'); ?>
        
        <!-- FullCalendar JS -->
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>
        
        <script>
            var calendar;
            var currentAppointmentId = null;
            var CRM_CAL_TZ = 'Australia/Adelaide';

            function crmCalFormat(d, opts) {
                if (!d) return '';
                opts = opts || {};
                opts.timeZone = CRM_CAL_TZ;
                return FullCalendar.formatDate(d, opts);
            }

            function crmCalEventTimeRange(ev) {
                var props = ev.extendedProps || {};
                if (props.time_start_display) {
                    var endDisp = props.time_end_display || '';
                    if (endDisp && endDisp !== props.time_start_display) {
                        return props.time_start_display + ' - ' + endDisp;
                    }
                    return props.time_start_display;
                }
                var startStr = crmCalFormat(ev.start, { hour: 'numeric', minute: '2-digit', meridiem: 'short' });
                var endStr = ev.end ? crmCalFormat(ev.end, { hour: 'numeric', minute: '2-digit', meridiem: 'short' }) : '';
                return endStr && endStr !== startStr ? (startStr + ' - ' + endStr) : startStr;
            }

            function crmCalEscapeHtml(s) {
                if (!s) return '';
                return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
            }

            function crmCalShortEventTitle(title, isBlocked) {
                if (isBlocked) return 'Blocked';
                if (!title) return '';
                var dash = title.indexOf(' - ');
                if (dash > 0) {
                    return title.substring(0, dash) + ' · ' + title.substring(dash + 3);
                }
                return title;
            }

            function crmCalOpenMoreEventsModal(arg) {
                var $list = $('#moreEventsList');
                $list.empty();
                var isTimeGrid = arg.view && arg.view.type && arg.view.type.indexOf('timeGrid') === 0;
                var dateLabel = isTimeGrid
                    ? crmCalFormat(arg.date, { weekday: 'long', month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit', meridiem: 'short' })
                    : crmCalFormat(arg.date, { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' });
                $('#moreEventsDate').text(dateLabel);
                var segs = (arg.allSegs || []).slice().sort(function(a, b) {
                    var ta = a.event.start ? a.event.start.getTime() : 0;
                    var tb = b.event.start ? b.event.start.getTime() : 0;
                    return ta - tb;
                });
                segs.forEach(function(seg) {
                    var ev = seg.event;
                    var color = ev.backgroundColor || ev.borderColor || '#0bb197';
                    var timeRange = crmCalEventTimeRange(ev);
                    var isBlocked = (ev.extendedProps && ev.extendedProps.event_type === 'blocked');
                    var row = '<li class="list-group-item d-flex justify-content-between align-items-center more-event-item" data-id="'+ev.id+'" data-type="'+(isBlocked ? 'blocked' : 'appointment')+'">'+
                              '<div class="d-flex align-items-center flex-grow-1 me-2 min-w-0">'+
                              '<span class="more-events-dot flex-shrink-0" style="background:'+color+';"></span>'+
                              '<span class="me-2 small text-muted flex-shrink-0">'+crmCalEscapeHtml(timeRange)+'</span>'+
                              '<span class="text-truncate">'+crmCalEscapeHtml(ev.title)+'</span>'+
                              '</div>'+
                              '<button type="button" class="btn btn-sm btn-outline-primary flex-shrink-0">'+(isBlocked ? 'Details' : 'View')+'</button>'+
                              '</li>';
                    $list.append(row);
                });
                $('#moreEventsModal').modal('show');
            }
            
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                
                calendar = new FullCalendar.Calendar(calendarEl, {
                    timeZone: 'Australia/Adelaide',
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    eventTimeFormat: {
                        hour: 'numeric',
                        minute: '2-digit',
                        meridiem: 'short',
                        timeZone: CRM_CAL_TZ
                    },
                    slotMinTime: '06:00:00',
                    slotMaxTime: '21:00:00',
                    scrollTime: '08:00:00',
                    nowIndicator: true,
                    slotEventOverlap: false,
                    eventMinHeight: 24,
                    views: {
                        dayGridMonth: {
                            dayMaxEvents: 3
                        },
                        timeGridWeek: {
                            eventMaxStack: 2
                        },
                        timeGridDay: {
                            eventMaxStack: 2
                        }
                    },
                    moreLinkContent: function(arg){
                        return { html: '<span class="text-primary fw-semibold">+'+arg.num+' more</span>' };
                    },
                    moreLinkClick: function(arg){
                        crmCalOpenMoreEventsModal(arg);
                        return false;
                    },
                    eventContent: function(arg) {
                        var vtype = arg.view.type;
                        if (vtype !== 'timeGridWeek' && vtype !== 'timeGridDay') {
                            return true;
                        }
                        if (arg.event.display === 'background') {
                            return { html: '<span class="fc-blocked-bg-label">BLOCKED</span>' };
                        }
                        var timeRange = crmCalEventTimeRange(arg.event);
                        var isBlocked = (arg.event.extendedProps && arg.event.extendedProps.event_type === 'blocked');
                        var shortTitle = crmCalShortEventTitle(arg.event.title, isBlocked);
                        return {
                            html: '<div class="fc-ev-compact">' +
                                '<div class="fc-ev-compact-time">' + crmCalEscapeHtml(timeRange) + '</div>' +
                                '<div class="fc-ev-compact-title">' + crmCalEscapeHtml(shortTitle) + '</div>' +
                                '</div>'
                        };
                    },
                    events: function(fetchInfo, successCallback, failureCallback) {
                        $.ajax({
                            url: 'includes/datacontrol',
                            type: 'POST',
                            data: {
                                formName: 'get_appointments_calendar',
                                start: fetchInfo.startStr,
                                end: fetchInfo.endStr,
                                staff_filter: $('#calendar_staff_filter').val() || 0
                            },
                            success: function(response) {
                                try {
                                    var events = JSON.parse(response);
                                    successCallback(events);
                                } catch(e) {
                                    console.error('Error parsing calendar events:', e);
                                    successCallback([]);
                                }
                            },
                            error: function() {
                                failureCallback();
                            }
                        });
                    },
                    eventClick: function(info) {
                        var eventType = (info.event.extendedProps && info.event.extendedProps.event_type) ? info.event.extendedProps.event_type : 'appointment';
                        if(eventType === 'blocked'){
                            showBlockedSlotDetails(info.event);
                            return;
                        }

                        var appointmentId = info.event.id;
                        currentAppointmentId = appointmentId;
                        loadAppointmentDetails(appointmentId);
                    },
                    eventDidMount: function(info) {
                        var tip = crmCalEventTimeRange(info.event) + ' — ' + info.event.title;
                        info.el.setAttribute('title', tip);
                        if (info.event.display === 'background') {
                            info.el.classList.add('fc-event-blocked-bg');
                        }
                        if (window.bootstrap && bootstrap.Tooltip) {
                            var existing = bootstrap.Tooltip.getInstance(info.el);
                            if (existing) existing.dispose();
                            new bootstrap.Tooltip(info.el, {
                                placement: 'top',
                                trigger: 'hover',
                                container: 'body',
                                title: tip
                            });
                        }
                    },
                    eventWillUnmount: function(info) {
                        if (window.bootstrap && bootstrap.Tooltip) {
                            var t = bootstrap.Tooltip.getInstance(info.el);
                            if (t) t.dispose();
                        }
                    }
                });
                
                calendar.render();
                
                // Modal button handlers
                $('#edit_appointment_btn').on('click', function() {
                    if(currentAppointmentId) {
                        window.location.href = 'appointment_booking.php?id=' + btoa(currentAppointmentId);
                    }
                });
                
                $('#mark_completed_btn').on('click', function() {
                    updateAppointmentStatus('completed');
                });
                
                $('#mark_no_show_btn').on('click', function() {
                    updateAppointmentStatus('no-show');
                });
                
                $('#cancel_appointment_btn').on('click', function() {
                    $('#cancelConfirmModal').modal('show');
                });
                
                $('#time_in_btn').on('click', function() {
                    recordTimeInOut('in');
                });
                
                $('#time_out_btn').on('click', function() {
                    recordTimeInOut('out');
                });

                $('#confirm_cancel_btn').on('click', function(){
                    $('#cancelConfirmModal').modal('hide');
                    updateAppointmentStatus('cancelled');
                });

                $('#calendar_staff_filter').on('change', function(){
                    calendar.refetchEvents();
                });

                // Delegate click for rows / View buttons in the "more events" modal
                $('#moreEventsList').on('click', '.more-event-item', function(e){
                    if ($(e.target).closest('button').length && !$(e.target).is('button')) return;
                    var $item = $(this);
                    var id = $item.data('id');
                    var type = $item.data('type') || 'appointment';
                    if(id){
                        $('#moreEventsModal').modal('hide');
                        if(type === 'blocked'){
                            var blockedEvent = calendar.getEventById(String(id));
                            if(blockedEvent){
                                showBlockedSlotDetails(blockedEvent);
                            }
                        } else {
                            loadAppointmentDetails(id);
                        }
                    }
                });
            });

            function showBlockedSlotDetails(eventObj){
                var blockedFor = (eventObj.extendedProps && eventObj.extendedProps.blocked_for) ? eventObj.extendedProps.blocked_for : 'All Staff';
                var blockedBy = (eventObj.extendedProps && eventObj.extendedProps.blocked_by) ? eventObj.extendedProps.blocked_by : 'Unknown';
                var reason = (eventObj.extendedProps && eventObj.extendedProps.reason) ? eventObj.extendedProps.reason : '';
                var startText = eventObj.start ? crmCalFormat(eventObj.start, { weekday:'short', year:'numeric', month:'short', day:'numeric', hour:'numeric', minute:'2-digit', meridiem:'short' }) : '-';
                var endText = eventObj.end ? crmCalFormat(eventObj.end, { hour:'numeric', minute:'2-digit', meridiem:'short' }) : '-';

                var html = '<div class="row">' +
                    '<div class="col-md-6"><strong>Type:</strong></div><div class="col-md-6">Blocked Slot</div>' +
                    '<div class="col-md-6"><strong>Date & Time:</strong></div><div class="col-md-6">' + startText + ' - ' + endText + '</div>' +
                    '<div class="col-md-6"><strong>Blocked For:</strong></div><div class="col-md-6">' + blockedFor + '</div>' +
                    '<div class="col-md-6"><strong>Blocked By:</strong></div><div class="col-md-6">' + blockedBy + '</div>';
                if(reason){
                    html += '<div class="col-md-6"><strong>Reason:</strong></div><div class="col-md-6">' + reason + '</div>';
                }
                html += '</div>';

                $('#appointment_details_content').html(html);
                $('#appointmentDetailsModal').modal('show');
                $('#edit_appointment_btn, #mark_completed_btn, #mark_no_show_btn, #cancel_appointment_btn, #time_in_btn, #time_out_btn').hide();
                currentAppointmentId = null;
            }
            
            function loadAppointmentDetails(appointmentId) {
                $.ajax({
                    url: 'includes/datacontrol',
                    type: 'POST',
                    data: {
                        formName: 'get_appointment_details',
                        appointment_id: appointmentId
                    },
                    success: function(response) {
                        $('#appointment_details_content').html(response);
                        $('#appointmentDetailsModal').modal('show');
                        $('#edit_appointment_btn').show();
                        
                        // Show/hide action buttons based on status
                        var status = $('#appointment_status_hidden').val();
                        if(status == 'scheduled') {
                            $('#mark_completed_btn').show();
                            $('#mark_no_show_btn').show();
                            $('#cancel_appointment_btn').show();
                            $('#time_in_btn').show();
                            $('#time_out_btn').hide();
                        } else if(status == 'completed') {
                            $('#mark_completed_btn').hide();
                            $('#mark_no_show_btn').hide();
                            $('#cancel_appointment_btn').hide();
                            $('#time_in_btn').hide();
                            $('#time_out_btn').hide();
                        } else {
                            $('#mark_completed_btn').hide();
                            $('#mark_no_show_btn').hide();
                            $('#cancel_appointment_btn').hide();
                            $('#time_in_btn').hide();
                            $('#time_out_btn').hide();
                        }
                    }
                });
            }
            
            function crmToastSuccess(msg) {
                $('#toast-text').html(msg);
                var t = document.getElementById('borderedToast1');
                if (t && window.bootstrap) {
                    new bootstrap.Toast(t).show();
                } else {
                    $('#borderedToast1Btn').trigger('click');
                }
            }
            function crmToastError(msg) {
                $('#toast-text2').html(msg);
                var t = document.getElementById('borderedToast2');
                if (t && window.bootstrap) {
                    new bootstrap.Toast(t).show();
                } else {
                    $('#borderedToast2Btn').trigger('click');
                }
            }

            function updateAppointmentStatus(status) {
                $.ajax({
                    url: 'includes/datacontrol',
                    type: 'POST',
                    dataType: 'text',
                    data: {
                        formName: 'update_appointment_status',
                        appointment_id: currentAppointmentId,
                        status: status
                    },
                    success: function(response) {
                        var ok = String(response == null ? '' : response).trim() === '1';
                        if(ok) {
                            crmToastSuccess('Appointment status updated successfully');
                            $('#appointmentDetailsModal').modal('hide');
                            calendar.refetchEvents();
                        } else {
                            crmToastError('Cannot update appointment status.');
                        }
                    },
                    error: function() {
                        crmToastError('Cannot update appointment status (network error).');
                    }
                });
            }
            
            function recordTimeInOut(type) {
                $.ajax({
                    url: 'includes/datacontrol',
                    type: 'POST',
                    dataType: 'text',
                    data: {
                        formName: 'record_time_in_out',
                        appointment_id: currentAppointmentId,
                        type: type
                    },
                    success: function(response) {
                        var ok = String(response == null ? '' : response).trim() === '1';
                        if(ok) {
                            crmToastSuccess(type === 'in' ? 'Time in recorded successfully.' : 'Time out recorded successfully.');
                            loadAppointmentDetails(currentAppointmentId);
                            calendar.refetchEvents();
                        } else {
                            crmToastError('Cannot record time.');
                        }
                    },
                    error: function() {
                        crmToastError('Cannot record time (network error).');
                    }
                });
            }
        </script>
    </body>
</html>
<?php }else{ 
    header("Location: index.php");
}
?>

