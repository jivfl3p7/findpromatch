<?php
  session_start();
  include 'config.php';

  $teamid = $_GET['id'];
  $getUserid = $connection->query("SELECT user_id FROM users WHERE team_id='$teamid'");
  $userid = $getUserid->fetch_assoc();
  $userid = $userid['user_id'];

  $teamhistory = $connection->query("SELECT t.category cat,t.id tid, t.name name, th.position position, team.nama_team teamname FROM tournament_history th JOIN tournaments t ON th.tournamentid = t.id JOIN teams team ON th.userid = team.user_id WHERE th.userid = '$userid' ");

 ?>

<h3>TOURNAMENT HISTORY</h3>
<div class="panel-content-left">

  <?php
    if($teamhistory->num_rows == 0){
  ?>
    <br><br><br><br><br><br><br>
    <center><i>This team not join any Tournament yet</i></center>
  <?php
    }else{
   ?>

  <div class="teamrank-table">
    <table class="container">
      <thead>
        <tr>
          <th></th>
          <th><h1>Tournament Name</h1></th>
          <th><h1>Game Category</h1></th>
          <th><h1>Final Position</h1></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        while($tourdetail = $teamhistory->fetch_assoc()){ ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><a href="tournamentdetail.php?id=<?php echo $tourdetail['tid']; ?>"><?php echo $tourdetail['name']; ?></a></td>
              <td>
                <?php
                if($tourdetail['cat'] == "csgo"){
                  echo 'CS:GO';
                }else{
                  echo 'Dota 2';
                }
                 ?>
              </td>
              <td class="text-center">
                <?php echo $tourdetail['position']; ?>
              </td>
            </tr>
        <?php
          $i++;
        } ?>
      </tbody>
    </table>
  </div>
  <?php
    }
   ?>

</div>
