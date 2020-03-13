<?php
 $server="localhost";
 $user="root";
 $pass="cabku";
 $db_name="palm7";

 $conn=new mysqli($server,$user,$pass,$db_name);

 if($conn->connect_error){
     die("Connection failed: ".$con->connect_error);
 }
 $conn->set_charset("utf8");

?>