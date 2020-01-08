<?php

include_once('functions.php');

$students = searchForStudents($_GET['query']);
while ($student = $students->fetch(PDO::FETCH_ASSOC)){
  echo getStudentCard($student['StudentID'], $student['First'], $student['Last'], $student['Email']);
}

?>
