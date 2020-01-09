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



    <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="pills-courses-tab" data-toggle="pill" href="#pills-courses" role="tab" aria-controls="pills-courses" aria-selected="true">Courses</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pills-followers-tab" data-toggle="pill" href="#pills-followers" role="tab" aria-controls="pills-followers" aria-selected="false">Followers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pills-following-tab" data-toggle="pill" href="#pills-following" role="tab" aria-controls="pills-following" aria-selected="false">Following</a>
      </li>
    </ul>



    <div class="tab-content" id="pills-tabContent">


      <div class="tab-pane fade show active" id="pills-courses" role="tabpanel" aria-labelledby="pills-home-tab">
        <h3>Courses content</h3>
      </div>



      <div class="tab-pane fade" id="pills-followers" role="tabpanel" aria-labelledby="pills-profile-tab">

        <h3>Followers content</h3>
      </div>




      <div class="tab-pane fade" id="pills-following" role="tabpanel" aria-labelledby="pills-contact-tab">

        <h3>Following content</h3>

      </div>





    </div>








  </div>

</body>

</html>
