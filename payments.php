<?php 
include("validateSession.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Payment Management</title>
    <?php include('includes/includedcss.php'); ?>
</head>

<body>
    <div class="wrapper">
        <?php include('includes/sidebarnav.php');?>
        <div id="body" class="active">
            <?php include('includes/topnavigation.php');?>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 page-header">
                            <div class="page-pretitle">Overview</div>
                            <h2 class="page-title">Payment Management</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Filter the memebers by group</div>
                                <div class="card-body">
                                    <div class="mb-3 col-md-6">
                                        <label for="group" class="form-label">Group</label>
                                        <select name="group" id="group" class="form-select">
                                            <option value="" selected>Choose...</option>
                                        </select>
                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="invalid-feedback">Please select a Group.</div>
                                    </div>   
                                </div>
                            </div>        
                        </div><!--top form for group ends-->
                        <div class="col-md-12">
                            <div class="card">
                            <div class="card-header">Filter the memebers by group</div>
                                <div class="card-body">
                                    <table class="table table-hover" id="dataTables-pendingPayment" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Member Name</th>
                                                <th>Start Date</th>
                                                <th>Installment Amount</th>
                                                <th>Progress</th>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>harish</td>
                                                <td>02/02/2023</td>
                                                <td>10000</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/includedjs.php');?>
    <script>
    $(document).ready(function(){
        function populateGroupDropDown() {
            $.ajax({
                url: 'core/action.php',
                type: 'POST',
                data: {
                    action: 'getGroupList'
                },
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    hideLoader();
                    var groupDropDown = '<option value="" selected>Choose...</option>';
                    $.each(response, function(index, group) {
                        groupDropDown += '<option value="'+group.ID+'">'+group.Name+'</option>';
                    });
                    $("#group").html(groupDropDown);
                    $("#group").select2();
                    $("#group").addClass("select2DropdownOverride");
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                    hideLoader();
                }
            });
        }
        populateGroupDropDown();

        var dataTable = $('#dataTables-pendingPayment').DataTable({
            responsive: true,
            pageLength: 20,
            lengthChange: false,
            searching: true,
            ordering: true
        });

        function loadMembersForPayment() {
            $.ajax({
                url: 'core/action.php',
                type: 'POST',
                data: {
                    action: 'getMembersPaymentWithGroup'
                },
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    hideLoader();
                    dataTable.clear().draw();
                    var sno = 1;
                    $.each(response, function(index, member) {
                        dataTable.row.add([
                            sno,
                            member.Name,
                            member.GroupCreatedDate,
                            parseInt(member.GroupAmount/12),
                            '<div class="progress"><div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>'
                        ]).draw();
                        sno++;
                    });
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                    hideLoader();
                }
            });
        }

        loadMembersForPayment();
    });
    </script>
</body>

</html>
