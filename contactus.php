<?php
  session_start();
  include ('controller/config.php');

  $ref = "contactus.php";

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

      #contentdata{
        padding: 60px 100px 200px 100px;
        height: 100%;
      }
  	</style>
  </head>
  <body>

    <?php include 'template/navsidemenu.php'; ?>

    <div id="content">
      <div class="content-header">
        <div class="content-title">
          <h2>CONTACT US</h2>
        </div>
      </div>

      <div id="contentlist">
        <div class="row">

          <div id="contentdata" class="content-left col-sm-10">
              <h4>
                <div class="row">
                  <img src="assets/img/icon/fb.png" width="20px" height="20px" alt="">
                  &nbsp;&nbsp;&nbsp;/FindProMatch
                </div>
                <br>
                <div class="row">
                  <img src="assets/img/icon/wa.png" width="20px" height="20px" alt="">
                  &nbsp;&nbsp;&nbsp;+62 859 6672 4477
                </div>
              </h4>
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
      $('#loginform').submit(function(event){
          var $form = $(this);
          var $inputs = $form.find("input, select, button, textarea");
          var serializedData = $form.serialize();
          var success = 0;

          $inputs.prop("disabled", true);

          $.post('controller/doLogin.php', serializedData, function(response) {
            if(response == "Login success"){
              setTimeout(function(){
                   location.reload();
              }, 1500);

              $.notify("Redirecting...", "success");

            }else{
              $inputs.prop("disabled", false);
              $.notify(response, "error");
            }
          }).fail(function(){ $.notify("failed", "error"); $inputs.prop("disabled", false); });

          return false;
      });

      $('#registerform').submit(function(event){
          var $form = $(this);
          var $inputs = $form.find("input, select, button, textarea");
          var serializedData = $form.serialize();
          var success = 0;

          $inputs.prop("disabled", true);

          $.post('controller/doRegister.php', serializedData, function(response) {
            if(response == "Register success"){
              setTimeout(function(){
                   location.reload();
              }, 3000);

              $.notify("Register success", "success");

            }else{
              $inputs.prop("disabled", false);
              $.notify(response, "error");
            }
          }).fail(function(){ $.notify("failed", "error"); });

          return false;
      });

      $('.collapse').collapse({
        toggle: false
      });

      $('#login').modal(options);

  	</script>

  </body>
</html>
