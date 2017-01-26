<?php
  if(!@$_GET['ref']){
    header("location:mm.php");
  }

?>
    <img src="assets/img/uploads/<?php echo $_GET['ref']; ?>" alt="">
<?php

 ?>
