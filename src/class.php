<?php
  session_start();
  if (!isset($_GET['classID'])) header("Location: school-search.php");
  include('functions.php');
  $class = getCourseInformation($_GET['classID'])->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title><?php echo $class['Dept']." ".$class['Number'] . ' - ' . $class['Title'];?></title>
</head>

<body>
  <?php include('navbar.php'); ?>
  <div class="container">

    <h1 class="custom-font"><?php echo $class['Dept'] ." ". $class['Number']; ?></h1>
    <h3 class="custom-font"> <?php echo $class['Title']; ?></h3>
    <h3><span class="badge badge-orange"><i class='bx bxs-user'></i> <?php echo $class['count']; ?></span></h3>

    <?php
      // check if student is enrolled
      $enrolled = isStudentEnrolled($_SESSION['userID'], $_GET['classID']);
      if ($enrolled == true) {
        include('class-enrolled.php');
      } else {
        include('class-not-enrolled.php');
      }
    ?>

    <div class="card-deck">

      <?php

      $enrolledStudents = getStudentsEnrolledInClass($_GET['classID']);
      $count = 0;
      while ($student = $enrolledStudents->fetch(PDO::FETCH_ASSOC)) {
        if ($count == 3) {
          echo '</div><div class="card-deck">';
          $count = 0;
        }
        echo getStudentCard($student['StudentID'], $student['First'], $student['Last'], $student['Email']);
        $count++;
      }
      ?>

    </div>
  </div>

  <script>
    $(document).ready(function() {
      $(".student-card").on("click", function() {
        var studentID = $(this).data("student-id");
        window.location.href = 'student.php?studentID=' + studentID;
      });

      $("#nav-item-courses").toggleClass("active");
    });
  </script>

</body>

</html>
