<?php
include_once('functions.php');
session_start();

if (isFollowing($_GET['studentID'], $_SESSION['userID'])) {
  removeStudentFollower($_GET['studentID'], $_SESSION['userID']);
  echo 'Follow';
} else {
  insertStudentFollower($_GET['studentID'], $_SESSION['userID']);
  echo 'Following';
}

exit;

?>
