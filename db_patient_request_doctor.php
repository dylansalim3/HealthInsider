<?php
require('database-conf.php');
if(isset($_GET['specialization'])){
  $specialization = $_GET['specialization'];
  $sql1 = "SELECT DOCTOR_NAME FROM doctor WHERE SPECIALIZATION = '$specialization'";
  $result1 = mysqli_query($conn,$sql1);
  echo "<option>Select Doctor</option>";
  if(isset($result1) && mysqli_num_rows($result1)>0){
    while($row1 = mysqli_fetch_assoc($result1)){
      echo '<option>'.$row1['DOCTOR_NAME'].'</option>';
    }
  }
}
if(isset($_GET['doctor'])&&!isset($_GET['date'])){
  $doctor = $_GET['doctor'];
  $sql2 = "SELECT DISTINCT DOCTOR_DAY FROM doctor_slot WHERE DOCTOR_ID = ANY(SELECT DOCTOR_ID FROM doctor WHERE DOCTOR_NAME = '$doctor') AND STATUS = 1 AND DOCTOR_DAY>CURDATE();";
  $result2 = mysqli_query($conn,$sql2);
  echo "<option>Select Date</option>";
  if(isset($result2) && mysqli_num_rows($result2)>0){
    while($row2 = mysqli_fetch_assoc($result2)){
      echo '<option>'.$row2['DOCTOR_DAY'].'</option>';
    }
  }
}
if(isset($_GET['date'])){
  $date = $_GET['date'];
  $doctor = $_GET['doctor'];
  $sql3 = "SELECT DOCTOR_TIME FROM doctor_slot WHERE DOCTOR_ID = ANY(SELECT DOCTOR_ID FROM doctor WHERE DOCTOR_NAME = '$doctor') AND DOCTOR_DAY = '$date' AND STATUS = 1 ;";
  $result3 = mysqli_query($conn,$sql3);
  echo "<option>Select Time</option>";
  if(isset($result3) && mysqli_num_rows($result3)>0){
    while($row3 = mysqli_fetch_assoc($result3)){
      echo '<option>'.$row3['DOCTOR_TIME'].'</option>';
    }
  }
}
?>