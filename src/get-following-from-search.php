<?php

include_once('functions.php');

$following = getStudentFollowingByQuery($_GET['studentID'], $_GET['query']);

if (isset($_GET['view'])) {
  if ($_GET['view'] == 'table') {
    echo '<br>';
    printStudentCardTable($following);
  } else {
    printStudentCardDeck($following);
  }
}

exit;




?>