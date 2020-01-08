<?php session_start(); ?>
<?php include('functions.php'); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title>Student search</title>
</head>

<body>

  <?php include('navbar.php'); ?>
  <div class="container">
    <h1 class="custom-font">Student search</h1>

    <div class="input-group input-group-lg">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class='bx bx-search'></i></span>
      </div>
      <input type="text" class="form-control" id="student-search-input" autofocus placeholder="Enter name">
    </div>







  </div>
</body>

</html>
