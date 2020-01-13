<?php
session_start();
include_once('functions.php');


if (isStudentEnrolled($_SESSION['userID'], $_GET['classID'])) {
  // drop course
} else {
  // register course
}


header('Location: class.php?classID=' . $_GET['classID']);
exit;

?>
