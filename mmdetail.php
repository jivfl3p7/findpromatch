<?php
	session_start();
	include 'controller/config.php';

	if(!@$_GET['id']){
		header("location:mm.php");
	}

	$ref = "mm.php";
	$matchid = $_GET['id'];

	$match = $connection->query("SELECT
		t1.nama_team t1name, t2.nama_team t2name, t.score_1 score1, t.score_2 score2, s.name servername, s.ip serverip,
		t.start_time starttime, t.team_1_id t1id, t.team_2_id t2id, t.map map, t.status status, t.screenshot ss, t.open open
		,t.category cat
		FROM threads t JOIN teams t1 ON t1.id=t.team_1_id
									 JOIN teams t2 ON t2.id=t.team_2_id
									 JOIN server_name s ON s.id=t.server_id
	  WHERE t.id='$matchid'");

	$match = $match->fetch_assoc();

	$currdate = date("Y-m-d H:i:s", time()+6*3600);

	$matchdate = date($match['starttime']);

	$datenow = new DateTime($currdate);
	$date2 = new DateTime($matchdate);

	$showdate = date("jS M Y H:i \W\I\B", strtotime($match['starttime']));

	$t1name = substr($match['t1name'], 0, 15);
	$t2name = substr($match['t2name'], 0, 15);
	$t1id = $match['t1id'];
	$t2id = $match['t2id'];

	$score1 = $match['score1'];
	$score2 = $match['score2'];

	$t1members = $connection->query("SELECT * FROM teams WHERE id='$t1id'");
	$t1members = $t1members->fetch_assoc();
	$t2members = $connection->query("SELECT * FROM teams WHERE id='$t2id'");
	$t2members = $t2members->fetch_assoc();

 ?>

<html>
<head>
	<title><?php echo $match['t1name'].' vs '.$match['t2name']; ?></title>
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
			<?php if($match['cat'] == "dota2"){ ?>
				background-image: url('assets/img/cover/dota.jpg');
				background-position: 0 -5em;
			<?php }else{ ?>
				background-image: url('assets/img/maps/<?php echo $match['map']; ?>.jpg');
				background-position: 0 -20em;
			<?php } ?>
			background-size: cover;
		}

		.team-header .matchtitle .teama{
			<?php
			//TEAM A LOSE
				if($score1 < $score2){
			 ?>/
			background: rgba(248,80,50,0);
			background: -moz-linear-gradient(left, rgba(248,80,50,0) 0%, rgba(240,47,23,0) 19%, rgba(240,47,23,0) 26%, rgba(240,47,23,0.48) 71%, rgba(233,54,35,0.7) 92%, rgba(231,56,39,1) 100%);
			background: -webkit-gradient(left top, right top, color-stop(0%, rgba(248,80,50,0)), color-stop(19%, rgba(240,47,23,0)), color-stop(26%, rgba(240,47,23,0)), color-stop(71%, rgba(240,47,23,0.48)), color-stop(92%, rgba(233,54,35,0.7)), color-stop(100%, rgba(231,56,39,1)));
			background: -webkit-linear-gradient(left, rgba(248,80,50,0) 0%, rgba(240,47,23,0) 19%, rgba(240,47,23,0) 26%, rgba(240,47,23,0.48) 71%, rgba(233,54,35,0.7) 92%, rgba(231,56,39,1) 100%);
			background: -o-linear-gradient(left, rgba(248,80,50,0) 0%, rgba(240,47,23,0) 19%, rgba(240,47,23,0) 26%, rgba(240,47,23,0.48) 71%, rgba(233,54,35,0.7) 92%, rgba(231,56,39,1) 100%);
			background: -ms-linear-gradient(left, rgba(248,80,50,0) 0%, rgba(240,47,23,0) 19%, rgba(240,47,23,0) 26%, rgba(240,47,23,0.48) 71%, rgba(233,54,35,0.7) 92%, rgba(231,56,39,1) 100%);
			background: linear-gradient(to right, rgba(248,80,50,0) 0%, rgba(240,47,23,0) 19%, rgba(240,47,23,0) 26%, rgba(240,47,23,0.48) 71%, rgba(233,54,35,0.7) 92%, rgba(231,56,39,1) 100%);

			<?php
			//TEAM A WIN
				}else if($score1 > $score2){
			?>
			background: rgba(248,80,50,0);
			background: -moz-linear-gradient(left, rgba(248,80,50,0) 0%, rgba(24,179,0,0) 19%, rgba(24,179,0,0) 26%, rgba(24,179,0,0.48) 71%, rgba(24,179,0,0.7) 92%, rgba(24,179,0,1) 100%);
			background: -webkit-gradient(left top, right top, color-stop(0%, rgba(248,80,50,0)), color-stop(19%, rgba(24,179,0,0)), color-stop(26%, rgba(24,179,0,0)), color-stop(71%, rgba(24,179,0,0.48)), color-stop(92%, rgba(24,179,0,0.7)), color-stop(100%, rgba(24,179,0,1)));
			background: -webkit-linear-gradient(left, rgba(248,80,50,0) 0%, rgba(24,179,0,0) 19%, rgba(24,179,0,0) 26%, rgba(24,179,0,0.48) 71%, rgba(24,179,0,0.7) 92%, rgba(24,179,0,1) 100%);
			background: -o-linear-gradient(left, rgba(248,80,50,0) 0%, rgba(24,179,0,0) 19%, rgba(24,179,0,0) 26%, rgba(24,179,0,0.48) 71%, rgba(24,179,0,0.7) 92%, rgba(24,179,0,1) 100%);
			background: -ms-linear-gradient(left, rgba(248,80,50,0) 0%, rgba(24,179,0,0) 19%, rgba(24,179,0,0) 26%, rgba(24,179,0,0.48) 71%, rgba(24,179,0,0.7) 92%, rgba(24,179,0,1) 100%);
			background: linear-gradient(to right, rgba(248,80,50,0) 0%, rgba(24,179,0,0) 19%, rgba(24,179,0,0) 26%, rgba(24,179,0,0.48) 71%, rgba(24,179,0,0.7) 92%, rgba(24,179,0,1) 100%);*/

			<?php
			//TEAM A DRAW
			}else{
			 ?>
			background: rgba(71,71,71,0);
			background: -moz-linear-gradient(left, rgba(71,71,71,0) 0%, rgba(135,135,135,0) 19%, rgba(126,126,126,0) 26%, rgba(71,71,71,0.48) 71%, rgba(71,71,71,0.7) 92%, rgba(71,71,71,0.85) 100%);
			background: -webkit-gradient(left top, right top, color-stop(0%, rgba(71,71,71,0)), color-stop(19%, rgba(135,135,135,0)), color-stop(26%, rgba(126,126,126,0)), color-stop(71%, rgba(71,71,71,0.48)), color-stop(92%, rgba(71,71,71,0.7)), color-stop(100%, rgba(71,71,71,0.85)));
			background: -webkit-linear-gradient(left, rgba(71,71,71,0) 0%, rgba(135,135,135,0) 19%, rgba(126,126,126,0) 26%, rgba(71,71,71,0.48) 71%, rgba(71,71,71,0.7) 92%, rgba(71,71,71,0.85) 100%);
			background: -o-linear-gradient(left, rgba(71,71,71,0) 0%, rgba(135,135,135,0) 19%, rgba(126,126,126,0) 26%, rgba(71,71,71,0.48) 71%, rgba(71,71,71,0.7) 92%, rgba(71,71,71,0.85) 100%);
			background: -ms-linear-gradient(left, rgba(71,71,71,0) 0%, rgba(135,135,135,0) 19%, rgba(126,126,126,0) 26%, rgba(71,71,71,0.48) 71%, rgba(71,71,71,0.7) 92%, rgba(71,71,71,0.85) 100%);
			background: linear-gradient(to right, rgba(71,71,71,0) 0%, rgba(135,135,135,0) 19%, rgba(126,126,126,0) 26%, rgba(71,71,71,0.48) 71%, rgba(71,71,71,0.7) 92%, rgba(71,71,71,0.85) 100%);
			<?php } ?>

			border-right: 5px solid rgba(0,0,0,0);
			line-height: 80px;
			font-size: 50px;
			padding-right: 20px;
			text-align: right;
		}

		.team-header .matchtitle .teamb{
			<?php
			//TEAM B WIN
				if($score1 < $score2){
			 ?>
			background: rgba(24,179,0,1);
			background: -moz-linear-gradient(left, rgba(24,179,0,1) 0%, rgba(24,179,0,0.7) 8%, rgba(24,179,0,0.48) 29%, rgba(24,179,0,0) 74%, rgba(24,179,0,0) 81%, rgba(248,80,50,0) 100%);
			background: -webkit-gradient(left top, right top, color-stop(0%, rgba(24,179,0,1)), color-stop(8%, rgba(24,179,0,0.7)), color-stop(29%, rgba(24,179,0,0.48)), color-stop(74%, rgba(24,179,0,0)), color-stop(81%, rgba(24,179,0,0)), color-stop(100%, rgba(248,80,50,0)));
			background: -webkit-linear-gradient(left, rgba(24,179,0,1) 0%, rgba(24,179,0,0.7) 8%, rgba(24,179,0,0.48) 29%, rgba(24,179,0,0) 74%, rgba(24,179,0,0) 81%, rgba(248,80,50,0) 100%);
			background: -o-linear-gradient(left, rgba(24,179,0,1) 0%, rgba(24,179,0,0.7) 8%, rgba(24,179,0,0.48) 29%, rgba(24,179,0,0) 74%, rgba(24,179,0,0) 81%, rgba(248,80,50,0) 100%);
			background: -ms-linear-gradient(left, rgba(24,179,0,1) 0%, rgba(24,179,0,0.7) 8%, rgba(24,179,0,0.48) 29%, rgba(24,179,0,0) 74%, rgba(24,179,0,0) 81%, rgba(248,80,50,0) 100%);
			background: linear-gradient(to right, rgba(24,179,0,1) 0%, rgba(24,179,0,0.7) 8%, rgba(24,179,0,0.48) 29%, rgba(24,179,0,0) 74%, rgba(24,179,0,0) 81%, rgba(248,80,50,0) 100%);

			<?php
			//TEAM B LOSE
				}else if($score1 > $score2){
			?>
			background: rgba(248,79,50,1);
			background: -moz-linear-gradient(left, rgba(248,79,50,1) 0%, rgba(248,79,50,0.7) 8%, rgba(248,79,50,0.48) 29%, rgba(248,79,50,0) 74%, rgba(248,79,50,0) 81%, rgba(248,78,48,0) 100%);
			background: -webkit-gradient(left top, right top, color-stop(0%, rgba(248,79,50,1)), color-stop(8%, rgba(248,79,50,0.7)), color-stop(29%, rgba(248,79,50,0.48)), color-stop(74%, rgba(248,79,50,0)), color-stop(81%, rgba(248,79,50,0)), color-stop(100%, rgba(248,78,48,0)));
			background: -webkit-linear-gradient(left, rgba(248,79,50,1) 0%, rgba(248,79,50,0.7) 8%, rgba(248,79,50,0.48) 29%, rgba(248,79,50,0) 74%, rgba(248,79,50,0) 81%, rgba(248,78,48,0) 100%);
			background: -o-linear-gradient(left, rgba(248,79,50,1) 0%, rgba(248,79,50,0.7) 8%, rgba(248,79,50,0.48) 29%, rgba(248,79,50,0) 74%, rgba(248,79,50,0) 81%, rgba(248,78,48,0) 100%);
			background: -ms-linear-gradient(left, rgba(248,79,50,1) 0%, rgba(248,79,50,0.7) 8%, rgba(248,79,50,0.48) 29%, rgba(248,79,50,0) 74%, rgba(248,79,50,0) 81%, rgba(248,78,48,0) 100%);
			background: linear-gradient(to right, rgba(248,79,50,1) 0%, rgba(248,79,50,0.7) 8%, rgba(248,79,50,0.48) 29%, rgba(248,79,50,0) 74%, rgba(248,79,50,0) 81%, rgba(248,78,48,0) 100%);

			<?php
			//TEAM B DRAW
			}else{
			 ?>
			background: rgba(71,71,71,0.85);
			background: -moz-linear-gradient(left, rgba(71,71,71,0.85) 0%, rgba(71,71,71,0.7) 8%, rgba(71,71,71,0.48) 29%, rgba(126,126,126,0) 74%, rgba(135,135,135,0) 81%, rgba(71,71,71,0) 100%);
			background: -webkit-gradient(left top, right top, color-stop(0%, rgba(71,71,71,0.85)), color-stop(8%, rgba(71,71,71,0.7)), color-stop(29%, rgba(71,71,71,0.48)), color-stop(74%, rgba(126,126,126,0)), color-stop(81%, rgba(135,135,135,0)), color-stop(100%, rgba(71,71,71,0)));
			background: -webkit-linear-gradient(left, rgba(71,71,71,0.85) 0%, rgba(71,71,71,0.7) 8%, rgba(71,71,71,0.48) 29%, rgba(126,126,126,0) 74%, rgba(135,135,135,0) 81%, rgba(71,71,71,0) 100%);
			background: -o-linear-gradient(left, rgba(71,71,71,0.85) 0%, rgba(71,71,71,0.7) 8%, rgba(71,71,71,0.48) 29%, rgba(126,126,126,0) 74%, rgba(135,135,135,0) 81%, rgba(71,71,71,0) 100%);
			background: -ms-linear-gradient(left, rgba(71,71,71,0.85) 0%, rgba(71,71,71,0.7) 8%, rgba(71,71,71,0.48) 29%, rgba(126,126,126,0) 74%, rgba(135,135,135,0) 81%, rgba(71,71,71,0) 100%);
			background: linear-gradient(to right, rgba(71,71,71,0.85) 0%, rgba(71,71,71,0.7) 8%, rgba(71,71,71,0.48) 29%, rgba(126,126,126,0) 74%, rgba(135,135,135,0) 81%, rgba(71,71,71,0) 100%);
			<?php } ?>

			border-left: 5px solid rgba(0,0,0,0);
			line-height: 80px;
			font-size: 50px;
			padding-left: 20px;
			text-align: left;
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
		<input type="hidden" id="matchid" value="<?php echo $matchid; ?>">

		<div class="team-header">
			<div class="matchtitle">
				<div class="teama col-sm-6">
					<?php echo $t1name; ?>&nbsp;&nbsp;
					<span class="score"><?php echo $score1; ?></span>
				</div>
				<div class="teamb col-sm-6">
					<span class="score"><?php echo $score2; ?></span>&nbsp;&nbsp;
					<?php echo $t2name; ?>
				</div>
			</div>
			<div class="matchtime">
				<?php if($match['status'] == "playing" && $datenow > $date2 == "1"){ ?>
				<h4 style="margin-bottom:-1em"><?php echo $showdate; ?></h4>
				<h2>
					<div class="live-glow">
						<span></span> LIVE
					</div>
				</h2>
				<?php } ?>

				<?php if($currdate < $matchdate){ ?>
				<h4>
					COUNTDOWN <br>
					<?php echo $showdate; ?>
				</h4>
				<div class="timer">
					<div class="countdown" style="text-align:center">
						<span id="clock"></span>
					</div>
				</div>
				<?php } ?>

				<?php
					if($match['status'] == "finished"){
				 ?>
				 	<h4><?php echo $showdate; ?></h4>
				<?php } ?>
				<div class="joinbtn text-center">
					<?php
							if($teamidsession == $t1id || $teamidsession == $t2id || $useridsession == 1){
					 ?>
					 		<button data-toggle="modal" data-target="#server" class="btn btn-info"><b>SERVER INFO</b></button>
					 <?php } ?>

					<?php if($match['status'] == "waiting" && $teamidsession != -1 && $teamidsession != 0 && $teamidsession != $t1id){ ?>
							<button data-toggle="modal" data-target="#join" class="btn btn-success">JOIN MATCH</button>
					<?php
								}else if($match['status'] == "playing" && $currdate > $matchdate){
									if($teamidsession == $t1id || $teamidsession == $t2id){
						?>
							<button data-toggle="modal" data-target="#sendresult" class="btn btn-success">SEND A SCREENSHOT</button>
					<?php
									}
								}else if($match['status'] == "finished"){
					?>
							<button data-toggle="modal" data-target="#result"  class="btn btn-success">RESULT</button>
					<?php } ?>
				</div>
			</div>
		</div>

		<div id="matchlist" class="row">
			<div class="row">

				<div class="player-list">
					<div class="teamatable col-sm-6">
						<table class="container">
							<?php
				      $i = 1;

				      while($i <= 6){
				        if($i == 6){
				      ?>
			            <tr>
			              <td class="col-sm-3"><center><i>Stand-in</i></center></td>
			              <td class="col-sm-9"><?php echo $t1members['nickname_'.$i]; ?></td>
			            </tr>
				      <?php
				        }else{
				       ?>
				        <tr>
				          <td class="col-sm-3 text-center"><?php if($i == 1){echo '<i class="fa fa-superpowers fa-lg" aria-hidden="true" title="'.$t1name.'\'s Leader"></i>';} ?></td>
				          <td class="col-sm-9"><?php echo $t1members['nickname_'.$i]; ?></td>
				        </tr>
				      <?php
				        }
				        $i++;
				      }
				       ?>
						</table>
					</div>

					<div class="teambtable col-sm-6">
						<table class="container">
							<?php
				      $i = 1;

				      while($i <= 6){
				        if($i == 6){
				      ?>
			            <tr>
			              <td class="col-sm-9" style="text-align:right"><?php echo $t2members['nickname_'.$i]; ?></td>
										<td class="col-sm-3"><center><i>Stand-in</i></center></td>
			            </tr>
				      <?php
				        }else{
				       ?>
				        <tr>
									<td class="col-sm-9" style="text-align:right"><?php echo $t2members['nickname_'.$i]; ?></td>
				          <td class="col-sm-3 text-center"><?php if($i == 1){echo '<i class="fa fa-superpowers fa-lg" aria-hidden="true" title="'.$t2name.'\'s Leader"></i>';} ?></td>
				        </tr>
				      <?php
				        }
				        $i++;
				      }
				       ?>
						</table>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="commentsec col-sm-8">

					<div class="comment">
						<div class="title">
							<h4>RULES DISCUSSION</h4>
						</div>
						<?php
						if($match['status'] != "waiting" && $match['open'] == 1){
							if($teamidsession == $t1id || $teamidsession == $t2id || $useridsession == 1){
						?>
							<form id="postform" method="post">
								<input type="hidden" name="matchid" value="<?php echo $matchid; ?>">
								<textarea class="form-control" name="postcontent" rows="5" max-width="100%" placeholder="Insert something here..."></textarea>
								<button type="submit" class="btn btn-info">POST</button>
							</form>
						<?php
							}
						}
						 ?>
					</div>

					<div id="loading" class="loading-screen text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
            <div class="text">
                Loading...
            </div>
          </div>

					<div id="commentary" class="othercomment">

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
						Are you sure want to match against <?php echo $match['t1name']; ?>?
						<br><br>
						<!--<form id="confirmation" method="post">
							<input type="hidden" name="tid" value="">
							<button type="submit" class="btn btn-success">CONFIRM</button>-->
							<button id="confirmBtn" class="btn btn-success">CONFIRM</button>
							&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info" class="close" data-dismiss="modal" aria-hidden="true">CANCEL</button>
						<!--</form>-->

					</center>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="server" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><b>SERVER INFORMATION</b></h4>
				</div>
				<div class="modal-body">
					<center>
						<table class="container">
							<tr>
								<td>Server Name</td>
								<td><?php echo $match['servername']; ?></td>
							</tr>
							<tr>
								<td>Server IP</td>
								<td><?php echo $match['serverip']; ?></td>
							</tr>
						</table>
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
						<input type="hidden" name="cat" value="<?php echo $match['cat']; ?>">
						<input type="hidden" name="from" value="mm">
						<input type="hidden" name="matchid" value="<?php echo $matchid; ?>">
						<input type="file" name="screenshot">
						<br>
						<button type="submit" class="btn btn-info">SEND REQUEST TO ADMIN</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="result" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><b>RESULT</b></h4>
				</div>
				<div class="modal-body">
					<a href="showResult.php?ref=<?php echo $match['ss']; ?>"><img src="assets/img/uploads/<?php echo $match['ss']; ?>" width="100%" alt=""></a>
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
		var matchid = $('#matchid').val();
		var contentData = $('#commentary');
		var loading = $('#loading');

		$(document).ready(function(){
			$.get('controller/getDiscussMatch.php?id='+matchid, function(data){
					loading.hide();
					contentData.html(data);
			})
		})

		$.notify.defaults({
			position: "top center",
			autoHide: 3000
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
			window.location.href = "controller/joinMatch.php?matchid="+matchid;
		})

		$('#clock').countdown('<?php echo $match["starttime"] ?>')
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

		$('#postform').submit(function(event){
				var $form = $(this);
				var $inputs = $form.find("input, select, button, textarea");
				var serializedData = $form.serialize();

				$inputs.prop("disabled", true);

				$.post('controller/doAddPost.php', serializedData, function(response) {
					if(response == "Posted"){
						setTimeout(function(){
								 location.reload();
						}, 1500);

						$.notify("Posted", "success");

					}else{
						$inputs.prop("disabled", false);
						$.notify(response, "error");
					}
				}).fail(function(){ $.notify("failed", "error"); });

				return false;
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
