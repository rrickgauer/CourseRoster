<?php

include('functions.php');

if (isset($_POST['first']) && isset($_POST['last']) && isset($_POST['email']) && isset($_POST['password'])) {

  if (getStudentID($_POST['email']) == null) {
   insertStudent($_POST['first'], $_POST['last'], $_POST['email'], $_POST['password']);
   session_start();
   $_SESSION['userID'] = getStudentID($_POST['email']);
   header('Location: my-profile.php');
   exit;

 } else {
   $emailExists = true;
 }
}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title>Sign up</title>
</head>

<body>
  <div class="container">

    <p class="login-title text-center">Sign up for
      <span class="blue-font">Course </span>
      <span class="orange-font">Roster</span>
    </p>


    <?php
    if (isset($emailExists)) {
      if ($emailExists == true) {
        echo getAlert('Oops!', 'warning', 'That email is already registered.');
      }
    }
    ?>

    <form class="form form-compact" action="createAccount.php" method="post">
      <input class="form-control" type="text" name="first" placeholder="First name" required autofocus><br>
      <input class="form-control" type="text" name="last" placeholder="Last name" required><br>
      <input class="form-control" type="email" name="email" placeholder="Email" required><br>
      <input class="form-control" type="password" id="new-password-1-create" name="password" placeholder="Password" required><br>
      <input class="form-control" type="password" id="new-password-2-create" name="password-2" placeholder="Reenter password" required><br>
      <input class="btn btn-primary form-control" id="save-password-btn" type="submit" name="createButton" value="Sign up" disabled>
    </form>

    <br>
    <p class="text-center">Already have an account?
      <a href="login.php"> Log in</a>
    </p>

    <?php printFooter(); ?>


  </div>

  <script>
    $(document).ready(function() {
      $("#new-password-1-create, #new-password-2-create").on("keyup", validatNewPassword);
    });

    function validatNewPassword() {
      var password1 = $("#new-password-1-create").val();
      var password2 = $("#new-password-2-create").val();

      if (isNewPasswordsNonEmpty()) {
        if (areNewPasswordsEqual() == false) {
          $("#new-password-2-create").addClass("invalid");
          $(".password-status").html("<i class='bx bxs-error'></i>");
          $("#save-password-btn").prop("disabled", true);

        } else {
          $("#new-password-2-create").removeClass("invalid");
          $(".password-status").html("<i class='bx bxs-check-circle'></i>");
          $("#save-password-btn").prop("disabled", false);
        }
      }

    }

    function areNewPasswordsEqual() {
      return ($("#new-password-1-create").val() == $("#new-password-2-create").val());
    }

    function isNewPasswordsNonEmpty() {
      var password1 = $("#new-password-1-create").val();
      var password2 = $("#new-password-2-create").val();
      return (password1.length > 0 && password2.length > 0)
    }
  </script>
</body>

</html>
