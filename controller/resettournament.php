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
$tournament = $c->makeCall("tournaments/reset/$uniqueid", $params, "post");
$tournament = $c->resetTournament($uniqueid, $params);

$connection->query("UPDATE tournaments SET finishtime='0000-00-00 00:00:00', status='pending' WHERE uniqueid='$uniqueid'");
$connection->query("DELETE FROM tournament_history WHERE tournamentid='$tournament_id'");

header("location:../managetournament.php");

?>
