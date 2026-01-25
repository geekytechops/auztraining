<?php include('includes/dbconnect.php'); ?>
<?php 
session_start();
if(@$_SESSION['user_type']!=''){
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
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <?php include('includes/app_includes.php'); ?>
        
        <!-- FullCalendar CSS -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.css" rel="stylesheet" />
        
        <style>
            .fc-event {
                cursor: pointer;
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
                                        <div class="appointment-actions mb-3">
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

        <?php include('includes/footer_includes.php'); ?>
        
        <!-- FullCalendar JS -->
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>
        
        <script>
            var calendar;
            var currentAppointmentId = null;
            
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    events: function(fetchInfo, successCallback, failureCallback) {
                        $.ajax({
                            url: 'includes/datacontrol.php',
                            type: 'POST',
                            data: {
                                formName: 'get_appointments_calendar',
                                start: fetchInfo.startStr,
                                end: fetchInfo.endStr
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
                        var appointmentId = info.event.id;
                        currentAppointmentId = appointmentId;
                        loadAppointmentDetails(appointmentId);
                    },
                    eventDidMount: function(info) {
                        // Add tooltip
                        $(info.el).attr('title', info.event.title);
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
                    Swal.fire({
                        title: 'Cancel Appointment?',
                        text: 'Are you sure you want to cancel this appointment?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ff3d60',
                        cancelButtonColor: '#74788d',
                        confirmButtonText: 'Yes, cancel it'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            updateAppointmentStatus('cancelled');
                        }
                    });
                });
                
                $('#time_in_btn').on('click', function() {
                    recordTimeInOut('in');
                });
                
                $('#time_out_btn').on('click', function() {
                    recordTimeInOut('out');
                });
            });
            
            function loadAppointmentDetails(appointmentId) {
                $.ajax({
                    url: 'includes/datacontrol.php',
                    type: 'POST',
                    data: {
                        formName: 'get_appointment_details',
                        appointment_id: appointmentId
                    },
                    success: function(response) {
                        $('#appointment_details_content').html(response);
                        $('#appointmentDetailsModal').modal('show');
                        
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
            
            function updateAppointmentStatus(status) {
                $.ajax({
                    url: 'includes/datacontrol.php',
                    type: 'POST',
                    data: {
                        formName: 'update_appointment_status',
                        appointment_id: currentAppointmentId,
                        status: status
                    },
                    success: function(response) {
                        if(response == '1') {
                            Swal.fire('Success', 'Appointment status updated successfully', 'success').then(() => {
                                $('#appointmentDetailsModal').modal('hide');
                                calendar.refetchEvents();
                            });
                        } else {
                            Swal.fire('Error', 'Cannot update appointment status', 'error');
                        }
                    }
                });
            }
            
            function recordTimeInOut(type) {
                $.ajax({
                    url: 'includes/datacontrol.php',
                    type: 'POST',
                    data: {
                        formName: 'record_time_in_out',
                        appointment_id: currentAppointmentId,
                        type: type
                    },
                    success: function(response) {
                        if(response == '1') {
                            Swal.fire('Success', 'Time recorded successfully', 'success').then(() => {
                                loadAppointmentDetails(currentAppointmentId);
                                calendar.refetchEvents();
                            });
                        } else {
                            Swal.fire('Error', 'Cannot record time', 'error');
                        }
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

