<div class="nav-side-menu">
  <div class="logo"><a href="index.php"><img src="assets/img/logo.png"></a></div>

  <div class="profile">

    <?php if($useridsession != 0){ ?>
    <div id="username"><?php echo $username; ?></div>
    <div id="teamname">[
      <?php
      if($role == "admin"){
        echo 'Administrator';
      }else if($teamidsession == 0 ){
        echo 'No Team';
      }else{
        echo $teamname;
      }
      ?> ]
    </div>
    <div id="teamlv">
      <div id="teamlv-wrap">
        <div id="lvshield" class="col-sm-3">
          <input type="hidden" id="userteamid" value="<?php echo $teamidsession; ?>">
          <i class="fa fa-shield fa-lg" aria-hidden="true"></i> <?php echo $teamlv; ?>
        </div>
        <div id="lvbar">
          <div id="lvbar-wrap">
            <div class="progress-bar progress-bar-warning progress-bar-striped img-rounded" role="progressbar" aria-valuenow="<?php echo $lvpercent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $lvpercent; ?>%">
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php }else{ ?>
    <div class="datetimeplace">
      <div id="dateplace"></div>
      <div id="timeplace"></div>
    </div>
    <?php } ?>

  </div>
  <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

  <div class="menu-list">

    <ul id="menu-content" class="menu-content collapse out">
      <li <?php if($ref == "index.php"){echo 'class="active"';} ?>>
        <a href="index.php">
          <i class="fa fa-home fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Home
        </a>
      </li>

      <li data-toggle="collapse" data-target="#products" class="collapsed <?php if($ref == "mm.php"){echo 'active';} ?>">
        <a href="mm.php"><i class="fa fa-rebel" aria-hidden="true"></i>&nbsp;&nbsp;Matchmaking <!--<span class="arrow"></span>--></a>
      </li>
      <!--<ul class="sub-menu collapse" id="products">
        <li class="active"><a href="mm.php?cat=csgo">CS:GO</a></li>
        <li><a href="mm.php?cat=dota2">Dota 2</a></li>
      </ul>-->


      <li data-toggle="collapse" data-target="#service" class="collapsed <?php if($ref == "tournaments.php"){echo 'active';} ?>">
        <a href="tournaments.php"><i class="fa fa-trophy fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Tournaments
          <?php
          if($role == "admin"){
           ?>
          <span class="arrow"></span>
          <?php } ?>
        </a>
      </li>
      <ul class="sub-menu collapse" id="service">
        <?php
        if($role == "admin"){
         ?>
         <li><a href="managetournament.php">Manage</a></li>
        <?php
        }
         ?>
      </ul>

      <?php if($useridsession != 0){ ?>
      <li data-toggle="collapse" data-target="#teams" class="collapsed <?php if($ref == "team"){echo 'active';} ?>">
        <a>
          <i class="fa fa-users fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Teams <span class="arrow"></span>
        </a>
      </li>
      <ul class="sub-menu collapse" id="teams">
        <?php
        if($role != "admin"){
          if($teamidsession != 0){
         ?>
        <li><a href="myteam.php">My Team</a></li>
        <?php }else{ ?>
        <li><a href="registerteam.php">Register Team</a></li>
        <?php
          }
        }
        ?>
        <li><a href="teamranking.php">All Team</a></li>
      </ul>

        <?php if($role != "admin"){ ?>
      <li <?php if($ref == "profile.php"){echo 'class="active"';} ?>>
        <a href="profile.php">
          <i class="fa fa-user fa-lg"></i>&nbsp;&nbsp;Profile
        </a>
      </li>
      <?php
        }
      }

      if(@$_SESSION['user']['role'] == "admin"){
      ?>

      <li <?php if($ref == "postmatchreq.php"){echo 'class="active"';} ?>>
        <a href="postmatchreq.php">
          <i class="fa fa-inbox fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Post-Match Requests
        </a>
      </li>

      <?php } ?>

      <?php if($role != "admin"){ ?>
      <li <?php if($ref == "contactus.php"){echo 'class="active"';} ?>>
        <a href="contactus.php">
          <i class="fa fa-envelope fa-lg" aria-hidden="true"></i></i>&nbsp;&nbsp;Contact Us
        </a>
      </li>
      <?php } ?>

      <?php if($useridsession != 0){ ?>
      <li>
        <a href="controller/doLogout.php">
          <i class="fa fa-power-off fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Logout
        </a>
      </li>
      <?php } ?>
    </ul>
  </div>

  <?php if($useridsession == 0){ ?>
  <div class="guestmenu">
    <div class="loginsec">
      <div data-toggle="modal" data-target="#login" class="btn btn-info btn-block">LOGIN</div>
    </div>
    <div class="registersec">
      <div data-toggle="modal" data-target="#register" class="btn btn-success btn-block">REGISTER</div>
    </div>
  </div>

  <?php } ?>

</div>

<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 class="modal-title" id="myModalLabel"><b>LOGIN</b></h4>
      </div>
      <div class="modal-body">
        <form id="loginform">
          <input type="hidden" name="refpage" value="<?php echo $refpage; ?>">
          <div class="form-group label-floating">
            <label class="control-label">Username</label>
            <input type="text" name="username" class="form-control">
          </div>
          <div class="form-group label-floating">
            <label class="control-label">Password</label>
            <input type="password" name="password" class="form-control">
          </div>
          <br>
          <div class="text-center">
            <button type="submit" class="btn btn-success">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 class="modal-title" id="myModalLabel"><b>REGISTER</b></h4>
      </div>
      <div class="modal-body">
        <form id="registerform">
          <div class="form-group label-floating">
            <label class="control-label">Username</label>
            <input type="text" name="username" class="form-control">
          </div>
          <div class="form-group label-floating">
            <label class="control-label">Password</label>
            <input type="password" name="password" class="form-control">
          </div>
          <div class="form-group label-floating">
            <label class="control-label">Confirm Password</label>
            <input type="password" name="confpassword" class="form-control">
          </div>
          <div class="form-group label-floating">
            <label class="control-label">E-mail</label>
            <input type="email" name="email" class="form-control">
          </div>
          <div class="form-group label-floating">
            <label class="control-label">Phone Number</label>
            <input type="text" name="phonenumber" class="form-control">
          </div>
          <br>
          <div class="text-center">
            <button type="submit" class="btn btn-success">Register</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
