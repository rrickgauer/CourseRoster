<?php
include_once('functions.php');
$students = searchForStudents($_GET['userID'], $_GET['query']);

if ($_GET['view'] == 'table') {
  printStudentCardTable($students);
} else {
  printStudentCardDeck($students);
}

exit;
?>
