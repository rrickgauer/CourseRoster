<?php
session_start();
include('functions.php');

if(!isset($_SESSION['userID']) || !isValidStudentID($_SESSION['userID'])) {
  header('Location: login.php');
  exit;
}
$student = getStudentInfo($_SESSION['userID'])->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include('head.php'); ?>
    <title>Course Roster</title>
  </head>
  <body>
    <?php include('navbar.php'); ?>
    <div class="container">

      <h1 class="custom-font">Welcome to&nbsp;<span class="blue-font">course</span><span class="orange-font">&nbsp;roster</span></h1>

    </div>

    <script>
    $(document).ready(function() {
      $("#nav-item-home").addClass("active");
    });

    </script>

  </body>
</html>
