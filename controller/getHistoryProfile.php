<?php
session_start();
include ('config.php');

$matches = $connection->query("SELECT t.*, t1.nama_team t1name, t2.nama_team t2name FROM threads t JOIN teams t1 ON t1.id=t.team_1_id JOIN teams t2 ON t2.id=t.team_2_id WHERE (t.team_1_id='$teamidsession' OR t.team_2_id='$teamidsession') AND t.status='finished'");

?>

<style media="screen">
  .panel-content-left tr td:nth-child(2), td:nth-child(5){
    width: 20%;
  }

  .panel-content-left tr th{
    text-align: center;
  }

  .panel-content-left tr td{
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 10px;
    padding-right: 10px;
  }

  table td,th{
    padding: 15px 5px;
  }

  table td{
    text-align: center;
  }

  table td a{
    text-decoration: none;
    color:#A9CF54;
  }

  table td a:hover{
    text-decoration: none;
    color:#A9CF54;
  }

  table td:nth-child(4),td:nth-child(5){
    width: 40px;
  }
  table td:last-child{
    width: 120px;
  }
</style>

<h3>MATCH HISTORY</h3>
<div class="panel-content-left">
  <?php
    if($matches->num_rows == 0){
  ?>
    <br><br><br><br><br><br><br>
    <center><i>No Match record</i></center>
  <?php
    }else{
   ?>
    <table>
      <tr>
        <th></th>
        <th>Game</th>
        <th colspan="4">Result</th>
        <th>Match Time</th>
        <th>Status</th>
      </tr>

      <?php
        $i = 1;
        while($match = $matches->fetch_assoc()){
       ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><a href="mmdetail.php?id=<?php echo $match['id']; ?>"><?php if($match['category']=="csgo"){ echo 'CS:GO'; }else{ echo 'Dota 2'; } ?></a></td>
              <td><?php echo $match['t1name']; ?></td>
              <?php
                if($match['score_1'] > $match['score_2']){
               ?>
                  <td class="text-success"><?php echo $match['score_1']; ?></td>
                  <td class="text-danger"><?php echo $match['score_2']; ?></td>
              <?php
                }else if($match['score_1'] < $match['score_2']){
               ?>
                  <td class="text-danger"><?php echo $match['score_1']; ?></td>
                  <td class="text-success"><?php echo $match['score_2']; ?></td>
              <?php
                }else{
              ?>
                  <td><?php echo $match['score_1']; ?></td>
                  <td><?php echo $match['score_2']; ?></td>
              <?php
                }
               ?>
              <td><?php echo $match['t2name']; ?></td>
              <td><?php echo $match['start_time']; ?></td>
              <td>
                <?php
                  if($match['team_1_id'] == $teamidsession && $match['score_1'] > $match['score_2']){
                    echo 'Win';
                  }else if($match['team_1_id'] == $teamidsession && $match['score_1'] < $match['score_2']){
                    echo 'Lose';
                  }else if($match['team_2_id'] == $teamidsession && $match['score_1'] > $match['score_2']){
                    echo 'Lose';
                  }else if($match['team_2_id'] == $teamidsession && $match['score_1'] < $match['score_2']){
                    echo 'Win';
                  }else{
                    echo 'Draw';
                  }
                ?>
              </td>
          </tr>
      <?php
          $i++;
        }
      ?>
    </table>
  <?php } ?>
</div>
