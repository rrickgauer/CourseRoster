<?php

include_once('functions.php');

$enrolledStudents = getStudentsEnrolledInClassByQuery($_GET['classID'], $_GET['query']);


if (isset($_GET['view']) && $_GET['view'] == 'table') {
  printStudentCardTable($enrolledStudents);
} else {
  printStudentCardDeck($enrolledStudents);
}

exit;






?>
