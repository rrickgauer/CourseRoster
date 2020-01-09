<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title>Account Info</title>
</head>

<body>

  <?php include('navbar.php'); ?>
  <div class="container">
    <h1 class="custom-font">Your profile</h1>

    <?php
        include('db-info.php');

        try {
          $pdo = new PDO("mysql:host=$host;dbname=$dbName",$user,$password);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sql = "SELECT First, Last, Email FROM Student WHERE StudentID=".$_SESSION['userID'];
          $result = $pdo->query($sql);
          $userInfo = $result->fetch(PDO::FETCH_ASSOC);

        } catch(PDOexception $e) {
            echo "connection failed" . $e->getMessage();
        }
      ?>

    <form class="form-horizontal" action="update-info.php" method="post">
      <div class="form-group">
        <label class="control-label col-sm-1" for="first">First</label>
        <div class="col-sm-11">
          <input class="form-control" type="text" name="first" value="<?php echo $userInfo['First']; ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-1" for="last">Last</label>
        <div class="col-sm-11">
          <input class="form-control" type="text" name="last" value="<?php echo $userInfo['Last']; ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-1" for="email">Email</label>
        <div class="col-sm-11">
          <input class="form-control" type="email" name="email" value="<?php echo $userInfo['Email']; ?>">
        </div>
      </div>

      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-11">
          <input type="submit" class="blue-button btn btn-primary" value="Save"><br><br>
          <p><b>Update your </b><a href="update-password.php"><b>password</b></a></p>
        </div>
      </div>
    </form>

  </div>
  <script>
    $(document).ready(function() {
      $("#nav-item-more").toggleClass("active");
      $("#nav-item-settings").toggleClass("active");
    });

  </script>
</body>

</html>
