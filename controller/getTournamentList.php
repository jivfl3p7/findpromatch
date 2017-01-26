<style media="screen">
  .panel-content-left{
    margin-bottom: 100px;
  }
</style>

<h3 style="color: #23282E;">HIDDEN TEXT BY 1801416106</h3>
<div class="panel-content-left">

<?php
  session_start();
  include 'config.php';

  if(!@$_GET['cat']){
    echo '<br><br><br><br><br><center><i>Failed to Retrieve List</i></center>';

  }else if(!@$_GET['status']){
    echo '<br><br><br><br><br><center><i>Failed to Retrieve List</i></center>';

  }else{
    $cat = $_GET['cat'];
    $status = $_GET['status'];

    if($status == "upcoming"){
      $tournaments = $connection->query("SELECT * FROM tournaments WHERE category='$cat' AND status!='complete' AND active = 1");
    }else{
      $tournaments = $connection->query("SELECT * FROM tournaments WHERE category='$cat' AND status='complete' AND active = 1");
    }


    $i = 1;

    if($tournaments->num_rows == 0){
      if($status == "upcoming"){
        echo '<br><br><br><br><br><center><i>No Tournament available at this time</i></center>';
      }else{
        echo '<br><br><br><br><br><center><i>No Tournament History</i></center>';
      }

    }else{
      while($tournament = $tournaments->fetch_assoc()){
        $tid = $tournament['id'];

        $currparticipant = $connection->query("SELECT COUNT(id) countperson FROM participants WHERE tournamentid='$tid'");
        $currparticipant = $currparticipant->fetch_assoc();

        $userparticipate = $connection->query("SELECT * FROM participants WHERE userid='$useridsession' AND tournamentid = '$tid'");

        $date = new DateTime($tournament['starttime']);
        $ttime = $date->format("H.i");
        $tdate = $date->format("d M");

        if($i % 2 == 1){
  ?>
          <div class="row">
  <?php
        }
  ?>
              <div class="tourcard col-sm-6">
                <a href="tournamentdetail.php?id=<?php echo $tid; ?>">
                <div class="card">
                  <div class="cardheader">
                    <?php if( $tournament['status'] == "underway" ){ ?>
                      <div class="live">
                        <span></span> LIVE
                      </div>
                    <?php } ?>
                    <img class="image" width="100%" src="assets/img/cover/<?php if($cat == "csgo"){ echo 'csgo.jpg'; }else{ echo 'dota.jpg'; } ?>">
                    <div class="date"><?php echo $tdate; ?></div>
                  </div>
                  <div class="carddetail">
                    <!-- DETAIL -->
                    <div class="title">
                      <h3><?php echo $tournament['name']; ?></h3>
                      <div class="date"><?php echo $ttime; ?> WIB</div>
                    </div>

                    <div class="joinbtn">
                    <?php if($useridsession != 0 && $userparticipate->num_rows == 0 && $teamidsession != 0 && $tournament['status'] != "complete"){
                            if($currparticipant['countperson'] != $tournament['participant']){
                      ?>
                            <a data-toggle="modal" data-target="#join<?php echo $tid; ?>" class="btn btn-success">Join</a>
                    <?php
                            }
                          }else if($userparticipate->num_rows == 1){ ?>
                            <button type="button" class="btn btn-success" disabled>JOINED</button>
                    <?php } ?>
                    </div>

                    <div class="person">
                      <i class="fa fa-user"></i>
                      <?php echo $currparticipant['countperson']; ?> / <?php echo $tournament['participant']; ?>
                    </div>
                  </div>
                </div>
                </a>
              </div>

              <div class="modal fade" id="join<?php echo $tid; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="myModalLabel"><b>CONFIRMATION</b></h4>
                    </div>
                    <div class="modal-body">
                      <center>
                        <h4><?php echo $tournament['name']; ?></h4><br>
                        Are you sure to join this tournament?<br>
                        After join, you can't unparticipate
                        <br><br>
                        <!--<form id="confirmation" method="post">
                          <input type="hidden" name="tid" value="">
                          <button type="submit" class="btn btn-success">CONFIRM</button>-->
                          <a href="controller/joinTournament.php?tid=<?php echo $tournament['id']; ?>&cat=<?php echo $tournament['category']; ?>" class="btn btn-success">CONFIRM</a>
                          &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info" class="close" data-dismiss="modal" aria-hidden="true">CANCEL</button>
                        <!--</form>-->

                      </center>
                    </div>
                  </div>
                </div>
              </div>

  <?php
        if($i % 2 == 0){
   ?>
            </div>
  <?php
        }

        $i++;
      }
    }
  }
 ?>

</div>

<script type="text/javascript">

</script>
