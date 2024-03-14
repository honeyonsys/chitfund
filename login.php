<?php 
session_start();
if(isset($_SESSION["adminUserid"]) && isset($_SESSION["admin"])) {
  header("Location:dashboard.php");
}
?>
<html>
<head>
<style>
	

.container {
  width: 100%;
  max-width: 400px;
}

.card {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
  color: #333;
}

form {
  display: flex;
  flex-direction: column;
}

input {
  padding: 10px;
  margin-bottom: 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  transition: border-color 0.3s ease-in-out;
  outline: none;
  color: #333;
}

input:focus {
  border-color: #555;
}

button {
  background-color: #3498db;
  color: #fff;
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
}

button:hover {
  background-color: #2980b9;
}

</style>	
</head>
<body>
	<div class="container" style="margin:0 auto;margin-top:15%">
  <div class="card">
    <h2>Login</h2>
    <form id="login-form">
      <input type="text" id="email" name="email" placeholder="Username" required>
      <input type="password" id="password" name="password" placeholder="Password" required>
      <button type="submit" id="login">Login</button>
    </form>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script>
 $(document).ready(function(){
  $('#login-form').submit(function(event) {
        event.preventDefault(); 
        var username = $('#email').val();
        var password = $('#password').val();
        //var formData = $(this).serialize();
        $.ajax({
            url: 'core/action.php',
            type: 'POST',
            data: {
                    action: 'login',
                    email: username,
                    password: password
                },
            beforeSend: function() {
                //showLoader(); 
            },
            success: function(res) {
              if(res == "success") {
                window.location.reload();
              } else {
                alert("Login is incorrect, please check username and password");
              }
            },
            error: function(xhr, status, error) {
                alert('Login failed!'); 
            },
            complete: function() {
                //hideLoader(); 
            }
          });
        });
});
</script>

</body>



</html>