<?php

$tournament_id = $_GET['id'];

include('config.php');
include('challonge.class.php');
$c = new ChallongeAPI($challonge_apikey);
$c->verify_ssl = false;

$uniqueid = $connection->query("SELECT uniqueid id FROM tournaments WHERE id='$tournament_id'");
$uniqueid = $uniqueid->fetch_assoc();
$uniqueid = $uniqueid['id'];

$tournament = $c->makeCall("tournaments/$uniqueid", array(), "delete");
$tournament = $c->deleteTournament($uniqueid);

$connection->query("DELETE FROM tournaments WHERE uniqueid='$uniqueid'");

header("location:../managetournament.php");

?>
