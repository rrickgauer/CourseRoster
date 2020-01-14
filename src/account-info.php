<?php
session_start();
include('functions.php');

if(!isset($_SESSION['userID']) || !isValidStudentID($_SESSION['userID'])) {
  header('Location: login.php');
  exit;
}

if (isset($_POST['first']) && isset($_POST['last']) && isset($_POST['email'])) {
  $successfulUpdate = updateStudentInfo($_SESSION['userID'], $_POST['first'], $_POST['last'], $_POST['email']);
}

$student = getStudentInfo($_SESSION['userID'])->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <?php include('head.php'); ?>
  <title>Account Info</title>
</head>

<body>

  <?php include('navbar.php'); ?>
  <div class="container">
    <h1 class="custom-font text-center">Account settings</h1>

    <?php
    if (isset($successfulUpdate)) {
      printUpdateAlert($successfulUpdate);
    }
    ?>

    <form class="form form-compact" method="post">

      <div class="form-group">
        <label for="first">First name</label>
        <input type="text" class="form-control" name="first" id="first" placeholder="Enter first name" value="<?php echo $student['First']; ?>" required>
      </div>

      <div class="form-group">
        <label for="last">Last name</label>
        <input type="text" class="form-control" name="last" id="last" placeholder="Enter last name" value="<?php echo $student['Last']; ?>" required>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="<?php echo $student['Email']; ?>" required>
      </div>

      <input type="submit" name="submit" value="Update" class="btn btn-primary float-right">
      <p>Update your <a href="update-password.php">password</a></p>
    </form>

    <?php printFooter(); ?>


  </div>
  <script>
    $(document).ready(function() {
      $("#nav-item-more").toggleClass("active");
      $("#nav-item-settings").toggleClass("active");
    });
  </script>
</body>

</html>

<?php
function printUpdateAlert($successfulUpdate) {
  if ($successfulUpdate == true) {
    echo getAlert('Success!', 'success', 'Your information was updated successfully.');
  } else {
    echo getAlert('Error', 'danger', 'There was an error in updating your information.');
  }
}
?>
