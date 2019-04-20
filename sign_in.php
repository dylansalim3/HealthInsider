<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: db_patient_index.php");
    exit();
}

include("database-conf.php");

// Define variables and initialize with empty values
if($_SERVER["REQUEST_METHOD"]=="POST"){
  $email = $_POST['email'];
  $password = $_POST['password'];
  $role = $_POST['role'];

  if(empty($email)||empty($password)||empty($role)){
    header("Location:sign_in.php?error=emptyfields");
    exit();
  }else{
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = mysqli_stmt_init($conn);
    //Prepare statement
    if(!mysqli_stmt_prepare($stmt,$sql)){
      header("Location:sign_in.php?error=sqlerror");
      exit();
    }else{
      mysqli_stmt_bind_param($stmt,"s",$email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      //Check whether the result is empty or not
      if($row = mysqli_fetch_assoc($result)){
        $pwcheck = password_verify($password,$row['PW']);
        if(!pwcheck){
          header("Location: sign_in.php?error=wrongpwd");
          exit();
        }else{

          $_SESSION['ID'] = $row['USER_ID'];

          if($role=="Staff" && $row['STAFF_ID']!=null){
            $_SESSION['ID'] = $row['USER_ID'];
            header("Location:db_staff_index.php");
            exit();
          }else if($role=="Patient" && $row['PATIENT_ID']!=null){
            $_SESSION['ID'] = $row['USER_ID'];
            header("Location:db_patient_index.php");
            exit();
          }else{
            header("Location:sign_in.php?error=wrongcredential");
            exit();
          }


        }
      }else{
        header("Location:sign_in.php?error=nouser");
        exit();
      }
    }
  }

}


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

      <div class="container-fluid">


        <div class="card bg-light">
          <article class="card-body mx-auto" style="max-width: 700px;">
            <h4 class="card-title mt-3 text-center">User login</h4>
            <p class="text-center">Login into system  </p>
            <p>
              <a href="" class="btn btn-block btn-google"> <i class="fab fa-google"></i>   Login via Google</a>
              <a href="" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i>   Login via Facebook</a>
            </p>
            <p class="divider-text">
              <span class="bg-light"></span>
            </p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <?php  if(isset($_GET['error'])){
                  echo "<div class='alert alert-warning'>";
                  if($_GET['error']=="emptyfields"){
                    echo "Please fill the required details";
                  }else{
                    echo "Please select the correct credential";
                  }
                  echo "</div>";
                }?>
              <div class="form-group input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                </div>
                <input name="email" value="dylansalim015@gmail.com" class="form-control" placeholder="Enter your email" type="text">
              </div> <!-- form-group// -->

              <div class="form-group input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                </div>
                <input name="password" value="96101530" class="form-control" placeholder="Enter your password" type="password">
              </div> <!-- form-group// -->
              <div class="form-group input-group">

                <div class="input-group-prepend">
                  <span class="input-group-text"> <i class="fas fa-venus-mars"></i> </span>
                </div>
                <select name="role" class="form-control" id="mySelect">
                  <option value="">Select role</option>
                  <option value="Staff">Staff</option>
                  <option value="Patient">Patient</option>
                </select>
              </div> <!-- form-group end.// -->


              <div class="form-group">
                <button id="mybut" type="submit" class="btn btn-primary btn-block"><a class="text-white" id="my-link" style="text-decoration:none;" >Sign in</a>  </button>
              </div> <!-- form-group// -->
              <p class="text-center"><a data-toggle="modal" href="#forgetps">Forgot password?</a> | <a href="sign_up.php">Already a user?</a></p>
          </form>
        </article>
      </div> <!-- card.// -->

    </div>
    <!--container end.//-->

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

    <!-- modal for forget password-->
    <div class="modal fade" id="forgetps">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Reset your password</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           <p>Enter your email address and we will send you a link to reset your password.</p>
         </div>

         <form>
            <div class="form-group">
              <input type="email" class="form-control" style="width:90%; margin: 0 auto;" id="resetEmail"  placeholder="Enter email address">
            </div>
         </form>

         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
           <button type="button" class="btn btn-primary" data-dismiss="modal">Send password reset email</button>
         </div>
       </div>
     </div>
   </div>
   <!-- end of modal for forget password-->

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
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
