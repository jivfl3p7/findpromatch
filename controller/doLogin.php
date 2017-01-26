<?php
	session_start();

	$loginUsername = $_POST['username'];
	$loginPassword = $_POST['password'];
	$refpage = $_POST['refpage'];

	$message = "";

	include("config.php");

	if($loginUsername == ""){
		$message = "Please input your Username";
	}else if($loginPassword == ""){
		$message = "Please input your Password";
	}else{
		$query = $connection->query("SELECT * FROM users WHERE username='$loginUsername' AND password ='$loginPassword'");

		if($query->num_rows == 0){
			$message = "Invalid Username or Password";
			header("location:../login.php?message=". $message);
		}else{
			$message = "Login success";
			$user = $query->fetch_assoc();
			$userid = $user['user_id'];

			$_SESSION['team'] = $user['team_id'];
			$_SESSION['user'] = $user;
		}
	}

	echo $message;

?>
