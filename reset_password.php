<?php

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['reset-password-btn'])){

	$selector = $_POST['selector'];
	$validator = $_POST['validator'];
	$password = $_POST['password'];
	$repeatPassword = $_POST['rpassword'];
	#check password
	if(empty($password)||empty($repeatPassword)){
		header('Location:forgot_password.php?selector='.$selector.'&validator='.$validator.'&error=emptyField');
		exit();
	}else if($password!=$repeatPassword){
		header('Location:forgot_password.php?selector='.$selector.'&validator='.$validator.'&error=unequalPassword');
		exit();
	}

	$currentDate = date("U");

	require("database-conf.php");

	$sql = "SELECT * FROM reset_pw WHERE RESET_PW_SELECTOR = ? AND RESET_PW_EXPIRES >= ".$currentDate.";";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		header('Location:forgot_password.php?selector='.$selector.'&validator='.$validator.'&error=database');
		exit();
	}else{
		mysqli_stmt_bind_param($stmt,'s',$selector);
		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);

		if(!mysqli_num_rows($result)){
			header('Location:forgot_password.php?selector='.$selector.'&validator='.$validator.'&error=tokenExpired');
			exit();
		}else{
			$row = mysqli_fetch_assoc($result);
			// print_r($row["RESET_PW_TOKEN"]);
			$tokenBin = hex2bin($validator);
			$tokenCheck = password_verify($tokenBin, $row['RESET_PW_TOKEN']);

			if($tokenCheck == false){
				header('Location:forgot_password.php?selector='.$selector.'&validator='.$validator.'&error=invalidLink');
				exit();

			}else if($tokenCheck == true){
				$tokenEmail = $row['RESET_PW_EMAIL'];
				$sql = "SELECT * FROM users WHERE EMAIL = '$tokenEmail';";
				$result = mysqli_query($conn,$sql);
				if(mysqli_num_rows($result)){
					$row = mysqli_fetch_assoc($result);
					$password = $_POST['password'];
					$pw = $row['PW'];
					var_dump($password,$pw);
					if(password_verify($password,$pw)== true){
						header('Location:forgot_password.php?selector='.$selector.'&validator='.$validator.'&error=samePassword');
							exit();
					}else{
						$hashedPassword = password_hash($password,PASSWORD_BCRYPT,array('cost'=>12));
						$sql = "UPDATE users SET PW='$hashedPassword' WHERE EMAIL='$tokenEmail';";
						if(!mysqli_query($conn,$sql)){
							header('Location:forgot_password.php?selector='.$selector.'&validator='.$validator.'&error=database');
							exit();
						}else{
							header('Location:forgot_password.php?selector='.$selector.'&validator='.$validator.'&success=true');
							exit();							
						}
					}
				}else{
					header('Location:forgot_password.php?selector='.$selector.'&validator='.$validator.'&error=invalidRequest');
							exit();
				}



			}else{
echo 'Please resubmit the request';
			exit();
			}
		}
	}
}
?>