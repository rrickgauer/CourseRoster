<?php
  session_start();
  if (!isset($_GET['classID'])) header("Location: school-search.php");
  include('functions.php');
  $class = getCourseInformation($_GET['classID']);
  $enrolledStudents = getStudentsEnrolledInClass($_GET['classID']);
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


     <table class="table table-sm table-hover">
       <thead>
         <tr>
           <th>First</th>
           <th>Last</th>
           <th>Email</th>
         </tr>
       </thead>

       <tbody>

         <?php

         while ($student = $enrolledStudents->fetch(PDO::FETCH_ASSOC)) {
           $studentID = $student['StudentID'];
           $first = $student['First'];
           $last = $student['Last'];
           $email = $student['Email'];

           echo "<tr data-student-id=\"$studentID\">";
           echo "<td>$first</td>";
           echo "<td>$last</td>";
           echo "<td>$email</td>";
           echo '</tr>';
         }
         ?>
       </tbody>
     </table>




  </div>

  <script>

  $(document).ready(function() {
    $("tr").on("click", function() {
      window.location.href = 'student.php?studentID=' + $(this).data("student-id");
    });
  });

  </script>




</body>

</html>
