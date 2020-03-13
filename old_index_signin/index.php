<?php

    //header("location:.././view/index/index.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Custom fonts for this template-->
    <link href="./lib/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./css/sb-admin-2.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <link href="./css/customize.css" rel="stylesheet">

    <link href="./lib/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Range Slider Css -->
    <link href="./lib/ion-rangeslider/css/ion.rangeSlider.css" rel="stylesheet" />
    <link href="./lib/ion-rangeslider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet" />

    <link href='./lib/calendar/css/fullcalendar.css' rel='stylesheet' />
    <link href='./lib/calendar/css/fullcalendar.print.css' rel='stylesheet' media='print' />

</head>
<style>
    body{
        background-color: #E91E63 !important ;
    }
    .card-signin{
        background-color: white;
    }
    #login-header{
        color:white;
    }
    .card-signin{
        align:center;
    }
    .login-small{
        float:center;
    }

</style>

<body >
   
        <div style="float:center;">         

            <form id="sign_in" method="POST" action="sign-in-verify.php">
                <br>
                <br>
                <br>
                <br>
                
                <div class="container">
                    <div class="row">
                        
                        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                            <div id="login-header">
                               <h5 class="text-center">ระบบบริหารจัดการแปลงปลูกปาล์มน้ำมัน </h5>
                                <h6 class="text-center login-small">© KU ศูนย์เทคโนโลยีชีวภาพเกษตร</h6>  
                            </div>
                           
                            <div class="card card-signin my-1">
                            
                                <div class="card-body">
                                    <form class="form-signin" method="POST" action='sign-in-verify.php'>
                                        <center><h6>ล็อกอินเข้าสู่ระบบ</h6></center>
                                        <br>
                                        <div class="form-label-group">
                                            <label for="inputEmail">ชื่อผู้ใช้</label>
                                            <input type="text" name="username" id="username" class="form-control" placeholder="username" required autofocus>

                                            <!-- <div class="row">
                                                <div class="col-sm-1 col-md-1 col-lg-1 mx-auto" >
                                                    <span><i class="fas fa-user fa-lg"></i></span>
                                                </div>
                                                <div class="col-sm-10 col-md-10 col-lg-10 mx-auto">
                                                    <input type="email" id="inputEmail" class="form-control" placeholder="username" required autofocus>

                                                </div>

                                            </div> -->
                                            
                                        </div>
                                        <br>
                                        <div class="form-label-group"> 
                                            <label for="inputPassword">รหัสผ่าน</label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                        
                                        </div>
                                        <br>
                                            <div class="custom-control custom-checkbox mb-1">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">บันทึกบัญชีผู้ใช้</label> 
                                            <button class="btn btn-success btn-md" style="float:right;" type="submit">ล็อกอิน</button>
                                        
                                       
                                        </div>
                                       
                                
                                
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    
    
</body>
</html>