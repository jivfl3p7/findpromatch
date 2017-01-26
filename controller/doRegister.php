<?php
	include("config.php");

	$inputUsername = $_POST["username"];
	$inputPassword = $_POST["password"];
	$confpassword = $_POST["confpassword"];
	$email = $_POST["email"];
	$phonenumber = $_POST["phonenumber"];

	$message = "";

	$checkUsername = $connection->query("SELECT * FROM users WHERE username='$inputUsername'");
	$checkEmail = $connection->query("SELECT * FROM users WHERE email='$email'");

	if(strlen($inputUsername) < 6 || strlen($inputUsername) > 10){
		$message = "Username must between 6-10 characters";
	}else if($checkUsername->num_rows != 0){
		$message = "Username already exists";
	}else if(strlen($inputPassword) < 8 || strlen($inputPassword) > 20){
		$message = "Password must between 8-20 characters";
	}else if($inputPassword != $confpassword){
		$message = "Password doesn't match";
	}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$message = "Invalid E-mail format";
	}else if($checkEmail->num_rows != 0){
		$message = "E-mail already exists";
	}else if(!is_numeric($phonenumber)){
		$message = "Phone number must be numeric";
	}else{
		$connection->query("INSERT INTO users (username, password, email, phonenumber, team_id, role) VALUES ('$inputUsername','$inputPassword','$email','$phonenumber',0,'member')");

		$message = "Register success";
	}

	echo $message;

?>
