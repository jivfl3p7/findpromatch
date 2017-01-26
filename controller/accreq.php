<?php
  session_start();
  include 'config.php';

  $reqid = $_GET['id'];
  $ss = $connection->query("SELECT screenshot FROM requests WHERE request_id='$reqid'");
  $ss = $ss->fetch_assoc();
  $ss = $ss['screenshot'];

  $game = $_GET['game'];

  $message = "";

    $score1 = $_GET['score1'];
    $score2 = $_GET['score2'];

    $gameid = $_GET['gameid'];

    $match = $connection->query("SELECT * FROM threads WHERE id='$gameid'");
    $match = $match->fetch_assoc();

    $t1id = $match['team_1_id'];
    $t2id = $match['team_2_id'];

    if($score1 == 0 && $score2 == 0){
      $message = "Don't input both 0 point";
    }else if($game == "dota2"){

      if($score1 == $score2){
        $message = "Dota 2 result mustn't be draw";
      }else{
        // kalau team 1 menang
        if($score1 > $score2){
          $connection->query("UPDATE teams SET windota=windota+1 WHERE id='$t1id'");
          $connection->query("UPDATE teams SET losedota=losedota+1 WHERE id='$t2id'");
        }
        // kalau team 2 menang
        else{
          $connection->query("UPDATE teams SET windota=windota+1 WHERE id='$t2id'");
          $connection->query("UPDATE teams SET losedota=losedota+1 WHERE id='$t1id'");
        }
      }

      $connection->query("UPDATE requests SET accepted = 1 WHERE request_id='$reqid'");
      $message = "Request accepted";

      $connection->query("UPDATE threads SET score_1='$score1',score_2='$score2', screenshot='$ss', status='finished' WHERE id='$gameid'");

    }
    // GAME CSGO
    else{
      // kalau team 1 menang
      if($score1 > $score2){
        $connection->query("UPDATE teams SET wincsgo=wincsgo+1 WHERE id='$t1id'");
        $connection->query("UPDATE teams SET losecsgo=losecsgo+1 WHERE id='$t2id'");
      }
      // kalau team 2 menang
      else if($score1 < $score2){
        $connection->query("UPDATE teams SET wincsgo=wincsgo+1 WHERE id='$t2id'");
        $connection->query("UPDATE teams SET losecsgo=losecsgo+1 WHERE id='$t1id'");
      }else{
        $connection->query("UPDATE teams SET drawcsgo=drawcsgo+1 WHERE id='$t2id'");
        $connection->query("UPDATE teams SET drawcsgo=drawcsgo+1 WHERE id='$t1id'");
      }

      $connection->query("UPDATE requests SET accepted = 1 WHERE request_id='$reqid'");
      $message = "Request accepted";

      $connection->query("UPDATE threads SET score_1='$score1',score_2='$score2', screenshot='$ss', status='finished' WHERE id='$gameid'");

    }

  echo $message;

 ?>
