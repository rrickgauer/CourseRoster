<?php

include('functions.php');
session_start();

if ($_SESSION['userID'] == $_GET['studentID']) {
  header('Location: enrolled.php');
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

        <h1><?php echo $student['First'] . ' ' . $student['Last']; ?></h1>
        <h5><?php echo $student['Email']; ?></h5>
        <p><i class='bx bx-chalkboard'></i> <?php echo $student['count']; ?></p>


      </div>

      <div class="col-sm-12 col-md-2">
        <?php if (isFollowing($_GET['studentID'], $_SESSION['userID']) == false)  { ?>
        <a href="follow.php?studentID=<?php echo $_GET['studentID']; ?>" class="btn btn-lg blue-button custom-font" role="button">Follow</a>
        <?php } else { ?>
        <a href="unfollow.php?studentID=<?php echo $_GET['studentID']; ?>" class="btn btn-lg blue-button custom-font" role="button">Unfollow</a> <?php } ?>
      </div>
    </div>


    <div class="card-deck">

      <?php

      $count = 0;
      while ($course = $enrolledCourses->fetch(PDO::FETCH_ASSOC)) {
        if ($count == 3) {
          echo '</div><div class="card-deck">';
          $count = 0;
        }

        echo getClassCard($course['cid'], $course['Dept'], $course['Number'], $course['Title'], $course['count']);

        $count++;
      }


      ?>

    </div>










  </div>

</body>

</html>
