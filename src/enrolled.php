<?php
session_start();
include('functions.php');
$enrolledCourses = getEnrolledCourses($_SESSION['userID']);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title>Your classes</title>
</head>

<body>

  <?php include('navbar.php'); ?>

  <div class="container">

    <p class="login-title"><span class="blue-font">Courses </span>you are enrolled in</p>

    <div class="card-deck">
    <?php
      $count = 0;
      while ($course = $enrolledCourses->fetch(PDO::FETCH_ASSOC)) {
        if ($count == 3) {
          echo '</div><div class="card-deck">';
          $count = 0;
        }
        printClassCard($course['cid'], $course['Dept'], $course['Number'], $course['Title'], $course['count']);
        $count++;
      }
    ?>

    </div>

  </div>
</body>

</html>

<?php

function printClassCard($classID, $dept, $number, $title, $count) {
  echo "<div class=\"card class-card\">
  <div class=\"card-header\">
    <h3>$dept-$number</h3>
  </div>
  <div class=\"card-body\">
    <h5>$title</h5>
   </div>
    <div class=\"card-footer\">
      <span class=\"badge badge-orange\"><i class='bx bxs-user' ></i> $count</span>
      <a href=\"class.php?classID=$classID\" class=\"float-right\"><i class='bx bx-link-external' ></i></a>
    </div>
  </div>";
}

?>
