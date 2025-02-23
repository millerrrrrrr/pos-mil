<?php 

include_once "connectdb.php";
session_start();

include_once "header.php";

$id= $_GET['id'];

$select = $pdo->prepare("select * from tbl_employee where eid=$id");
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);

$id_db=$row['eid'];
$surname_db=$row['surname'];
$name_db=$row['name'];
$middlename_db=$row['middlename'];
$gender_db=$row['gender'];
$contactnumber_db=$row['contactnumber'];
$address_db=$row['address'];
$image_db=$row['image'];

if(isset($_POST['btneditproduct'])){

    $surname_txt=$_POST['txtsurname'];
    $name_txt=$_POST['txtname'];
    $middlename_txt=$_POST['txtmiddlename'];
    $gender_txt = isset($_POST['select_option']) ? $_POST['select_option'] : '';
    $contactnumber_txt=$_POST['txtcontactnumber'];
    $address_txt=$_POST['txtaddress'];

    $f_name = $_FILES['myfile']['name'];

    if(!empty($f_name)){
        $f_tmp = $_FILES['myfile']['tmp_name'];
        $f_size = $_FILES['myfile']['size'];
        $f_extension = strtolower(pathinfo($f_name, PATHINFO_EXTENSION));

        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

        if(!in_array($f_extension, $allowed_extensions)){
            $_SESSION['status'] = "File should be an image (JPG, JPEG, PNG, GIF)";
            $_SESSION['status_code'] = 'warning';
        } elseif($f_size >= 4000000){
            $_SESSION['status'] = "Max file size should be 4MB";
            $_SESSION['status_code'] = 'warning';
        } else {
            $f_newfile = uniqid().'.'.$f_extension;
            $store = "employeeimages/".$f_newfile;

            if(move_uploaded_file($f_tmp,$store)){
                $update = $pdo->prepare("update tbl_employee set surname=:surname, name=:name, middlename=:middlename, gender=:gender, contactnumber=:contactnumber, address=:address, image=:image where eid=$id");
                $update->bindParam(':surname',$surname_txt);
                $update->bindParam(':name',$name_txt);
                $update->bindParam(':middlename',$middlename_txt);
                $update->bindParam(':gender',$gender_txt);
                $update->bindParam(':contactnumber',$contactnumber_txt);
                $update->bindParam(':address',$address_txt);
                $update->bindParam(':image',$f_newfile);
            
                if($update->execute()){
                    $_SESSION['status']="Product Updated Successfully With New Image";
                    $_SESSION['status_code']="success";
                } else {
                    $_SESSION['status']="Product Update Failed";
                    $_SESSION['status_code']="error";
                }
            }
        }
    } else {
        // If no file uploaded, update other fields without changing the image
        $update = $pdo->prepare("update tbl_employee set surname=:surname, name=:name, middlename=:middlename, gender=:gender, contactnumber=:contactnumber, address=:address where eid=$id");
        $update->bindParam(':surname',$surname_txt);
        $update->bindParam(':name',$name_txt);
        $update->bindParam(':middlename',$middlename_txt);
        $update->bindParam(':gender',$gender_txt);
        $update->bindParam(':contactnumber',$contactnumber_txt);
        $update->bindParam(':address',$address_txt);
        
        if ($update->execute()) {
            $_SESSION['status'] = "Product Updated Successfully";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Product Update Failed";
            $_SESSION['status_code'] = "error";
        }
    }
}

?>




  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1 class="m-0">Blank Dashboard</h1> -->
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li> -->
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">

            <div class="card card-success card-outline">
                <div class="card-header">
                  <h5 class="m-0">Edit Employee</h5>
                </div>

                <form action="" method="POST" name="formeditproduct" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                          
                        <div class="form-group">
                          <label>Surname</label>
                          <input type="text" class="form-control" value="<?php echo $surname_db; ?>" placeholder="Enter Surname" name="txtsurname">
                        </div>

                        <div class="form-group">
                          <label>Name</label>
                          <input type="text" class="form-control" value="<?php echo $name_db; ?>" placeholder="Enter Name" name="txtname" >
                        </div>

                        <div class="form-group">
                          <label>Middle Name</label>
                          <input type="text" class="form-control" value="<?php echo $middlename_db; ?>" placeholder="Enter Middle Name" name="txtmiddlename" >
                        </div>

                        <div class="form-group">
                          <label>Gender</label>
                          
                              
                          <select class="form-control" name="select_option" required>
    <option value="" disabled>Select Gender</option>
    <option value="Male" <?php if ($gender_db === "Male") echo "selected"; ?>>Male</option>
    <option value="Female" <?php if ($gender_db === "Female") echo "selected"; ?>>Female</option>
</select>
                        </div>

                        

                          
                      </div>
                      <div class="col-md-6">
                          
                      <div class="form-group">
                          <label>Contact Number</label>
                          <input type="number" min="1" step="any" value="<?php echo $contactnumber_db; ?>" class="form-control" placeholder="Enter Contact Number" name="txtcontactnumber" >
                        </div>
                        
                    
                      <div class="form-group">
                          <label>Address</label>
                          <input type="text" min="1" step="any" value="<?php echo $address_db; ?>" class="form-control" placeholder="Enter Stock" name="txtaddress" >
                        </div>

                        <div class="form-group">
    <label>Employee Image</label> <br>
    <img src="employeeimages/<?php echo $image_db;?>" class="img-rounded" width="50px" height="50px"/>
    <input type="file" class="input-group" name="myfile">
    <p>Upload Image</p>
</div>



                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-center">
                      <button type="submit" class="btn btn-success" name="btneditproduct">Update</button>
                    </div>
                  </div>

                </form>






                
              </div>
              
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->






<?php 
include_once"footer.php";
?>

<?php
if (isset($_SESSION['status']) && $_SESSION['status'] !== '') {
  $icon = $_SESSION['status_code'];
  $message = $_SESSION['status'];

  // Output JavaScript directly with values from PHP variables
  echo <<<HTML
    <script>
            Swal.fire({
                icon: '{$icon}',
                title: '{$message}'
            });
    </script>
HTML;

  unset($_SESSION['status']);
}
?>