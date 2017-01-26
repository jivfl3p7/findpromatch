<?php
  session_start();
  include 'controller/config.php';

  if(@$_SESSION['user']['role'] != "admin"){
    header("location:index.php");
  }

  $ref = "postmatchreq.php";

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

      #contentdata{
        padding-bottom: 400px;
      }

   	</style>
   </head>
   <body>

     <?php include 'template/navsidemenu.php'; ?>

     <div id="content">

       <div class="content-header">
         <div class="content-title">
             <h2>POST-MATCH REQUEST</h2>
         </div>
       </div>

       <div id="contentlist">

         <div class="row">
           <div id="contentdata" class="content-left col-sm-10">

           </div>

           <div class="content-tabs col-sm-2">
             <ul class="nav nav-pills nav-pills-info" role="tablist">
             	<li class="active">
             		<a id="unacctab" role="tab" data-toggle="tab">
             			<i class="fa fa-list fa-lg"></i>
             			Queue
             		</a>
             	</li>
               <br>
             	<li>
             		<a id="acctab" role="tab" data-toggle="tab">
             			<i class="fa fa-check fa-lg"></i>
             			Accepted
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
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
   	<script type="text/javascript" src="assets/js/material.min.js"></script>
   	<script type="text/javascript" src="assets/js/material-kit.js"></script>
   	<script type="text/javascript" src="assets/js/notify.min.js"></script>
    <script type="text/javascript" src="assets/js/flatpickr.min.js"></script>
    <script type="text/javascript">
        $.notify.defaults({position:"top center"})

        var contentData = $('#contentdata');
        var loading = $('#loading');

        $(document).ready(function(){
            $.get('controller/getRequestList.php?acc=0',function(data){
              contentData.html(data);
              loading.hide();
            })

        })

        $('#unacctab').on("click", function(){
          contentData.html('');

          loading.show();

          $.get('controller/getRequestList.php?acc=0', function(data){
            loading.hide();
            contentData.html(data);
          })
        })

        $('#acctab').on("click", function(){
          contentData.html('');

          loading.show();

          $.get('controller/getRequestList.php?acc=1', function(data){
            loading.hide();
            contentData.html(data);
          })
        })

        $('.collapse').collapse({
     			toggle: false
     		});

    </script>
   </body>
 </html>
