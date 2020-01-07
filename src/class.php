<?php
  session_start();
  if (!isset($_GET['classID'])) header("Location: school-search.php");
  include('functions.php');
  $class = getCourseInformation($_GET['classID']);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title><?php echo $class['Dept']." ".$class['Number'] . ' - ' . $class['Title'];?></title>
</head>

<body>
  <?php include('navbar.php'); ?>
  <div class="container">
    <div class="row">

      <div class="col-sm-12 col-md-10">
        <h1 class="custom-font"><?php echo $class['Dept'] ." ". $class['Number']; ?></h1>
        <h4 class="custom-font"> <?php echo $class['Title']; ?></h4>
      </div>

      <div class="col-sm-12 col-md-2">
        <br><br>
        <?php
          // check if student is enrolled
          $enrolled = isStudentEnrolled($_SESSION['userID'], $_GET['classID']);
          if ($enrolled == true) {
            include('class-enrolled.php');
          } else {
            include('class-not-enrolled.php');
          }
        ?>

      </div>
    </div>

    <div class="row">
      <div class="panel blue-background">
        <div class="panel-heading">
          <h4 class="custom-font">Current roster</h4>
        </div>
        <div class="list-group">

          <?php printCourseStudents($_GET['classID']); ?>

        </div>
      </div>
    </div>

  </div>
</body>

</html>
