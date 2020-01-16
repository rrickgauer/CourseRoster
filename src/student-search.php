<?php
session_start();
include('functions.php');

if(!isset($_SESSION['userID']) || !isValidStudentID($_SESSION['userID'])) {
  header('Location: login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title>Student search</title>
</head>

<body>

  <?php include('navbar.php'); ?>
  <div class="container">
    <h1 class="custom-font blue-font text-center">Student search</h1> <br>

    <div class="input-group toolbar" id="student-search-toolbar">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class='bx bx-search'></i></span>
      </div>
      <input type="text" class="form-control" placeholder="Search" id="student-search-input">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary dropleft" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='bx bx-dots-horizontal-rounded'></i></button>
        <div class="dropdown-menu view-menu">
          <h6 class="dropdown-header">View</h6>
          <a class="dropdown-item view active" data-view-type="card" href="#">Card</a>
          <a class="dropdown-item view" data-view-type="table" href="#">Table</a>
        </div>
      </div>
    </div>

    <!-- get-students-from-search.php -->
    <div id="student-search-results"></div>

    <?php printFooter(); ?>

  </div>


  <script>

  var view = 'card';

    $(document).ready(function() {
      $("#student-search-input").on("keyup", studentSearch);
      $("#nav-item-students").toggleClass("active");
      $("#student-search-toolbar .view-menu .view").on("click", updateView);
    });

    function updateView() {
      if (view == 'card') {
        view = 'table';
      } else {
        view = 'card';
      }

      studentSearch();
      $("#student-search-toolbar .view-menu .view").toggleClass("active");
    }

    function studentSearch() {

      var query = $("#student-search-input").val();
      if (query.length >= 2) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var e = this.responseText;
            $("#student-search-results").html(e);
          }
        };

        var userID = '<?php echo $_SESSION['userID']; ?>';
        var link = 'get-students-from-search.php?query=' + query + '&userID=' + userID + '&view=' + view;
        xhttp.open("GET", link, true);
        xhttp.send();
      }

      else {
        $("#student-search-results").html('');
      }
    }

    function gotoStudentPage(studentCard) {
      var studentID = $(studentCard).data("student-id");
      window.location.href = 'student.php?studentID=' + studentID;
    }
  </script>
</body>

</html>
