<?php

include_once('functions.php');

$classes = getClassesInDept($_GET['dept']);

if ($_GET['view'] == 'table') {
  printCourseCardTable($classes);
} else {
  printClassCardDeck($classes);
}




?>
