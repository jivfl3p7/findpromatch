<?php
  session_start();
  include 'config.php';

  $uniqueid = $_GET['id'];


 ?>
<h3>TOURNAMENT BRACKET</h3>
<div class="panel-content-left">
  <br><br><br>
  <iframe src="http://challonge.com/<?php echo $uniqueid; ?>/module?theme=4803" width="100%" height="500" frameborder="0" scrolling="auto" allowtransparency="true"></iframe>

</div>
