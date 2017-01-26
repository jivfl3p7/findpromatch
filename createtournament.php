<?php
  session_start();
  include 'controller/config.php';

  if(@$_SESSION['user']['role'] != "admin"){
    header("location:tournaments.php");
  }

  $ref = "tournaments.php";

 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>New Tournament | ProFindMatch</title>
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
   	</style>
   </head>
   <body>

     <?php include 'template/navsidemenu.php'; ?>

     <div id="content">
       <div class="content-header">
         <div class="content-title">
             <h2>CREATE TOURNAMENT</h2>
         </div>
       </div>

       <div id="contentlist">

         <div class="row">

           <div class="newtourform">
             <form id="tournamentform" method="post">
               <input type="hidden" name="ttype" value="single elimination">
               <input type="hidden" name="trankedby" value="game wins">
               <table>
                  <tr>
                    <td>Name</td>
                    <td><input type="text" name="tname" class="form-control"></td>
                  </tr>
                  <tr>
                    <td>Unique ID</td>
                    <td><input type="text" name="tid" class="form-control"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td style="padding: 20px 15px;">
                      <label for=""><input type="checkbox" name="3rdplace"> 3rd Place</label>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <label for=""><input type="checkbox" name="opensignup"> Open Sign-Up</label>
                    </td>
                  </tr>
                  <tr>
                    <td>Max Participants</td>
                    <td><input type="number" name="maxcap" class="form-control" value="4" min="4" max="256" step="1"></td>
                  </tr>
                  <tr>
                    <td>Game Category</td>
                    <td>
                      <select class="form-control" name="gamecat">
                        <option style="color:black" value="Counter-Strike: Global Offensive">CS:GO</option>
                        <option style="color:black" value="Dota 2">Dota 2</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Start Time</td>
                    <td><input id="myID" name="start_time" class="form-control flatpickr" placeholder="Match Time" data-format="MM/dd/yyyy HH:mm:ss PP" type="text" value=""></input></td>
                  </tr>
                  <tr>
                    <td>Description</td>
                    <td><textarea class="form-control" name="tdesc" rows="4" cols="60" max-width="100%"></textarea></td>
                  </tr>
                  <tr>
                    <td style="border:0"></td>
                    <td><button type="submit" class="btn btn-success btn-block">CREATE</button></td>
                  </tr>
               </table>
             </form>
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

        $('#tournamentform').submit(function(event){
            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var serializedData = $form.serialize();
            var success = 0;

            $inputs.prop("disabled", true);

            $.post('controller/doAddTournament.php', serializedData, function(response) {
              if(response == "Create Tournament success!"){
                $.notify("Create Tournament success!", "success");
                window.location.href = "managetournament.php";
              }else{
                $inputs.prop("disabled", false);
                $.notify(response, "error");
              }
            }).fail(function(){ $.notify("failed", "error"); });

            return false;
        });

        flatpickr(".flatpickr", {
            minDate: new Date(),
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
