<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- logo -->
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
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="about_us.php">About Us</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="services.php">Our Services</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="news.php">Articles</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Us</a>
                      </li>

                    </ul>
          <!-- <i class="fas fa-sign-in-alt mr-2"><a href="#"> Sign In</a></i>
            <i class="fas fa-user-plus mr-2"><a href="#"> Sign Up</a></i> -->
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
             <button type="button" class="btn btn-info"><a class="text-white" href="sign_in.php" style="text-decoration:none;">Already has an account?</a></button>
           </div>
         </div>
       </div>
     </div>
     <!-- end of modal -->
     <!-- modal of appointment request ends -->

     <!-- bg starts -->
     <div class="mycontainer">
       <img class="img-fluid" src="images\bg1.jpg" >
       <div class="centered">
        <h1>The Most Valuable Thing Is Your Health</h1>
        <p style="color: #818189">We care about your health. HealthInsider provides primary health care services to everyone. </p>
      </div>
    </div>
    <!-- bg ends -->