<?php
  session_start();
  include 'config.php';

  $uniqueid = $_GET['id'];

  $tournament = $connection->query("SELECT id,description, status FROM tournaments WHERE uniqueid='$uniqueid'");
  $t = $tournament->fetch_assoc();
  $tid = $t['id'];

  $thistory = $connection->query("SELECT th.*, t.nama_team tname, t.id teamid FROM tournament_history th JOIN teams t ON th.userid=t.user_id WHERE th.tournamentid='$tid' ORDER BY th.position ASC");

 ?>

<style media="screen">
  .information .contents{
    padding-top: 40px;
    padding-right: 15px;
  }

  .contents table{
    margin-top: -150px;
  }

  .contents table, .contents table tr, .contents table tr td{
    border:1px solid #23282e;
  }

  .contents table tr td{
    padding: 20px 40px;
  }
</style>

<h3 style="color: #23282E;">HIDDEN TEXT BY 1801416106</h3>
<div class="panel-content-left">

  <div class="information col-sm-6">
    <div class="titles">
      <h3>DESCRIPTION</h3>
    </div>
    <div class="contents">
      <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $t['description']; ?></p>
    </div>
  </div>

  <div class="information col-sm-6">
    <?php if($t['status'] == "complete"){ ?>
      <div class="titles">
        <h3>RESULTS</h3>
      </div>
      <div class="contents text-center">

        <table>
            <?php
            while($th = $thistory->fetch_assoc()){
              echo '<tr>';
              if($th['position'] == 1){
            ?>
                <td class="text-center"><i class="fa fa-trophy fa-4x text-warning" title="Champion"></i></td>
                <td style="font-size:21px" class="text-center"><a href="team.php?id=<?php echo $th['teamid']; ?>" style="color:white"><?php echo $th['tname']; ?></a></td>
            <?php
              }else if($th['position'] == 2){
            ?>
                <td class="text-center"><i class="fa fa-trophy fa-3x" style="color:silver" title="1st Runner-Up"></i></td>
                <td style="font-size:21px" class="text-center"><a href="team.php?id=<?php echo $th['teamid']; ?>" style="color:white"><?php echo $th['tname']; ?></a></td>
            <?php
              }else if($th['position'] == 3){
            ?>
                <td class="text-center"><i class="fa fa-trophy fa-2x" title="2nd Runner-Up" style="color:#CD7F32"></i></td>
                <td style="font-size:21px" class="text-center"><a href="team.php?id=<?php echo $th['teamid']; ?>" style="color:white"><?php echo $th['tname']; ?></a></td>

            <?php
              }
              echo '<br><br></tr>';
            }
            ?>
        </table>


      </div>
    <?php } ?>
  </div>

</div>
