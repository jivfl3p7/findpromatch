<?php
  session_start();
  include ('controller/config.php');

  if(!@$_SESSION['user']){
    header("location:index.php");
  }

  $ref = "team";

  $teams = $connection->query("SELECT * FROM teams WHERE id != 0	ORDER BY exp DESC, wincsgo DESC");

	$maxrecord = $connection->query("SELECT MAX(exp) maxexp, MAX(wincsgo/(wincsgo+drawcsgo+losecsgo) * 100) maxwinrate1, MAX(windota/(windota+losedota) * 100) maxwinrate2	FROM teams");
	$maxrecord = $maxrecord->fetch_assoc();

 ?>

<html>
<head>
	<title>Team Ranking | ProFindMatch</title>
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

	<?php include 'template/navsidemenu.php'; ?>

	<div id="content">

		<div class="content-header">
			<div class="content-title">
				<h2>TEAM RANKING</h2>
				<br>
			</div>

		</div>

		<div id="matchlist" class="row">

			<div class="teamrank-table">
				<table class="container">
					<thead>
						<tr>
							<th rowspan="2"></th>
							<th rowspan="2"><h1>Team Name</h1></th>
							<th rowspan="2"><h1>Experience</h1></th>
							<th class="text-center" colspan="4">CS:GO</th>
							<th class="text-center" colspan="3">Dota 2</th>
						</tr>
						<tr>
							<th><h1>WR(%)</h1></th>
							<th><h1>Win</h1></th>
							<th><h1>Draw</h1></th>
							<th><h1>Lose</h1></th>
							<th><h1>WR(%)</h1></th>
							<th><h1>Win</h1></th>
							<th><h1>Lose</h1></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i = 1;
							while($team = $teams->fetch_assoc()){
						?>
						<tr>
							<td>#<?php echo $i; ?></td>
							<td><a href="team.php?id=<?php echo $team['id']; ?>" style="text-decoration:none;color:#A9CF54;"><?php echo $team['nama_team'].' '; if($team['id'] == $teamidsession){echo '<i class="fa fa-star-o fa-lg" aria-hidden="true"></i>';} ?></a></td>
							<td>
								<?php
								echo $team['exp'];

								$exprate = $team['exp']/$maxrecord['maxexp'] * 100;
								$exprate = round($exprate,2);
								?>
								<div class="rankbar">
									<div class="progress" style="background-color: rgba(0,0,0,0)">
										<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70"
										aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $exprate; ?>%">
											<span></span>
										</div>
									</div>
								</div>
							</td>
							<td>
								<?php
									$totalmatch = $team['wincsgo']+$team['drawcsgo']+$team['losecsgo'];

									if($totalmatch == 0){$totalmatch = 1;}

									$winrate1 = $team['wincsgo']/($totalmatch) * 100;
									$winrate1 = round($winrate1, 2);
									echo $winrate1.'%';

									$winrate1 = $winrate1 / $maxrecord['maxwinrate1'] * 100;
									$winrate1 = round($winrate1, 2);

								?>
								<div class="rankbar">
									<div class="progress" style="background-color: rgba(0,0,0,0)">
										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70"
										aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $winrate1; ?>%">
											<span></span>
										</div>
									</div>
								</div>
							</td>
							<td><?php echo $team['wincsgo']; ?></td>
							<td><?php echo $team['drawcsgo']; ?></td>
							<td><?php echo $team['losecsgo']; ?></td>
							<td>
								<?php
									$totalmatch = $team['windota']+$team['losedota'];

									if($totalmatch == 0){$totalmatch = 1;}

									$winrate2 = $team['windota']/($totalmatch) * 100;
									$winrate2 = round($winrate2, 2);
									echo $winrate2.'%';

									$winrate2 = $winrate2 / $maxrecord['maxwinrate2'] * 100;
									$winrate2 = round($winrate2, 2);
								?>
								<div class="rankbar">
									<div class="progress" style="background-color: rgba(0,0,0,0)">
										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70"
										aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $winrate2; ?>%">
											<span></span>
										</div>
									</div>
								</div>
							</td>
							<td><?php echo $team['windota']; ?></td>
							<td><?php echo $team['losedota']; ?></td>
						</tr>
						<?php
							$i++;
						} ?>
					</tbody>
				</table>
			</div>

		</div>

		<?php include 'template/footer.html'; ?>

	</div>

	<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
					<h4 class="modal-title" id="myModalLabel"><b>LOGIN</b></h4>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group label-floating">
							<label class="control-label">Username</label>
							<input type="text" class="form-control">
						</div>
						<div class="form-group label-floating">
							<label class="control-label">Password</label>
							<input type="password" class="form-control">
						</div>
						<br>
						<div class="text-center">
							<button type="submit" class="btn btn-success">Login</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
					<h4 class="modal-title" id="myModalLabel"><b>REGISTER</b></h4>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group label-floating">
							<label class="control-label">Username</label>
							<input type="email" class="form-control">
						</div>
						<div class="form-group label-floating">
							<label class="control-label">Password</label>
							<input type="email" class="form-control">
						</div>
						<br>
						<div class="text-center">
							<button type="submit" class="btn btn-success">Register</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/material.min.js"></script>
	<script type="text/javascript" src="assets/js/material-kit.js"></script>
	<script type="text/javascript">
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
