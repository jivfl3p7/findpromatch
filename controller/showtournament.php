<?php
  session_start();
  include 'config.php';

  $tid = $_GET['id'];

  $connection->query("UPDATE tournaments SET active=1 WHERE id='$tid'");

  header("location:../managetournament.php");

 ?>
