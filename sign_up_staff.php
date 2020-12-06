<?php

require('php/staff_signup.php');

?>

<!--html code-->
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Main css for all pages -->
    <link rel="stylesheet" href="css/main.css">
    <!-- Font awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
    <title>Staff signup</title>
</head>

<body style="max-width: 600px; margin-left: auto; margin-right: auto; margin-top: 70px;">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <?php if (isset($_GET['error'])) {
        echo "<div class='alert alert-warning'>";
        if ($_GET['error'] == "emptyfields") {
            echo "Please fill the required details";
        } else if ($_GET['error'] == "sqlerror") {
            echo "Sorry we are facing an error now. Please refresh the page.";
        } else if ($_GET['error'] = "userexists") {
            echo "User already exists. Please contact our customer hotline.";
        } else {
            echo "unknown error";
        }
        echo "</div>";
    } ?>
    <div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
        </div>
        <input value="" id="username" name="username" class="form-control" placeholder="Username" type="text">
    </div>
    <div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
        </div>
        <input value="" id="name" name="name" class="form-control" placeholder="Full name" type="text">
    </div> <!-- form-group// -->
    <div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
        </div>
        <input value="" id="email" name="email" class="form-control" placeholder="Email address" type="email">
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
        <input value="" id="phone" name="phone" class="form-control" placeholder="Phone number" type="text">
    </div> <!-- form-group// -->
    <div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fas fa-sort-numeric-up"></i> </span>
        </div>
        <input value="" id="nric" name="nric" class="form-control" placeholder="NRIC" type="text">

    </div> <!-- form-group// -->
    <div id="dob_form" class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-building"></i> </span>
        </div>

        <input id="datepicker" name="dob" placeholder="Date of Birth"/>
    </div>

    <div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-building"></i> </span>
        </div>
        <textarea id="address" name="address" class="form-control" placeholder="Home address" type="text"
                  rows="4"></textarea>
    </div>
    <div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fas fa-venus-mars"></i> </span>
        </div>
        <select id="gender" name="gender" class="form-control">
            <option> Select gender</option>
            <option selected="">Male</option>
            <option>Female</option>
        </select>
    </div>
    <div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
        </div>
        <input value="" name="password" id="password" class="form-control" placeholder="Create password"
               type="password">
    </div> <!-- form-group// -->
    <div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
        </div>
        <input value="" name="password_verify" id="password_verify" class="form-control"
               placeholder="Repeat password" type="password">
    </div> <!-- form-group// -->
    <div class="form-group">
        <input type="submit" value="Create Account" class="btn btn-primary btn-block">
    </div> <!-- form-group// -->
</form>
<script src="https://code.jquery.com/jquery-3.4.0.js"
        integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
