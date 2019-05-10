<?php
require("index-header.php");



$selector = $_GET['selector'];
$validator = $_GET['validator'];

if(empty($selector)||empty($validator)){
	echo 'Sorry we are unable to process your request';
}else{
	if(ctype_xdigit($selector)!==false||ctype_xdigit($validator)!==false){
		?>
		<div class="container-fluid">
        <div class="card bg-light">
          <article class="card-body mx-auto" style="max-width: 700px;">
            <h4 class="card-title mt-3 text-center">Reset Password</h4>
            <p class="text-center">Please enter your new password</p>
            
           
            
                <?php  if(isset($_GET['error'])){
                  echo "<div class='alert alert-warning'>";
                  if($_GET['error']=="emptyfields"){
                    echo "Please fill the required details";
                  }else if($_GET['error']=="unequalPassword"){
                    echo "Please enter the same password";
                  }else if($_GET['error']=="database"){
                    echo "Database Error";
                  }else if($_GET['error']=="invalidRequest"){
                    echo "Your request is invalid. Please request another email.";
                  }else if($_GET['error']=="tokenExpired"){
                    echo "Your token is expired. Please request another email.";
                  }
                    echo "</div>";
                  }
                  if(isset($_GET['success'])){
                    if($_GET['success']=="true"){                      
                      echo "<div class='alert alert-info'>Password Changed</div>";
                    }
                  }
                  ?>
          <form action="reset_password.php" method="POST">
              <div class="form-group input-group">   
              	<input type="hidden" name="selector" value="<?php echo $selector?>">
              	<input type="hidden" name="validator" value="<?php echo $validator?>">             
                <input name="password" class="form-control" placeholder="Enter new password" type="password">
              </div> <!-- form-group// -->
              <div class="form-group input-group">                
                <input name="rpassword" class="form-control" placeholder="Repeat your password" type="password">
              </div>
              <div class="form-group">
                <button id="mybut" type="submit" name="reset-password-btn" class="btn btn-primary btn-block"><a class="text-white" id="my-link" style="text-decoration:none;" >Reset Now</a>  </button>
              </div> <!-- form-group// -->
          </form>
        </article>
      </div> <!-- card.// -->

    </div>
		<?php
	}
}

?>
