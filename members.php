<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Member Management</title>
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
                            <h2 class="page-title">Members Management</h2>
                        </div>
                    </div>
                    <div class="row">
                        <!--member create form-->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Add new member</div>
                                    <div class="card-body">
                                    <form accept-charset="utf-8" id="addMemberForm">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                                                <small class="form-text text-muted">Name should be alphabets.</small>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please enter your name.</div>
                                            </div>    
                                            <div class="mb-3 col-md-6">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                                                <small class="form-text text-muted">Enter a valid email address.</small>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please enter your email address.</div>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="row">
                                            <div class="mb-3 col-md-4">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                                                <small class="form-text text-muted">e.g House No 1, Street No #1, Area Name.</small>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please enter your address.</div>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label for="address" class="form-label">City</label>
                                                <input type="text" class="form-control" name="city" id="city" placeholder="City">
                                                <small class="form-text text-muted">City name.</small>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please enter city.</div>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label for="state" class="form-label">State</label>
                                                <select name="state" id="state" class="form-select" required>
                                                    <option value="" selected>Choose...</option>
                                                    <option value="AP">Andhra Pradesh</option>
                                                    <option value="AR">Arunachal Pradesh</option>
                                                    <option value="AS">Assam</option>
                                                    <option value="BR">Bihar</option>
                                                    <option value="CT">Chhattisgarh</option>
                                                    <option value="GA">Gujarat</option>
                                                    <option value="HR">Haryana</option>
                                                    <option value="HP">Himachal Pradesh</option>
                                                    <option value="JK">Jammu and Kashmir</option>
                                                    <option value="GA">Goa</option>
                                                    <option value="JH">Jharkhand</option>
                                                    <option value="KA">Karnataka</option>
                                                    <option value="KL">Kerala</option>
                                                    <option value="MP">Madhya Pradesh</option>
                                                    <option value="MH">Maharashtra</option>
                                                    <option value="MN">Manipur</option>
                                                    <option value="ML">Meghalaya</option>
                                                    <option value="MZ">Mizoram</option>
                                                    <option value="NL">Nagaland</option>
                                                    <option value="OR">Odisha</option>
                                                    <option value="PB">Punjab</option>
                                                    <option value="RJ">Rajasthan</option>
                                                    <option value="SK">Sikkim</option>
                                                    <option value="TN">Tamil Nadu</option>
                                                    <option value="TG">Telangana</option>
                                                    <option value="TR">Tripura</option>
                                                    <option value="UT">Uttarakhand</option>
                                                    <option value="UP">Uttar Pradesh</option>
                                                    <option value="WB">West Bengal</option>
                                                    <option value="AN">Andaman and Nicobar Islands</option>
                                                    <option value="CH">Chandigarh</option>
                                                    <option value="DN">Dadra and Nagar Haveli</option>
                                                    <option value="DD">Daman and Diu</option>
                                                    <option value="DL">Delhi</option>
                                                    <option value="LD">Lakshadweep</option>
                                                    <option value="PY">Puducherry</option>
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please select a State.</div>
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label for="zip" class="form-label">Zip code</label>
                                                <input type="text" class="form-control" name="zip" id="zip" placeholder="00000" required>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please enter a Zip code.</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone">
                                                <small class="form-text text-muted">Phone.</small>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please enter phone.</div>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="group" class="form-label">Group</label>
                                                <select name="group" id="group" class="form-select">
                                                    <option value="" selected>Choose...</option>
                                                    <option value="1">Group 1</option>
                                                    <option value="2">Group 2</option>
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please select a Group.</div>
                                            </div>
                                            
                                        </div>
                                        <input type="submit" value="Add Member [+]" class="btn btn-primary">
                                        <!-- <button class="btn btn-primary"><i class="fas fa-save"></i> Save</button> -->
                                        
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--member create form ends here-->
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">Members List</div>
                                <div class="card-body">
                                    <p class="card-title"></p>
                                    <table class="table table-hover" id="dataTables-memberList" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Group</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Dakota Rice</td>
                                                <td>$36,738</td>
                                                <td>United States</td>
                                                <td>Oud-Turnhout</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Minerva Hooper</td>
                                                <td>$23,789</td>
                                                <td>Curaçao</td>
                                                <td>Sinaai-Waas</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--data table end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/includedjs.php');?>
    <script>
    $(document).ready(function(){
        var dataTable = $('#dataTables-memberList').DataTable({
            responsive: true,
            pageLength: 20,
            lengthChange: false,
            searching: true,
            ordering: true
        });
        function getMemberList() {
            $.ajax({
                url: 'core/action.php',
                type: 'POST',
                data: {
                    action: 'getMemberList'
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
                            member.Email,
                            member.GroupID,
                            '<button class="btn btn-outline-secondary mb-2">Edit</button>'
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

        getMemberList();

        $('#addMemberForm').submit(function(e) {
            // Prevent default form submission behavior
            e.preventDefault();

            // Get form data
            var formData = $(this).serialize();

            // Send AJAX request to action.php
            $.ajax({
                url: 'core/action.php',
                type: 'POST',
                data: formData + '&action=addMember', // Include action parameter
                beforeSend: function() {
                    // Show loader or perform other actions before sending the request
                    showLoader();
                },
                success: function(response) {
                    // Handle success response
                    $("#name").val("");
                    $("#email").val("");
                    $("#address").val("");
                    $("#city").val("");
                    $("#state").val("");
                    $("#zip").val("");
                    $("#phone").val("");
                    $('#group option[value=""]').attr("selected",true);

                    getMemberList();

                    // Hide loader
                    hideLoader();

                    // You can redirect or perform other actions here if needed
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error: ' + error);

                    // Hide loader
                    hideLoader();
                }
            });
        });
    })
    </script>
</body>

</html>
