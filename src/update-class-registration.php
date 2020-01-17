<?php
session_start();
include_once('functions.php');

if (isStudentEnrolled($_SESSION['userID'], $_GET['classID'])) {
  dropEnrolledCourse($_SESSION['userID'], $_GET['classID']);
  insertActivity($_SESSION['userID'], $_GET['classID'], 'dropped');
} else {
  enrollStudentInCourse($_SESSION['userID'], $_GET['classID']);
  insertActivity($_SESSION['userID'], $_GET['classID'], 'enrolled');

}

$class = getCourseInformation($_GET['classID'])->fetch(PDO::FETCH_ASSOC);
echo $class['count'];

exit;
?>
