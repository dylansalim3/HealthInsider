<?php
include('check-session.php');
$page = $_SESSION['page'];
 ?>

<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css\db_index.css">
  <!-- Font awesome CDN -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link href='fullcalendar/core/main.css' rel='stylesheet'/>
    <link href='fullcalendar/daygrid/main.css' rel='stylesheet'/>
    <link href='fullcalendar/timegrid/main.css' rel='stylesheet'/>
    <title>HealthInsider Healthcare Data Mangement System</title>
</head>
<body>
  <!-- navbar -->
  <nav class="navbar navbar-expand-md navbar-light">
    <button class="navbar-toggler ml-auto mb-2 bg-light" type="button" data-toggle="collapse" data-target="#myNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="myNavbar">
      <div class="container-fluid">
        <div class="row">
          <!-- sidebar -->
          <div class="col-xl-2 col-lg-3 col-md-4 sidebar fixed-top">

            <a href="#" class="navbar-brand text-white d-block mx-auto text-center py-3 mb-4 bottom-border">HealthInsider</a>
            <div class="bottom-border pb-3">
              <img src="<?php
              $allowed = array('jpg','jpeg','png');
              $exist = 0;
              foreach($allowed as $key){
                if(file_exists("uploads/".$user_check.".".$key)){
                  echo "uploads/".$user_check.".".$key;
                  $exist = 1;
                }
              }
              if($exist == 0){
                echo "images/man.png";
              }
              ?>
              " width="50px" height="50px" class="mr-3">
              <a href="#" class="text-white"><?php echo $login_session ?></a>
            </div>
            <ul class="navbar-nav flex-column mt-3">
              <li class="nav-item"><a href="db_patient_index.php" class="nav-link text-white p-3 mb-3 <?php if($page=="dashboard"){
                echo "current";
              }else{
                echo "sidebar-link";
              } ?>">
                <i class="fas fa-home fa-lg mr-3"></i>Dashboard</a>
              </li>
              <li class="nav-item"><a href="db_patient_profile.php" class="nav-link text-white p-3 mb-3 <?php if($page=="profile"){
                echo "current";
              }else{
                echo "sidebar-link";
              } ?>">
                <i class="fas fa-user fa-lg mr-3"></i>Profile</a>
              </li>
              <li class="nav-item"><a href="db_patient_request.php" class="nav-link text-white p-3 mb-3 <?php if($page=="request"){
                echo "current";
              }else{
                echo "sidebar-link";
              } ?>">
                <i class="fas fa-envelope-open-text fa-lg mr-3"></i>Request</a>
              </li>
              <li class="nav-item"><a href="db_patient_medical.php" class="nav-link text-white p-3 mb-3 <?php if($page=="medical"){
                echo "current";
              }else{
                echo "sidebar-link";
              } ?>">
                <i class="fas fa-file-medical fa-lg mr-3"></i>Medical</a>
              </li>
              <li class="nav-item"><a href="db_patient_appointment.php" class="nav-link text-white p-3 mb-3 <?php if($page=="appointment"){
                echo "current";
              }else{
                echo "sidebar-link";
              } ?>">
                <i class="fas fa-calendar-alt fa-lg mr-3"></i>Appointment</a>
              </li>
            </ul>
          </div>
          <!-- end of sidebar -->

          <!-- top-nav -->
          <div class="col-xl-10 col-md-8 col-lg-9 ml-auto bg-dark fixed-top py-2 top-navbar">
            <div class="row align-items-center">
              <div class="col-6 col-md-5">

                <a class="back-landing light-color"href="index.php">Back to landing</a>
              </div>
              <div class="col-6 col-md-7 d-flex flex-row-reverse">
                <?php echo "<h6 style='color:white'>Welcome ".$login_session."</h6>"; ?>
                <a class="nav-link"href="#" data-toggle="modal" data-target="#signout"><i class="fas fa-sign-out-alt fa-lg text-danger"></i></a>
              </div>
            </div>
          </div>
          <!-- end of top-nav -->
        </div>
      </div>
    </div>
  </nav>
  <!-- end of navbar -->

  <!-- modal to sign out-->
  <div class="modal fade" id="signout">
    <div class="modal-dialog " id="small-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Sign out?</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <p>Are you sure to sign out?</p>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Stay here</button>
         <button type="button" class="btn btn-primary active-2"><a class="text-white" href="logout.php" style="text-decoration:none;">Sign out</a></button>
       </div>
     </div>
   </div>
 </div>
 <!-- end of sign out modal -->
