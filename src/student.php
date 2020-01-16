<?php
include('functions.php');
session_start();

if ($_SESSION['userID'] == $_GET['studentID']) {
  header('Location: home.php');
  exit;
}
$student = getStudentInfo($_GET['studentID'])->fetch(PDO::FETCH_ASSOC);
$enrolledCourses = getEnrolledCourses($_GET['studentID']);
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

    <div class="row">
      <div class="col-sm-12 col-md-10">
        <h1 class="custom-font blue-font"><?php echo $student['First'] . ' ' . $student['Last']; ?></h1>
        <h5><?php echo $student['Email']; ?></h5>
        <h5><span class="badge badge-primary"><i class='bx bx-chalkboard'></i> <?php echo $student['coursesCount']; ?></span></h5>
      </div>

      <div class="col-sm-12 col-md-2">
        <?php if (isFollowing($_GET['studentID'], $_SESSION['userID']) == false)  { ?>
        <a href="follow.php?studentID=<?php echo $_GET['studentID']; ?>" class="btn btn-lg blue-button custom-font" role="button">Follow</a>
        <?php } else { ?>
        <a href="unfollow.php?studentID=<?php echo $_GET['studentID']; ?>" class="btn btn-lg blue-button custom-font" role="button">Unfollow</a> <?php } ?>
      </div>
    </div>

    <div class="input-group toolbar">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class='bx bx-search'></i></span>
      </div>
      <input type="text" class="form-control" placeholder="Search" id="course-search-input">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary dropleft" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='bx bx-dots-horizontal-rounded'></i></button>
        <div class="dropdown-menu view-menu">
          <h6 class="dropdown-header">View</h6>
          <a class="dropdown-item view active" data-view-type="card" href="#">Card</a>
          <a class="dropdown-item view" data-view-type="table" href="#">Table</a>
        </div>
      </div>
    </div>

    <div id="courses-section">

    </div>



    <?php printFooter(); ?>

  </div>
  <script>

  var view = 'card';

    $(document).ready(function() {
      $("#nav-item-students").toggleClass("active");
      $('[data-toggle="tooltip"]').tooltip();
      $("#course-search-input").on("keyup", searchCourses);
      searchCourses();

      $(".view-menu .view").on("click", updateView);
    });

    function updateView() {
      if (view == 'card') {
        view = 'table';
      } else {
        view = 'card';
      }

      searchCourses();

      $(".view-menu .view").toggleClass("active");
    }

    function searchCourses() {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var e = this.responseText;
          $("#courses-section").html(e);
        }
      };

      var link = getLinkForSeachCourses();
      xhttp.open("GET", link, true);
      xhttp.send();
    }

    function getLinkForSeachCourses() {
      var studentID = '<?php echo $_GET['studentID']; ?>';
      var query = $("#course-search-input").val();
      var link = 'get-user-courses-from-search.php?studentID=' + studentID + '&view=' + view + '&query=' + query;
      return link;
    }





  </script>






</body>

</html>
