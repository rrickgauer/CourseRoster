<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include('head.php'); ?>
    <title>New class</title>
  </head>

  <body>
    <div class="container">
      <?php include('navbar.php'); ?>

      <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">

          <p class="login-title text-center">Submit a new
            <span class="blue-font"> course</span>
          </p>

          <form action="new-class.php" method="post">
            <input class="form-control" type="text" name="dept" placeholder="Department" required><br>
            <input class="form-control" type="number" name="number" placeholder="Number" required><br>
            <input class="form-control" type="text" name="title" placeholder="Title" required><br>
            <input type="submit" value="Submit" class="btn blue-button form-control">
          </form>

          <?php
            // check if all fields have been set
            if (isset($_POST['dept']) && isset($_POST['number']) && isset($_POST['title']))
            {
              include('functions.php');

              // call the insertPotentialCourse function in 'functions.php'
              $worked = insertPotentialCourse($_POST['dept'], $_POST['number'], $_POST['title'], $_SESSION['userID']);

              // potential course was submitted successfully
              if($worked == true) {
                echo "<br><div class=\"alert alert-success\"><strong>Sucess!</strong> Please give us some time to review your submission.</div>";
              }

              // error in submitting potential course
              else {
                echo "<br><div class=\"alert alert-warning\"><strong>Warning!</strong> Error with submission.</div>";
              }
            }
          ?>
        </div>
        <div class="col-sm-3"></div>
      </div>
    </div>
  </body>
</html>
