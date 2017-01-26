<?php
  session_start();
  include 'config.php';

  include 'challonge.class.php';
  $c = new ChallongeAPI($challonge_apikey);
  $c->verify_ssl = false;

  $cat = "";
  $message = "";

  if(!@$_GET['tid']){
    $message = 'Failed connect to server';
  }else{
    $tid = $_GET['tid'];
    $cat = $_GET['cat'];

    $tournament = $connection->query("SELECT uniqueid FROM tournaments WHERE id='$tid'");
    $tournament_id = $tournament->fetch_assoc();
    $tournament_id = $tournament_id['uniqueid'];

    $params = array(
      "participant[name]" => $teamname,
      "participant[seed]" => "1",
      "participant[misc]" => $useridsession
    );
    $participant = $c->makeCall("tournaments/$tournament_id/participants", $params, "post");
    $participant = $c->createParticipant($tournament_id, $params);

    $connection->query("INSERT INTO participants (tournamentid, userid) VALUES ('$tid', '$useridsession')");

    $message = 'Join Tournament success';
  }

    if($message == "Join Tournament success"){

      header("location:../tournamentdetail.php?id=".$tid);

    }else{
      echo $message;
    }

 ?>
