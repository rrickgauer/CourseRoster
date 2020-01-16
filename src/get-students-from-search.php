<?php
include_once('functions.php');
$students = searchForStudents($_GET['userID'], $_GET['query']);
printStudentCardDeck($students);
?>
