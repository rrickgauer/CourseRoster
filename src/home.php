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
      <!-- <div class="settings-link d-inline"><a href="account-info.php"><i class='bx bx-cog'></i></a></div> -->
      <br>

      <div class="d-inline home-count-stat"><span class="number"><?php echo $student['coursesCount'];   ?></span> courses</div>
      <div class="d-inline home-count-stat"><span class="number"><?php echo $student['followersCount']; ?></span> followers</div>
      <div class="d-inline home-count-stat"><span class="number"><?php echo $student['followingCount']; ?></span> following</div>
    </div>


    <div id="home-content">
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

          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class='bx bx-search'></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Search" id="enrolled-courses-search-input">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary dropleft" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='bx bx-dots-horizontal-rounded'></i></button>
              <div class="dropdown-menu">
                <h6 class="dropdown-header">View</h6>
                <a class="dropdown-item active" href="#">Card</a>
                <a class="dropdown-item" href="#">Table</a>
              </div>
            </div>
          </div>

          <div id="enrolled-courses-cards"></div>
        </div>

        <!-- followers -->
        <div class="tab-pane fade" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab">

          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class='bx bx-search'></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Search" id="followers-search-input">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary dropleft" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='bx bx-dots-horizontal-rounded'></i></button>
              <div class="dropdown-menu">
                <h6 class="dropdown-header">View</h6>
                <a class="dropdown-item active" href="#">Card</a>
                <a class="dropdown-item" href="#">Table</a>
              </div>
            </div>
          </div>

          <?php
            $followers = getStudentFollowers($student['StudentID']);
            echo '<div class="card-deck">';
            $count = 0;
            while ($follower = $followers->fetch(PDO::FETCH_ASSOC)) {
              if ($count == 3) {
                echo '</div><div class="card-deck">';
                $count = 0;
              }
              echo getStudentCard($follower['sid'], $follower['First'], $follower['Last'], $follower['Email'], $follower['enrollmentCount'], $follower['followersCount']);
              $count++;
            }
            echo '</div>';
          ?>
        </div>

        <!-- following -->
        <div class="tab-pane fade" id="pills-following" role="tabpanel" aria-labelledby="pills-following-tab">

          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class='bx bx-search'></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Search" id="following-search-input">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary dropleft" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='bx bx-dots-horizontal-rounded'></i></button>
              <div class="dropdown-menu">
                <h6 class="dropdown-header">View</h6>
                <a class="dropdown-item active" href="#">Card</a>
                <a class="dropdown-item" href="#">Table</a>
              </div>
            </div>
          </div>

          <?php
          $followings = getStudentFollowing($student['StudentID']);
          echo '<div class="card-deck">';
          $count = 0;
          while ($following = $followings->fetch(PDO::FETCH_ASSOC)) {
            if ($count == 3) {
              echo '</div><div class="card-deck">';
              $count = 0;
            }
            echo getStudentCard($following['sid'], $following['First'], $following['Last'], $following['Email'], $following['enrollmentCount'], $student['followersCount']);
            $count++;
          }
          echo '</div>';
          ?>

        </div>
      </div>
    </div>








  </div>
  <script>
    $(document).ready(function() {
      $("#nav-item-home").toggleClass("active");
      $("#enrolled-courses-search-input").on("keyup", filterEnrolledCourses);
      filterEnrolledCourses();
    });

    function gotoStudentPage(studentCard) {
      var studentID = $(studentCard).data("student-id");
      window.location.href = 'student.php?studentID=' + studentID;
    }

    function filterEnrolledCourses() {
      var xhttp = new XMLHttpRequest();

      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var e = this.responseText;
          $("#enrolled-courses-cards").html(e);
        }
      };

      var listID = $("#todo-list-card").attr("data-listid");
      var query = $("#enrolled-courses-search-input").val();
      var link = 'get-user-courses-from-search.php?studentID=<?php echo $_SESSION['userID']; ?>' + '&query=' + query;

      xhttp.open("GET", link, true);
      xhttp.send();
    }
  </script>

</body>

</html>
