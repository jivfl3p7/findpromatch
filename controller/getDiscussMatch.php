<?php
  session_start();
  include 'config.php';

  $matchid = $_GET['id'];

  $match = $connection->query("SELECT t1.nama_team t1name, t2.nama_team t2name FROM threads t
                 JOIN teams t1 ON t1.id=t.team_1_id
                 JOIN teams t2 ON t2.id=t.team_2_id WHERE t.id='$matchid'");
  $match = $match->fetch_assoc();

  $posts = $connection->query("SELECT p.*, t.nama_team tname FROM posts p JOIN teams t ON t.user_id=p.user_id WHERE p.thread_id='$matchid' ORDER BY p.post_date ASC");

  if($posts->num_rows == 0){
    echo '<br>
    <center><i>No Post</i></center>';
  }else{
    $i = 1;
    while($post = $posts->fetch_assoc()){
?>
      <div class="detail">
        <div class="profile col-sm-3">
          <div class="image img-circle">
            <h2>
              <?php
              if($post['user_id'] == 1){
                echo 'A';
              }else if($match['t1name'][0] == $match['t2name'][0]){
                echo substr($post['tname'],0,2);
              }else{
                echo $post['tname'][0];
              }
               ?>
            </h2>
          </div>
          <div class="username"><?php if($post['user_id'] == 1){ echo 'Administrator'; }else{ echo $post['tname']; } ?></div>
          <div class="count">
            <?php
            $userid = $post['user_id'];
            $countpost = $connection->query("SELECT COUNT(id) count FROM posts WHERE user_id='$userid'");
            $countpost = $countpost->fetch_assoc();

            echo 'Posts : '. $countpost['count'];
             ?>
          </div>
        </div>
        <div class="text col-sm-9">
          <div class="paragraph">
            <?php echo $post['content']; ?>
          </div>
          <div class="date">
            <date>Posted date : <?php echo $post['post_date']; ?></date>
            <counter>#<?php echo $i; ?></counter>
          </div>
        </div>
      </div>
      <hr>
<?php
      $i++;
    }
  }
?>
