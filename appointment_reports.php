<?php include('includes/dbconnect.php'); ?>
<?php 
session_start();
if(@$_SESSION['user_type']!=''){
?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Appointment Reports</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <?php include('includes/app_includes.php'); ?>
        
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
        <style>
            .chart-container {
                position: relative;
                height: 300px;
                width: 100%;
                overflow: hidden;
                padding: 10px;
            }
            .chart-container canvas {
                max-width: 100% !important;
                max-height: 100% !important;
            }
            .card-body {
                overflow: hidden;
            }
        </style>
    </head>

    <body data-topbar="colored">

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <?php include('includes/header.php'); ?>
            <?php include('includes/sidebar.php'); ?>
            
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Appointment Reports</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                            <li class="breadcrumb-item"><a href="appointment_calendar.php">Appointments</a></li>
                                            <li class="breadcrumb-item active">Reports</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <!-- Filter Section -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Filter Reports</h5>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Date Range</label>
                                                <select class="form-select" id="date_range">
                                                    <option value="today">Today</option>
                                                    <option value="week">This Week</option>
                                                    <option value="month" selected>This Month</option>
                                                    <option value="custom">Custom Range</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3" id="custom_date_section" style="display:none;">
                                                <label class="form-label">Start Date</label>
                                                <input type="date" class="form-control" id="start_date">
                                            </div>
                                            <div class="col-md-3" id="custom_date_section2" style="display:none;">
                                                <label class="form-label">End Date</label>
                                                <input type="date" class="form-control" id="end_date">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">&nbsp;</label><br>
                                                <button type="button" class="btn btn-primary" onclick="loadReports()">Generate Report</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Cards -->
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-14 mb-2">Total Appointments</p>
                                                <h4 class="mb-2" id="total_appointments">0</h4>
                                            </div>
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-primary rounded-circle">
                                                    <i class="mdi mdi-calendar-clock font-size-18"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-14 mb-2">Attended</p>
                                                <h4 class="mb-2 text-success" id="attended_count">0</h4>
                                            </div>
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-success rounded-circle">
                                                    <i class="mdi mdi-check-circle font-size-18"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-14 mb-2">Missed/No-Show</p>
                                                <h4 class="mb-2 text-danger" id="missed_count">0</h4>
                                            </div>
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-danger rounded-circle">
                                                    <i class="mdi mdi-close-circle font-size-18"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-14 mb-2">Cancelled</p>
                                                <h4 class="mb-2 text-warning" id="cancelled_count">0</h4>
                                            </div>
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-warning rounded-circle">
                                                    <i class="mdi mdi-cancel font-size-18"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Charts -->
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Appointments by Status</h4>
                                        <div class="chart-container">
                                            <canvas id="statusChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Appointments by Purpose</h4>
                                        <div class="chart-container">
                                            <canvas id="purposeChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Appointments by Staff Member</h4>
                                        <div class="chart-container">
                                            <canvas id="staffChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Daily Appointments Trend</h4>
                                        <div class="chart-container">
                                            <canvas id="dailyTrendChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Reports Table -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Detailed Appointments</h4>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="appointments_table">
                                                <thead>
                                                    <tr>
                                                        <th>Date & Time</th>
                                                        <th>Purpose</th>
                                                        <th>Attendee</th>
                                                        <th>Staff Member</th>
                                                        <th>Status</th>
                                                        <th>Meeting Type</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="appointments_table_body">
                                                    <!-- Loaded via AJAX -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->                            
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <?php include('includes/footer_includes.php'); ?>
        
        <script>
            var statusChart, purposeChart, staffChart, dailyTrendChart;
            
            $(document).ready(function() {
                $('#date_range').on('change', function() {
                    if($(this).val() == 'custom') {
                        $('#custom_date_section').show();
                        $('#custom_date_section2').show();
                    } else {
                        $('#custom_date_section').hide();
                        $('#custom_date_section2').hide();
                    }
                });
                
                loadReports();
            });
            
            function loadReports() {
                var dateRange = $('#date_range').val();
                var startDate = '';
                var endDate = '';
                
                if(dateRange == 'custom') {
                    startDate = $('#start_date').val();
                    endDate = $('#end_date').val();
                }
                
                $.ajax({
                    url: 'includes/datacontrol.php',
                    type: 'POST',
                    data: {
                        formName: 'get_appointment_reports',
                        date_range: dateRange,
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        try {
                            var data = JSON.parse(response);
                            
                            // Update summary cards
                            $('#total_appointments').text(data.summary.total);
                            $('#attended_count').text(data.summary.attended);
                            $('#missed_count').text(data.summary.missed);
                            $('#cancelled_count').text(data.summary.cancelled);
                            
                            // Update charts - use setTimeout to ensure DOM is ready
                            setTimeout(function() {
                                updateStatusChart(data.charts.status);
                                updatePurposeChart(data.charts.purpose);
                                updateStaffChart(data.charts.staff);
                                updateDailyTrendChart(data.charts.daily);
                            }, 100);
                            
                            // Update table
                            updateAppointmentsTable(data.appointments);
                        } catch(e) {
                            console.error('Error parsing report data:', e);
                            console.error('Response:', response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        console.error('Status:', status);
                    }
                });
            }
            
            function updateStatusChart(data) {
                var ctx = document.getElementById('statusChart');
                if(!ctx) return;
                
                if(statusChart) {
                    statusChart.destroy();
                    statusChart = null;
                }
                
                // Ensure we have data
                if(!data.labels || data.labels.length === 0) {
                    data.labels = ['No Data'];
                    data.values = [0];
                }
                
                statusChart = new Chart(ctx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.values,
                            backgroundColor: ['#0ac074', '#ff3d60', '#fcb92c', '#74788d', '#4aa3ff']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            animateRotate: true,
                            animateScale: false,
                            duration: 1000
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 10,
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        },
                        layout: {
                            padding: {
                                top: 5,
                                bottom: 5,
                                left: 5,
                                right: 5
                            }
                        }
                    }
                });
            }
            
            function updatePurposeChart(data) {
                var ctx = document.getElementById('purposeChart');
                if(!ctx) return;
                
                if(purposeChart) {
                    purposeChart.destroy();
                    purposeChart = null;
                }
                
                // Ensure we have data
                if(!data.labels || data.labels.length === 0) {
                    data.labels = ['No Data'];
                    data.values = [0];
                }
                
                purposeChart = new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Appointments',
                            data: data.values,
                            backgroundColor: '#0bb197'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        animation: {
                            duration: 1000
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
            
            function updateStaffChart(data) {
                var ctx = document.getElementById('staffChart');
                if(!ctx) return;
                
                if(staffChart) {
                    staffChart.destroy();
                    staffChart = null;
                }
                
                // Ensure we have data
                if(!data.labels || data.labels.length === 0) {
                    data.labels = ['No Data'];
                    data.values = [0];
                }
                
                staffChart = new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Appointments',
                            data: data.values,
                            backgroundColor: '#564ab1'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        animation: {
                            duration: 1000
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
            
            function updateDailyTrendChart(data) {
                var ctx = document.getElementById('dailyTrendChart');
                if(!ctx) return;
                
                if(dailyTrendChart) {
                    dailyTrendChart.destroy();
                    dailyTrendChart = null;
                }
                
                // Ensure we have data
                if(!data.labels || data.labels.length === 0) {
                    data.labels = ['No Data'];
                    data.values = [0];
                }
                
                dailyTrendChart = new Chart(ctx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Appointments',
                            data: data.values,
                            borderColor: '#0bb197',
                            backgroundColor: 'rgba(11, 177, 151, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        animation: {
                            duration: 1000
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        }
                    }
                });
            }
            
            function updateAppointmentsTable(appointments) {
                var tbody = $('#appointments_table_body');
                tbody.empty();
                
                if(appointments.length == 0) {
                    tbody.append('<tr><td colspan="7" class="text-center">No appointments found</td></tr>');
                    return;
                }
                
                appointments.forEach(function(apt) {
                    var statusClass = 'status-' + apt.status;
                    var statusText = apt.status.charAt(0).toUpperCase() + apt.status.slice(1).replace('-', ' ');
                    
                    var row = '<tr>' +
                        '<td>' + apt.datetime + '</td>' +
                        '<td>' + apt.purpose + '</td>' +
                        '<td>' + apt.attendee + '</td>' +
                        '<td>' + apt.staff + '</td>' +
                        '<td><span class="status-badge ' + statusClass + '">' + statusText + '</span></td>' +
                        '<td>' + apt.meeting_type + '</td>' +
                        '<td><a href="appointment_booking.php?id=' + btoa(apt.id) + '" class="btn btn-sm btn-primary">View</a></td>' +
                        '</tr>';
                    tbody.append(row);
                });
            }
        </script>
    </body>
</html>
<?php }else{ 
    header("Location: index.php");
}
?>

