<?php session_start(); ?>
<?php include('functions.php'); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title>Student search</title>
</head>

<body>

  <?php include('navbar.php'); ?>
  <div class="container">
    <h1 class="custom-font">Student search</h1>

    <div class="input-group input-group-lg">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class='bx bx-search'></i></span>
      </div>
      <input type="text" class="form-control" id="student-search-input" autofocus placeholder="Enter name">
    </div>

    <!-- get-students-from-search.php -->
    <div id="student-search-results"></div>
  </div>


  <script>
    $(document).ready(function() {
      $("#student-search-input").on("keyup", studentSearch);
      $("#nav-item-students").toggleClass("active");
    });

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

        var link = 'get-students-from-search.php?query=' + query;
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
