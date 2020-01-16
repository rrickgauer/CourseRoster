<?php
include_once('functions.php');
$courses = searchForStudentEnrolledCourses($_GET['studentID'], $_GET['query']);

if ($_GET['view'] == 'table') {
  printCourseCardTable($courses);
} else {
  printClassCardDeck($courses);
}

exit;
?>
