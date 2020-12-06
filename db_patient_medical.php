<?php
session_start();  
$_SESSION['page'] = "medical";
require("db_patient_header.php");

$sql = "SELECT p.PATIENT_NAME, p.DOB, p.GENDER, p.ADDR,u.EMAIL, p.PHONE, p.NRIC,p.HEIGHT, p.WEIGHT,p.LDC, p.SYSTOLIC, p.DIASTOLIC,p.HEART_RATE FROM patient p, users u WHERE p.PATIENT_ID = u.PATIENT_ID AND u.USER_ID = '$user_check'";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0){
  $row = mysqli_fetch_assoc($result);


?>



 <!-- right section -->
 <section>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
        <div class="row pt-md-5 mt-md-3 mb-5">
          <div class="container-fluid">
            <div class="card bg-light">
              <div class="card-body">
                <h4 class="card-title mt-3 text-center">Medical condition</h4>
                <p class="text-center">Below are the information that will be generated in medical report</p>
                <p class="divider-text">
                  <span class="bg-light">REPORT IS IN PDF FORMAT</span>
                  <form action="db_patient_fpdf.php" method="POST">

                    <div class="form-group">
                      <label for="formGroupExampleInput">Patient's Name</label>
                      <input type="text" class="form-control" id="formGroupExampleInput" readonly name="patient_name" value="<?php echo $row['PATIENT_NAME']; ?>">
                    </div>
                    <div class="form-group">
                      <label for="formGroupExampleInput2">Date of birth</label>
                      <input type="date" class="form-control" id="formGroupExampleInput2" readonly name="dob" value = "<?php echo $row['DOB'];  ?>">
                    </div>
                    <div class="form-group">
                      <label for="formGroupExampleInput3">Gender</label>
                      <input type="text" class="form-control" name="gender" id="formGroupExampleInput3" readonly value="<?php if($row['GENDER']){
                        echo 'Male';
                        }else{
                        echo 'Female';
                        }  ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleTextarea">Address</label>
                      <textarea class="form-control" name="address" id="exampleTextarea" readonly rows="4"><?php echo $row['ADDR'];  ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="formGroupExampleInput4">Email</label>
                      <input type="email" class="form-control" name="email" id="formGroupExampleInput4" readonly value="<?php echo $row['EMAIL'];  ?>">
                    </div>
                    <div class="form-group">
                      <label for="formGroupExampleInput5">Phone no</label>
                      <input type="text" class="form-control" id="formGroupExampleInput5" readonly name="phone" value="<?php echo $row['PHONE'];  ?>">
                    </div>
                    <div class="form-group">
                      <label for="formGroupExampleInput6">IC</label>
                      <input type="text" class="form-control" id="formGroupExampleInput6" readonly name="nric" value = "<?php echo $row['NRIC'];  ?>">
                    </div>

                    <span class="bg-light"></span>
                    <div class="form-group">
                      <label for="formGroupExampleInput7">Height</label>
                      <input type="text" class="form-control" id="formGroupExampleInput7" readonly class="form-control-plaintext" name="height" value="<?php echo !empty($row['HEIGHT'])?$row['HEIGHT']:'0';  ?> cm">
                    </div>
                    <div class="form-group">
                      <label for="formGroupExampleInput8">Weight</label>
                      <input type="text" class="form-control" id="formGroupExampleInput8" readonly class="form-control-plaintext" name="weight" value="<?php echo !empty($row['WEIGHT'])?$row['WEIGHT']:'0';  ?> kg">
                    </div>
                    <div class="form-group">
                      <label for="formGroupExampleInput9">BMI</label>
                      <input type="text" class="form-control" id="formGroupExampleInput9" readonly class="form-control-plaintext" name="bmi" value="<?php 
                      if($row['HEIGHT']>0 && $row['WEIGHT']>0){
                        echo $row['WEIGHT']/pow($row['HEIGHT']/100,2);
                      }else{
                        echo '0';
                      }  ?>">
                    </div>
                    <div class="form-group">
                      <label for="formGroupExampleInput10">LDL Colesterol level</label>
                      <input type="text" class="form-control" id="formGroupExampleInput10" readonly class="form-control-plaintext" value="<?php echo !empty($row['LDC'])?$row['LDC']:'0';  ?> mg/dL"> 
                    </div>
                    <div class="form-group">
                      <label for="formGroupExampleInput11">Systolic blood pressure</label>
                      <input type="text" class="form-control" id="formGroupExampleInput11" readonly class="form-control-plaintext" value="<?php echo !empty($row['SYSTOLIC'])?$row['SYSTOLIC']:'0';  ?> mmHg">
                    </div>
                    <div class="form-group">
                      <label for="formGroupExampleInput12">Diastolic blood pressure</label>
                      <input type="text" class="form-control" id="formGroupExampleInput12" readonly class="form-control-plaintext" value="<?php echo !empty($row['DIASTOLIC'])?$row['DIASTOLIC']:'0';   ?> mmHg">
                    </div>

                    <div class="form-group">
                      <label for="formGroupExampleInput13">Heart rate per minute</label>
                      <input type="text" class="form-control" id="formGroupExampleInput13" readonly class="form-control-plaintext" value="<?php echo !empty($row['HEART_RATE'])?$row['HEART_RATE']:'0';  ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleTextarea2">Past medical history</label>
                      <?php
                      $sql1 = "SELECT PATIENT_HISTORY, DATE, TIME FROM patient_history WHERE PATIENT_ID = ANY(SELECT PATIENT_ID FROM users WHERE USER_ID = '$user_check')";
                      $result1 = mysqli_query($conn,$sql1);

                      if(mysqli_num_rows($result1)>0){
                      echo '<table class ="table table-hover table-responsive-md">
                        <thead>
                          <tr class="table-active">
                             <th scope="col">ID</th>
                              <th scope="col">Date</th>
                              <th scope="col">Time</th>
                              <th scope="col">Descriptions</th>
                          </tr>
                          <tbody>';
                            $i=1;
                            while($row1 = mysqli_fetch_assoc($result1)){
                              echo '<tr class="table-secondary">
                              <td scope="row">'.$i.'</td>
                              <td>'.$row1["DATE"].'</td>
                              <td>'.$row1["TIME"].'</td>
                              <td>'.$row1["PATIENT_HISTORY"].'</td>
                            </tr>';
                            $i++;
                          }
                            

                            echo "
                          </tbody>
                        </thead>
                      </table>";



                      }
                      ?>
                    </div>
                    <div class="form-group"> 
                      <button type="submit" class="btn btn-primary btn-block"><a class="text-white" style="text-decoration: none;">Generate report</a></button>
                    </div>
                    
                  </form>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section> 

<!-- right section ends -->
<?php

}

$conn->close(); ?>

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
