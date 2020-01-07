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

    <!-- Keyword search form -->
    <form action="student-search.php" method="post">
      <div class="row">
        <div class="col-sm-12 col-md-10">
          <input class="form-control" type="text" name="keyword" placeholder="Keyword" required autofocus>
        </div>

        <div class="col-sm-12 col-md-1">
          <button class="btn blue-button" type="submit">Search</button>
        </div>
      </div>
    </form>

    <br>

    <!-- If the key word is set, print the results -->
    <?php if (isset($_POST['keyword'])) printStudentSearchResults($_POST['keyword']); ?>

  </div>
</body>

</html>
