<?php 

include_once "connectdb.php";
session_start();

include_once"header.php";

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           
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

            <div class="card card-secondary card-outline">
                <div class="card-header">
                  <h5 class="m-0">Employee List: </h5>
                </div>
                <div class="card-body">
                <table class="table table-striped" id="table_product">
                                <thead>
                                    <tr>
                                        <td>Surname</td>
                                        <td>Name</td>
                                        <td>Middle Name</td>
                                        <td>Gender</td>
                                        <td>Contact Number</td>
                                        <td>Address</td>
                                        <td>Image</td>
                                        <td>Action Icons</td>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $select = $pdo -> prepare('SELECT * from tbl_employee ORDER BY eid ASC');
                                    $select->execute();

                                    while($row = $select -> fetch(PDO::FETCH_OBJ)){
                                      
                                        echo'
                                        <tr>
                                        <td>'.$row->surname.'</td>
                                        <td>'.$row->name.'</td>
                                        <td>'.$row->middlename.'</td>
                                        <td>'.$row->gender.'</td>
                                        
                                        <td>'.$row->contactnumber.'</td>

                                        <td>'.$row->address.'</td>
                                        
                                        <td><image src="employeeimages/'.$row->image.'" class="img-rounded" width="40px" height="40px/"></td>
                                        
                                        <td>
                                        <div class="btn-group">
                                       

                                        <a href="viewemployee.php?id='.$row->eid.'" class="btn btn-warning btn-xs" role="button"><span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>

                                        <a href="editemployee.php?id='.$row->eid.'" class="btn btn-success btn-xs" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Product"></span></a>

                                        <button id='.$row->eid.' class="btn btn-danger btn-xs btndelete" ><span class="fa fa-trash style="color:#ffffff" data-toggle="tooltip" title="Delete Product""></span></button>


                                        </div>


                                        </td>



                                        </tr>
                                        ';
                                    }
                                    ?>
                                </tbody>
                            </table>
                </div>
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
include_once "footer.php";
?>



<script>

$(document).ready( function () {
    $('#table_product').DataTable();
} );


</script>
<script>

$(document).ready( function () {
   $('[data-toggle="tooltip"]').tooltip();
} ); 


</script>

<script>
    $(document).ready(function() {
    $('.btndelete').click(function() {

        var tdh = $(this);
        var id = $(this).attr("id");


        Swal.fire({
  title: "Do you want to delete this Employee?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Yes, delete it!"
}).then((result) => {
  if (result.isConfirmed) {

    $.ajax({

url: 'employeedelete.php',
type: 'post',
data: {
    pidd: id
},
success: function(data) {
    tdh.parents('tr').hide();
}

});




    Swal.fire({
      title: "Deleted!",
      text: "Employee has been deleted.",
      icon: "success"
    });
  }
});




        
    });
});










</script>