<?php

include_once('functions.php');

$students = searchForStudents($_GET['query']);
echo '<div class="card-deck">';
$count = 0;
while ($student = $students->fetch(PDO::FETCH_ASSOC)){
  if ($count == 3) {
    echo '</div><div class="card-deck">';
    $count = 0;
  }
  echo getStudentCard($student['sid'], $student['First'], $student['Last'], $student['Email'], $student['enrollmentCount'], $student['followersCount']);
  $count++;
}

echo '</div>';


?>
