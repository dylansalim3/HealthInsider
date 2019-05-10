<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["ID"])){
    header("location: db_patient_index.php");
    exit();
}
include_once("index-header.php");
include("database-conf.php");

// $emptyError = $usernameError = $passwordNotMatchError = $weakPasswordError = $phoneError = $nricError = false; 
  
if($_SERVER["REQUEST_METHOD"]=="POST"){
  $username = $_POST['username'];
  $fullname = $_POST['name'];
  $email = $_POST['email'];
  $prefix = $_POST['prefix'];
  $phone = $_POST['phone'];
  $nationality = $_POST['nationality'];
  $nric = str_replace(array(" ","-"), "", $_POST['nric']);
  $address = $_POST['address'];
  $gender = $_POST['gender'];
  $password = $_POST['password'];
  $verify_password = $_POST['password_verify'];
  $dob = $_POST['dob'];

  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $number    = preg_match('@[0-9]@', $password);
  $error = array();
  $valid=true;
  if(empty($username)||empty($fullname)||empty($email)||empty($phone)||empty($nationality)||empty($address)||empty($gender)||empty($password)||empty($verify_password)||empty($nric)||empty($dob)){
    array_push($error,"Empty field! Please insert values!");
    // $emptyError=true;
    $valid=false;
  }
  if ( !preg_match('/^[a-z0-9_-]{5,30}$/', $username) ){
    array_push($error,"Username must consist of 5-32 words,must start with letter and only letters and numbers allowed! Please Try Again!");
    // $passwordNotMatchError=true;
    $valid=false;
  }
  if($password!=$verify_password){
    array_push($error,"Both Password Not Match! Please Try Again!");
    // $usernameError=true;
    $valid=false;
  }
  if(!$uppercase || !$lowercase || !$number || strlen($password) < 8){
    array_push($error,'Weak Password! Please Try Again!');   
    // $weakPasswordError=true;
    $valid=false;
  }
  if(!preg_match('/^[0-9]+$/',$phone) || strlen($phone)<7||strlen($phone)>8){
    array_push($error,'Incorrect phone number! Please Try Again!');
    // $phoneError=true;
    $valid=false;
  }
  if((!preg_match('/^[0-9]+$/',$nric) || strlen($nric)!=12) && $nationality=="Malaysian"){
    array_push($error,'Incorrect NRIC format! Please Try Again!');
    // $nricError=true;
    $valid=false;
  }  
  if($valid==true){

    $sql = "SELECT p.nric FROM users u JOIN patient p ON p.PATIENT_ID = u.PATIENT_ID WHERE nric=?";
    $stmt = mysqli_stmt_init($conn);
    //Prepare statement
    if(!mysqli_stmt_prepare($stmt,$sql)){
      header("Location:sign_up.php?error=sqlerror");
      exit();
    }else{
      mysqli_stmt_bind_param($stmt,"i",$nric);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);
      // Check whether the given NRIC is available in the database or not
      if(mysqli_num_rows($result)<1){
        $hashedPassword = password_hash($password,PASSWORD_BCRYPT,array('cost'=>12));
        //insert patient data into patient table
        
          $sql1 = "INSERT INTO patient(PATIENT_NAME,NRIC,ADDR,DOB,PHONE,GENDER) VALUES ('$fullname','$nric','$address','$dob','$prefix-$phone','$gender')";
        if(mysqli_query($conn,$sql1)){
          $patient_id = mysqli_insert_id($conn);
          $sql2 = "INSERT INTO users(EMAIL,PW,PATIENT_ID,USERNAME) VALUES('$email','$hashedPassword','$patient_id','$username')";
          if(mysqli_query($conn,$sql2)){
            header("Location:sign_in.php");
            $_SESSION['ID'] = mysqli_insert_id($conn);
            header("Location:db_patient_index.php");
          }
        }
      }else{
  header("Location:sign_up.php?error=userexists");
  exit();
      }
    }
}
}

