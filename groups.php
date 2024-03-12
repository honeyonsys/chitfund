<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Group Management</title>
    <?php include('includes/includedcss.php'); ?>
</head>

<body>
    <?php include('includes/screenLoader.php'); ?>
    <div class="wrapper">
        <?php include('includes/sidebarnav.php');?>
        <div id="body" class="active">
            <?php include('includes/topnavigation.php');?>
            <div class="content">
                <div class="container">

                    <!-- Modal for selecting members-->
                    <div class="modal fade" id="membersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add list of members in the group</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal for selecting members ends-->
                    <div class="row">
                        <div class="col-md-12 page-header">
                            <div class="page-pretitle">Overview</div>
                            <h2 class="page-title">Group Management</h2>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">Add new group</div>
                                <div class="card-body">
                                    
                                    <form accept-charset="utf-8" id="addGroupForm">
                                        <div class="mb-3">
                                            <label for="groupname" class="form-label">Group Name</label>
                                            <input type="text" id="groupname" placeholder="Group Name" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="groupamount" class="form-label">Total Amount</label>
                                            <input type="number" id="groupamount" placeholder="Group Amount" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="submit" value="Add Group [+]" class="btn btn-primary">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#membersModal">Add Members <i class="fa-solid fa-user-group"></i></button>

                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                                <div class="card-header">Group List</div>
                                <div class="card-body">
                                    <p class="card-title"></p>
                                    <table class="table table-hover" id="dataTables-grouplist" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Group Name</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- <tr>
                                                <td>Dakota Rice</td>
                                                <td>$36,738</td>
                                                <td><button class="btn btn-outline-secondary mb-2">Edit</button></td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php include('includes/includedjs.php');?>
    <script>
    (function() {
        'use strict';
        var dataTable = $('#dataTables-grouplist').DataTable({
            responsive: true,
            pageLength: 20,
            lengthChange: false,
            searching: true,
            ordering: true
        });
        function getGroupList() {
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
                    dataTable.clear().draw();
                    $.each(response, function(index, group) {
                        dataTable.row.add([
                            group.Name,
                            group.Amount,
                            '<button class="btn btn-outline-secondary mb-2">Edit</button>'
                        ]).draw();
                    });
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                    hideLoader();
                }
            });
        }

        getGroupList();

        $('#addGroupForm').submit(function(event) {
            event.preventDefault();
            var groupname = $('#groupname').val().trim();
            var groupamount = $('#groupamount').val().trim();

            if (groupname == '' || groupamount == '') {
                alert('Please fill in all fields');
                return;
            }
            
            // AJAX request to action.php
            $.ajax({
                url: 'core/action.php',
                type: 'POST',
                data: {
                    action: 'addGroup',
                    groupname: groupname,
                    groupamount: groupamount
                },
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    // Handle success response
                    $("#groupname").val("");
                    $("#groupamount").val("");
                    getGroupList();
                    hideLoader();
                    // You can redirect or perform other actions here if needed
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    alert('Error: ' + error);
                    hideLoader();
                }
            });
        });


        // $('#exampleModal').on('show.bs.modal', function (event) {
        //     var button = $(event.relatedTarget) // Button that triggered the modal
        //     var recipient = button.data('whatever') // Extract info from data-* attributes
        //     // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        //     // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        //     var modal = $(this)
        //     modal.find('.modal-title').text('New message to ' + recipient)
        //     modal.find('.modal-body input').val(recipient)
        // })
    })();
    </script>
</body>

</html>
