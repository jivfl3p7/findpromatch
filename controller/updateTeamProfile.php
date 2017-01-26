<?php
	session_start();
	include("config.php");

	$member1 = $_POST["nickname1"];
	$member2 = $_POST["nickname2"];
	$member3 = $_POST["nickname3"];
	$member4 = $_POST["nickname4"];
	$member5 = $_POST["nickname5"];
	$member6 = $_POST["nickname6"];

	if($member6 == ""){
		$member6 = "N/A";
	}

	$message = "";

	if($member1 == ""){
		$message = "Please input Leader's Nickname";
	}else if($member2 == ""){
		$message = "Please input 2nd Nickname";
	}else if($member3 == ""){
		$message = "Please input 3rd Nickname";
	}else if($member4 == ""){
		$message = "Please input 4th Nickname";
	}else if($member5 == ""){
		$message = "Please input 5th Nickname";
	}else{

		$query = $connection->query("UPDATE teams
			SET nickname_1 = '$member1', nickname_2 = '$member2' , nickname_3 = '$member3', nickname_4 = '$member4', nickname_5 = '$member5', nickname_6 = '$member6'
			WHERE id = '$teamidsession'");

		$message = "Team updated";
	}

	echo $message;

?>
