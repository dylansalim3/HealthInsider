<?php
session_start();  
$_SESSION['page'] = "profile";
require("db_patient_header.php");


$sql = "SELECT * FROM PATIENT p JOIN users u WHERE p.PATIENT_ID = u.PATIENT_ID AND u.USER_ID ='$user_check'";
$result = mysqli_query($conn,$sql);


if(mysqli_num_rows($result)){
  $row = mysqli_fetch_assoc($result);

if($_SERVER['REQUEST_METHOD']=='POST')  { 
	$fullname = $_POST['fullname'];
	$date = $_POST['dob'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$gender = $_POST['gender'];
	$passwordOld = $_POST['password-old'];
	$passwordNew1 = $_POST['password-new1'];
	$passwordNew2 = $_POST['password-new2'];
	$error = array(); $successArray = array();
	$success = false;
  $uppercase = preg_match('@[A-Z]@', $passwordNew1);
  $lowercase = preg_match('@[a-z]@', $passwordNew1);
  $number    = preg_match('@[0-9]@', $passwordNew1);
	if(!empty($passwordOld)){
		$hashedPassword = password_hash($passwordOld,PASSWORD_BCRYPT,array('cost'=>12));
		if($passwordNew1!=$passwordNew2){
			array_push($error,'Both Password Not Match! Please Try Again!');
		}else if(password_verify($hashedPassword,$row['PW'])){
			array_push($error,'Old Password Not Match! Please Try Again!');
		}else if(empty($passwordNew1||$passwordNew2)){
			array_push($error,"Empty New Password field! Please insert values!");
		}else if(empty($fullname)||empty($date)&&empty($address)&&empty($phone)){
			array_push($error,'Empty Field! Please Try Again!');
		}else if(!$uppercase || !$lowercase || !$number || strlen($password) < 8){
			array_push($error,'Weak Password! Please Try Again!');  
    }
    
    if(!empty($passwordNew1)&&empty($error)){
      $password = password_hash($passwordNew1,PASSWORD_BCRYPT,array('cost'=>12));
      $updateSql = "UPDATE users SET PW = '$password' WHERE USER_ID = '$user_check';";
		if(mysqli_multi_query($conn,$updateSql)){
			array_push($successArray,"User Password Changed Successfully!");
		}else{
			array_push($error,"User Password Update Error! Please Try Again!");
		}
		}
		
  }
  if($fullname!=$row['PATIENT_NAME']||$date!=$row['DOB']||$address!=$row['ADDR']||$phone!=$row['PHONE']||$gender!=$row['GENDER']){
    
  //update user detail
 if(!preg_match('/^(\+?6?01)[0|1|2|3|4|6|7|8|9]\-*[0-9]{7,8}$/',$phone) || strlen($phone)<9||strlen($phone)>12){
    array_push($error,'Incorrect phone number! Please Try Again!');
  }

  if(empty($error)){
    $updateSql1 = "UPDATE patient SET PATIENT_NAME = '$fullname', DOB = '$date',  ADDR = '$address', PHONE = '$phone', GENDER = '$gender' WHERE PATIENT_ID = ANY(SELECT PATIENT_ID FROM users WHERE USER_ID = '$user_check'); ";

    if(mysqli_multi_query($conn,$updateSql1)){
      array_push($successArray,"User Detail Updated Successfully!");
      header("Refresh:0");
    }else{
      array_push($error,"Update Error! Please Try Again!");
    }
  }
    

  }



    //Files upload
    if(!empty($_FILES['file']['tmp_name'])){
      $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTempName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];  
    $fileExt = strtolower(explode(".",$fileName)[count(explode(".",$fileName))-1]);

    $allowed = array('jpg','jpeg','png');

    if(in_array($fileExt, $allowed)&&!$fileError){
      if($fileSize<20000000){
        foreach ($allowed as $key) {
          if(file_exists("uploads/".$user_check.".".$key)){
            unlink("uploads/".$user_check.".".$key);
          }
        }
        $fileDestination = "uploads/".$user_check.".".$fileExt;
        move_uploaded_file($fileTempName,$fileDestination);
        $success = true;
      }else{
        array_push($error,'File Size is Too Big! Choose a file less than 20MB!');
      }

    }else{

      array_push($error,'Upload Error! Please choose a file with extensions of jpg, jpeg or png!');
    } 
    }
    
  }


}
?>


 <!-- right section -->
 <section>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
        <div class="pt-md-5 mt-md-3 mb-5">
          <div><?php 
          if(!empty($error)||!empty($successArray)){
            
          forEach($error as $e){
            echo "<div class='alert alert-danger'>".$e."</div>";
          }
          forEach($successArray as $e){
            echo "<div class='alert alert-success'>".$e."</div>";
          }
          }
          ?></div>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleFormControlInput4">Role</label>
              <input type="text" class="form-control" id="exampleFormControlInput4" value="Patient" readonly class="form-control-plaintext"> <!-- readonly cannot be edited -->
            </div>
            <div class="form-group">
              <label for="exampleFormControlInput4">Patient ID</label>
              <input type="text" class="form-control" id="exampleFormControlInput4" value=<?php echo $row['PATIENT_ID']; ?> readonly class="form-control-plaintext"> <!-- readonly cannot be edited -->
            </div>
            <div class="form-group">
              <label for="exampleFormControlInput1">Name</label>
              <input type="text" class="form-control"  required  name="fullname" id="exampleFormControlInput1" value="<?php echo $row['PATIENT_NAME'];?>">
            </div>
            <div class="form-group">
              <label for="exampleFormControlInput10">Date of birth</label>
              <input type="date" class="form-control" name="dob" id="exampleFormControlInput10" value = "<?php echo $row['DOB']; ?>">
            </div>
            <div class="form-group">
              <label for="exampleFormControlInput10">IC</label>
              <input type="text" class="form-control" readonly id="exampleFormControlInput10" value = "<?php echo $row['NRIC']?>">
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Home address</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" required name="address" rows="3" ><?php echo $row['ADDR']?></textarea>
            </div>
            <div class="form-group">
              <label for="exampleFormControlInput2">Email address</label>
              <input type="email" class="form-control" id="exampleFormControlInput2" name="email" readonly value="<?php
              echo $row['EMAIL']?>">
            </div>
            <div class="form-group">
              <label for="exampleFormControlInput3">Phone number</label>
              <input type="text" name="phone" class="form-control" id="exampleFormControlInput3" required value="<?php
              echo $row['PHONE']?>">
            </div>

            <div class="form-group">
              <label for="exampleFormControlSelect1">Gender</label>
              <select class="form-control" id="exampleFormControlSelect1" name="gender">
                
                
                <option value='1' <?php echo $row['GENDER']==1 ?  "selected" : ""; ?>>Male </option>
                <option value='0'<?php echo $row['GENDER']==0 ?  "selected" : ""; ?>>Female</option>

              </select>
            </div>

            <div class="form-group">
              <label for="exampleFormControlInput3">Change password</label>
              <input type="password" name="password-old" class="form-control" id="exampleFormControlInput3" placeholder="Old password">
              <input type="password" name="password-new1" class="form-control mt-2" id="exampleFormControlInput3" placeholder="New password">
              <input type="password" name="password-new2" class="form-control mt-2" id="exampleFormControlInput3" placeholder="Retype new password">
            </div>

            <div class="form-group">
              <label for="exampleFormControlFile1">Change profile picture</label>
              <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
            </div>

            <button type="submit" name="submit-profile" class="btn btn-dark mt-3">Update</button>



          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php

$conn->close(); ?>
<!-- right section ends -->


<!-- footer starts-->
<footer>
  <div class="container-fluid  mt-5">
    <div class="row">
      <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
        <div class="row border-top pt-3">
          <div class="col text-center">
            <p>&copy; 2019 Copyright All rights reserved - HealthInsider</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- end of footer -->


<script src="js\db_index.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
