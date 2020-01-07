<?php
  session_start();

  if (isset($_GET['studentID']) == false) {
      header("Location: student-search.php");
  }

  include('functions.php');
  insert_Student_Followers($_GET['studentID'], $_SESSION['userID']);

  $studentID = $_GET['studentID'];

  header("Location: student.php?studentID=$studentID");
?>
