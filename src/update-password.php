<?php
session_start();
include('functions.php');

if(!isset($_SESSION['userID']) || !isValidStudentID($_SESSION['userID'])) {
  header('Location: login.php');
  exit;
}

// if new password was submitted check if it matches old password
if (isset($_POST['old-password']) && isset($_POST['new-password-1']) && isset($_POST['new-password-2'])) {

  if (isCorrectPassword($_SESSION['userID'], $_POST['old-password'])) {
    updateStudentPassword($_SESSION['userID'], $_POST['new-password-1']);
    $succesfulUpdate = true;
  } else {
    $succesfulUpdate = false;
  }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title>Update password</title>
</head>

<body>
  <?php include('navbar.php'); ?>
  <div class="container">

    <h1 class="custom-font text-center blue-font">Update password</h1>

    <form class="form form-compact form-password" method="post">
      <?php
      if (isset($succesfulUpdate)) {
        isPasswordUpdated($succesfulUpdate);
      }
      ?>

      <!-- old password -->
      <input type="password" class="form-control" id="old-password" name="old-password" placeholder="Old password" required autofocus>

      <!-- new password 1 -->
      <div class="new-password-group">
        <input type="password" class="form-control" id="new-password-1" name="new-password-1" placeholder="New password" required>
      </div>

      <!-- new-password 2 -->
      <div class="new-password-group" id="new-password-group-2">
        <input type="password" class="form-control" id="new-password-2" name="new-password-2" placeholder="Confirm new password" required>
        <span class="password-status"></span>
      </div>

      <input type="submit" value="Save" id="save-password-btn" class="btn btn-primary" disabled>
      <p>Update your <a href="account-info.php">account settings</a></p>
    </form>

    <?php printFooter(); ?>


  </div>

  <script>
    $(document).ready(function() {
      $("#new-password-1, #new-password-2").on("keyup", validatNewPassword);
    });

    function validatNewPassword() {
      var password1 = $("#new-password-1").val();
      var password2 = $("#new-password-2").val();

      if (isNewPasswordsNonEmpty()) {
        if (areNewPasswordsEqual() == false) {
          $("#new-password-2").addClass("invalid");
          $(".password-status").html("<i class='bx bxs-error'></i>");
          $("#save-password-btn").prop("disabled", true);

        } else {
          $("#new-password-2").removeClass("invalid");
          $(".password-status").html("<i class='bx bxs-check-circle'></i>");
          $("#save-password-btn").prop("disabled", false);
        }
      }

    }

    function areNewPasswordsEqual() {
      return ($("#new-password-1").val() == $("#new-password-2").val());
    }

    function isNewPasswordsNonEmpty() {
      var password1 = $("#new-password-1").val();
      var password2 = $("#new-password-2").val();
      return (password1.length > 0 && password2.length > 0)
    }
  </script>



  <script>

  $(document).ready(function() {
    $("#nav-item-more").toggleClass("active");
    $("#nav-item-settings").toggleClass("active");
  });

  </script>

</body>

</html>

<?php

function isPasswordUpdated($succesfulUpdate) {
  if ($succesfulUpdate == true) {
    echo getAlert('Success!', 'success', 'Your password has been updated.');
  } else {
    echo getAlert('Error!', 'danger', 'Please enter your correct password.');

  }
}

?>
