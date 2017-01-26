<?php
  session_start();
  include 'config.php';

  $matchid = $_GET['matchid'];

  $connection->query("UPDATE threads SET team_2_id='$teamidsession', status='playing' WHERE id='$matchid'");

  header("location:../mmdetail.php?id=".$matchid);
 ?>
