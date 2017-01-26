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
$tournament = $c->makeCall("tournaments/$uniqueid/finalize", $params, "post");
$tournament = $c->finalizeTournament($uniqueid, $params);

$get_url = "https://api.challonge.com/v1/tournaments/".$uniqueid."/participants.json?api_key=".$challonge_apikey;
$get_url = file_get_contents($get_url);
$participants = json_decode($get_url, TRUE);

for($i=0; $i<sizeof($participants); $i++){
  $userid_part = $participants[$i]['participant']['misc'];
  $finalrank = $participants[$i]['participant']['final_rank'];

  $connection->query("INSERT INTO tournament_history (tournamentid, userid, position)
  VALUES ('$tournament_id','$userid_part','$finalrank')");
}

$connection->query("UPDATE tournaments SET finishtime=CURRENT_TIMESTAMP, status='complete' WHERE uniqueid='$uniqueid'");

header("location:../managetournament.php");

?>
