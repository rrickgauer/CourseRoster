<?php
  session_start();
  include('db-info.php');

  try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName",$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $classID = $_GET['classID'];
    $userID = $_SESSION['userID'];
    $sql = "INSERT INTO Enrolled values($userID, $classID)";
    $result = $pdo->exec($sql);

    header("Location: class.php?classID=$classID");

  } catch(PDOexception $e) {
      echo "connection failed" . $e->getMessage();
      header("Location: class.php?classID=$classID");
  }
?>
