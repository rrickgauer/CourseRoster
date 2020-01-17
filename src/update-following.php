<?php
include_once('functions.php');
session_start();

if (isFollowing($_GET['studentID'], $_SESSION['userID'])) {
  removeStudentFollower($_GET['studentID'], $_SESSION['userID']);
  insertActivity($_SESSION['userID'], $_GET['studentID'], 'unfollowed');
  echo 'Follow';
} else {
  insertStudentFollower($_GET['studentID'], $_SESSION['userID']);
  insertActivity($_SESSION['userID'], $_GET['studentID'], 'followed');
  echo 'Following';
}

exit;

?>
