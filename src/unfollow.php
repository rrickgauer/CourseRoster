<?php
  session_start();
  include('functions.php');
  delete_Student_Followers($_GET['studentID'], $_SESSION['userID']);
  $studentID = $_GET['studentID'];
  header("Location: student.php?studentID=$studentID");
?>
