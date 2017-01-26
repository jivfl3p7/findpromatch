<?php
  session_start();
  include 'controller/config.php';

  if(@$_SESSION['user']['role'] != "admin"){
    header("location:tournaments.php");
  }

  $ref = "tournaments.php";

  $tournaments = $connection->query("SELECT * FROM tournaments");

 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Manage Tournament | ProFindMatch</title>
     <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
   	<link rel="stylesheet" type="text/css" href="assets/css/material-kit.css">
   	<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
   	<link href="https://fonts.googleapis.com/css?family=Kanit:300" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/flatpickr.min.css">
   	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

   	<style type="text/css">
   		body,h1,h2,h3,h4{
   			font-family: 'Kanit', sans-serif;
   		}

      #contentlist{
        overflow: hidden;
      }

      #contentlist .row{
        padding-left: 20px;
      }

      #contentlist .row .newtourform{
        padding: 30px 0;
      }

      #contentlist .row th{
        padding: 20px 15px;
        font-size: 15px;
        text-align: center;
      }

      #contentlist .row td:nth-child(2) a{
        text-decoration: none;
        color: white;
      }

      .newtourform td:first-child{
        width: 7%;
      }

      #contentlist .row td:nth-child(2)-child a:hover{
        color: #A9CF54;
      }

      #contentlist .row td:first-child, td:nth-child(2){
        color: white;
        padding: 30px;
      }

      #contentlist .row td:nth-child(2){
        width: auto;
      }
   	</style>
   </head>
   <body>

     <?php include 'template/navsidemenu.php'; ?>

     <div id="content">
       <div class="content-header">
         <div class="content-title">
             <h2>MANAGE TOURNAMENT</h2>
         </div>
       </div>

       <div id="contentlist">

         <div class="row">
           <a href="createtournament.php" class="btn btn-info"><i class="fa fa-plus fa-lg"></i>&nbsp;&nbsp;&nbsp;New Tournament</a>
           <div class="newtourform">
             <table class="container">
                <!-- STATUS : pending, underway, awaiting_review, complete  -->
                <!-- ACTION : START, FINALIZE, DELETE -->

                <!--
                    Action -> Status:
                    - if(status = pending)         | Start    -> underway
                    - if(status = awaiting_review) | Finalize -> complete
                -->

                <tr>
                  <th></th>
                  <th>Tournament Name</th>
                  <th>Category</th>
                  <th>Unique ID</th>
                  <th>Users</th>
                  <th>Start Time</th>
                  <th>Finish Time</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                <?php
                    while($tournament = $tournaments->fetch_assoc()){
                      $tid = $tournament['id'];
                      $participant = $connection->query("SELECT COUNT(id) curr FROM participants WHERE tournamentid='$tid'");
                      $p = $participant->fetch_assoc();
                 ?>
                        <tr>
                            <td>
                              <?php if($tournament['active'] == 1){ ?>
                                <a href="controller/hidetournament.php?id=<?php echo $tournament['id']; ?>"><i class="fa fa-low-vision fa-lg text-warning" title="Hide"></i></a>&nbsp;&nbsp; <!-- HIDE -->
                              <?php }else{ ?>
                                <a href="controller/showtournament.php?id=<?php echo $tournament['id']; ?>"><i class="fa fa-eye fa-lg text-success" title="Show"></i></a>&nbsp;&nbsp; <!-- SHOW -->
                              <?php } ?>
                            </td>
                            <td><a href="tournamentdetail.php?id=<?php echo $tournament['id']; ?>"><?php echo $tournament['name']; ?></a></td>
                            <td><?php echo $tournament['category']; ?></td>
                            <td><a style="text-decoration:none;color:white" href="http://challonge.com/<?php echo $tournament['uniqueid']; ?>"><?php echo $tournament['uniqueid']; ?></a></td>
                            <td class="text-center"><?php echo $p['curr'].'/'.$tournament['participant']; ?></td>
                            <td><?php echo $tournament['starttime']; ?></td>
                            <td><?php if($tournament['status'] == "complete"){ echo $tournament['finishtime']; }else{ echo '<i>N/A</i>'; } ?></td>
                            <td><?php echo $tournament['status']; ?></td>
                            <td class="text-center">
                                <?php if($tournament['status'] == "pending" && $p['curr'] == $tournament['participant']){ ?>
                                  <a href="controller/starttournament.php?id=<?php echo $tournament['id']; ?>"><i class="fa fa-play fa-lg text-success" title="Start"></i></a>&nbsp;&nbsp; <!-- START -->
                                  <br><br><a href="controller/randomizetournament.php?id=<?php echo $tournament['id']; ?>"><i class="fa fa-random fa-lg text-info" title="Randomize Seed"></i></a>&nbsp;&nbsp; <!-- RANDOMIZE PARTICIPANT SEED -->
                                <?php }else if($tournament['status'] == "underway"){ ?>
                                  <a href="controller/finalizetournament.php?id=<?php echo $tournament['id']; ?>"><i class="fa fa-stop fa-lg text-danger" title="Finalize"></i></a>&nbsp;&nbsp; <!-- FINALIZE -->
                                <?php } ?>

                                <?php
                                    if($tournament['status'] != "pending"){
                                 ?>
                                  <br><br><a href="controller/resettournament.php?id=<?php echo $tournament['id']; ?>"><i class="fa fa-refresh fa-lg text-danger" title="Reset"></i></a>&nbsp;&nbsp; <!-- RESET -->
                                <?php
                                    }
                                 ?>


                                <br><br>
                                <!--<a href="controller/deletetournament.php?id=<?php //echo $tournament['id']; ?>"><i class="fa fa-trash fa-lg text-info" title="Delete"></i></a>--> <!-- DELETE -->
                            </td>
                        </tr>
                 <?php
                    }
                  ?>
             </table>
           </div>

         </div>

       </div>

       <?php include 'template/footer.html'; ?>
     </div>

    <script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
   	<script type="text/javascript" src="assets/js/date.js"></script>
   	<script type="text/javascript" src="assets/js/jquery-time-status.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
   	<script type="text/javascript" src="assets/js/material.min.js"></script>
   	<script type="text/javascript" src="assets/js/material-kit.js"></script>
   	<script type="text/javascript" src="assets/js/notify.min.js"></script>
    <script type="text/javascript" src="assets/js/flatpickr.min.js"></script>
    <script type="text/javascript">

        $.notify.defaults({position:"top center"})

        flatpickr(".flatpickr", {
            enableTime: true
        });

        flatpickr(".selector", {}); // [Flatpickr, Flatpickr, ...]
        document.getElementById("myID").flatpickr(config); // Flatpickr
        let calendar = new Flatpickr(element, config); // Flatpickr


        $(".selector").flatpickr({}); // jQuery

        $('.collapse').collapse({
     			toggle: false
     		});

    </script>
   </body>
 </html>
