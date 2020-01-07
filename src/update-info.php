<?php session_start(); ?>

<?php

  include('db-info.php');

  try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName",$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $id = $_SESSION['userID'];

    $sql = "UPDATE Student SET First=\"$first\", Last=\"$last\", Email=\"$email\" WHERE StudentID=$id";
    $result = $pdo->exec($sql);

    header("Location: account-info.php");

  } catch(PDOexception $e) {
      echo "connection failed" . $e->getMessage();
  }


?>
