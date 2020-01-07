<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include('head.php'); ?>
    <title>Update password</title>
  </head>
  <body>
    <div class="container">
      <?php include('navbar.php'); ?>

      <h1 class="custom-font text-center">Update your password</h1><br>

      <div class="row">
        <div class="col-md-2 col-lg-3"></div>

        <div class="col-md-8 col-lg-6">
          <form action="update-password.php" method="post">
            <input class="form-control" type="password" name="old-password" placeholder="Old password" required><br>
            <input class="form-control" type="password" name="new-password" placeholder="New password" required><br>
            <input class="form-control" type="password" name="new-password-confirm" placeholder="Confirm new password" required><br>
            <input type="submit" class="btn blue-button form-control" name="submit-new-password" value="Save"><br>
          </form>

          <?php
            if (isset($_POST['old-password']) && isset($_POST['new-password']) && isset($_POST['new-password-confirm'])) {
              include('functions.php');
              $update = updatePassword($_SESSION['userID'], $_POST['old-password'], $_POST['new-password'], $_POST['new-password-confirm']);

              if($update == true) {
                echo "<br><div class=\"alert alert-success\"><strong>Sucess!</strong> Your password has been updated.</div>";
              }
              else {
                echo "<br><div class=\"alert alert-warning\"><strong>Warning!</strong> Password not updated. Please try again.</div>";
              }
            }
          ?>

        </div>
        <div class="col-md-2 col-lg-3"></div>
      </div>
    </div>
  </body>
</html>
