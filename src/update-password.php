<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title>Update password</title>
</head>

<body>
  <?php include('navbar.php'); ?>
  <div class="container">

    <h1 class="custom-font text-center">Update your password</h1>

    <form class="form form-compact form-password" method="post">
      <input type="password" class="form-control" id="old-password" name="old-password" placeholder="Old password" required autofocus><br>

      <div class="new-password-group">
        <input type="password" class="form-control" id="new-password-1" name="new-password-1" placeholder="Confirm new password" required>
      </div>

      <br>

      <div class="new-password-group" id="new-password-group-2">
        <input type="password" class="form-control" id="new-password-2" name="new-password-2" placeholder="Confirm new password" required>
        <span class="password-status"></span>
      </div>

      <br>

      <input type="submit" value="Save" id="save-password-btn" class="btn btn-primary" disabled> <br> <br>
      <p>Update your <a href="account-info.php">account settings</a></p>
    </form>


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





</body>

</html>
