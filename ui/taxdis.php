<?php

include_once "connectdb.php";
session_start();

include_once "header.php";


if(isset($_POST['btnsave'])){

    $sgst = $_POST['txtsgst'];

    $cgst = $_POST['txtcgst'];

    $discount = $_POST['txtdiscount'];

    if(empty($sgst)){

        
        $_SESSION['status'] = "Field is Empty.";
        $_SESSION['status_code'] = 'warning';

    }else{
        $insert = $pdo->prepare("insert into tbl_taxdis (sgst,cgst,discount) values(:sgst,:cgst,:discount)");

        $insert->bindParam(":sgst",$sgst);
        $insert->bindParam(":cgst",$cgst);
        $insert->bindParam(":discount",$discount);

        if($insert->execute()){

        $_SESSION['status'] = "Tax And Discount Added Successfully";
        $_SESSION['status_code'] = 'success';

        }else{

        $_SESSION['status'] = "Failed";
        $_SESSION['status_code'] = 'warning';

        }




    }



} 

if(isset($_POST['btnupdate'])){

  


    $sgst = $_POST['txtsgst'];

    $cgst = $_POST['txtcgst'];

    $discount = $_POST['txtdiscount'];




    $id = $_POST['txtid'];

    if(empty($sgst)){

        
        $_SESSION['status'] = "Field is Empty.";
        $_SESSION['status_code'] = 'warning';

    }else{
        $update = $pdo->prepare("update tbl_taxdis set sgst=:sgst,cgst=:cgst,discount=:dis where taxdis_id=".$id);

      


        $update->bindParam(":sgst",$sgst);
        $update->bindParam(":cgst",$cgst);
        $update->bindParam(":dis",$discount);




        if($update->execute()){

        $_SESSION['status'] = "Tax and Discount Update Successfully";
        $_SESSION['status_code'] = 'success';

        }else{

        $_SESSION['status'] = "Failed";
        $_SESSION['status_code'] = 'warning';

        }




    }



} 

// if(isset($_POST['btndelete'])){
//     $delete = $pdo->prepare("delete from tbl_category where catid=".$_POST['btndelete']);

//     if($delete->execute()){

//         $_SESSION['status'] = "Deleted Successfully";
//         $_SESSION['status_code'] = 'success';

//     }else{

//         $_SESSION['status'] = "Delete Failed";
//         $_SESSION['status_code'] = 'error';

//     }


// }


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tax and Discount</h1>
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
                    <h5 class="m-0">Tax and Discount Form</h5>
                </div>
                <div class="card-body">
                <form action="" method="POST">

                
                 <div class="row">
                
                <?php
                
                if(isset($_POST['btnedit'])){

                    $select= $pdo->prepare("select * from tbl_taxdis where taxdis_id=".$_POST['btnedit']);
                    $select->execute();

                    if($select){
                        $row=$select->fetch(PDO::FETCH_OBJ);

                        echo '<div class="col-md-4">

                            
                                

                    <div class="form-group">
                     

                        <input type="hidden" class="form-control" placeholder="Enter Category" value="'.$row->taxdis_id.'" name="txtid">

                        





                        <div class="form-group">
                        <label>SGST(%)</label>
                        <input type="text" class="form-control" placeholder="Enter SGST" value="'.$row->sgst.'" name="txtsgst">
                    </div>

                    <div class="form-group">
                        <label>CGST(%)</label>
                        <input type="text" class="form-control" placeholder="Enter CGST" value="'.$row->cgst.'" name="txtcgst">
                    </div>

                    <div class="form-group">
                        <label>Discount(%)</label>
                        <input type="text" class="form-control" placeholder="Enter Discount" value="'.$row->discount.'" name="txtdiscount">
                    </div>




                    







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
                        <label>SGST(%)</label>
                        <input type="text" class="form-control" placeholder="Enter SGST" name="txtsgst">
                    </div>

                    <div class="form-group">
                        <label>CGST(%)</label>
                        <input type="text" class="form-control" placeholder="Enter CGST" name="txtcgst">
                    </div>

                    <div class="form-group">
                        <label>Discount(%)</label>
                        <input type="text" class="form-control" placeholder="Enter Discount" name="txtdiscount">
                    </div>

                    

                    
                
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning" name="btnsave">Save</button>
                </div>
            

        </div>';
                    
                }
                
                
                ?>

                        
                        <div class="col-md-8">
                            <table id="table_tax" class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>SGST</td>
                                        <td>CGST</td>
                                        <td>Discount</td>
                                        <td>Edit</td>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $select = $pdo -> prepare('SELECT * from tbl_taxdis ORDER BY taxdis_id ASC');
                                    $select->execute();

                                    while($row = $select -> fetch(PDO::FETCH_OBJ)){
                                        echo'
                                        <tr>
                                        <td>'.$row->taxdis_id.'</td>
                                        <td>'.$row->sgst.'</td>
                                        <td>'.$row->cgst.'</td>
                                        <td>'.$row->discount.'</td>
                                        <td>
                                        <button type="submit" class="btn btn-primary" value="'.$row->taxdis_id.'" name="btnedit">Edit</button>
                                        </td>
                                       
                                        </tr>
                                        ';
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <td>#</td>
                                        <td>SGST</td>
                                        <td>CGST</td>
                                        <td>Discount</td>
                                        <td>Edit</td>
                                        
                                    </tr>
                                </tfoot>
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
        $('#table_tax').DataTable();
    });
</script>