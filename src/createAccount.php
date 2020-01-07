
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include('head.php'); ?>
    <title>Sign up</title>
  </head>
  <body>
    <div class="container">
      <div class="col-md-2 col-lg-3"></div>

      <div class="col-md-8 col-lg-6" id="login-space-above">

        <p class="login-title text-center">Sign up for
          <span class="blue-font">Course </span>
          <span class="orange-font">Roster</span>
        </p>

        <div class="form-group">
          <form class="form" action="createAccount.php" method="post">
            <input class="form-control" type="text" name="first" placeholder="First name" required><br>
            <input class="form-control" type="text" name="last" placeholder="Last name" required><br>
            <input class="form-control" type="email" name="email" placeholder="Email" required><br>
            <input class="form-control" type="password" name="password" placeholder="Password" required><br>
            <input class="form-control blue-button" type="submit" name="createButton"  value="Create account">
          </form>

          <br><p class="text-center">Already have an account?
            <a href="login.php"> Log in</a>
          </p>
        </div>

        <div class="col-md-2 col-lg-3"></div>


      </div>

      <?php
        // check if all inputs have been filled out
        if (isset($_POST['first']) && isset($_POST['last']) && isset($_POST['email']) && isset($_POST['password'])) {
          include('functions.php');

          // call function createNewStudent from functions.php
          createNewStudentAccount($_POST['first'], $_POST['last'], $_POST['email'], $_POST['password']);

          // get new student's id
          $studentID = getStudentID($_POST['email']);

          // start the session and set the session student id
          session_start();
          $_SESSION['userID'] = $studentID;

          // load enrolled page
          header("Location: school-search.php");

        }
      ?>

      <section>
        <div class="row">
          <div class="col-sm-12 col-lg-12">
            <ul class="list-inline text-center">
              <li><a href="about.php">About</a></li>
              <li><a href="contact-us.php">Contact</a></li>
            </ul>
          </div>
        </div>
      </section>

    </div>
  </body>
</html>
