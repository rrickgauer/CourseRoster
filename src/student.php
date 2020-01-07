<?php

include('functions.php');
session_start();

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include('head.php'); ?>
    <title>
        <?php
            // get students first and last names
            $names = getStudentFirstLastNames($_GET['studentID']);
            echo $names['First'] . ' ' . $names['Last'];
        ?>
    </title>
  </head>
  <body>
    <div class="container">

      <?php include('navbar.php'); ?>

      <div class="row">
        <div class="col-sm-12 col-md-10">
          <p class="login-title">
            <?php echo $names['First'] . ' ' . $names['Last'] . "'s"; ?>
            <span class="blue-font"> courses</span>
          </p>
        </div>

        <div class="col-sm-12 col-md-2">
            <?php if (isFollowing($_GET['studentID'], $_SESSION['userID']) == false)  { ?>
                <a href="follow.php?studentID=<?php echo $_GET['studentID']; ?>" class="btn btn-lg blue-button custom-font" role="button">Follow</a>
            <?php } else { ?>
                <a href="unfollow.php?studentID=<?php echo $_GET['studentID']; ?>" class="btn btn-lg blue-button custom-font" role="button">Unfollow</a> <?php } ?>
        </div>
    </div>

    <div class="list-group">
        <?php printStudentCourses($_GET['studentID']); ?>
    </div>

  </div>

  </body>
</html>
