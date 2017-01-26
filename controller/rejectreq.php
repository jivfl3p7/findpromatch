<?php
  session_start();
  include 'config.php';

  if(!@$_GET['id']){
    header("location:../postmatchreq.php");
  }

  $reqid = $_GET['id'];

  $connection->query("UPDATE requests SET accepted = -1 WHERE request_id='$reqid'");

  header("location:../postmatchreq.php");

 ?>
