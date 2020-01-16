<?php
include_once('functions.php');
session_start();

header('Location: student.php?studentID=' . $_SESSION['userID']);
exit;

?>
