<?php
	session_start();

	unset($_SESSION['user']);
	unset($_SESSION['team']);

	header("location:../index.php");
?>