$conn->close();
 ?>


     <div class="container-fluid">
      <div class="card bg-light">
        <article class="card-body mx-auto" style="max-width: 700px;">
          <h4 class="card-title mt-3 text-center">Create Account</h4>
          <p class="text-center">Get started with your free account</p>
          <p>
            <a href="#" class="btn btn-block btn-google"> <i class="fab fa-google"></i>   Login via Google</a>
            <a href="#" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i>   Login via Facebook</a>
          </p>
          <p class="divider-text">
            <span class="bg-light">OR</span>
          </p>
          <div id="add_err"></div>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <?php  
            if(!empty($error)){
              echo "<div class='alert alert-danger'>";
              forEach($error as $e){
                echo $e;
              }
              echo "</div>";
              }
            
            if(isset($_GET['error'])){
              echo "<div class='alert alert-warning'>";
              if($_GET['error']=="emptyfields"){
                echo "Please fill the required details";
              }else if($_GET['error']=="sqlerror"){
                echo "Sorry we are facing an error now. Please refresh the page.";
              }else if($_GET['error']="userexists"){
                echo "User already exists. Please contact our customer hotline.";
              }else{
                echo "unknown error";
              }
              echo "</div>";
            }?>
            <div class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
              </div>
              <input id="username" name="username" class="form-control" placeholder="Username" type="text">
            </div>
            <div class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
              </div>
              <input id="name" name="name" class="form-control" placeholder="Full name" type="text">
            </div> <!-- form-group// -->
            <div class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
              </div>
              <input id="email" name="email" class="form-control" placeholder="Email address" type="email">
            </div> <!-- form-group// -->
            <div class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
              </div>
              <select id="prefix" name="prefix" class="custom-select" style="max-width: 120px;">
                <option selected="" value="010">010</option>
                <option value="011">011</option>
                <option value="012">012</option>
                <option value="013">013</option>
                <option value="014">014</option>
                <option value="016">016</option>
                <option value="017">017</option>
                <option value="018">018</option>
                <option value="019">019</option>
              </select>
              <input id="phone" name="phone" class="form-control" placeholder="Phone number" type="text">
            </div> <!-- form-group// -->
            <div class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fas fa-sort-numeric-up"></i> </span>
              </div>
              <select onchange="changeNationality()" id="nationality" name="nationality" class="custom-select" style="max-width: 120px;">
                <option selected value="Malaysian">Malaysian</option>
                <option value="Other">Other</option>
              </select>
              <input id="nric" name="nric" class="form-control" placeholder="NRIC" type="text">

            </div> <!-- form-group// -->
            <div id="dob_form" class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-building"></i> </span>
             </div>

             <input type="date" class="form-control" name="dob" width="276" placeholder="Date of Birth" />
              </div>

            <div class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-building"></i> </span>
              </div>
              <textarea  id="address" name="address" class="form-control" placeholder="Home address" type="text" rows="4"></textarea>
            </div> <!-- form-group// -->
            <div class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fas fa-venus-mars"></i> </span>
              </div>
              <select id="gender" name="gender" class="form-control">
                <option selected=""> Select gender</option>
                <option>Male</option>
                <option>Female</option>
              </select>
            </div> <!-- form-group end.// -->
            <div class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
              </div>
              <input name="password" id="password" class="form-control" placeholder="Create password" type="password">
            </div> <!-- form-group// -->
            <div class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
              </div>
              <input name="password_verify" id="password_verify" class="form-control" placeholder="Repeat password" type="password">
            </div> <!-- form-group// -->
            <div class="form-group">
              <button onclick="submitForm()" class="btn btn-primary btn-block"> Create Account  </button>
            </div> <!-- form-group// -->
            <p class="text-center">Have an account? <a href="sign_in.php">Log In</a> </p>
          </form>
        </article>
      </div> <!-- card.// -->

    </div>
    <!--container end.//-->

    <!-- footer starts -->
    <footer class="mt-3 my-background-2 my-footer text-center">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <h4 class="text-center">HealthInsider</h4>
            <p class="mt-md-5 mt-sm-3">HealthInsider is a not-for-profit independent hospital that located in Petaling Jaya. We are open to all patients every day.
            </p>
            <p>We provides fundamental medical treatment and cutting-edge medicine. We commit to provide the highest quality care for every person in the community.</p>
          </div>
          <div class="col-md">
            <h4 class="text-center">Contact Info</h4>
            <div class="text-center">
              <p class="mt-md-5 mt-sm-3">Address: Jalan Universiti, 50603 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur</p>
              <p>Phone: +60 04-5987458</p>
              <p>Email: yourmail@gmail.com</p>
            </div>
          </div>

          <div class="col-md">
            <h4 class="text-center">Opening Hours</h4>
            <div class="text-center">
              <p class="mt-md-5 mt-sm-3">Monday: 8:00am - 9:00pm</p>
              <p>Tuesday: 8:00am - 9:00pm</p>
              <p>Wednesday: 8:00am - 9:00pm</p>
              <p>Thursday: 8:00am - 9:00pm</p>
              <p>Friday: 8:00am - 9:00pm</p>
            </div>

          </div>
        </div>

        <div class="row">
          <div class="col-md-12 text-center">
            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved  - HealthInsider</p>
          </div>
        </div>
      </div>

    </footer>
    <!-- footer ends -->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
    src="https://code.jquery.com/jquery-3.4.0.js" integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
  </body>
  </html>
