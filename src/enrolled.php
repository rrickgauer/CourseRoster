<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include('head.php'); ?>
    <title>Find a course</title>
  </head>
  <body>
    <div class="container">
      <?php include('navbar.php'); ?>

      <h1 class="custom-font">Find a course</h1>

      <form class="form-inline" action="enrolled.php" method="post">

        <div class="form-group">
          <label for="school">School:</label>
          <select name="school" id="school" class="form-control">

            <?php
              include('functions.php');
              $pdo = dbConnect();
              $sql = "SELECT SchoolID, Name from School ORDER BY Name;";
              $result = $pdo->query($sql);

              while($row = $result->fetch(PDO::FETCH_ASSOC))
              {
                echo "<option value=\"".$row['SchoolID']."\" class=\"form-control\">".$row['Name']."</option>";
              }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="dept">Department:</label>
          <select class="form-control" name="dept" id="dept">
            <?php
              $sql = "SELECT DISTINCT Dept from Class ORDER BY Dept;";
              $result = $pdo->query($sql);

              while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value=\"".$row['Dept']."\">".$row['Dept']."</option>";
              }

            ?>
          </select>
        </div>

        <input type="submit" value="Submit" class="form-control btn blue-button">
      </form><br>



      <div class="list-group">
        <?php
          if (isset($_POST['dept']) && isset($_POST['school']))
          {
            $dept = $_POST['dept'];
            $schoolID = $_POST['school'];
            $sql = "SELECT Class.ClassID, Dept, Number, Title, COUNT(Enrolled.ClassID) AS Count FROM Class LEFT JOIN Enrolled ON Class.ClassID=Enrolled.ClassID WHERE Dept=\"$dept\" AND SchoolID=$schoolID GROUP BY Class.ClassID";

            $result = $pdo->query($sql);

            echo "<h2 class=\"custom-font\">$dept courses</h2>";

            // print the list of classes in the selected department
            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
              $id = $row['ClassID'];
              $title = $row['Title'];
              $dept = $row['Dept'];
              $number = $row['Number'];

              $item = getCourseListItem($row['ClassID'], $row['Dept'], $row['Number'], $row['Title'], $row['Count']);
              echo $item;
            }

            // link to submit a new course not on the website
            echo "<br><p class=\"text-center\">Don't see your course here? Submit a <a href=\"new-class.php\"> new course</a></p>";
          }
        ?>


      </div>

    </div>
  </body>
</html>
