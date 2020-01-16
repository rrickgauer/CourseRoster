<?php
include_once('functions.php');
session_start();
$student = getStudentInfo($_GET['studentID'])->fetch(PDO::FETCH_ASSOC);
$response = json_encode($student);
echo $response;
?>
