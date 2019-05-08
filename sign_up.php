<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["ID"])){
    header("location: db_patient_index.php");
    exit();
}

include("database-conf.php");

// Define variables and initialize with empty values
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
  print_r($dob);

  if(empty($username)||empty($password)||empty($nric)){
    header("Location:sign_up.php?error=emptyfields");
    exit();
  }else{

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
        
          $sql1 = "INSERT INTO patient(PATIENT_NAME,NRIC,ADDR,DOB,PHONE) VALUES ('$fullname','$nric','$address','$dob','$prefix-$phone')";
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

<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Main css for all pages -->
  <link rel="stylesheet" href="css\main.css">
  <!-- Font awesome CDN -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

   <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

  <title>HealthInsider</title>
</head>

<body>
  <!-- top nav bar -->
  <nav class="navbar navbar-expand-lg navbar-light top-nav hide-on-mobile ">

    <div class="collapse navbar-collapse">
      <div class="mr-auto"></div>
      <a class="nav-link mr-2 schedule" data-toggle="modal" data-target="#appointRequest" href="#">Schedule an appointment</a>
      <i class="fas fa-sign-in-alt mr-2"><a class="mr-2" href="sign_in.php"> Sign In</a></i>
      <i class="fas fa-user-plus mr-2"><a class="mr-3" href="sign_up.php"> Sign Up</a></i>
    </div>

  </nav>
  <!-- top nav bar ends -->
  <nav class="navbar navbar-expand-lg my-background-2 navbar-dark">
    <div class="container">
      <button class="navbar-toggler" style="color:#fff" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0 ">
          <!-- <ul class="nav nav-pills nav-fill w-100"> -->

            <li class="nav-item active">
              <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about_us.html">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="services.html">Our Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="news.html">News</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact Us</a>
            </li>

          </ul>
          </div>
        </div>
      </nav>

      <!-- start of modal for appointment request -->
      <!-- modal -->
      <div class="modal fade" id="appointRequest">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Make an appointment?</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <p>Sign in to make an appointment</p>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
             <button type="button" class="btn btn-secondary"><a class="text-white" href="sign_up.html" style="text-decoration:none;">Sign up</a></button>
             <button type="button" class="btn btn-info"><a class="text-white" href="sign_in.html" style="text-decoration:none;">Already has an account?</a></button>
           </div>
         </div>
       </div>
     </div>
     <!-- end of modal -->
     <!-- modal of appointment request ends -->


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
            <?php  if(isset($_GET['error'])){
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

            <input id="datepicker" name="dob" width="276" placeholder="Date of Birth" />
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
                <option> Select gender</option>
                <option selected="">Male</option>
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

    </script>

        <script type="text/javascript">
        
$('#datepicker').datepicker({
            format : 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4'

        });
        </script>


  </body>
  </html>
