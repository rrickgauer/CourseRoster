<?php
session_start();
include('functions.php');

if(!isset($_SESSION['userID']) || !isValidStudentID($_SESSION['userID'])) {
  header('Location: login.php');
  exit;
}

$activities = getActivity();

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
    <h1 class="custom-font text-center"><span class="blue-font">Course</span><span class="orange-font">&nbsp;Roster</span></h1>

    <h6>Latest activity</h6>

    <ul class="list-group list-group-flush">
    <?php

    while ($activity = $activities->fetch(PDO::FETCH_ASSOC)) {
      printActivity($activity);
    }
    ?>

    </ul>
  </div>

  <script>
    $(document).ready(function() {
      $("#nav-item-home").addClass("active");
    });
  </script>

</body>

</html>

<?php

function printActivity($activity) {

  $activityID  = $activity['ActivityID'];
  $studentID   = $activity['StudentID'];
  $first       = $activity['First'];
  $last        = $activity['Last'];
  $type        = $activity['Type'];
  $targetID    = $activity['tid'];
  $target      = $activity['target'];
  $time        = $activity['Time'];
  $displayDate = $activity['display_date'];
  $displayTime = $activity['display_time'];

  echo '<li class="list-group-item">';

  echo "<a href=\"student.php?studentID=$studentID\">$first $last</a>";

  if ($type == 'enrolled') {
    echo " <i>enrolled</i> in <a href=\"class.php?classID=$targetID\"> $target</a>";
  } else if ($type == 'followed') {
    echo " <i>followed</i> <a href=\"student.php?studentID=$targetID\"> $target</a>";
  } else if ($type == 'dropped') {
    echo " <i>dropped</i> <a href=\"class.php?classID=$targetID\"> $target</a>";
  }

  echo '<br>';

  echo "<i class='bx bx-time'></i> $displayDate &bull; $displayTime";
  echo '</li>';


}



?>
