<?php
	session_start();
	include 'controller/config.php';

	if(!@$_GET['id']){
		header("location:tournaments.php");
	}

	$ref = "tournaments.php";
	$tid = $_GET['id'];

	$tour = $connection->query("SELECT * FROM tournaments WHERE id='$tid'");

	$tour = $tour->fetch_assoc();

	$currdate = date("Y-m-d H:i:s", time()+6*3600);

	$tourdate = date($tour['starttime']);

	$datenow = new DateTime($currdate);
	$date2 = new DateTime($tourdate);

	$showdate = date("jS M Y H:i \W\I\B", strtotime($tour['starttime']));

	$uniqueid = $tour['uniqueid'];

	$participated = $connection->query("SELECT * FROM participants WHERE tournamentid='$tid' AND userid='$useridsession'");
	$participants = $connection->query("SELECT * FROM participants WHERE tournamentid='$tid'");

 ?>

<html>
<head>
	<title><?php echo $tour['name']; ?> | ProFindMatch</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/material-kit.css">
	<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Kanit:300" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Exo+2:800" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<style type="text/css">
		body,h1,h2,h3,h4{
			font-family: 'Kanit', sans-serif;
		}

		.team-header{
			margin-bottom: -5em;
			overflow: hidden;
		}

		#content{
			<?php if($tour['category'] == "dota2"){ ?>
				background-image: url('assets/img/cover/dota.jpg');
			<?php }else{ ?>
				background-image: url('assets/img/cover/csgo.jpg');
			<?php } ?>
			background-size: cover;
			background-position: 0 -5em;
		}

		.team-header .matchtitle .title{
				background: rgba(71,71,71,0);
				background: -moz-linear-gradient(left, rgba(71,71,71,0) 0%, rgba(71,71,71,0.25) 40%, rgba(71,71,71,0.25) 50%, rgba(71,71,71,0.25) 60%, rgba(71,71,71,0) 100%);
				background: -webkit-gradient(left top, right top, color-stop(0%, rgba(71,71,71,0)), color-stop(40%, rgba(71,71,71,0.25)), color-stop(50%, rgba(71,71,71,0.25)), color-stop(60%, rgba(71,71,71,0.25)), color-stop(100%, rgba(71,71,71,0)));
				background: -webkit-linear-gradient(left, rgba(71,71,71,0) 0%, rgba(71,71,71,0.25) 40%, rgba(71,71,71,0.25) 50%, rgba(71,71,71,0.25) 60%, rgba(71,71,71,0) 100%);
				background: -o-linear-gradient(left, rgba(71,71,71,0) 0%, rgba(71,71,71,0.25) 40%, rgba(71,71,71,0.25) 50%, rgba(71,71,71,0.25) 60%, rgba(71,71,71,0) 100%);
				background: -ms-linear-gradient(left, rgba(71,71,71,0) 0%, rgba(71,71,71,0.25) 40%, rgba(71,71,71,0.25) 50%, rgba(71,71,71,0.25) 60%, rgba(71,71,71,0) 100%);
				background: linear-gradient(to right, rgba(71,71,71,0) 0%, rgba(71,71,71,0.25) 40%, rgba(71,71,71,0.25) 50%, rgba(71,71,71,0.25) 60%, rgba(71,71,71,0) 100%);

				line-height: 100px;
			}

			.team-header .matchtitle .title .text{
				font-size: 70px;
				font-weight: bold;
				color: white;
				text-align: center;
			}

		.live-glow span{
			width: 20px;
			height: 20px;
		}

		.loading-screen .text{
			margin-left: 1.7em;
		}

	</style>


