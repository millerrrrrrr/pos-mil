<?php
include_once"ui/connectdb.php";
session_start();

if(isset($_POST['btn_login'])){


$useremail = $_POST['txt_email'];
$password=$_POST['txt_password'];

$select = $pdo->prepare("select * from tbl_user where useremail ='$useremail' and userpassword ='$password'");
$select->execute();


$row = $select->fetch(PDO::FETCH_ASSOC);

if(is_array($row)){

  if($row['useremail']==$useremail and $row['userpassword']==$password and $row['role'] == "Admin"){

    

    $_SESSION['status']="Login Success By Admin";
    $_SESSION['status_code']="Success";

    header('refresh: 1;ui/dashboard.php');
    
$_SESSION['userid']=$row['userid'];
$_SESSION['username']=$row['username'];
$_SESSION['useremail']=$row['useremail'];
$_SESSION['role'] = $row['role'];
    


    
  }else if($row['useremail']==$useremail and $row['userpassword']==$password and $row['role'] == "User"){

    $_SESSION['status']="Login Success By User";
    $_SESSION['status_code']="Success";

    header('refresh: 3;ui/user.php');

    $_SESSION['userid']=$row['userid'];
    $_SESSION['username']=$row['username'];
    $_SESSION['useremail']=$row['useremail'];
    $_SESSION['role'] = $row['role'];

  }
    
    
    


}else{

  //echo $success = "Wrong Email or Password";

  $_SESSION['status']="Wrong Email or Password ";
  $_SESSION['status_code']="Error";

}

}









?>






<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>POS Miller | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>POS </b>Miller</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
        <div class="input-group mb-3">

          <input type="email" class="form-control" placeholder="Email" name="txt_email" required>

  <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">


          <input type="password" class="form-control" placeholder="Password" name="txt_password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
            <a href="forgot-password.html">I forgot my password</a>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="btn_login">Log In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      
      <!-- /.social-auth-links -->

      <p class="mb-1">
        
      </p>
      <p class="mb-0">
        
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->


</body>
</html>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
<<<<<<< HEAD
  
=======
>>>>>>> a634244ec399d70a7b6c8e9b070fd66749c7d84e




  <?php

  if(isset($_SESSION['status']) && $_SESSION['status']!='')

  {
  
?>
<script>

$(function() {
  var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
<<<<<<< HEAD
    timer: 3000
=======
    timer: 5000
>>>>>>> a634244ec399d70a7b6c8e9b070fd66749c7d84e
  });

  Toast.fire({
    icon: '<?php echo ($_SESSION['status_code'] == 'Error') ? 'error' : 'success'; ?>',
    title: '<?php echo $_SESSION['status'];?>'
  });
});


</script>

<?php

unset($_SESSION['status']);
  }

  ?>

