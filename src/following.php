<?php session_start(); ?>
<?php include('functions.php'); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title>Following</title>
</head>

<body>

  <?php include('navbar.php'); ?>
  <div class="container">

    <?php

      // calculate how many people the student is following
        $pdo = dbConnect();
        $sql = "SELECT COUNT(*) FROM Student_Followers WHERE Student_Followers.FollowerID=" . $_SESSION['userID'];

        $result = $pdo->query($sql);
        $result2 = $result->fetch(PDO::FETCH_NUM);
        $numFollowing = $result2[0];
      ?>

    <h1 class="custom-font">People you are following
      <span class="badge blue-background" id="following-badge"><?php echo $numFollowing; ?></span>
    </h1>


    <div class="list-group">

      <?php
        $sql = "SELECT Student_Followers.StudentID, First, Last FROM Student_Followers, Student WHERE Student.StudentID=Student_Followers.StudentID AND Student_Followers.FollowerID=" . $_SESSION['userID'];

        $result = $pdo->query($sql);

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
          $id = $row['StudentID'];
          $first = $row['First'];
          $last = $row['Last'];
          echo "<a class=\"list-group-item\" href=\"student.php?studentID=$id\"><b>$first $last</b></a>";
        }
      ?>



    </div>
  </div>

</body>

</html>
