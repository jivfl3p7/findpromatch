<?php
	session_start();
	include("controller/config.php");

	if(!@$_GET['cat']){
		header('location:mm.php?cat=csgo');
	}

	$cat = $_GET['cat'];
	$ref = "mm.php";
	$refpage = "mm.php?cat=".$cat;

	$currdate = date("Y-m-d H:i:s", time()+6*3600);
	$currdate = new DateTime($currdate);

	$matches = $connection->query("SELECT t.*, t1.nama_team t1name, t2.nama_team t2name FROM threads t
		JOIN teams t1 ON t1.id = t.team_1_id
		JOIN teams t2 ON t2.id = t.team_2_id
		WHERE t.category = '$cat'
		ORDER BY t.id DESC");

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
				<h2>MATCHMAKING</h2>
			</div>
			<div class="category-bar">
				<a href="mm.php?cat=csgo" class="category-list first <?php if($cat == "csgo"){ echo 'active'; }?>">
					<div>
						<img src="assets/img/icon/csgo.png" width="30px" class="img-rounded">&nbsp;&nbsp;Counter-Strike: Global Offensive
					</div>
				</a>
				<a href="mm.php?cat=dota2" class="category-list <?php if($cat == "dota2"){ echo 'active'; }?>" style="padding-bottom:19px;">
					<div>
						<img src="assets/img/icon/dota2.png" width="30px" class="img-rounded">&nbsp;&nbsp;Dota 2
					</div>
				</a>

			</div>
		</div>

		<div id="matchlist" class="row">
			<input type="hidden" id="category" value="<?php echo $cat; ?>">

			<?php
				while($match = $matches->fetch_assoc()){
					$matchtime = new DateTime($match['start_time']);
			 ?>
				<div class="mm-card">
					<?php if($match['status'] == "playing" && $matchtime < $currdate){ ?>
					<div class="live">
						LIVE
					</div>
					<?php }else if($match['status'] == "finished"){ ?>
					<div class="decided">
						DECIDED
					</div>
					<?php } ?>
					<div class="mm-card-title text-center">
						<div class="mm-card-header">
							<h3>Match #<?php echo $match['id'] ?>&nbsp;</h3>

						</div>
						<hr>
						<div class="mm-card-content">
							<div class="content-wrap">
								<div class="team1">
									<?php echo $match['t1name']; ?>
								</div>
								<div class="vs">vs</div>
								<div class="team2">
									<?php
										if($match['team_2_id'] == 0){
												echo 'TBD';
										}else{
												echo $match['t2name'];
										}
									 ?>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="mm-card-btn text-center">
						<?php if($teamidsession != $match['team_1_id'] && $teamidsession != -1 && $match['status'] == "waiting" && $teamidsession != 0){ ?>
						<a data-toggle="modal" data-target="#join<?php echo $match['id']; ?>" class="btn btn-success btn-block">Accept</a>
						<?php } ?>
						<a href="mmdetail.php?id=<?php echo $match['id']; ?>" class="btn btn-info btn-block">View Details</a>
					</div>
				</div>

				<div class="modal fade" id="join<?php echo $match['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="myModalLabel"><b>CONFIRMATION</b></h4>
							</div>
							<div class="modal-body">
								<center>
									Are you sure want to match against <?php echo $match['t1name']; ?>?
									<br><br>
									<!--<form id="confirmation" method="post">
										<input type="hidden" name="tid" value="">
										<button type="submit" class="btn btn-success">CONFIRM</button>-->
										<button class="confirmBtn btn btn-success" value="<?php echo $match['id']; ?>">CONFIRM</button>
										&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info" class="close" data-dismiss="modal" aria-hidden="true">CANCEL</button>
									<!--</form>-->

								</center>
							</div>
						</div>
					</div>
				</div>

			<?php
			}
			 ?>

		</div>
		<?php if($useridsession != 0 && $teamidsession != -1){ ?>
		<a class="create-match" data-toggle="tooltip" data-placement="top" title="Create Match">
			<i class="fa fa-plus fa-lg" aria-hidden="true"></i>
		</a>
		<?php } ?>

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
		var category = $('#category').val();

		$('.confirmBtn').click(function(){
			var matchid = $(this).val();

			window.location.href = "controller/joinMatch.php?matchid="+matchid;
		})

		$('.create-match').on("click", function(){
				var teamid = $('#userteamid').val();

				if(teamid == 0){
					$.notify("Please register your team at Profile > Team", {position:"top center"}, "error");
				}else{
					window.location.href = "createmm.php?cat="+category;
				}
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
