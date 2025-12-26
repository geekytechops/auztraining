<?php include('includes/dbconnect.php'); ?>
<?php 
session_start();
if(@$_SESSION['user_type']!=''){
    $users = mysqli_query($connection, "SELECT * FROM users WHERE user_status != 1 ORDER BY user_name");
?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Block Appointment Slots</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <?php include('includes/app_includes.php'); ?>
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
                                    <h4 class="mb-sm-0">Block Appointment Slots</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                            <li class="breadcrumb-item"><a href="appointment_calendar.php">Appointments</a></li>
                                            <li class="breadcrumb-item active">Block Slots</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Add Blocked Slot</h5>
                                        <form id="block_form">
                                            <input type="hidden" name="formName" value="add_appointment_block">
                                            <input type="hidden" name="block_id" id="block_id" value="0">
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Block Date <span class="asterisk">*</span></label>
                                                <input type="date" class="form-control" id="block_date" name="block_date" required>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Start Time <span class="asterisk">*</span></label>
                                                        <input type="time" class="form-control" id="block_start_time" name="block_start_time" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">End Time <span class="asterisk">*</span></label>
                                                        <input type="time" class="form-control" id="block_end_time" name="block_end_time" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Staff Member</label>
                                                <select class="form-select" id="block_staff_member_id" name="block_staff_member_id">
                                                    <option value="">All Staff</option>
                                                    <?php 
                                                    while($user = mysqli_fetch_array($users)){
                                                        echo "<option value='{$user['user_id']}'>{$user['user_name']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <small class="text-muted">Leave empty to block for all staff</small>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Reason</label>
                                                <input type="text" class="form-control" id="block_reason" name="block_reason" placeholder="Reason for blocking">
                                            </div>
                                            
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Add Block</button>
                                                <button type="button" class="btn btn-secondary waves-effect waves-light" onclick="resetBlockForm()">Reset</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Blocked Slots</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="blocks_table">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Staff</th>
                                                        <th>Reason</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="blocks_table_body">
                                                    <!-- Loaded via AJAX -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
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
            $(document).ready(function() {
                loadBlocks();
                
                $('#block_form').on('submit', function(e) {
                    e.preventDefault();
                    
                    var formData = new FormData(this);
                    
                    $.ajax({
                        url: 'includes/datacontrol.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if(response == '1') {
                                Swal.fire('Success', 'Block added successfully', 'success').then(() => {
                                    resetBlockForm();
                                    loadBlocks();
                                });
                            } else {
                                Swal.fire('Error', 'Cannot add block', 'error');
                            }
                        }
                    });
                });
            });
            
            function loadBlocks() {
                $.ajax({
                    url: 'includes/datacontrol.php',
                    type: 'POST',
                    data: {formName: 'get_appointment_blocks'},
                    success: function(response) {
                        try {
                            var blocks = JSON.parse(response);
                            var tbody = $('#blocks_table_body');
                            tbody.empty();
                            
                            if(blocks.length == 0) {
                                tbody.append('<tr><td colspan="5" class="text-center">No blocked slots</td></tr>');
                                return;
                            }
                            
                            blocks.forEach(function(block) {
                                var row = '<tr>' +
                                    '<td>' + block.date + '</td>' +
                                    '<td>' + block.start_time + ' - ' + block.end_time + '</td>' +
                                    '<td>' + (block.staff || 'All Staff') + '</td>' +
                                    '<td>' + (block.reason || '-') + '</td>' +
                                    '<td>' +
                                    '<button class="btn btn-sm btn-danger" onclick="deleteBlock(' + block.id + ')">Delete</button>' +
                                    '</td>' +
                                    '</tr>';
                                tbody.append(row);
                            });
                        } catch(e) {
                            console.error('Error loading blocks:', e);
                        }
                    }
                });
            }
            
            function deleteBlock(blockId) {
                Swal.fire({
                    title: 'Delete Block?',
                    text: 'Are you sure you want to delete this blocked slot?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ff3d60',
                    cancelButtonColor: '#74788d',
                    confirmButtonText: 'Yes, delete it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'includes/datacontrol.php',
                            type: 'POST',
                            data: {
                                formName: 'delete_appointment_block',
                                block_id: blockId
                            },
                            success: function(response) {
                                if(response == '1') {
                                    Swal.fire('Success', 'Block deleted successfully', 'success').then(() => {
                                        loadBlocks();
                                    });
                                } else {
                                    Swal.fire('Error', 'Cannot delete block', 'error');
                                }
                            }
                        });
                    }
                });
            }
            
            function resetBlockForm() {
                $('#block_form')[0].reset();
                $('#block_id').val('0');
            }
        </script>
    </body>
</html>
<?php }else{ 
    header("Location: index.php");
}
?>

