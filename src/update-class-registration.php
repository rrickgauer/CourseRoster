<?php
session_start();
include_once('functions.php');


if (isStudentEnrolled($_SESSION['userID'], $_GET['classID'])) {
  dropEnrolledCourse($_SESSION['userID'], $_GET['classID']);
} else {
  enrollStudentInCourse($_SESSION['userID'], $_GET['classID']);
}


header('Location: class.php?classID=' . $_GET['classID']);
exit;

?>
