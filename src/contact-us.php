<?php

session_start();
include('functions.php');

if (isset($_POST['first']) && isset($_POST['last']) && isset($_POST['email']) && isset($_POST['message']))
{
  contact_us_submission($_POST['first'], $_POST['last'], $_POST['email'], $_POST['message']);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include('head.php'); ?>
    <title>Contact us - Course Roster</title>
  </head>
  <body>
    <div class="container">

      <?php
        if (isset($_SESSION['userID'])) {
          include('navbar.php');
        }

      ?>

      <h1 class="custom-font">Contact course roster</h1>

      <form class="form-horizontal" action="contact-us.php" method="post">

        <div class="row">
        <div class="form-group">
          <label class="control-label col-sm-2" for="first">First name:</label>
          <div class="col-sm-5">
            <input type="text" name = "first" class="form-control" id="first" placeholder="Enter first name">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <label class="control-label col-sm-2" for="last">Last name:</label>
          <div class="col-sm-5">
            <input type="text" name="last" class="form-control" id="last" placeholder="Enter last name">
          </div>
        </div>
        </div>

      <div class="row">
        <div class="form-group">
          <label class="control-label col-sm-2" for="email">Email:</label>
          <div class="col-sm-5">
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
          </div>
        </div>
        </div>


      <div class="row">
        <div class="form-group">
          <label class="control-label col-sm-2" for="message">Message:</label>
          <div class="col-sm-5">
            <textarea name="message" class="form-control" rows="5" id="comment" placeholder="Enter message"></textarea>
          </div>
        </div>
        </div>

        <div class="row">
          <div class="col-sm-2"></div>
          <div class="col-sm-5">
          <input type="submit" value="Submit" class="form-control btn blue-button">
        </div>


      </form>
    </div>

  </body>
</html>
