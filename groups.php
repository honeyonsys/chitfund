<?php 
include("validateSession.php");
?>
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
                            <div class="modal-body" id="membersModalBody">
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="addMembersToGroup">Add Members to Group</button>
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
                                        <input type="hidden" name="editId" id="editId" />
                                        <div class="mb-3">
                                            <label for="groupname" class="form-label">Group Name</label>
                                            <input type="text" id="groupname" placeholder="Group Name" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="groupamount" class="form-label">Total Amount</label>
                                            <input type="number" id="groupamount" placeholder="Group Amount" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="submit" id="saveGroupBtn" value="Add Group [+]" class="btn btn-primary">
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
                            '<button class="btn btn-outline-secondary mb-2 editGroup" data-id="'+group.ID+'">Edit</button>'
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
                    $("#editId").val("");
                    $("#groupname").val("");
                    $("#groupamount").val("");
                    $("#saveGroupBtn").val("Add Group [+]");
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


        //triggered event when members modal open for selecting members
        $('#membersModal').on('show.bs.modal', function (event) {
            var editId = $("#editId").val();
            if(editId == "") {
                var errorHtml = '<div class="alert alert-danger" role="alert">Please edit any existing group to select list of members</div>';
                $("#membersModalBody").html(errorHtml);

            } else {
                var modal = $(this)
                $.ajax({
                    url: 'core/action.php',
                    type: 'POST',
                    data: {
                        action: 'getMemberList'
                    },
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(data) {
                        hideLoader();
                        $('#membersModalBody').empty();

                        // Iterate over the user data and generate HTML content
                        data.forEach(function(user) {
                            var checkboxHtml = '<div class="form-check">';
                            checkboxHtml += '<input class="form-check-input" type="checkbox" value="' + user.ID + '" id="userCheckbox' + user.ID + '"';
                            if(editId==user.GroupID) {
                                checkboxHtml += ' checked'
                            }
                            checkboxHtml += '>';
                            checkboxHtml += '<label class="form-check-label" for="userCheckbox' + user.ID + '">' + user.Name + ' | ' + user.Email+'</label></div>';
                            
                            $('#membersModalBody').append(checkboxHtml);
                        });

                    },
                    error: function(xhr, status, error) {
                        console.log('Error: ' + error);
                        hideLoader();
                    }
                });
            }
            
        });


        $('#dataTables-grouplist').on("click", ".editGroup", function() {
            let groupId = $(this).attr('data-id');
            
            $.ajax({
                url: 'core/action.php',
                type: 'POST',
                data: {
                    action: 'getGroupSingle',
                    groupId: groupId
                },
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    hideLoader();
                    $("#editId").val(response.ID);
                    $("#groupname").focus();
                    $("#groupname").val(response.Name);
                    $("#groupamount").val(response.Amount);
                    $("#saveGroupBtn").val("Save Group");
                    
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                    hideLoader();
                }
            });
        });

        //add members button in modal, the selected checkbox items will add to group
        // $("#addMembersToGroup").click(function() {
        //     alert("asfsdf");
        // });

        $('#addMembersToGroup').on('click', function() {
            // Initialize an array to store the IDs of checked checkboxes
            var checkedIds = [];
            var groupId = $("#editId").val();
            // Find all checked checkboxes and collect their IDs
            $('#membersModalBody input[type="checkbox"]:checked').each(function() {
                checkedIds.push($(this).val());
            });

            // Iterate over the checked IDs and make AJAX calls to update the values
            checkedIds.forEach(function(id) {
                $.ajax({
                    url: 'core/action.php', // Update with your API endpoint
                    method: 'POST',
                    data: {
                        action: 'updateGroupInMember',
                        memberId: id,
                        groupId: groupId
                        // Add other parameters as needed for updating values
                    },
                    success: function(response) {
                        // Handle success response
                        
                        console.log('Value updated successfully:', response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error('Error updating value:', error);
                    }
                });
            });
            $('#membersModal').modal('hide');
            alert("members added to the group");
        }); //end addMembersToGroup button method 
    })();
    </script>
</body>

</html>
