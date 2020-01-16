<?php

include('functions.php');

if (isset($_POST['email']) && isset($_POST['password'])) {

  if (validateLoginAttempt($_POST['email'], $_POST['password'])) {
    session_start();
    $_SESSION['userID'] = getStudentID($_POST['email']);
    header('Location: my-profile.php');
    exit;
  } else {
    $incorrectLoginAttempt = true;
  }

}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title>Course Roster</title>
</head>

<body style="background-color: #ededed;">
  <div class="container">

    <h1 class="login-title login-title-large text-center">
      <span class="blue-font">Course </span>
      <span class="orange-font">Roster</span>
    </h1>

    <?php
    if (isset($incorrectLoginAttempt)) {
      if ($incorrectLoginAttempt == true) {
        echo getAlert('Login unsuccessful!', 'danger');
      }
    }
    ?>

    <form class="form form-compact" action="login.php" method="post">
      <input class="form-control" type="email" name="email" placeholder="Email" required autofocus><br>
      <input class="form-control" type="password" name="password" placeholder="Password" required><br>
      <input class="form-control blue-button" type="submit" class="btn btn-default" value="Login" name="loginButton">
    </form>
    <br>
    <p class="text-center">Don't have an account?<a href="createAccount.php"> Sign up</a></p>

    <?php printFooter(); ?>


  </div>
</body>

</html>
