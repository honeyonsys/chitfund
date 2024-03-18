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
                                        <label for="group" class="form-label">Select Group</label>
                                        <select name="group" id="group" class="form-select">
                                            <option value="" selected>Choose...</option>
                                        </select>
                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="invalid-feedback">Please select a Group.</div>
                                    </div>
                                    <table class="table table-hover" id="dataTables-pendingPayment" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Member Name</th>
                                                <th>Start Date</th>
                                                <th>Installment Amount</th>
                                                <th>Progress</th>
                                                <th>Action</th>
                                            </tr>
                                            <!-- <tr>
                                                <td>1</td>
                                                <td>harish</td>
                                                <td>02/02/2023</td>
                                                <td>10000</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr> -->
                                        </thead>
                                        <tbody>
                                            
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!--Member Payment Detail Block-->
                        <div class="col-md-12" id="paymentsBlock" style="display:none">
                            <div class="card">
                            <div class="card-header">Payment Details</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2"><b>Member Name:</b> <input type="hidden" id="memberIdForPayment"/></div>
                                        <div class="col-md-10" id="paymentDetailMemberName">--</div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2"><b>Group:</b> <input type="hidden" id="groupIdForPayment"/></div>
                                        <div class="col-md-10" id="paymentDetailMemberGroup">--</div>
                                        
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-md-12"><h3>Pending/Paid Installment</h3></div>
                                        <div class="col-md-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Month - Year</th>
                                                    <th scope="col">Paid & Pending Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody id="paymentStatus">
                                                
                                                
                                            </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>  
                        <!--Member Payment Detail Block ends-->
                    </div><!--row ends-->
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
                        groupDropDown += '<option value="'+group.ID+'" data-createdAt="'+group.CreatedAt+'">'+group.Name+'</option>';
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

        function loadMembersForPayment(groupId) {
            $.ajax({
                url: 'core/action.php',
                type: 'POST',
                data: {
                    action: 'getMembersForPaymentWithGroup',
                    groupId: groupId
                },
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    hideLoader();
                    dataTable.clear().draw();
                    if(response.length > 0) {
                        var sno = 1;
                        var totalMembers = response.length;
                        var groupTotalAmount = response[0].GroupAmount;
                        var groupPerMonthInstallment = parseInt(groupTotalAmount/12);
                        var perMemberInstallment = parseInt(groupPerMonthInstallment/totalMembers);
                        $.each(response, function(index, member) {
                            dataTable.row.add([
                                sno,
                                member.Name,
                                member.GroupCreatedDate,
                                "<b>₹</b>"+perMemberInstallment,
                                '<div class="progress"><div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>',
                                '<button class="btn btn-info paymentDetailBtn" data-id="'+member.ID+'">Details</button>'
                            ]).draw();
                            sno++;
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                    hideLoader();
                }
            });
        }

        $("#group").change(function() {
            loadMembersForPayment($(this).val());
        });

        $("#dataTables-pendingPayment").on("click", ".paymentDetailBtn", function() {
            //Fetching paid amounts
            
            
            $("#paymentsBlock").show();
            // Select the target div by its ID
            var targetDiv = $('#paymentDetailMemberName');

            // Get the position of the target div relative to the document
            var targetPosition = targetDiv.offset().top;

            // Animate scrolling to the target position
            $('html, body').animate({
                scrollTop: targetPosition
            }, 500); // Adjust the duration as needed (in milliseconds)

            $("#paymentDetailMemberName").focus();
            $("#paymentDetailMemberName").text($(this).parents("tr").children("td:eq(1)").text());
            $("#paymentDetailMemberGroup").text($("#group").find('option:selected').text());
            $("#memberIdForPayment").val($(this).attr("data-id"));
            $("#groupIdForPayment").val($("#group").find('option:selected').val());
            
            var tableBody = $("#paymentStatus");
            tableBody.html("");
            // Parse the start date stamp to get the month and year
            var startDate = new Date($(this).parents("tr").children("td:eq(2)").text());
            var startMonth = startDate.getMonth() + 1; // Months are 0-indexed, so add 1
            var startYear = startDate.getFullYear();

            for (var i = 0; i < 12; i++) {
                // Calculate the month and year for the current iteration
                var currentMonth = (startMonth + i) % 12; // Wrap around to January if necessary
                var currentYear = startYear + Math.floor((startMonth + i - 1) / 12); // Increment year if necessary

                // Create a table row element
                var row = $('<tr>');

                // Create and append the table header cell with the month number
                var th = $('<th scope="row">').text(i+1);
                row.append(th);

                var tdMonth = $('<td>').text(getMonthName(currentMonth) + ' ' + currentYear);
                row.append(tdMonth);

                var tdInput = $('<td>').append('<input type="text" class="form-control is-invalid" value="">');
                row.append(tdInput);
                
                var tdPayBtn = $('<td>').append('<input type="button" class="btn btn-primary payBtn" value="Pay" />');
                row.append(tdPayBtn);
                
                // Append the row to the table body
                tableBody.append(row);
            }


            //getting all the paid amount done by member for this group
            $.ajax({
                url: 'core/action.php',
                type: 'POST',
                data: {
                    action: 'getPaidAmountWithMemberIdAndGroupId',
                    groupId: $("#groupIdForPayment").val(),
                    memberId: $("#memberIdForPayment").val()
                },
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    hideLoader();
                    var paidAmounts = response;
                    //localStorage.setItem("paymentRes", JSON.stringify(response));
                    $('#paymentStatus tr').each(function() {
                        var monthYearText = $(this).find('td:eq(0)').text();
                        var inputField = $(this).find('input[type="text"]');
                        var payButton = $(this).find('.payBtn');
                        // Find the corresponding paid amount for the month and year
                        var paidAmount = paidAmounts.find(function(item) {
                            return item.paidForYearMonth === monthYearText;
                        });
                        
                        if (paidAmount) {
                            // Set the value of the input field to the paid amount
                            inputField.val(paidAmount.AmountPaid);
                            // Change the class of the input field to 'is-valid'
                            inputField.removeClass('is-invalid').addClass('is-valid');
                            inputField.prop('disabled', true);
                            payButton.remove();
                        }
                    });
                    
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                    hideLoader();
                }
            });
            
        });

        

        // Function to get the name of the month based on its number
        function getMonthName(monthNumber) {
            var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return monthNames[monthNumber === 0 ? 11 : monthNumber - 1];
        }

        $("#paymentStatus").on("click", ".payBtn", function() {
            var groupId = $("#groupIdForPayment").val();
            var memberId = $("#memberIdForPayment").val(); 
            var amount = $(this).parents("tr").children("td:eq(1)").children("input").val();
            var paidForYearMonth = $(this).parents("tr").children("td:eq(0)").text();
            var payBtn = $(this);
            var payInputField = $(this).parents('tr').children('td:eq(1)').children("input"); 
            if(amount <=0 || amount == "") {
                alert("Please fill the amount");
            } else {
                $.ajax({
                    url: 'core/action.php',
                    type: 'POST',
                    data: {
                        action: 'addPayment',
                        groupId: groupId,
                        memberId: memberId,
                        amount: amount,
                        paidForYearMonth: paidForYearMonth
                    },
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        hideLoader();
                        payInputField.removeClass('is-invalid').addClass('is-valid');
                        payInputField.prop('disabled', true);
                        payBtn.remove();
                    },
                    error: function(xhr, status, error) {
                        console.log('Error: ' + error);
                        alert('Error: ' + error);
                        hideLoader();
                    }
                });
            }
        });
    });
    </script>
</body>

</html>
