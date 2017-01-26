<?php
	session_start();
	include("config.php");

	$teamname = $_POST["teamname"];
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

	if(strpos($teamname,"'") !== false){
		$message = "Team name must not contain ' character";
	}else{
		$team = $connection->query("SELECT * FROM teams WHERE nama_team='$teamname'");
		$row = $team->num_rows;

		if($teamname == ""){
			$message = "Please input your Team Name";
		}else if($row != 0){
			$message = "Team Name already exists";
		}else if($member1 == ""){
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
			$query = $connection->query("INSERT INTO teams (user_id, nama_team, nickname_1, nickname_2, nickname_3, nickname_4, nickname_5, nickname_6)
			VALUES ('$useridsession','$teamname', '$member1', '$member2','$member3','$member4','$member5','$member6')");

			$newteamid = $connection->query("SELECT MAX(id) FROM teams");
			$newteamid = $newteamid->fetch_assoc();
			$newteamid = $newteamid['MAX(id)'];

			$query = $connection->query("UPDATE users SET team_id = '$newteamid' WHERE user_id = '$useridsession'");

			$message = "Team registered";
		}
	}

	echo $message;

?>
