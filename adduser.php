<?php
session_start();
require("database-conf.php");

$name = mysqli_real_escape($conn,$_POST['name']);
$email = mysqli_real_escape($conn,$_POST['email']);
$phone = mysqli_real_escape($conn,$_POST['phone']);
$nric = mysqli_real_escape($conn,$_POST['age']);
$address = mysqli_real_escape($conn,$_POST['address']);
$gender = mysqli_real_escape($conn,$_POST['gender']);
$password= mysqli_real_escape($conn,$_POST['password']);


//InvalidArgumentException
if(strlen($name)<=2){
  echo "name";
}else if(filter_var($email,FILTER_VALIDATE_EMAIL)===false){
  echo "email";
}else{
//Encrypt password
$hashedPassword = password_hash($password,PASSWORD_BCRYPT,array('cost'=>12));

$query = "  SELECT * FROM users WHERE EMAIL='$email'";
$result = mysqli_query($conn,$query) or die(mysqli_error());
$num_row = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

  if($num_row<1){
    $result = $conn->query("INSERT INTO PATEINT (PATIENT_NAME,NRIC,ADDR) VALUES ('$name','$nric','$address')");
    $patient_id_sql = $conn->query("SELECT PATIENT_ID FROM PATIENT WHERE NRIC = '$nric'");
    $patient_id = $patient_id_sql->fetch_assoc();
    $result2 = $conn->query("INSERT INTO users (email,pw,PATIENT_ID,username) VALUES ('$email','$hashedPassword','$patient_id['PATIENT_ID']','$name')");

    if($result){
      $_SESSION['ID'] = "1";
      echo 'true';
    }else{
      echo 'false';
    }
  }
}
 ?>
