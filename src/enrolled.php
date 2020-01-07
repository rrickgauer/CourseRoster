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

    <?php
      while ($course = $enrolledCourses->fetch(PDO::FETCH_ASSOC)) {
        printClassCard($course['cid'], $course['Dept'], $course['Number'], $course['Title'], $course['count']);
      }
    ?>

  </div>

  <script>

  $(document).ready(function() {
    $(".card-enrolled").on("click", function() {
      window.location.href = "class.php?classID=" + $(this).data("class-id");
    });
  });

  </script>

</body>

</html>

<?php

function printClassCard($classID, $dept, $number, $title, $count) {
  echo "<div class=\"card card-enrolled\" data-class-id=\"$classID\">
    <div class=\"card-body\">
      <h5>$dept-$number: $title</h5>
      <p><span class=\"badge badge-secondary\">Students: $count</span></p>
    </div>
  </div>";
}

?>
