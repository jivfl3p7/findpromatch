<?php

$tournament_id = $_GET['id'];

include('config.php');
include('challonge.class.php');
$c = new ChallongeAPI($challonge_apikey);
$c->verify_ssl = false;

$uniqueid = $connection->query("SELECT uniqueid id FROM tournaments WHERE id='$tournament_id'");
$uniqueid = $uniqueid->fetch_assoc();
$uniqueid = $uniqueid['id'];

$participants = $c->makeCall("tournaments/$uniqueid/participants/randomize", array(), "post");
$participants = $c->randomizeParticipants($uniqueid);


header("location:../managetournament.php");

?>
