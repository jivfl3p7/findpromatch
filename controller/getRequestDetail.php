<?php
  session_start();
  include 'config.php';

  $reqid = $_GET['id'];

  $req = $connection->query("SELECT r.request_id reqid, t.nama_team tname, r.screenshot ss, r.sent_time sent, mm.id matchid, mm.team_1_id t1id, mm.team_2_id t2id, mm.category cat, mm.start_time mmtime FROM requests r JOIN threads mm ON r.room_id=mm.id JOIN teams t ON r.team_id=t.id WHERE r.request_id='$reqid'");
  $req = $req->fetch_assoc();

 ?>

<table>
 <tr>
   <th>ReqID</th>
   <th>MatchID</th>
   <th>Sender Team</th>
   <th>Screenshot</th>
   <th>Req Time</th>
 </tr>
 <tr class="text-center">
   <td><?php echo $req['reqid']; ?></td>
   <td><?php echo $req['matchid']; ?></td>
   <td><?php echo $req['tname']; ?></td>
   <td><a style="color:white" href="showResult.php?ref=<?php echo $req['ss']; ?>">Link</a></td>
   <td><?php echo $req['sent']; ?></td>
 </tr>
</table>

<br><br>

<?php
  $matchid = $req['matchid'];
  $teams = $connection->query("SELECT t1.nama_team t1name, t2.nama_team t2name FROM threads mm JOIN teams t1 ON t1.id=mm.team_1_id JOIN teams t2 ON t2.id=mm.team_2_id WHERE mm.id='$matchid'");
  $t = $teams->fetch_assoc();
 ?>
<style media="screen">
  table tr td:first-child,
  table tr td:nth-child(4){
    width: 200px;
  }

  .btns button{
    width: 150px;
  }
</style>

<table>
 <tr>
   <th>Team A</th>
   <th colspan="2">Score</th>
   <th>Team B</th>
 </tr>
 <tr>
   <td class="text-center"><?php echo $t['t1name']; ?></td>
   <td><input type="number" class="form-control" id="score1" value="0"></td>
   <td><input type="number" class="form-control" id="score2" value="0"></td>
   <td class="text-center"><?php echo $t['t2name']; ?></td>
 </tr>
</table>

<br><br>

<div class="btns text-center">
  <input type="hidden" id="gameid" value="<?php echo $req['matchid']; ?>">
  <input type="hidden" id="game" value="<?php echo $req['cat']; ?>">
  <button class="btn btn-info" id="accBtn" value="<?php echo $req['reqid']; ?>"><i class="fa fa-check fa-lg"></i></button>&nbsp;&nbsp;&nbsp;
  <button class="btn btn-info" id="rejectBtn" value="<?php echo $req['reqid']; ?>"><i class="fa fa-times fa-lg"></i></button>
</div>

<script type="text/javascript">
  $('#accBtn').click(function(){
    var score1 = $('#score1').val();
    var score2 = $('#score2').val();
    var matchid = $('#gameid').val();
    var gamecat = $('#game').val();
    var reqid = $(this).val();

    $.get('controller/accreq.php?id='+reqid+'&score1='+score1+'&score2='+score2+'&gameid='+matchid+'&game='+gamecat, function(response){
      if(response == "Request accepted"){
        setTimeout(function(){
             location.reload();
        }, 1500);

        $.notify(response, "success");
      }else{
        $.notify(response, "error");
      }
    })
  })

  $('#rejectBtn').click(function(){
    var reqid = $(this).val();

    window.location.href = "controller/rejectreq.php?id="+reqid;
  })

</script>
