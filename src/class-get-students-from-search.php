<?php

include_once('functions.php');
$enrolledStudents = getStudentsEnrolledInClass($_GET['classID'], $_GET['query']);

if (isset($_GET['view']) && $_GET['view'] == 'table') {
  printStudentCardTable($enrolledStudents);
} else {
  printStudentCardDeck($enrolledStudents);
}

exit;
?>
