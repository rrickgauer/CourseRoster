<?php
  session_start();
  include('functions.php');
  dropEnrolledCourse($_SESSION['userID'], $_GET['classID']);
  header("Location: class.php?classID=".$_GET['classID']);
?>
