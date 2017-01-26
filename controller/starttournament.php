<?php

$tournament_id = $_GET['id'];

include('config.php');
include('challonge.class.php');
$c = new ChallongeAPI($challonge_apikey);
$c->verify_ssl = false;

$uniqueid = $connection->query("SELECT uniqueid id FROM tournaments WHERE id='$tournament_id'");
$uniqueid = $uniqueid->fetch_assoc();
$uniqueid = $uniqueid['id'];

$params = array();
$tournament = $c->makeCall("tournaments/start/$uniqueid", $params, "post");
$tournament = $c->startTournament($uniqueid, $params);

$connection->query("UPDATE tournaments SET status='underway' WHERE uniqueid='$uniqueid'");

header("location:../managetournament.php");

?>
