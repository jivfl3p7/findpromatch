<?php
	session_start();
	include("config.php");

	$inputUsername = $_POST["username"];
	$inputPassword = $_POST["password"];
	$confpassword = $_POST["confpassword"];
	$inputEmail = $_POST["email"];
	$phonenumber = $_POST["phonenumber"];

	$message = "";
	$row = 0;
	$row2 = 0;

	if($inputUsername != $username){
		$checkUsername = $connection->query("SELECT * FROM users WHERE username='$inputUsername'");
		$row = $checkUsername->num_rows;
	}

	if($inputEmail != $emailsession){
		$checkEmail = $connection->query("SELECT * FROM users WHERE email='$inputEmail'");
		$row2 = $checkEmail->num_rows;
	}

	if(strlen($inputUsername) < 6 || strlen($inputUsername) > 10){
		$message = "Username must between 6-10 characters";
	}else if($row != 0){
		$message = "Username already exists";
	}else if(strlen($inputPassword) < 8 || strlen($inputPassword) > 20){
		$message = "Password must between 8-20 characters";
	}else if($inputPassword != $confpassword){
		$message = "Password doesn't match";
	}else if(!filter_var($inputEmail,FILTER_VALIDATE_EMAIL)){
		$message = "Invalid E-mail format";
	}else if($row2 != 0){
		$message = "E-mail already exists";
	}else if(!is_numeric($phonenumber)){
		$message = "Phone number must be numeric";
	}else{
		$connection->query("UPDATE users
			SET username = '$inputUsername',
			password = '$inputPassword',
			email='$inputEmail',
			phonenumber = '$phonenumber'

			WHERE user_id='$useridsession'");

		$message = "Update profile success";
		$_SESSION['user']['email'] = $inputEmail;
		$_SESSION['user']['username'] = $inputUsername;
	}

	echo $message;

?>
