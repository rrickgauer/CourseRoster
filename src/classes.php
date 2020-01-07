<?php session_start(); ?>
<?php include('functions.php'); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include('head.php'); ?>
    <title>Your classes</title>
  </head>
  <body>
    <div class="container">
      <?php include('navbar.php'); ?>

        <?php
            if (isset($_POST['classID']))
                dropEnrolledCourse($_SESSION['userID'], $_POST['classID']);
        ?>

      <p class="login-title"><span class="blue-font">Courses </span>you are enrolled in</p>

      <div class="table-responsive">
        <form class="form" action="classes.php" method="post">
          <table class="table table-striped" id="student-schedule">
              <thead>
                <tr>
                  <th>Dept</th>
                  <th>Number</th>
                  <th>Title</th>
                  <th>Select</th>
                </tr>
            </thead>

            <tbody>
                <?php printStudentCoursesTable($_SESSION['userID']); ?>
            </tbody>

          </table>
          <button type="submit" class="blue-button btn btn-primary form-control">Drop class</button>
        </form>
        <br><br><br>
      </div>
    </div>
  </body>
</html>
