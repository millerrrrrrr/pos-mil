<?php 

include_once "connectdb.php";
session_start();


include_once "header.php";

include "barcode/barcode128.php";




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

            <div class="card card-info card-outline">
                <div class="card-header">
                  <h5 class="m-0">View Product</h5>
                </div>
                <div class="card-body">

                <?php
                
                $id =$_GET['id'];

                $select = $pdo->prepare("select * from tbl_employee where eid = $id");
                $select->execute();

                while($row=$select->fetch(PDO::FETCH_OBJ)){


                    echo '
                    
                     
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group">

                                <center><p class="list-group-item list-group-item-info"><b>PRODUCT DETAILS</b></p></center>

                                <li class="list-group-item"><b>Surname </b><span class="badge badge-light float-right">'.($row->surname).'</span></li>
                                <li class="list-group-item"><b>Name </b><span class="badge badge-warning float-right">'.$row->name.'</span></li>
                                <li class="list-group-item"><b>Middle Name </b><span class="badge badge-success float-right">'.$row->middlename.'</span></li>
                                <li class="list-group-item"><b>Gender </b><span class="badge badge-primary float-right">'.$row->gender.'</span></li>
                                <li class="list-group-item"><b>Contact Number </b><span class="badge badge-danger float-right">'.$row->contactnumber.'</span></li>
                                <li class="list-group-item"><b>Address </b><span class="badge badge-secondary float-right">'.$row->address.'</span></li>
                               

                            </ul>
                        </div>

                        <div class="col-md-6">
                            <ul class="list-group">

                            <center><p class="list-group-item list-group-item-info"><b>EMPLOYEE IMAGE</b></p></center>


                            <img src="employeeimages/'.$row->image.'" class="img-responsive"/>

                               
                            </ul>
                        </div>
                    </div>
                    
                    
                    ';








                }
                
                
                
                ?>





                    


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

=




<?php 
include_once"footer.php";
?>