<?php
  session_start();
  include 'config.php';

  $content = $_POST['postcontent'];
  $matchid = $_POST['matchid'];

  if(strlen($content) < 1 || strlen($content) > 255){
    echo 'Post content must be between 1-255 characters';
  }else{
    $connection->query("INSERT INTO posts (thread_id, user_id, content) VALUES ('$matchid','$useridsession','$content')");

    echo 'Posted';
  }

 ?>
