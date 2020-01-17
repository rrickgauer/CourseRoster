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
  <title>Course Roster</title>
</head>

<body>
  <?php include('navbar.php'); ?>
  <div class="container">
    <h1 class="custom-font text-center"><span class="blue-font">Course</span><span class="orange-font">&nbsp;roster</span></h1>

    <h3>Latest activity</h3>

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

  echo "<a href=\"#\">$first $last</a>";

  if ($type == 'followed') {
    echo " $type $target";
  } else {
    echo " $type in $target";
  }

  echo "<span class=\"badge badge-secondary float-right\"> 1/16/20</span>";
  echo '</li>';


}



?>
