<?php
	$host = "localhost";
	$username = "root";
	$password = "";
	$database = "esportsmm";

	$connection = new mysqli($host, $username, $password, $database);

	$useridsession = 0;
	$username = "";
	$emailsession = "";
	$role = "";
	$teamidsession = -1;
	$teamname = "";
	$teamexp = 0;
	$teamlv = 0;
	$lvpercent = 0.00;

	if(@$_SESSION['user']){
		$useridsession = $_SESSION['user']['user_id'];
		$username = $_SESSION['user']['username'];
		$emailsession = $_SESSION['user']['email'];
		$role = $_SESSION['user']['role'];

		$team = $connection->query("SELECT id, nama_team, exp FROM teams WHERE user_id = '$useridsession'");
		$team = $team->fetch_assoc();

		$teamidsession = $team['id'];
		$teamname = $team['nama_team'];
		$teamexp = $team['exp'];

		//LEVEL 1 = 0 - 700 XP
	  if($team['exp'] >= 0 && $team['exp'] <= 700){
	      $teamlv = 1;
	      $lvpercent = $team['exp'] / 700 * 100;
	      $lvpercent = round($lvpercent, 2);
	  }
	  //LEVEL 2 = 701 - 2000 XP
	  else if($team['exp'] > 700 && $team['exp'] <= 2000){
	      $teamlv = 2;
	      $lvpercent = ($team['exp']-700) / 1300 * 100;
	      $lvpercent = round($lvpercent, 2);
	  }
	  // LEVEL 3 = 2001 - 3500 XP
	  else if($team['exp'] > 2000 && $team['exp'] <= 3500){
	      $teamlv = 3;
	      $lvpercent = ($team['exp']-2000) / 1500 * 100;
	      $lvpercent = round($lvpercent, 2);
	  }
	  // LEVEL 4 = 3501 - 6000 XP
	  else if($team['exp'] > 3500 && $team['exp'] <= 6000){
	      $teamlv = 4;
	      $lvpercent = ($team['exp']-3500) / 2500 * 100;
	      $lvpercent = round($lvpercent, 2);
	  }
	  // LEVEL 5 = >6000 XP
	  else{
	    $teamlv = 5;
	    $lvpercent = 100.00;
	  }

		if($lvpercent < 7.00){
			$lvpercent = 7.00;
		}

	}

	$challonge_username = "winfrx";
	$challonge_apikey = "eLx8DFQ6umrtQRRCvB4Vw85kQAcdO40nVztK4uTJ";

?>
