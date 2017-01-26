<?php
  session_start();
  include ('controller/config.php');

  if(!@$_SESSION['user']){
    header("location:index.php");
  }

  $ref = "profile.php";


 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Profile | ProFindMatch</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="assets/css/material-kit.css">
  	<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
  	<link href="https://fonts.googleapis.com/css?family=Kanit:300" rel="stylesheet">
  	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

  	<style type="text/css">
  		body,h1,h2,h3,h4{
  			font-family: 'Kanit', sans-serif;
  		}
  	</style>
  </head>
  <body>

    <?php include 'template/navsidemenu.php'; ?>

    <div id="content">
      <input type="hidden" id="teamidsession" value="<?php echo $teamidsession; ?>">
      <div class="content-header">
        <div class="content-title">
          <h2>USER PROFILE</h2>
        </div>
      </div>

      <div id="contentlist">
        <div class="row">

          <div id="contentdata" class="content-left col-sm-10">

          </div>

          <div class="content-tabs col-sm-2">
            <ul class="nav nav-pills nav-pills-info" role="tablist">
            	<li class="active">
            		<a id="personaltab" role="tab" data-toggle="tab">
            			<i class="fa fa-user fa-lg"></i>
            			Personal
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
            		<a id="historytab" role="tab" data-toggle="tab">
            			<i class="fa fa-clock-o"></i>
            			History
            		</a>
            	</li>
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
  	<script type="text/javascript" src="assets/js/notify.min.js"></script>
  	<script type="text/javascript">
    var contentData = $('#contentdata');
    var loading = $('#loading');
    var teamid = $('#teamidsession').val();

    /*var personalTab = $('#personaltab');
    var teamTab = $('#teamtab');
    var historyTab = $('#historytab');*/

    $(document).on({
      ajaxStart: function() {
        loading.show();

        /*personalTab.addClass("disabled");
        teamTab.addClass("disabled");
        historyTab.addClass("disabled");*/
      }
      /*ajaxStop: function() {
        $body.removeClass("loading");
      }*/
    });

    $(document).ready(function(){
        loading.show();
        /*personalTab.addClass("disabled");
        teamTab.addClass("disabled");
        historyTab.addClass("disabled");*/

        $.get('controller/getUserProfile.php', function(data){
          loading.hide();
          /*personalTab.addClass("disabled");
          teamTab.addClass("disabled");
          historyTab.addClass("disabled");*/

          $('#contentdata').html(data);
        })

    });

  		$('.collapse').collapse({
  			toggle: false
  		});

      $('#personaltab').on("click", function(){
        contentData.html('');

        loading.show();

        $.get('controller/getUserProfile.php', function(data){
          loading.hide();
          $('#contentdata').html(data);
        })
      })

      $('#teamtab').on("click", function(){
        contentData.html('');

        loading.show();

        $.get('controller/getTeamProfile.php', function(data){
          loading.hide();
          $('#contentdata').html(data);
        })
      })

      $('#historytab').on("click", function(){
        contentData.html('');

        loading.show();

        $.get('controller/getHistoryProfile.php', function(data){
          loading.hide();
          $('#contentdata').html(data);
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

  	</script>

  </body>
</html>
