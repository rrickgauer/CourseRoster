<?php
session_start();
include('functions.php');

if(!isset($_SESSION['userID']) || !isValidStudentID($_SESSION['userID'])) {
  header('Location: login.php');
  exit;
}

$depts = getDistinctDepts();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title>Course search</title>
</head>

<body>

  <?php include('navbar.php'); ?>

  <div class="container">
    <h1 class="custom-font">Course search</h1>

    <!-- dept select -->
    <select class="form-control" name="dept" id="dept-select">
      <option></option>
      <?php
      while ($dept = $depts->fetch(PDO::FETCH_ASSOC)){
        echo '<option value="' . $dept['Dept'] . '">' . $dept['Dept'] . '</option>';
      }
      ?>
    </select>

    <!-- get-classes-in-dept.php -->
    <div id="classes-section"></div>

  </div>

  <script>
    $(document).ready(function() {
      $("#dept-select").select2({
        placeholder: "Select a department",
        allowClear: true,
        theme: 'bootstrap4',
      });
      $("#dept-select").on('change', printClasses);
      $("#nav-item-courses").toggleClass("active");
    });

    function printClasses() {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var e = this.responseText;
          $("#classes-section").html(e);
        }
      };

      var dept = $("#dept-select").val();
      var link = 'get-classes-in-dept.php?dept=' + dept;
      xhttp.open("GET", link, true);
      xhttp.send();
    }
  </script>
</body>

</html>
