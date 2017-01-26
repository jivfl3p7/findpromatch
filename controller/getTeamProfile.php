<?php
session_start();
include ('config.php');

$team = $connection->query("SELECT * FROM teams WHERE user_id='$useridsession'");
$team = $team->fetch_assoc();

$teamname = strtoupper($teamname);
?>
<style media="screen">
  .panel-content-left tr td{
    padding-top: 5px;
    padding-bottom: 5px;
  }

  .panel-content-left th{
    text-align: center;
  }


</style>

<h3><?php if($teamname != ""){ echo $teamname.'\'S MEMBER'; } else { echo 'REGISTER TEAM'; } ?></h3>
<div class="panel-content-left">
  <?php if($teamidsession == 0){ ?>
  <form id="teamregisterform" method="post">
    <table style="border:0">
      <tr>
        <td>Team Name</td>
        <td><input type="text" name="teamname" class="form-control" value=""></td>
      </tr>
      <tr>
        <td>Leader's Nickname</td>
        <td><input type="text" name="nickname1" class="form-control" value="<?php echo $team['nickname_1']; ?>"></td>
      </tr>
      <tr>
        <td>2nd Nickname</td>
        <td><input type="text" name="nickname2" class="form-control" value="<?php echo $team['nickname_2']; ?>"></td>
      </tr>
      <tr>
        <td>3rd Nickname</td>
        <td><input type="text" name="nickname3" class="form-control" value="<?php echo $team['nickname_3']; ?>"></td>
      </tr>
      <tr>
        <td>4th Nickname</td>
        <td><input type="text" name="nickname4" class="form-control" value="<?php echo $team['nickname_4']; ?>"></td>
      </tr>
      <tr>
        <td>5th Nickname</td>
        <td><input type="text" name="nickname5" class="form-control" value="<?php echo $team['nickname_5']; ?>"></td>
      </tr>
      <tr>
        <td>
          6th Nickname
          <br>(<i>Stand-in</i>)
        </td>
        <td><input type="text" name="nickname6" class="form-control" value="<?php if($team['nickname_6'] != "N/A"){ echo $team['nickname_6']; } ?>"></td>
      </tr>
      <tr>
        <td style="border:0"></td>
        <td><button type="submit" class="btn btn-success btn-block" name="button">Register</button></td>
      </tr>
    </table>
  </form>

  <?php }else{ ?>

  <form id="teamupdateform" method="post">
    <table style="border:0">
      <tr>
        <td>Leader's Nickname</td>
        <td><input type="text" name="nickname1" class="form-control" value="<?php echo $team['nickname_1']; ?>"></td>
      </tr>
      <tr>
        <td>2nd Nickname</td>
        <td><input type="text" name="nickname2" class="form-control" value="<?php echo $team['nickname_2']; ?>"></td>
      </tr>
      <tr>
        <td>3rd Nickname</td>
        <td><input type="text" name="nickname3" class="form-control" value="<?php echo $team['nickname_3']; ?>"></td>
      </tr>
      <tr>
        <td>4th Nickname</td>
        <td><input type="text" name="nickname4" class="form-control" value="<?php echo $team['nickname_4']; ?>"></td>
      </tr>
      <tr>
        <td>5th Nickname</td>
        <td><input type="text" name="nickname5" class="form-control" value="<?php echo $team['nickname_5']; ?>"></td>
      </tr>
      <tr>
        <td>
          6th Nickname
          <br>(<i>Stand-in</i>)
        </td>
        <td><input type="text" name="nickname6" class="form-control" value="<?php if($team['nickname_6'] != "N/A"){ echo $team['nickname_6']; } ?>"></td>
      </tr>
      <tr>
        <td style="border:0"></td>
        <td><button type="submit" class="btn btn-success btn-block" name="button">Update</button></td>
      </tr>
    </table>
  </form>
  <?php } ?>

</div>

<script type="text/javascript">
  /*$('#teamregisterform').submit(function(event){
    var form = $(this);
    var $inputs = $form.find("input, select, button, textarea");
    var serializedData = form.serialize();

    $inputs.prop("disabled", true);

    $.post('controller/doRegisterTeam.php', serializedData, function(response){
      if(response == "Team registered"){

        $.notify("Team registered", "success");

      }else{


        $inputs.prop("disabled", false);
        $.notify(response, "error");
      }
    }).fail(function(){ $.notify("failed", "error"); });

    return false;
  })*/

  $('#teamregisterform').submit(function(event){
      var $form = $(this);
      var $inputs = $form.find("input, select, button, textarea");
      var serializedData = $form.serialize();

      $.notify.defaults({position: "top center"});

      $inputs.prop("disabled", true);

      $.post('controller/doRegisterTeam.php', serializedData, function(response) {
        if(response == "Team registered"){

          $.notify("Team registered", "success");

          setTimeout(function(){
            location.reload();
          }, 2500);

        }else{
          $inputs.prop("disabled", false);
          $.notify(response, "error");
        }
      }).fail(function(){ $.notify("failed", "error"); });

      loading.hide();
      return false;
  });

  $('#teamupdateform').submit(function(event){
      var $form = $(this);
      var $inputs = $form.find("input, select, button, textarea");
      var serializedData = $form.serialize();

      $.notify.defaults({position: "top center"});

      $inputs.prop("disabled", true);

      $.post('controller/updateTeamProfile.php', serializedData, function(response) {
        if(response == "Team updated"){

          $.notify("Team updated", "success");

        }else{
          $inputs.prop("disabled", false);
          $.notify(response, "error");
        }
      }).fail(function(){ $.notify("failed", "error"); });

      loading.hide();
      return false;
  });

</script>
