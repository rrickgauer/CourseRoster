<?php
session_start();
include('functions.php');

if(!isset($_SESSION['userID']) || !isValidStudentID($_SESSION['userID'])) {
  header('Location: login.php');
  exit;
}

$student = getStudentInfo($_GET['studentID'])->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title><?php echo $student['First'] . ' ' . $student['Last']; ?></title>
</head>

<body>
  <?php include('navbar.php'); ?>

  <div class="container">

    <div id="home-summary">

      <div class="left-side">
        <div class="top-line">
          <div class="name"><?php echo $student['First'] . ' ' . $student['Last']; ?> </div>
          <div class="email">&nbsp;<?php echo $student['Email']; ?></div>
        </div>

        <div class="second-line">
          <div class="home-count-stat"><span class="number"><?php echo $student['coursesCount'];   ?></span>&nbsp;courses</div>
          <div class="home-count-stat" id="followers-count-stat"><span class="number"><?php echo $student['followersCount']; ?></span>&nbsp;followers</div>
          <div class="home-count-stat"><span class="number"><?php echo $student['followingCount']; ?></span>&nbsp;following</div>
        </div>

      </div>

      <!-- see update-following.php -->
      <div class="right-side">
        <?php isUserProfile(); ?>
      </div>

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
                <a class="dropdown-item view active" data-view-type="card" href="#"><i class='bx bx-card'></i>&nbsp;Card</a>
                <a class="dropdown-item view" data-view-type="table" href="#"><i class='bx bx-table'></i>&nbsp;Table</a>
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
                <a class="dropdown-item view active" href="#"><i class='bx bx-card'></i>&nbsp;Card</a>
                <a class="dropdown-item view" href="#"><i class='bx bx-table'></i>&nbsp;Table</a>
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
                <a class="dropdown-item view active" href="#"><i class='bx bx-card'></i>&nbsp;Card</a>
                <a class="dropdown-item view" href="#"><i class='bx bx-table'></i>&nbsp;Table</a>
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
      $("#nav-item-students").toggleClass("active");
      $("#enrolled-courses-search-input").on("keyup", filterEnrolledCourses);
      $("#enrolled-courses-toolbar .view").on("click", updateCoursesView);
      filterEnrolledCourses();

      $("#followers-search-input").on("keyup", filterFollowers);
      $("#pills-followers .view").on("click", updateFollowersView);
      filterFollowers();

      $("#following-search-input").on("keyup", filterFollowing);
      $("#pills-following .view").on("click", updateFollowingView);
      filterFollowing();

      $("#update-following-btn").on("click", updateFollowing);


      $(function () {
        $("[data-toggle='tooltip']").tooltip();
      });
    });

    function updateFollowing() {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          filterFollowers();
          $("#update-following-btn").html(this.responseText);
          updateSummaryStats();
        }
      };

      var studentID = "<?php echo $_GET['studentID']; ?>";
      var link = 'update-following.php?studentID=' + studentID;
      xhttp.open("GET", link, true);
      xhttp.send();
    }

    function updateSummaryStats() {
      $.ajax({
        type: "GET",
        url: 'get-student-data.php',
        data: {"studentID": "<?php echo $_GET['studentID']; ?>"},
        success: function(response) {
          var student = JSON.parse(response);
          $("#followers-count-stat .number").text(student.followersCount);
        }
      });
    }

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

      var userID = '<?php echo $_SESSION['userID']; ?>';
      var query = $("#enrolled-courses-search-input").val();
      var link = 'get-user-courses-from-search.php?studentID=<?php echo $_GET['studentID']; ?>' + '&query=' + query + '&view=' + coursesView + '&userID=' + userID;
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

      var userID = '<?php echo $_SESSION['userID']; ?>';
      var query = $("#followers-search-input").val();
      var link = 'get-followers-from-search.php?studentID=<?php echo $_GET['studentID']; ?>' + '&query=' + query + '&view=' + followersView + '&userID=' + userID;
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

      var userID = '<?php echo $_SESSION['userID']; ?>';
      var query = $("#following-search-input").val();
      var link = 'get-following-from-search.php?studentID=<?php echo $_GET['studentID']; ?>' + '&query=' + query + '&view=' + followingView + '&userID=' + userID;
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

<?php

function isUserProfile() {
  if ($_GET['studentID'] == $_SESSION['userID']) {
    printAccountSettingsLink();
    echo 
      '<script>
      $(document).ready(function() {
        $("#nav-item-profile").addClass("active");
      });
      </script>';
  } else {
    printFollowButton();
  }
}

function printFollowButton() {
  echo '<button class="btn btn-primary btn-lg custom-font" id="update-following-btn">';

  if (isFollowing($_GET['studentID'], $_SESSION['userID'])) {
    echo 'Following';
  } else {
    echo 'Follow';
  }

  echo '</button>';
}

function printAccountSettingsLink() {
  echo '<a href="account-info.php" class="btn btn-primary custom-font">Account settings</a>';
}

?>
