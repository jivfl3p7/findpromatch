<?php
  session_start();
  include ('controller/config.php');

  if(!@$_SESSION['user']){
    header("location:index.php");
  }

  $ref = "team";

  $teamid = $teamidsession;

  $team = $connection->query("SELECT * FROM teams WHERE id= '$teamid'");
  if($team->num_rows == 0){
    header("location:team.php?id=".$teamidsession);
  }

  $team = $team->fetch_assoc();

  $currteamlv = 0;
  $currlvpercent = 0;

  //LEVEL 1 = 0 - 700 XP
  if($team['exp'] >= 0 && $team['exp'] <= 700){
      $currteamlv = 1;
      $currlvpercent = $team['exp'] / 700 * 100;
      $currlvpercent = round($currlvpercent, 2);
  }
  //LEVEL 2 = 701 - 2000 XP
  else if($team['exp'] > 700 && $team['exp'] <= 2000){
      $currteamlv = 2;
      $currlvpercent = ($team['exp']-700) / 1300 * 100;
      $currlvpercent = round($currlvpercent, 2);
  }
  // LEVEL 3 = 2001 - 3500 XP
  else if($team['exp'] > 2000 && $team['exp'] <= 3500){
      $currteamlv = 3;
      $currlvpercent = ($team['exp']-2000) / 1500 * 100;
      $currlvpercent = round($currlvpercent, 2);
  }
  // LEVEL 4 = 3501 - 6000 XP
  else if($team['exp'] > 3500 && $team['exp'] <= 6000){
      $currteamlv = 4;
      $currlvpercent = ($team['exp']-3500) / 2500 * 100;
      $currlvpercent = round($currlvpercent, 2);
  }
  // LEVEL 5 = >6000 XP
  else{
    $currteamlv = 5;
    $currlvpercent = 100.00;
  }

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php if($teamid == $teamidsession){echo 'My Team';}else{ echo $team["nama_team"]; } ?> | ProFindMatch</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="assets/css/material-kit.css">
  	<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
  	<link href="https://fonts.googleapis.com/css?family=Kanit:300" rel="stylesheet">
  	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

  	<style type="text/css">
  		body,h1,h2,h3,h4{
  			font-family: 'Kanit', sans-serif;
  		}

      .container td:nth-child(2) a{
        text-decoration: none;
        color: #A9CF54;
      }
  	</style>
  </head>
  <body>

    <?php include 'template/navsidemenu.php'; ?>

    <input type="hidden" id="teamid" value="<?php echo $teamid; ?>">

    <div id="content">
      <div class="team-header">
        <div class="content-title">
            <h1><?php echo $team['nama_team']; ?></h1>
            <div class="teamlvbar">
              <div class="shield col-sm-2">
                <h3>
                  <i class="fa fa-shield fa-lg" aria-hidden="true"></i> <?php echo $currteamlv; ?>
                </h3>
              </div>
              <div class="expbar col-sm-10">
                <div class="progress">
                  <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $currlvpercent; ?>%">
                    <span class="sr-only"></span>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>

      <div id="contentlist">
        <div class="row">

          <div id="contentdata" class="content-left col-sm-10">

          </div>

          <div class="content-tabs col-sm-2">
            <ul class="nav nav-pills nav-pills-info" role="tablist">
            	<li class="active">
            		<a id="charttab" role="tab" data-toggle="tab">
            			<i class="fa fa-pie-chart fa-lg"></i>
            			Matchmaking Record
            		</a>
            	</li>
              <br>
            	<li>
            		<a id="teamtab" role="tab" data-toggle="tab">
            			<i class="fa fa-users fa-lg"></i>
            			Team
            		</a>
            	</li>
              <br>
            	<li>
            		<a id="trophytab" role="tab" data-toggle="tab">
            			<i class="fa fa-trophy fa-lg"></i>
            			Tournament History
            		</a>
            	</li>
            </ul>
          </div>

          <div id="loading" class="loading-screen text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
            <div class="text">
                Loading...
            </div>
          </div>

        </div>

      </div>

      <?php include 'template/footer.html'; ?>
    </div>

    <script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
  	<script type="text/javascript" src="assets/js/date.js"></script>
  	<script type="text/javascript" src="assets/js/jquery-time-status.js"></script>
    <script type="text/javascript" src="assets/js/d3.min.js"></script>
    <script type="text/javascript" src="assets/js/donutchart.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  	<script type="text/javascript" src="assets/js/material.min.js"></script>
  	<script type="text/javascript" src="assets/js/material-kit.js"></script>
  	<script type="text/javascript">
      var teamid = $('#teamid').val();

      var contentData = $('#contentdata');
      var loading = $('#loading');

      $(document).ready(function(){
        $.get('controller/getRecordTeam.php?id='+teamid, function(data){
          loading.hide();
          contentData.html(data);
        });

      })

      $('#charttab').click(function(){
        contentData.html('');
        loading.show();

        $.get('controller/getRecordTeam.php?id='+teamid, function(data){
          loading.hide();
          contentData.html(data);
        })

      })

      $('#teamtab').click(function(){
        contentData.html('');
        loading.show();

        $.get('controller/getPlayerTeam.php?id='+teamid, function(data){
          loading.hide();
          contentData.html(data);
        })

      })

      $('#trophytab').click(function(){
        contentData.html('');
        loading.show();

        $.get('controller/getHistoryTeam.php?id='+teamid, function(data){
          loading.hide();
          contentData.html(data);
        })

      })


  		$('.collapse').collapse({
  			toggle: false
  		});

  		$('#login').modal(options);


  	</script>

  </body>
</html>
