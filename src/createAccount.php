<?php

include('functions.php');

if (isset($_POST['first']) && isset($_POST['last']) && isset($_POST['email']) && isset($_POST['password'])) {

  if (getStudentID($_POST['email']) == null) {
   insertStudent($_POST['first'], $_POST['last'], $_POST['email'], $_POST['password']);
   session_start();
   $_SESSION['userID'] = getStudentID($_POST['email']);
   header('Location: home.php');
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
      <input class="form-control" type="text" name="first" placeholder="First name" required><br>
      <input class="form-control" type="text" name="last" placeholder="Last name" required><br>
      <input class="form-control" type="email" name="email" placeholder="Email" required><br>
      <input class="form-control" type="password" name="password" placeholder="Password" required><br>
      <input class="btn btn-primary form-control" type="submit" name="createButton" value="Sign up">
    </form>

    <br>
    <p class="text-center">Already have an account?
      <a href="login.php"> Log in</a>
    </p>

  </div>
</body>

</html>
