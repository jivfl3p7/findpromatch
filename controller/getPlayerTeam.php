<?php
  session_start();
  include 'config.php';

  $teamid = $_GET['id'];

  $team = $connection->query("SELECT * FROM teams WHERE id= '$teamid'");
  $team = $team->fetch_assoc();

 ?>

<h3>PLAYERS</h3>
<div class="panel-content-left">

  <table class="container">
    <tbody>
      <?php
      $i = 1;

      while($i <= 6){
        if($i == 6){
          if($team['nickname_'.$i] != "N/A"){
      ?>
            <tr>
              <td><center><i>Stand-in</i></center></td>
              <td><?php echo $team['nickname_'.$i]; ?></td>
            </tr>
      <?php
          }
        }else{
       ?>
        <tr>
          <td class="text-center"><?php if($i == 1){echo '<i class="fa fa-superpowers fa-lg" aria-hidden="true" title="'.$team['nama_team'].'\'s Leader"></i>';} ?></td>
          <td><?php echo $team['nickname_'.$i]; ?></td>
        </tr>
      <?php
        }
        $i++;
      }
       ?>
    </tbody>
  </table>

</div>
