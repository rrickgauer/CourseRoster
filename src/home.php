<?php

include('functions.php');
session_start();

$student = getStudentInfo($_SESSION['userID'])->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include('head.php'); ?>
    <title></title>
  </head>
  <body>
    <?php include('navbar.php'); ?>

    <div class="container">

      <div id="home-summary">
        <div class="name d-inline"><?php echo $student['First'] . ' ' . $student['Last']; ?></div>
        <div class="d-inline float-right"><a href="account-info.php"><i class='bx bx-cog'></i></a></div><br>
        <div class="d-inline home-count-stat"><?php echo $student['coursesCount']; ?> courses</div>
        <div class="d-inline home-count-stat"><?php echo $student['followersCount']; ?> followers</div>
        <div class="d-inline home-count-stat"><?php echo $student['followingCount']; ?> following</div>
      </div>

      






    </div>

  </body>
</html>
