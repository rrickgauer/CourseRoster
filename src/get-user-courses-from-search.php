<?php
include_once('functions.php');
$courses = searchForStudentEnrolledCourses($_GET['studentID'], $_GET['query']);



if ($_GET['view'] == 'table') {
  echo '<br>';
  echo '<table class="table">
    <thead>
      <tr>
        <th>Course</th>
        <th>Title</th>
        <th>Size</th>
        <th>Link</th>
      </tr>
    </thead>

    <tbody>';

    while ($course = $courses->fetch(PDO::FETCH_ASSOC)) {
      echo '<tr>';

      $classID = $course['cid'];

      echo '<td>' . $course['Dept'] . '-' . $course['Number'] . '</td>';
      echo '<td>' . $course['Title'] . '</td>';
      echo '<td>' . $course['count'] . '</td>';
      echo "<td><a href=\"class.php?classID=$classID\">View</a></td>";
      echo '</tr>';

    }
  echo '</tbody></table>';


} else {
  printClassCardDeck($courses);
}

exit;
?>
