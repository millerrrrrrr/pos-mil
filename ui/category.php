<?php

include_once "connectdb.php";
session_start();

include_once "header.php";


if(isset($_POST['btnsave'])){

    $category = $_POST['category'];

    if(empty($category)){

        
        $_SESSION['status'] = "Category Field is Empty.";
        $_SESSION['status_code'] = 'warning';

    }else{
        $insert = $pdo->prepare("insert into tbl_category (category) values(:cat)");

        $insert->bindParam(":cat",$category);

        if($insert->execute()){

        $_SESSION['status'] = "Category Added Successfully";
        $_SESSION['status_code'] = 'success';

        }else{

        $_SESSION['status'] = "Category Added Failed";
        $_SESSION['status_code'] = 'warning';

        }




    }



} 

if(isset($_POST['btnupdate'])){

    $category = $_POST['category'];
    $catid = $_POST['catid'];

    if(empty($category)){

        
        $_SESSION['status'] = "Category Field is Empty.";
        $_SESSION['status_code'] = 'warning';

    }else{
        $update = $pdo->prepare("update tbl_category set category=:cat where catid=".$catid);

        $update->bindParam(":cat",$category);

        if($update->execute()){

        $_SESSION['status'] = "Category Update Successfully";
        $_SESSION['status_code'] = 'success';

        }else{

        $_SESSION['status'] = "Category Update Failed";
        $_SESSION['status_code'] = 'warning';

        }




    }



} 

if(isset($_POST['btndelete'])){
    $delete = $pdo->prepare("delete from tbl_category where catid=".$_POST['btndelete']);

    if($delete->execute()){

        $_SESSION['status'] = "Deleted Successfully";
        $_SESSION['status_code'] = 'success';

    }else{

        $_SESSION['status'] = "Delete Failed";
        $_SESSION['status_code'] = 'error';

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
            <h1 class="m-0">Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="card card-warning card-outline">
                
                <div class="card-header">
                    <h5 class="m-0">Category Form</h5>
                </div>
                <div class="card-body">
                <form action="" method="POST">

                
                 <div class="row">
                
                <?php
                
                if(isset($_POST['btnedit'])){

                    $select= $pdo->prepare("select * from tbl_category where catid=".$_POST['btnedit']);
                    $select->execute();

                    if($select){
                        $row=$select->fetch(PDO::FETCH_OBJ);

                        echo '<div class="col-md-4">

                            
                                

                    <div class="form-group">
                        <label>Category</label>

                        <input type="hidden" class="form-control" placeholder="Enter Category" value="'.$row->catid.'" name="catid">

                        <input type="text" class="form-control" placeholder="Enter Category" value="'.$row->category.'" name="category">
                    </div>

                    
                
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-info" name="btnupdate">Update</button>
                </div>
            

        </div>';
                    }



                }else{

                    echo '<div class="col-md-4">

                            
                                

                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" class="form-control" placeholder="Enter Category" name="category">
                    </div>

                    
                
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning" name="btnsave">Save</button>
                </div>
            

        </div>';
                    
                }
                
                
                ?>

                        
                        <div class="col-md-8">
                            <table id="table_category" class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Category</td>
                                        <td>Edit</td>
                                        <td>Delete</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $select = $pdo -> prepare('SELECT * from tbl_category ORDER BY catid ASC');
                                    $select->execute();

                                    while($row = $select -> fetch(PDO::FETCH_OBJ)){
                                        echo'
                                        <tr>
                                        <td>'.$row->catid.'</td>
                                        <td>'.$row->category.'</td>
                                        <td>
                                        <button type="submit" class="btn btn-primary" value="'.$row->catid.'" name="btnedit">Edit</button>
                                        </td>
                                        <td>
                                        <button type="submit" class="btn btn-info" value="'.$row->catid.'" name="btndelete">Delete</button>
                                        </td>
                                        </tr>
                                        ';
                                    }
                                    ?>
                                </tbody>
                                <tr>
                                        <td>#</td>
                                        <td>Category</td>
                                        <td>Edit</td>
                                        <td>Delete</td>
                                    </tr>
                            </table>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

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

<script>
    $(document).ready( function () {
        $('#table_category').DataTable();
    });
</script>