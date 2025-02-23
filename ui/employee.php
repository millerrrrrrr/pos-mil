<?php 

include_once "connectdb.php";
session_start();
include_once "header.php";

if(isset($_POST['btnsave'])) {
    $surname = $_POST['txtsurname'];
    $name = $_POST['txtname'];
    $middlename = $_POST['txtmiddlename'];
    $gender = $_POST['select_option'];
    $contactnumber = $_POST['txtcontactnumber'];
    $address = $_POST['txtaddress'];
    

    $f_name = $_FILES['myfile']['name'];
    $f_tmp = $_FILES['myfile']['tmp_name'];
    $f_size = $_FILES['myfile']['size'];
    $f_extension = explode('.',$f_name);
    $f_extension = strtolower(end($f_extension));
    $f_newfile = uniqid().'.'.$f_extension;
    $store = "employeeimages/".$f_newfile;

    if($f_extension=='jpg' || $f_extension=='jpeg' || $f_extension=='png' || $f_extension=='gif') {
        if($f_size >= 4000000) {
            $_SESSION['status'] = "Max file should be 1MB";
            $_SESSION['status_code'] = 'warning';
        } else {
            if(move_uploaded_file($f_tmp,$store)) {
                $productimage = $f_newfile;
                if(empty($surname)) {
                    $insert = $pdo->prepare("insert into tbl_employee (surname, name, middlename, gender, contactnumber, address, image) values (:surname, :name, :middlename, :gender, :contactnumber, :address, :image)");
                    $insert->bindParam(':surname', $surname);
                    $insert->bindParam(':name', $name);
                    $insert->bindParam(':middlename', $middlename);
                    $insert->bindParam(':gender', $gender);
                    $insert->bindParam(':contactnumber', $contactnumber);
                    $insert->bindParam(':address', $address);
                    $insert->bindParam(':image', $productimage);
                    $insert->execute();
                    $eid = $pdo->lastInsertId();
                    
                    if($update->execute()) {
                        $_SESSION['status'] = "Product Inserted Successfully";
                        $_SESSION['status_code'] = "success";
                    } else {
                        $_SESSION['status'] = "Product Inserted Failed";
                        $_SESSION['status_code'] = "error";
                    }
                } else {
                    $insert = $pdo->prepare("insert into tbl_employee (surname, name, middlename, gender, contactnumber, address, image) values (:surname, :name, :middlename, :gender, :contactnumber, :address, :image)");
                    $insert->bindParam(':surname', $surname);
                    $insert->bindParam(':name', $name);
                    $insert->bindParam(':middlename', $middlename);
                    $insert->bindParam(':gender', $gender);
                    $insert->bindParam(':contactnumber', $contactnumber);
                    $insert->bindParam(':address', $address);
                    $insert->bindParam(':image', $productimage);
                    if($insert->execute()) {
                        $_SESSION['status'] = "Product Inserted";
                        $_SESSION['status_code'] = "success";
                    } else {
                        $_SESSION['status'] = "Product Inserted Failed";
                        $_SESSION['status_code'] = "error";
                    }
                }
            }
        }
    } else {
        $_SESSION['status'] = "only jpg, jpeg, png, and gif can be upload";
        $_SESSION['status_code'] = 'warning';
    }
}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Employee</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Surname</label>
                                            <input type="text" class="form-control" placeholder="Enter Surname" name="txtsurname">
                                        </div>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Name" name="txtname" >
                                        </div>
                                        <div class="form-group">
                                            <label>Middle Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Middle Name" name="txtmiddlename" >
                                        </div>
                                        <div class="form-group">
                                            <label>Gender   </label>
                                            <select class="form-control" name="select_option" required>
                                            <option value="" disabled selected>Select Gender</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contact Number</label>
                                            <input type="number" min="1" step="any" class="form-control" placeholder="Enter Contact Number" name="txtcontactnumber" >
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" min="1" step="any" class="form-control" placeholder="Enter Address" name="txtaddress" >
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label>Employee Image</label>
                                            <input type="file" class="input-group" name="myfile" required>
                                            <p>Upload Image</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" name="btnsave">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include_once "footer.php";
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
