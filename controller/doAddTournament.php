<?php

include('config.php');
include('challonge.class.php');
$c = new ChallongeAPI($challonge_apikey);
$c->verify_ssl = false;

$tname = $_POST['tname'];
$ttype = $_POST['ttype'];
$uniqueid = $_POST['tid'];
$desc = $_POST['tdesc'];
$opensignup = isset($_POST['opensignup']);
$thirdplace = isset($_POST['3rdplace']);
$rankedby = $_POST['trankedby'];
$signupcap = $_POST['maxcap'];
$start_at = $_POST['start_time'];
$gamecat = $_POST['gamecat'];
$img = "cover/";

$tour_exist = $connection->query("SELECT * FROM tournaments WHERE name='$tname' OR uniqueid='$uniqueid'");

if(strlen($tname) < 1 || strlen($tname) > 60) {
    $msg = "Tournament Name must be 1-60 characters";
}else if(strlen($uniqueid) < 6){
    $msg = "Unique ID minimal 6 characters (alphanumeric)";
}else if($tour_exist->num_rows != 0){
    $msg = "Tournament Name or Unique ID already exists";
}else if($start_at == ""){
    $msg = "Please select start date and time";
}else {
    $params = array(
        "tournament[name]" => $tname,
        "tournament[tournament_type]" => $ttype,
        "tournament[url]" => $uniqueid,
        "tournament[description]" => $desc,
        "tournament[open_signup]" => $opensignup,
        "tournament[hold_third_place_match]" => $thirdplace,
        "tournament[ranked_by]" => $rankedby,
        "tournament[signup_cap]" => $signupcap,
        "tournament[start_at]" => $start_at,
        "tournament[game_name]" => $gamecat
    );

    $tournament = $c->makeCall("tournaments", $params, "post");
    $tournament = $c->createTournament($params);

    if($gamecat == "Dota 2"){
        $gamecat = "dota2";
        $img .= "dota.jpg";
    }else{
        $gamecat = "csgo";
        $img .= "csgo.jpg";
    }

    $query = $connection->query("INSERT INTO tournaments (uniqueid, name, category, participant, starttime, description)
    VALUES('$uniqueid', '$tname', '$gamecat', '$signupcap', '$start_at', '$desc')");

    $msg = "Create Tournament success!";
}

echo $msg;

?>
