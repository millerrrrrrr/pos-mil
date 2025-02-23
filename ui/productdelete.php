<?php

include_once 'connectdb.php';



$id=$_POST['pidd'];
$sql="delete from tbl_product where pid =$id";

$delete=$pdo->prepare($sql);

if($delete->execute()){



} else {


    echo "Error on deleteing Product";
}







?>