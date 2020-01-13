<?php
session_start();
include_once('functions.php');


if (isStudentEnrolled($_SESSION['userID'], $_GET['classID'])) {
  dropEnrolledCourse($_SESSION['userID'], $_GET['classID']);
} else {
  // register course
}


header('Location: class.php?classID=' . $_GET['classID']);
exit;

?>
