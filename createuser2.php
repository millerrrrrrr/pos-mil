<?php

session_start();

include_once 'ui/connectdb.php';


if(isset($_POST['btnsave'])){

    $username = $_POST['name'];
    $userage = $_POST['age'];
    $useremail = $_POST['email'];
    $useraddress = $_POST['address'];
    $usercontact = $_POST['contact'];
    $userpassword = $_POST['password'];
    $userrepassword = $_POST['repassword'];
    $userrole = $_POST['select_option'];


    if(isset($_post['email']) && isset($_POST['password']) && isset($_POST['repassword'])){

        $selectemail = $pdo->prepare("select email from tbl_user where email='$useremail'");
        $selectpassword = $pdo->prepare("select userpassword from tbl_user where password='$userpassword'");

        $selectemail->execute();
        $selectpassword->execute();

        if($selectemail->rowCount()>0){

            $_SESSION['status'] = "Email Already Exists";
            $_SESSION['status_code'] = "warning";

        }else if($selectpassword->rowCount()>0){

            $_SESSION['status'] = "Password Already Exists";
            $_SESSION['status_code'] = "warning";

        }else if($_POST['age'] > 18){

            $_SESSION['status'] = "Sorry, you must be 18 or older to register.";
            $_SESSION['status_code'] = "warning";


        }else if($userpassowrd != $userrepassword){

            $_SESSION['status'] = "Password dont Match.";
            $_SESSION['status_code'] = "error";

        }else{

            $insert = $pdo->prepare("insert into tbl_user (name, age, email, address, contact, password, role) values (:name, :age, :email, :address, :contact, :password, :role) ");

            $insert->bindParam(':name', $username);
            $insert->bindParam(':age', $userage);
            $insert->bindParam(':email', $useremail);
            $insert->bindParam(':name', $user);
            $insert->bindParam(':address', $useraddress);
            $insert->bindParam(':contact', $usercontact);
            $insert->bindParam(':password', $userpassword);
            $insert->bindParam(':role', $userrole);
            

            if($insert->execute()){

                $_SESSION['status'] = "Registered Successfully";
                $_SESSION['status_code'] = "success";
                header('refresh: 1; index.php');

            }else{


                $_SESSION['status'] = "Registration Failed";
                $_SESSION['status_code'] = "error";

            }



        }





    }




}




?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>POS MIL | REGISTER</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">

  <style>
    .login-page{
      background-color: black;
    }
    .card-body{
      background-color: #0C2D57;
      color: white;
      border-radius: 0 0 20px 20px;
      padding: 15px; /* Adjusted padding */
    }
    .card-header{
      background-color: #0C2D57;
      color: white;
      border-radius: 20px 20px 0 0;
      padding: 10px; /* Adjusted padding */
    }
    .card{
      background-color: black;
      width: 400px; /* Adjust the width as needed */
      margin: auto; /* Center the card */
      margin-top: 50px; /* Adjust margin-top as needed */
    }
  </style>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>POS MIL</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register an account</p>
      <form action="" method="POST">
        <div class="card-body">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" placeholder="Enter Name" name="name" required>
          </div>
          <div class="form-group">
            <label>Age</label>
            <input type="number" class="form-control" placeholder="Enter Age" name="age" min="1" max="99" required>
          </div>
          <div class="form-group">
            <label>Email address</label>
            <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
          </div>
          <div class="form-group">
            <label>Address</label>
            <input type="text" class="form-control" placeholder="Enter Address" name="address" required>
          </div>
          <div class="form-group">
            <label>Contact No.</label>
            <input type="number" class="form-control" placeholder="Enter Contact No." name="contact" required>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" placeholder="Password" name="password" required>
          </div>
          <div class="form-group">
            <label>Re-type Password</label>
            <input type="password" class="form-control" placeholder="Re-type Password" name="repassword" required>
          </div>
          <div class="form-group">
            <label>Role</label>
            <select class="form-control" name="select_option" required>
              <option value="" disabled selected>Select Role</option>
              <option>Admin</option>
              <option>User</option>
            </select>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary" name="btnsave">Register</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</body>
</html>

<?php
if(isset($_SESSION['status']) && $_SESSION['status'] != '')
{
?>

<script>

$(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: 5000
    });

    
      Toast.fire({
        icon: '<?php echo $_SESSION['status_code']?>',
        title: '<?php echo $_SESSION['status']?>'
      })
    })

</script>

<?php
unset($_SESSION['status']);

} 

?>