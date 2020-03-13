<?php
$servername = "localhost";
$username = "root";
$password = "cabku";
$db_name = "palm1";

 $conn=new mysqli($servername,$username,$password,$db_name);

 if($conn->connect_error){
     die("Connection failed: ".$con->connect_error);
 }
 $conn->set_charset("utf8");

?>
