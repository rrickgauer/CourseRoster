<?php

include('functions.php');

if (isset($_POST['email']) && isset($_POST['password'])) {

  $student = validateLoginAttempt($_POST['email'], $_POST['password']);

  if ($student->rowCount() == 1) {
    session_start();
    $userID = $student->fetch(PDO::FETCH_ASSOC);
    $_SESSION['userID'] = $userID['StudentID'];
    header('Location: home.php');
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
    <title>Free student course scheduling tool - Course Roster </title>
  </head>
  <body>
    <div class="container">

      <header>
        <div class="row" id="login-space-above">
          <div class="col-md-2 col-lg-3"></div>
          <div class="col-md-8 col-lg-6">
              <h1 class="login-title-large text-center">
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

            <form action="login.php" method="post">
              <input class="form-control" type="email" name="email" placeholder="Email" required><br>
              <input class="form-control" type="password" name="password" placeholder="Password" required><br>
              <input class="form-control blue-button" type="submit" class="btn btn-default" value="Login" name="loginButton">
            </form>

            <br>
            <p class="text-center">Don't have an account?
              <a href="createAccount.php">Sign up</a>
            </p>

          </div>
          <div class="col-md-2 col-lg-3"></div>
        </div>
      </header>

      <section>
        <div class="row">
          <div class="col-sm-12 col-lg-12">
            <ul class="list-inline text-center">
              <li class="list-inline-item"><a href="about.php">About</a></li>
              <li class="list-inline-item"><a href="contact-us.php">Contact</a></li>
            </ul>
          </div>
        </div>
      </section>

    </div>
  </body>
</html>
