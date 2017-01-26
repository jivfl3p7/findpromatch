<?php
	session_start();
	include("controller/config.php");

	$refpage = "index.php";
	$ref = $refpage;
?>
<html>
<head>
	<title>Home | FindProMatch</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/material-kit.css">
	<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Kanit:300" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<script type="text/javascript" src="assets/js/modernizr.js"></script>

	<style type="text/css">
		body,h1,h2,h3,h4{
			font-family: 'Kanit', sans-serif;
		}
	</style>


</head>
<body>

	<?php include("template/navsidemenu.php"); ?>

	<div id="content">

		<div class="home-header">
			<h1>FindProMatch</h1>
			<section class="cd-intro">
				<h1 class="cd-headline zoom">
					<span>Find your </span>
					<span class="cd-words-wrapper text-center">
						<b class="is-visible">different</b>
						<b>new</b>
						<b>fun</b>
					</span>
					<span> experience</span>
				</h1>
			</section> <!-- cd-intro -->
		</div>

		<div id="carouselHome" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#carouselHome" data-slide-to="0" class="active"></li>
				<li data-target="#carouselHome" data-slide-to="1"></li>
				<li data-target="#carouselHome" data-slide-to="2"></li>
				<li data-target="#carouselHome" data-slide-to="3"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<img src="assets/img/banner/pic1.jpg" alt="..." class="item-pic">
					<div class="carousel-caption">

					</div>
				</div>
				<div class="item">
					<img src="assets/img/banner/pic2.jpg" alt="..." class="item-pic">
					<div class="carousel-caption">

					</div>
				</div>
				<div class="item">
					<img src="assets/img/banner/pic3.jpg" alt="..." class="item-pic">
					<div class="carousel-caption">

					</div>
				</div>
				<div class="item">
					<img src="assets/img/banner/pic4.jpg" alt="..." class="item-pic">
					<div class="carousel-caption">

					</div>
				</div>
			</div>

			<!-- Controls -->
			<a class="left carousel-control" href="#carouselHome" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carouselHome" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

		<div id="navigator" class="text-center">
			<a href="javascript:;" id="scrollToBottom"><i class="fa fa-angle-down fa-4x" aria-hidden="true"></i></a>
		</div>

		<div class="features">
			<div class="feat-wrapper">
				<div class="mm-feat">
					<h3>MATCHMAKING</h3>
					&nbsp;&nbsp;&nbsp;&nbsp;Find more exciting & fun with our friendly matchmaking against other teams and makes your team #1 on community!
					<div class="feat-btn text-center">
						<a href="mm.php" class="btn btn-info">GET INTO THE FIELD</a>
					</div>
				</div>
				<div class="divider"></div>
				<div class="tour-feat">
					<h3>TOURNAMENT</h3>
					&nbsp;&nbsp;&nbsp;&nbsp;Join our tournament events and win various prizes and prove your team's skill & beat 'em all ! <br><br>
					<div class="feat-btn text-center">
						<a href="tournaments.php" class="btn btn-info">JOIN NOW</a>
					</div>
				</div>
			</div>
		</div>

		<?php include 'template/footer.html'; ?>

	</div>


	<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="assets/js/headline.js"></script>
	<script type="text/javascript" src="assets/js/date.js"></script>
	<script type="text/javascript" src="assets/js/jquery-time-status.js"></script>
	<script type="text/javascript" src="assets/js/notify.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/material.min.js"></script>
	<script type="text/javascript" src="assets/js/material-kit.js"></script>
	<script type="text/javascript">
		$(function () {
        $('#scrollToBottom').bind("click", function () {
            $('html, body').animate({ scrollTop: $(document).height() }, 3000);
            return false;
        });
    });

		$.notify.defaults({
			position: "top center",
			autoHide: 3000
		})

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

  	$('.carousel').carousel({
			interval: false
		});

		$('.collapse').collapse({
			toggle: false
		});

		$('#login').modal(options);

	</script>

</body>
</html>
