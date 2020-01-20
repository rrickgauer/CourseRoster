<?php
  session_start();

  include('functions.php');

  if(!isset($_SESSION['userID']) || !isValidStudentID($_SESSION['userID'])) {
    header('Location: login.php');
    exit;
  }

  if (!isset($_GET['classID'])) {
    header("Location: school-search.php");
    exit;
  }


  $class = getCourseInformation($_GET['classID'])->fetch(PDO::FETCH_ASSOC);
  $isUserEnrolled = isStudentEnrolled($_SESSION['userID'], $_GET['classID']);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title><?php echo $class['Dept'] . '-' . $class['Number']; ?></title>
</head>

<body>
  <?php include('navbar.php'); ?>
  <div class="container">

    <h1 class="custom-font blue-font text-center"><?php echo $class['Dept'] ." ". $class['Number']; ?></h1>
    <h3 class="custom-font text-center"><?php echo $class['Title']; ?>&nbsp;&nbsp;<span class="badge badge-orange h3" id="class-enrollment-badge"><i class='bx bxs-user'></i>&nbsp;<?php echo $class['count']; ?></span></h3>


    <!-- register / drop -->
    <!-- see update-class-registration.php -->
    <button type="button" name="button" class="btn btn-primary custom-font" id="update-register-btn" data-class-id="<?php echo $_GET['classID']; ?>"><?php printDropRegisterButton($isUserEnrolled); ?></button>

    <br><br>

    <h4 class="custom-font">Current roster</h4>

    <!-- input toolbar -->
    <div class="input-group toolbar">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class='bx bx-search'></i></span>
      </div>
      <input type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Search">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='bx bx-dots-horizontal-rounded'></i></button>
        <div class="dropdown-menu">
          <h6 class="dropdown-header">View</h6>
          <button class="dropdown-item view active" onclick="setView('card')"><i class='bx bx-card'></i>&nbsp;Card</button>
          <button class="dropdown-item view" onclick="setView('table')"><i class='bx bx-table'></i>&nbsp;Table</button>
          <div role="separator" class="dropdown-divider"></div>
        </div>
      </div>
    </div>


    <!-- class-get-students-from-search.php -->
    <div id="data-view"></div>

    <?php printFooter(); ?>
  </div>

  <script>
    var view = 'card';

    $(document).ready(function() {
      $("#nav-item-courses").toggleClass("active");
      $("#update-register-btn").on("click", updateClassEnrollment);
      $(".toolbar input").on("keyup", searchForStudents);
      searchForStudents();
    });

    function updateClassEnrollment() {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          searchForStudents();
          $("#class-enrollment-badge").html('<i class="bx bxs-user"></i>&nbsp;' + this.responseText);
          updateRegisterButtonText();
        }
      };

      var classID = $("#update-register-btn").data("class-id");
      var link = 'update-class-registration.php?classID=' + classID;

      xhttp.open("GET", link, true);
      xhttp.send();
    }

    function updateRegisterButtonText() {
      var currentText = $("#update-register-btn").text();

      if (currentText == 'Enroll') {
        $("#update-register-btn").text("Enrolled");
      } else {
        $("#update-register-btn").text("Enroll");
      }
    }

    function searchForStudents() {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var e = this.responseText;
          $("#data-view").html(e);
        }
      };

      var userID = "<?php echo $_SESSION['userID']; ?>";
      var classID = "<?php echo $_GET['classID']; ?>";
      var query = $(".toolbar input").val();
      var link = 'class-get-students-from-search.php?view=' + view + '&query=' + query + '&classID=' + classID + '&userID=' + userID;

      xhttp.open("GET", link, true);
      xhttp.send();

    }

    function setView(newView) {
      view = newView;
      searchForStudents();
      $(".toolbar .view").toggleClass("active");
    }
  </script>

</body>

</html>

<?php

function printDropRegisterButton($isUserEnrolled) {
  if ($isUserEnrolled == true) {
    echo 'Enrolled';
  } else {
    echo 'Enroll';
  }
}

?>
