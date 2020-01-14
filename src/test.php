<?php session_start(); ?>
<?php include('functions.php'); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title>Test</title>
</head>

<body>
  <?php include('navbar.php'); ?>

  <div class="container">

    <h1 class="custom-font text-center blue-font">Test</h1>


    <?php
        $hash = password_hash("901hayrack", PASSWORD_DEFAULT);

        if (password_verify('901hayrack', $hash)) {
          echo 'Password is valid!';
        } else {
          echo 'Invalid password.';
        }
    ?>










  </div>


</body>

</html>
