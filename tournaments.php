<?php
	session_start();
	include("controller/config.php");

	if(!@$_GET['cat']){
		header('location:tournaments.php?cat=csgo');
	}

	$cat = $_GET['cat'];
	$ref = "tournaments.php";
	$refpage = "tournaments.php?cat=".$cat;

	$currdate = date("Y-m-d H:i:s");
	$currdate = new DateTime($currdate);

 ?>


<html>
<head>
	<title>Matchmaking | ProFindMatch</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/material-kit.css">
	<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Kanit:300" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<style type="text/css">
		body,h1,h2,h3,h4{
			font-family: 'Kanit', sans-serif;
		}
	</style>


</head>
<body>

	<?php include("template/navsidemenu.php"); ?>

	<div id="content">

		<div class="content-header">
			<div class="content-title">
				<h2>TOURNAMENTS</h2>
			</div>
			<div class="category-bar">
				<a href="tournaments.php?cat=csgo" class="category-list first <?php if($cat == "csgo"){ echo 'active'; }?>">
					<div>
						<img src="assets/img/icon/csgo.png" width="30px" class="img-rounded">&nbsp;&nbsp;Counter-Strike: Global Offensive
					</div>
				</a>
				<a href="tournaments.php?cat=dota2" class="category-list <?php if($cat == "dota2"){ echo 'active'; }?>" style="padding-bottom:19px;">
					<div>
						<img src="assets/img/icon/dota2.png" width="30px" class="img-rounded">&nbsp;&nbsp;Dota 2
					</div>
				</a>

			</div>
		</div>

		<div id="matchlist" class="row">
			<input type="hidden" id="category" value="<?php echo $cat; ?>">
			<div class="row">

				<div id="contentdata" class="content-left col-sm-10">


				</div>

				<div class="content-tabs col-sm-2">
					<ul class="nav nav-pills nav-pills-info" role="tablist">
						<li class="active">
							<a id="upcomingtab" role="tab" data-toggle="tab">
								<i class="fa fa-list fa-lg"></i>
								Upcoming
							</a>
						</li>
						<br>
						<li>
							<a id="historytab" role="tab" data-toggle="tab">
								<i class="fa fa-clock-o fa-lg"></i>
								History
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
	<script type="text/javascript" src="assets/js/notify.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/material.min.js"></script>
	<script type="text/javascript" src="assets/js/material-kit.js"></script>
	<script type="text/javascript">
		var contentData = $('#contentdata');
		var loading = $('#loading');
		var category = $('#category').val();

		$(document).ready(function(){
				contentData.html('');
				loading.show();

				$.get('controller/getTournamentList.php?cat='+category+'&status=upcoming', function(data){
						loading.hide();
						contentData.html(data);
				})

		})

		$('#upcomingtab').click(function(){
			contentData.html('');
			loading.show();

			$.get('controller/getTournamentList.php?cat='+category+'&status=upcoming', function(data){
					loading.hide();
					contentData.html(data);
			})
		})

		$('#historytab').click(function(){
			contentData.html('');
			loading.show();

			$.get('controller/getTournamentList.php?cat='+category+'&status=complete', function(data){
					loading.hide();
					contentData.html(data);
			})
		})


		$.notify.defaults({
			position: "top center",
			autoHide: 3000
		})

		/*$('#confirmation').submit(function(event){
	    var $form = $(this);
	    var $inputs = $form.find("input, select, button, textarea");
	    var serializedData = $form.serialize();

	    $.post('controller/joinTournament.php', serializedData, function(response){
	      if(response == "Join Tournament success"){
	        setTimeout(function(){
	             location.reload();
	        }, 3000);

	        $.notify("Success", "success");
	      }else{
	        $.notify("Success", "success");
	      }
	      return false;
	    })
	  })*/

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

		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		});

	</script>

</body>
</html>
