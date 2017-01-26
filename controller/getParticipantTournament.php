<?php
  session_start();
  include 'config.php';

  $tid = $_GET['tid'];

  $participants = $connection->query("SELECT p.*, t.id teamid, t.nama_team tname FROM participants p JOIN teams t ON p.userid=t.user_id WHERE p.tournamentid = '$tid'");

 ?>
<style media="screen">
  .panel-content-left .row a{
    border: 1px solid #e1ffff;
    border-radius: 3px;
    margin: 10px 20px;
    padding: 20px 0;
    color: white;
    font-size: 20px;
    transition: 0.1s;
    text-decoration: none;
  }

  .panel-content-left .row a:hover{
    transition: 0.1s;
    background-color: white;
    color: black;
    text-decoration: none;
  }
</style>

<h3>PARTICIPANTS</h3>
<div class="panel-content-left">
  <br><br>
  <div class="row">
      <?php
        $i = 1;
        while($p = $participants->fetch_assoc()){
      ?>
          <a class="col-sm-3" href="team.php?id=<?php echo $p['teamid']; ?>">
            <div class="participants text-center">
              <?php echo $p['tname']; ?>
            </div>
          </a>
      <?php
          $i++;
        }
      ?>
    </table>
  </div>

</div>