</head>
<body>

	<?php include 'template/navsidemenu.php'; ?>

	<div id="content">
		<input type="hidden" id="uniqueid" value="<?php echo $uniqueid; ?>">

		<div class="team-header">
			<div class="matchtitle">
				<div class="title col-sm-12">
					<div class="text">
						<i class="fa fa-trophy fa-lg text-warning"></i> <?php echo $tour['name']; ?>
					</div>
				</div>
			</div>
			<div class="matchtime">
				<center><h2><?php echo $showdate; ?></h2></center>

				<?php if($tour['status'] == "underway" || $datenow > $date2 == "1"){ ?>
				<h2>
					<div class="live-glow">
						<span></span> LIVE
					</div>
				</h2>
				<?php } ?>

				<?php if($currdate < $tourdate && $tour['status'] == "pending"){ ?>
				<h4>
					COUNTDOWN
				</h4>
				<div class="timer">
					<div class="countdown" style="text-align:center">
						<span id="clock"></span>
					</div>
				</div>
				<?php } ?>


				<div class="joinbtn text-center">
					<?php if($tour['status'] == "pending" && $participated->num_rows == 0 && $participants->num_rows != $tour['participant']){ ?>
						<button type="button" data-toggle="modal" data-target="#join" class="btn btn-success">JOIN</button>
					<?php }else if($participated->num_rows == 1){ ?>
						<button type="button" class="btn btn-success" disabled>JOINED</button>
					<?php } ?>

					<?php if($tour['status'] == "underway" && $participated->num_rows == 1){ ?>
						<!--<button type="button" data-toggle="modal" data-target="#sendresult" class="btn btn-success">SEND A SCREENSHOT</button>-->
					<?php } ?>
				</div>
			</div>
		</div>

		<div id="matchlist" class="row">
			<div class="row">

				<div id="contentdata" class="content-left col-sm-10">

				</div>

				<div class="content-tabs col-sm-2">
					<ul class="nav nav-pills nav-pills-info" role="tablist">
						<li class="active">
							<a id="infotab" role="tab" data-toggle="tab">
								<i class="fa fa-info-circle fa-lg"></i>
								INFORMATION
							</a>
						</li>
						<br>
						<li>
							<a id="brackettab" role="tab" <?php if($participants->num_rows < 2){ echo 'disabled data-toggle="tooltip" data-placement="left" title="Min. 2 Participants"'; } else{ echo 'data-toggle="tab"'; } ?>>
								<i class="fa fa-list fa-lg"></i>
								Bracket
							</a>
						</li>
						<br>
						<li>
							<a id="teamtab" role="tab" data-toggle="tab">
								<i class="fa fa-users fa-lg"></i>
								Participants<h4><?php echo $participants->num_rows.'/'.$tour['participant']; ?></h4>
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

	<div class="modal fade" id="join" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><b>CONFIRMATION</b></h4>
				</div>
				<div class="modal-body">
					<center>
						<h4><?php echo $tour['name']; ?></h4><br>
						Are you sure to join this tournament?<br>
						After join, you can't unparticipate
						<br><br>
						<!--<form id="confirmation" method="post">
							<input type="hidden" name="tid" value="">
							<button type="submit" class="btn btn-success">CONFIRM</button>-->
							<a href="controller/joinTournament.php?tid=<?php echo $tour['id']; ?>&cat=<?php echo $tour['category']; ?>&ref=1" class="btn btn-success">CONFIRM</a>
							&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info" class="close" data-dismiss="modal" aria-hidden="true">CANCEL</button>
						<!--</form>-->

					</center>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade" id="sendresult" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><b>SEND RESULT</b></h4>
				</div>
				<div class="modal-body">
					<form id="sendresultform" action="controller/doSendRequest.php" method="post" enctype="multipart/form-data">
						<input type="hidden" name="cat" value="<?php echo $tour['category']; ?>">
						<input type="hidden" name="from" value="tour">
						<input type="hidden" name="matchid" value="<?php echo $tid; ?>">
						<input type="file" name="screenshot">
						<textarea name="detailmatch" class="form-control" rows="8" placeholder="Include some match detail & information (e.g. Server IP, Server Name, Time etc.)"></textarea>
						<br>
						<button type="submit" class="btn btn-info">SEND REQUEST TO ADMIN</button>
					</form>
				</div>
			</div>
		</div>
	</div>


	<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="assets/js/date.js"></script>
	<script type="text/javascript" src="assets/js/jquery-time-status.js"></script>
	<script type="text/javascript" src="assets/js/jquery.countdown.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/material.min.js"></script>
	<script type="text/javascript" src="assets/js/material-kit.js"></script>
	<script type="text/javascript" src="assets/js/notify.min.js"></script>
	<script type="text/javascript">
		var uniqueid = $('#uniqueid').val();
		var contentData = $('#contentdata');
		var loading = $('#loading');

		$(document).ready(function(){
			$.get('controller/getDetailTournament.php?id='+uniqueid, function(data){
					loading.hide();
					contentData.html(data);
			})
		})

		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		});

		$.notify.defaults({
			position: "top center",
			autoHide: 3000
		})

		$('#infotab').on("click", function(){
			contentData.html('');

			loading.show();

			$.get('controller/getDetailTournament.php?id='+uniqueid, function(data){
				loading.hide();
				$('#contentdata').html(data);
			})
		})

		<?php if($participants->num_rows >= 2){ ?>
			$('#brackettab').on("click", function(){
				contentData.html('');

				loading.show();

				$.get('controller/getBracketTournament.php?id='+uniqueid, function(data){
					loading.hide();
					$('#contentdata').html(data);
				})
			})
		<?php } ?>

		$('#teamtab').on("click", function(){
			contentData.html('');

			loading.show();

			$.get('controller/getParticipantTournament.php?tid='+<?php echo $tid; ?>, function(data){
				loading.hide();
				$('#contentdata').html(data);
			})
		})

		<?php
				if(@$_GET['err']){
					if($_GET['err'] == "Request sent"){
		?>
						$.notify("Request sent", "success");
		<?php
					}else{
		?>
						$.notify("<?php echo $_GET['err']; ?>", "error");
		<?php
					}
				}
		 ?>

		$('#confirmBtn').click(function(){
			window.location.href = "controller/joinTournament.php?tid="+<?php echo $tid; ?>;
		})

		$('#clock').countdown('<?php echo $tour["starttime"] ?>')
		.on('update.countdown', function(event) {
			var format = '%H:%M:%S';
			if(event.offset.totalDays > 0) {
				format = '%-dD ' + format;
			}
			if(event.offset.weeks > 0) {
				format = '%-wW ' + format;
			}
			$(this).html(event.strftime(format));
		})
		.on('finish.countdown', function(event) {
			location.reload();

		});

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
						}, 3000);

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
