<?php

include_once 'connectdb.php';
session_start();

include_once"header.php";



if (isset($_POST['btnsave'])) {
    $company = $_POST['txtcompany'];
    $suppliername = $_POST['txtsupplier'];
    $contactinfo = $_POST['txtcontact'];

    if (empty($company)) {
        $_SESSION['status'] = "Category Field is empty";
        $_SESSION['status_code'] = "warning";
    } else {
        // Check if the supplier already exists
        $checkSupplier = $pdo->prepare("SELECT * FROM tbl_supplier WHERE company = :company AND suppliername = :suppliername");
        $checkSupplier->bindParam(':company', $company);
        $checkSupplier->bindParam(':suppliername', $suppliername);
        $checkSupplier->execute();

        if ($checkSupplier->rowCount() > 0) {
            // Supplier already exists
            $_SESSION['status'] = "Supplier already exists";
            $_SESSION['status_code'] = "warning";
        } else {
            // Insert the new supplier
            $insert = $pdo->prepare("INSERT INTO tbl_supplier (company, suppliername, contactinfo) VALUES (:company, :sup, :contact)");
            $insert->bindParam(':company', $company);
            $insert->bindParam(':sup', $suppliername);
            $insert->bindParam(':contact', $contactinfo);

            if ($insert->execute()) {
                $_SESSION['status'] = "Category Added Successfully";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Category Added Failed";
                $_SESSION['status_code'] = "warning";
            }
        }
    }
}
  
  if(isset($_POST['btnupdate'])){

    $suppliername = $_POST['txtsupplier'];
    $id = $_POST['txtsupid'];
    
    if(empty($suppliername)){
    
      $_SESSION['status'] = "Category Field is empty";
      $_SESSION['status_code'] = "warning";
    
    
    }else{
    
    $update=$pdo->prepare("update tbl_supplier set suppliername =:sup where supid=" .$id);
    $update->bindParam(':sup',$suppliername);
   
    if($update->execute()){
      $_SESSION['status'] = "Category Update Successfully";
      $_SESSION['status_code'] = "success";
    
    }else{
      $_SESSION['status'] = "Category Update Failed";
      $_SESSION['status_code'] = "warning";
    
    
    }
   
   
    $company = $_POST['txtcompany'];
    $id = $_POST['txtsupid'];


    if(empty($company)){
    
      $_SESSION['status'] = "Category Field is empty";
      $_SESSION['status_code'] = "warning";

    }else{
    
    $update=$pdo->prepare("update tbl_supplier set company =:com where supid=" .$id);
    $update->bindParam(':com',$company);

    }

    if($update->execute()){
      $_SESSION['status'] = "Category Update Successfully";
      $_SESSION['status_code'] = "success";
    
    }else{
      $_SESSION['status'] = "Category Update Failed";
      $_SESSION['status_code'] = "warning";
    
    
    }




    $contactinfo = $_POST['txtcontact'];
    $id = $_POST['txtsupid'];

    if(empty($contactinfo)){
    
      $_SESSION['status'] = "Category Field is empty";
      $_SESSION['status_code'] = "warning";

    }else{
    
    $update=$pdo->prepare("update tbl_supplier set contactinfo =:contact where supid=" .$id);
    $update->bindParam(':contact',$contactinfo);

    }
    
    if($update->execute()){
      $_SESSION['status'] = "Category Update Successfully";
      $_SESSION['status_code'] = "success";
    
    }else{
      $_SESSION['status'] = "Category Update Failed";
      $_SESSION['status_code'] = "warning";
    
    
    }
    }}

    if(isset($_POST['btndelete'])){

     $delete = $pdo->prepare("delete from tbl_supplier where supid =".$_POST['btndelete']); 

     if($delete->execute()){
      $_SESSION['status'] = "Deleted Successfully";
      $_SESSION['status_code'] = "success";
    

     }else{
      $_SESSION['status'] = "Deletion Failed";
      $_SESSION['status_code'] = "warning";
    




     }
    }else{



      
    }

?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Supplier Info</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="card card-info card-outline">
              <div class="card-header">
                <h5 class="m-0">Category Form</h5>
              </div>
              <form action="" method="post">
              <div class="card-body">



<div class="row">

<?php
if(isset($_POST['btnedit'])){

$select=$pdo->prepare("select * from tbl_supplier where supid =".$_POST['btnedit']);

$select->execute();

if($select){
$row = $select->fetch(PDO::FETCH_OBJ);

echo' <div class="col-md-4">


                
<div class="form-group">
  <label for="exampleInputName1">Category</label>

  <input type="hidden" class="form-control"  placeholder="Enter Category" value="'.$row->supid.'"name="txtsupid">

  <input type="text" class="form-control"  placeholder="Enter Company" value="'.$row->company.'"name="txtcompany">


  <input type="text" class="form-control"  placeholder="Enter Supplier Name" value="'.$row->suppliername.'" name="txtsupplier">

  <input type="text" class="form-control"  placeholder="Enter Contact Info" value="'.$row->contactinfo.'" name="txtcontact">
</div>







<div class="card-footer">
<button type="submit" class="btn btn-info" name="btnupdate">Update</button>
</div>









</div>';

}

}else{
echo' <div class="col-md-4">


                
<div class="form-group">
  <label for="exampleInputName1">Company</label>
  <input type="text" class="form-control"  placeholder="Enter Company" name="txtcompany">
</div>
<div class="form-group">
  <label for="exampleInputName1">Supplier</label>
  <input type="text" class="form-control"  placeholder="Enter Supplier Name" name="txtsupplier">
</div>
<div class="form-group">
  <label for="exampleInputName1">Contact</label>
  <input type="text" class="form-control"  placeholder="Enter Contact info" name="txtcontact">
</div>







<div class="card-footer">
<button type="submit" class="btn btn-warning" name="btnsave">Save</button>
</div>









</div>';






}





?>




<div class="col-md-8">

<table id="table_supplier" class="table table-striped table-hover">
<thead>
<tr>
  <td>#</td>
  <td>Company</td>
  <td>Supplier Name</td>
  <td>Contact info</td>
  <td>Edit</td>
  <td>Delete</td>
  
</tr>

</thead>

<tbody>

<?php

$select = $pdo->prepare("select * from tbl_supplier order by supid ASC"); 
$select->execute();

while($row=$select->fetch(PDO::FETCH_OBJ))
{

echo'
<tr>
<td>'.$row->supid.'</td>
<td>'.$row->company.'</td>
<td>'.$row->suppliername.'</td>
<td>'.$row->contactinfo.'</td>


<td>
<button type="submit" class="btn btn-primary" value="'.$row->supid.'" name="btnedit">Edit</button>

</td>

<td>
<button type="submit" class="btn btn-danger" value="'.$row->supid.'" name="btndelete">Delete</button>
</td>
</tr>';


}

?>

</tbody>

<tfoot>
<tr>
<td>#</td>
  <td>Company</td>
  <td>Supplier Name</td>
  <td>Contact info</td>
  <td>Edit</td>
  <td>Delete</td>
  
</tr>



</tfoot>

</table>





</div>


                

                
                
              </div>
            
              
            
          </div>
          </form>  
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <?php

include_once"footer.php";


?>

<?php

include_once"footer.php";

?>

<?php

if(isset($_SESSION['status']) && $_SESSION['status']!='')

{

?>
<script>

      Swal.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<?php echo $_SESSION['status'];?>'
      });
    
</script>

<?php

unset ($_SESSION['status']);
}

?>

<script>

$(document).ready( function () {
    $('#table_supplier').DataTable();
} );


</script>