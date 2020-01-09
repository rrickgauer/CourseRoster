<?php
include_once('functions.php');
$courses = searchForStudentEnrolledCourses($_GET['studentID'], $_GET['query']);
printClassCardDeck($courses);
exit;
?>
