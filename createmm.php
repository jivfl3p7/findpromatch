<?php
  session_start();
  include 'controller/config.php';

  if(@$_SESSION['user']['role'] == "admin" || !@$_SESSION['user']){
    header("location:tournaments.php");
  }

  if(!@$_GET['cat']){
    header("location:mm.php");
  }

  $cat = $_GET['cat'];

  $ref = "mm.php";

 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>New Match | ProFindMatch</title>
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

      .text-black{
        color:black;
      }
   	</style>
   </head>
   <body>

     <?php include 'template/navsidemenu.php'; ?>

     <div id="content">
       <div class="content-header">
         <div class="content-title">
             <h2>CREATE MATCH</h2>
         </div>
       </div>

       <div id="contentlist">

         <div class="row">

           <div class="newtourform">
             <form id="matchform" method="post">
               <input type="hidden" id="cat" name="category" value="<?php echo $cat; ?>">
               <table>
                 <tr>
                   <td>Game</td>
                   <td><input type="text" class="form-control" value="<?php if($cat == "csgo"){ echo 'Counter-Strike: Global Offensive'; }else{ echo 'Dota 2'; } ?> [Bo1]" readonly></td>
                 </tr>
                  <tr>
                    <td>Server</td>
                    <td>
                      <select class="form-control" name="serverid">
                        <?php
    				  					$result = $connection->query("SELECT * FROM server_name");

    				  					while($data = $result->fetch_assoc()){
    				  						?>
    				  						<option style="color:black" value="<?php echo $data['id']; ?>"><?php echo $data["name"]." (".$data["ip"].")" ?></option>
    				  						<?php
    				  					}
    				  					?>
                      </select>
                    </td>
                  </tr>
                  <?php if($cat == "csgo"){ ?>
                  <tr>
                    <td>Map</td>
                    <td>
                      <select name="mapname" class="form-control">
						  					<option class="text-black" value="dust2">Dust2</option>
						  					<option class="text-black" value="mirage">Mirage</option>
						  					<option class="text-black" value="train">Train</option>
						  					<option class="text-black" value="cache">Cache</option>
						  					<option class="text-black" value="cobblestone">Cobblestone</option>
						  					<option class="text-black" value="overpass">Overpass</option>
						  					<option class="text-black" value="nuke">Nuke</option>
						  				</select>
                    </td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <td>Match Time</td>
                    <td><input id="myID" name="start_time" class="form-control flatpickr" placeholder="Match Time" data-format="MM/dd/yyyy HH:mm:ss PP" type="text"></td>
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

        $('#matchform').submit(function(event){
            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var serializedData = $form.serialize();
            var success = 0;

            $inputs.prop("disabled", true);

            $.post('controller/doAddMatch.php', serializedData, function(response) {
              if(response == "Match created"){
                setTimeout(function(){
                  window.location.href = "mm.php?cat="+$('#cat').val();
                }, 2000)

                $.notify("Match created", "success");

              }else{
                $inputs.prop("disabled", false);
                $.notify(response, "error");
              }
            }).fail(function(){ $.notify("Failed", "error"); });

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
