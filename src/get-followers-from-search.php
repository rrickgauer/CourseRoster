<?php

include_once('functions.php');

$followers = getStudentFollowersByQuery($_GET['studentID'], $_GET['query']);

if (isset($_GET['view'])) {
  if ($_GET['view'] == 'table') {
    echo '<br>';
    printStudentCardTable($followers);
  } else {
    printStudentCardDeck($followers);
  }
}










?>
