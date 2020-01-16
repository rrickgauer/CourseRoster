<?php
session_start();
include('functions.php');

if(!isset($_SESSION['userID']) || !isValidStudentID($_SESSION['userID'])) {
  header('Location: login.php');
  exit;
}

$student = getStudentInfo($_SESSION['userID'])->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title>Course Roster - Home</title>
</head>

<body>
  <?php include('navbar.php'); ?>

  <div class="container">

    <div id="home-summary">
      <div class="name d-inline"><?php echo $student['First'] . ' ' . $student['Last']; ?></div>
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

          <div class="input-group" id="enrolled-courses-toolbar">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class='bx bx-search'></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Search" id="enrolled-courses-search-input">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary dropleft" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='bx bx-dots-horizontal-rounded'></i></button>
              <div class="dropdown-menu">
                <h6 class="dropdown-header">View</h6>
                <a class="dropdown-item view active" data-view-type="card" href="#">Card</a>
                <a class="dropdown-item view" data-view-type="table" href="#">Table</a>
              </div>
            </div>
          </div>

          <!-- get-user-courses-from-search.php -->
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
                <a class="dropdown-item view active" href="#">Card</a>
                <a class="dropdown-item view" href="#">Table</a>
              </div>
            </div>
          </div>

          <!-- get-followers-from-search.php -->
          <div id="follower-cards"></div>

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
                <a class="dropdown-item view active" href="#">Card</a>
                <a class="dropdown-item view" href="#">Table</a>
              </div>
            </div>
          </div>

          <!-- get-following-from=search.php -->
          <div id="following-cards"></div>



        </div>
      </div>
    </div>






    <?php printFooter(); ?>


  </div>
  <script>
    var coursesView = "card";
    var followersView = "card";
    var followingView = "card";

    $(document).ready(function() {
      $("#nav-item-home").toggleClass("active");
      $("#enrolled-courses-search-input").on("keyup", filterEnrolledCourses);
      $("#enrolled-courses-toolbar .view").on("click", updateCoursesView);
      filterEnrolledCourses();

      $("#followers-search-input").on("keyup", filterFollowers);
      $("#pills-followers .view").on("click", updateFollowersView);
      filterFollowers();

      $("#following-search-input").on("keyup", filterFollowing);
      $("#pills-following .view").on("click", updateFollowingView);
      filterFollowing();
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

      var query = $("#enrolled-courses-search-input").val();
      var link = 'get-user-courses-from-search.php?studentID=<?php echo $_SESSION['userID']; ?>' + '&query=' + query + '&view=' + coursesView;
      xhttp.open("GET", link, true);
      xhttp.send();
    }

    function filterFollowers() {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var e = this.responseText;
          $("#follower-cards").html(e);
        }
      };

      var query = $("#followers-search-input").val();
      var link = 'get-followers-from-search.php?studentID=<?php echo $_SESSION['userID']; ?>' + '&query=' + query + '&view=' + followersView;
      xhttp.open("GET", link, true);
      xhttp.send();
    }

    function filterFollowing() {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var e = this.responseText;
          $("#following-cards").html(e);
        }
      };

      var query = $("#following-search-input").val();
      var link = 'get-following-from-search.php?studentID=<?php echo $_SESSION['userID']; ?>' + '&query=' + query + '&view=' + followingView;
      xhttp.open("GET", link, true);
      xhttp.send();
    }

    function updateCoursesView() {
      if (coursesView == "card") {
        coursesView = "table";
      } else {
        coursesView = "card";
      }

      filterEnrolledCourses();
      $("#enrolled-courses-toolbar .view").toggleClass("active");
    }

    function updateFollowersView() {
      if (followersView == "card") {
        followersView = "table";
      } else {
        followersView = "card";
      }

      filterFollowers();
      $("#pills-followers .view").toggleClass("active");
    }

    function updateFollowingView() {
      if (followingView == "card") {
        followingView = "table";
      } else {
        followingView = "card";
      }

      filterFollowing();
      $("#pills-following .view").toggleClass("active");
    }


  </script>

</body>

</html>
