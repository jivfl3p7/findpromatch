<?php
	session_start();
	include("config.php");

	$serverid = $_POST['serverid'];
	$map = "";
	$category = $_POST['category'];
	$starttime = $_POST['start_time'];

	if($category == "csgo"){
		$map = $_POST['mapname'];
	}

	$message = "";

	if($starttime == ""){
		$message = "Please fill Match Time";
	}else{
		$query = $connection->query("INSERT INTO threads (server_id, team_1_id, team_2_id, score_1, score_2, start_time, map, status, category)
			VALUES ('$serverid','$teamidsession',0,0,0,'$starttime','$map','waiting','$category')");

		$newmatchid = $connection->query("SELECT MAX(id) FROM threads");
		$newmatchid = $newmatchid->fetch_assoc();
		$newmatchid = $newmatchid['MAX(id)'];

		$message = "Match created";
	}

	echo $message;

?>
