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

      <!-- enrolled courses -->
      <div class="tab-pane fade show active" id="pills-courses" role="tabpanel" aria-labelledby="pills-courses-tab">

        <?php
        $enrolledCourses = getEnrolledCourses($_SESSION['userID']);
        echo '<div class="card-deck">';
        $count = 0;
        while ($course = $enrolledCourses->fetch(PDO::FETCH_ASSOC)) {

          if ($count == 3) {
            echo '</div><div class="card-deck">';
            $count = 0;
          }
          echo getClassCard($course['cid'], $course['Dept'], $course['Number'], $course['Title'], $course['count']);
          $count++;
        }

        echo '</div>';
        ?>
      </div>

      <!-- followers -->
      <div class="tab-pane fade" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab">
        <?php
        $followers = getStudentFollowers($student['StudentID']);
        echo '<div class="card-deck">';
        $count = 0;
        while ($follower = $followers->fetch(PDO::FETCH_ASSOC)) {
          if ($count == 3) {
            echo '</div><div class="card-deck">';
            $count = 0;
          }
          echo getStudentCard($follower['StudentID'], $follower['First'], $follower['Last'], $follower['Email']);
          $count++;
        }
        echo '</div>';
        ?>
      </div>

      <!-- following -->
      <div class="tab-pane fade" id="pills-following" role="tabpanel" aria-labelledby="pills-following-tab">
        <?php
        $followings = getStudentFollowing($student['StudentID']);
        echo '<div class="card-deck">';
        $count = 0;
        while ($following = $followings->fetch(PDO::FETCH_ASSOC)) {
          if ($count == 3) {
            echo '</div><div class="card-deck">';
            $count = 0;
          }
          echo getStudentCard($following['StudentID'], $following['First'], $following['Last'], $following['Email']);
          $count++;
        }
        echo '</div>';
        ?>

      </div>





    </div>








  </div>
  <script>

  function gotoStudentPage(studentCard) {
    var studentID = $(studentCard).data("student-id");
    window.location.href = 'student.php?studentID=' + studentID;
  }

  </script>

</body>

</html>
