<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
<?php

session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["ID"])){
    header("location: db_patient_index.php");
    exit();
}
include_once("index-header.php");
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
        $pw = $row['PW'];
        var_dump($password,$pw);
        $pwcheck = password_verify($password,$pw);
        if(!$pwcheck){
          header("Location: sign_in.php?error=wrongpwd");
          exit();
        }else{

          if($role=="Staff" && !empty($row['STAFF_ID'])){
            $_SESSION['ID'] = $row['USER_ID'];
            header("Location:db_staff_index.php");
            exit();
          }else if($role=="Patient" && !empty($row['PATIENT_ID'])){
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

if(isset($_GET['resetError'])||isset($_GET['reset'])){
  ?>


  <script type="text/javascript">
  $(document).ready(function(){
    $('#forgetps').modal('show');
});
  
  </script>
  <?php
}
 ?>

      

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
                  }else if($_GET['error']=="wrongcredential"){
                    echo "Please select the correct credential";
                  }else if($_GET['error']=="wrongpwd"){
                    echo "Please select the correct password";
                  }
                  echo "</div>";
                }?>
              <div class="form-group input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                </div>
                <input name="email" class="form-control" placeholder="Enter your email" type="text">
              </div> <!-- form-group// -->

              <div class="form-group input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                </div>
                <input name="password" class="form-control" placeholder="Enter your password" type="password">
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
              <p class="text-center"><a data-toggle="modal" href="#forgetps">Forgot password?</a> | <a href="sign_up.php">New User?</a></p>
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
             <button type="button" class="btn btn-info"><a class="text-white" href="sign_in.html" style="text-decoration:none;">Create new account</a></button>
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
            <?php
            if(isset($_GET['reset'])){
              if($_GET['reset']=="success"){
              ?>
              
              <div class="alert alert-info">Email sent! Please check your mail.</div>
              <?php
              }
            }
              
              if(isset($_GET['resetError'])){
                if($_GET['resetError']=="databaseError"){
                  ?>
                  <div class="alert alert-warning">Database Error! Please try again later.</div>
                  <?php
                }else if($_GET['resetError']=="emailNotExist"){
                  ?>
                  <div class="alert alert-warning">User Exist! Please try again later.</div>
                  <?php
                }else{
                  ?>
                  <div class="alert alert-warning">Failed to send the email! Please try again later.</div>
                  <?php
                }
               
              
            }
            ?>
           <p>Enter your email address and we will send you a link to reset your password.</p>
         </div>

         <form action="request_reset_password.php" method="POST">
            <div class="form-group">
              <input type="email" name="email" class="form-control" style="width:90%; margin: 0 auto;" id="resetEmail" placeholder="Enter email address">
            </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
           <button type="submit" class="btn btn-primary" name="reset-password-btn" >Send password reset email</button>
         </div>
         </form>

         
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
