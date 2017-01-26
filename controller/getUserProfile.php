<?php
session_start();
include ('config.php');

$user = $connection->query("SELECT * FROM users WHERE user_id='$useridsession'");
$user = $user->fetch_assoc();
?>
<style media="screen">
  .panel-content-left tr td{
    padding-top: 10px;
    padding-bottom: 10px;
  }
</style>

<h3>PERSONAL INFORMATION</h3>
<div class="panel-content-left">
  <form id="profileupdateform" method="post">
    <table>
      <tr>
        <td>Username</td>
        <td><input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>"></td>
      </tr>

      <tr>
        <td>E-mail</td>
        <td><input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>"></td>
      </tr>
      <tr>
        <td>Phone Number</td>
        <td><input type="text" name="phonenumber" class="form-control" value="<?php echo $user['phonenumber']; ?>"></td>
      </tr>
      <tr>
        <td>Role</td>
        <td><input type="text" class="form-control" value="<?php echo $user['role']; ?>" readonly></td>
      </tr>
    </table>
    <br><br>
    <table style="border:0">
      <tr>
        <td>Password</td>
        <td><input type="password" name="password" class="form-control" value="<?php echo $user['password']; ?>"></td>
      </tr>
      <tr>
        <td>Confirm Password</td>
        <td><input type="password" name="confpassword" class="form-control"></td>
      </tr>
      <tr>
        <td style="border:0"></td>
        <td><button type="submit" class="btn btn-success btn-block" name="button">Update</button></td>
      </tr>
    </table>
  </form>
</div>

<script type="text/javascript">
  $('#profileupdateform').submit(function(event){
      var $form = $(this);
      var $inputs = $form.find("input, select, button, textarea");
      var serializedData = $form.serialize();

      $.notify.defaults({position: "top center"});

      $inputs.prop("disabled", true);

      $.post('controller/updateUserProfile.php', serializedData, function(response) {
        if(response == "Update profile success"){

          $.notify("Update profile success", "success");

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
</script>
