<?php

include_once('functions.php');

$classes = getClassesInDept($_GET['dept']);

// print out cards
echo '<div class="card-deck">';
$count = 0;
while ($class = $classes->fetch(PDO::FETCH_ASSOC)) {
  if ($count == 3) {
    echo '</div><div class="card-deck">';
    $count = 0;
  }
  printCard($class);
  $count++;
}
echo '</div>';


// functions
function printCard($class) {
  $classID = $class['cid'];
  $dept = $class['Dept'];
  $number = $class['Number'];
  $title = $class['Title'];
  $count = $class['enrollmentCount'];

  echo "<div class=\"card\" data-class-id=\"$classID\" onresize=\"getSize()\">
          <div class=\"card-header\">
            <h3>$dept-$number</h3>
          </div>
          <div class=\"card-body\">
            <h5>$title</h5>
          </div>
          <div class=\"card-footer\">
            <span class=\"badge badge-primary\"><i class='bx bxs-user' ></i> $count</span>
            <a href=\"class.php?classID=$classID\" class=\"float-right\"><i class='bx bx-link-external' ></i></a>

          </div>
    </div>";
}


?>
