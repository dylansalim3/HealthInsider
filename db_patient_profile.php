<?php
require("db_patient_header.php");

$sql = "SELECT * FROM PATIENT WHERE PATIENT_ID = ANY(SELECT PATIENT_ID FROM users WHERE USER_ID='$user_check')";
if($result = mysqli_query($conn,$sql)){
  $row = mysqli_fetch_assoc($result);

?>


 <!-- right section -->
 <section>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
        <div class="pt-md-5 mt-md-3 mb-5">
          <form>
            <div class="form-group">
              <label for="exampleFormControlInput4">Role</label>
              <input type="text" class="form-control" id="exampleFormControlInput4" value="Patient" readonly class="form-control-plaintext"> <!-- readonly cannot be edited -->
            </div>
            <div class="form-group">
              <label for="exampleFormControlInput1">Name</label>
              <input type="text" class="form-control" id="exampleFormControlInput1" value="<?php echo $row['PATIENT_NAME'];?>">
            </div>
            <div class="form-group">
              <label for="exampleFormControlInput10">Date of birth</label>
              <input type="date" class="form-control" id="exampleFormControlInput10" value = "1988-08-03">
            </div>
            <div class="form-group">
              <label for="exampleFormControlInput10">IC</label>
              <input type="text" class="form-control" id="exampleFormControlInput10" value = "980842578546">
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Home address</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" >Jalan Munich, 14000, Taman Madrid, Kuala Lumpur</textarea>
            </div>
            <div class="form-group">
              <label for="exampleFormControlInput2">Email address</label>
              <input type="email" class="form-control" id="exampleFormControlInput2" value="123@gmail.com">
            </div>
            <div class="form-group">
              <label for="exampleFormControlInput3">Phone number</label>
              <input type="text" class="form-control" id="exampleFormControlInput3" value="011-5478445">
            </div>

            <div class="form-group">
              <label for="exampleFormControlSelect1">Gender</label>
              <select class="form-control" id="exampleFormControlSelect1">
                <option>Male</option>
                <option>Female</option>
              </select>
            </div>

            <div class="form-group">
              <label for="exampleFormControlInput3">Change password</label>
              <input type="password" class="form-control" id="exampleFormControlInput3" placeholder="Old password">
              <input type="password" class="form-control mt-2" id="exampleFormControlInput3" placeholder="New password">
              <input type="password" class="form-control mt-2" id="exampleFormControlInput3" placeholder="Retype new password">
            </div>

            <div class="form-group">
              <label for="exampleFormControlFile1">Change profile picture</label>
              <input type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>

            <button type="submit" class="btn btn-dark mt-3">Update</button>



          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php

}

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
