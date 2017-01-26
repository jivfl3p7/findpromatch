<?php
    session_start();
    include("config.php");
    setlocale(LC_ALL,'en_US.UTF-8');

    $cat = $_POST['cat'];    // csgo & dota2
    $from = $_POST['from'];  // mm = MATCHMAKING & tour = TOURNAMENT
    $threadid = $_POST['matchid'];
    $err = "";


    if(isset($_FILES['screenshot'])){

        $file_name = $_FILES['screenshot']['name'];
        $file_size =$_FILES['screenshot']['size'];
        $file_tmp =$_FILES['screenshot']['tmp_name'];
        $file_type=$_FILES['screenshot']['type'];
        $pop = explode('.',$_FILES['screenshot']['name']);
        $file_ext=strtolower(end($pop));

        $expensions= array("jpeg","jpg");

        if(in_array($file_ext,$expensions) === false){
           $err = "Only JPEG or JPG extension are allowed";
        }else if($file_size > (1024000*5)){
           $err = "Max image size is 5MB";
        }

        if($err == ""){
            move_uploaded_file($file_tmp,"../assets/img/uploads/".$file_name);
            $connection->query("INSERT INTO requests (room_id, user_id, team_id, game, category, screenshot)
                VALUES ('$threadid','$useridsession','$teamidsession','$cat','$from','$file_name')");

            $err = "Request sent";

        }
    }else{
        $err = "Please upload an image";
    }

    header("location:../mmdetail.php?id=".$threadid."&err=".$err);

?>
