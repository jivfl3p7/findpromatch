<?php
  session_start();
  include 'config.php';

  $acc = $_GET['acc'];

  if($acc == 0){
    $reqs = $connection->query("SELECT * FROM requests WHERE accepted='$acc'");
  }else{
    $reqs = $connection->query("SELECT * FROM requests WHERE accepted!=0");
  }


?>
<style media="screen">
  .panel-content-left table tr th{
    width: 210px;
  }

  .panel-content-left table tr th:first-child{
    width: 50px;
  }

</style>

<h3 style="color: #23282E;">HIDDEN TEXT BY 1801416106</h3>
<div id="requestarea" class="panel-content-left">
  <table>
    <tr>
      <th>RequestID</th>
      <th>Sender<br>TeamID</th>
      <th>Game <br>Category</th>
      <th>Detail</th>
    </tr>
    <?php
      $i = 1;
      while($req = $reqs->fetch_assoc()){
     ?>
        <tr class="text-center">
            <td><?php echo $req['request_id']; ?></td>
            <td><a style="text-decoration:none; color:white" href="team.php?id=<?php echo $req['team_id']; ?>"><?php echo $req['team_id']; ?></a></td>
            <td>
              <?php
              if($req['game'] == "csgo"){
                echo 'CS:GO';
              }else{
                echo 'Dota2';
              }
               ?>
            </td>
            <td>
              <?php if($req['accepted'] == 0){ ?>
                <button type="button" class="getrequest btn btn-info" value="<?php echo $req['request_id']; ?>" name="button"><i class="fa fa-list fa-lg"></i></button>
              <?php }else if($req['accepted'] == 1){ ?>
                <i class="fa fa-check fa-lg text-success"></i>
              <?php }else{ ?>
                <i class="fa fa-times fa-lg text-danger"></i>
              <?php } ?>
            </td>
        </tr>
    <?php
        $i++;
      }
     ?>
  </table>
</div>

<script type="text/javascript">
  $('.getrequest').click(function(){
    var reqid = $(this).val();

    $('#requestarea').html('');

    $.get('controller/getRequestDetail.php?id='+reqid, function(data){
      $('#requestarea').html(data);
    })
  })
</script>
