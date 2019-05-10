<?php
if(isset($_POST['reset-password-btn'])){
	
	$selector = bin2hex(random_bytes(8));
	
	
	$token = random_bytes(32);
	
	
	$url = $_SERVER['HTTP_HOST'] . "/healthInsider/forgot_password.php?selector=".$selector."&validator=". bin2hex($token);
	//the token expired in 3 hours
	$expires = date("U") +10800;

	require('database-conf.php');

	$userEmail = $_POST['email'];
	$sql = "SELECT EMAIL FROM users WHERE EMAIL = ?";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		header('Location:sign.php?resetError=databaseError');
		exit();
	}else{
		mysqli_stmt_bind_param($stmt,"s",$userEmail);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if(mysqli_num_rows($result)<1){
			header('Location:sign_in.php?resetError=emailNotExist');
			exit();
		}
	}

	$sql = "DELETE FROM reset_pw WHERE RESET_PW_EMAIL = ?";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		header('Location:sign.php?resetError=databaseError');
		exit();
	}else{
		mysqli_stmt_bind_param($stmt,"s",$userEmail);
		mysqli_stmt_execute($stmt);

	}

	$sql = "INSERT INTO reset_pw (RESET_PW_EMAIL,RESET_PW_SELECTOR,RESET_PW_TOKEN,RESET_PW_EXPIRES) VALUES (?,?,?,?);";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		header('Location:sign.php?resetError=databaseError');
		exit();
	}else{
		$hashedToken = password_hash($token,PASSWORD_BCRYPT,array('cost'=>12));
		mysqli_stmt_bind_param($stmt,"ssss",$userEmail,$selector,$hashedToken,$expires);
		mysqli_stmt_execute($stmt);
	}

	mysqli_stmt_close($stmt);
	mysqli_close();

	$to = $userEmail;

	$subject = 'Reset your password for HealthInsider';

	$message = '<p> This is a system generated message. Ignore this message if you are able to login to your system</p>';
	$message .= '<p>Here is your password reset link<br>';
	$message .= '<a href = '.$url.'> '.$url.'</a></p>';

	$header = "From: HealthInsiderAdmin<healthinsider10@gmail.com>\r\n";
	$header .= "Reply-To: healthinsider10@gmail.com\r\n";
	$header .= "Content-type: text/html\r\n";

	mail($to,$subject,$message,$header);

	header("Location:sign_in.php?reset=success");
}else{
	header('Location:sign.php?resetError=databaseError');
}

?>