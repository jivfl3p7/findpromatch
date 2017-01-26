<?php
  session_start();
  include 'config.php';

  $teamid = $_GET['id'];

  $team = $connection->query("SELECT * FROM teams WHERE id= '$teamid'");
  $team = $team->fetch_assoc();

 ?>

<h3>MATCHMAKING RECORD</h3>
<div class="panel-content-left">
  <br>
  <div class="row">
    <div class="col-sm-6">
      <div id="recordChart" class="chart" style="margin-left:2.4em;padding-bottom:25px"></div>
      <div class="chartlabel text-center">
        Counter-Strike: Global Offensive
      </div>
    </div>
    <div class="col-sm-6">
      <div id="recordChart2" class="chart" style="margin-left:2.4em;padding-bottom:25px"></div>
      <div class="chartlabel text-center">
          Dota 2
      </div>
    </div>
  </div>

</div>

<input type="hidden" id="win1" value="<?php echo $team['wincsgo']; ?>">
<input type="hidden" id="draw1" value="<?php echo $team['drawcsgo']; ?>">
<input type="hidden" id="lose1" value="<?php echo $team['losecsgo']; ?>">
<input type="hidden" id="win2" value="<?php echo $team['windota']; ?>">
<input type="hidden" id="lose2" value="<?php echo $team['losedota']; ?>">

<script type="text/javascript">
  var win = parseInt($('#win1').val());
  var draw = parseInt($('#draw1').val());
  var lose = parseInt($('#lose1').val());
  var win2 = parseInt($('#win2').val());
  var lose2 = parseInt($('#lose2').val());

  $(document).ready(function(){

    $(function(){
      $("#recordChart").drawDoughnutChart([
        { title: "Win",       value : win,  color: "#0096d0" },
        { title: "Draw",      value:  draw,   color: "#f0ff00" },
        { title: "Lose",      value:  lose,   color: "#d40808" }
      ]);

      $("#recordChart2").drawDoughnutChart([
        { title: "Win",       value : win2,  color: "#5b87ff" },
        { title: "Lose",      value:  lose2,   color: "#ff6262" }
      ]);
    });
  });
</script>
