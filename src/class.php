<?php
  session_start();
  if (!isset($_GET['classID'])) header("Location: school-search.php");
  include('functions.php');
  $class = getCourseInformation($_GET['classID'])->fetch(PDO::FETCH_ASSOC);
  $isUserEnrolled = isStudentEnrolled($_SESSION['userID'], $_GET['classID']);

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

    <div class="card class-card">
      <div class="card-header">
        <h1 class="custom-font"><?php echo $class['Dept'] ." ". $class['Number']; ?></h1>
      </div>

      <div class="card-body">
        <h3 class="custom-font"> <?php echo $class['Title']; ?></h3>
      </div>

      <div class="card-footer">
        <p class="h3"><span class="h3 badge badge-orange h3"><i class='bx bxs-user'></i> <?php echo $class['count']; ?></span>
        <button type="button" name="button" class="btn btn-primary float-right" id="update-register-btn" data-class-id="<?php echo $_GET['classID']; ?>">
          <?php
          if ($isUserEnrolled == true) {
            echo 'Drop';
          } else {
            echo 'Register';
          }
          ?>
        </button></p>
      </div>

    </div>





    <div class="card-deck">

      <?php
      $enrolledStudents = getStudentsEnrolledInClass($_GET['classID']);
      $count = 0;
      while ($student = $enrolledStudents->fetch(PDO::FETCH_ASSOC)) {
        if ($count == 3) {
          echo '</div><div class="card-deck">';
          $count = 0;
        }
        echo getStudentCard($student['sid'], $student['First'], $student['Last'], $student['Email'],  $student['enrollmentCount'], $student['followersCount']);
        $count++;
      }
      ?>

    </div>
  </div>

  <script>
    $(document).ready(function() {
      $(".student-card").on("click", function() {
        var studentID = $(this).data("student-id");
        window.location.href = 'student.php?studentID=' + studentID;
      });

      $("#nav-item-courses").toggleClass("active");

      $("#update-register-btn").on("click", function() {
        window.location.href = 'update-class-registration.php?classID=<?php echo $_GET['classID']; ?>';
      });





    });
  </script>

</body>

</html>
