<?php

function dbConnect()
{
  include('db-info.php');

  try {
    // connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName",$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;

  } catch(PDOexception $e) {
      return 0;
  }

}


function insertStudentFollower($studentID, $followerID)
{
  $pdo = dbConnect();

  // prepare sql and bind parameters
  $sql = $pdo->prepare("INSERT INTO Student_Followers (StudentID, FollowerID) VALUES (:StudentID, :FollowerID)");
  $sql->bindParam(':StudentID', $studentID);
  $sql->bindParam(':FollowerID', $followerID);

  // insert the row
  $sql->execute();

}

function isFollowing($studentID, $followerID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT StudentID FROM Student_Followers WHERE StudentID=:studentID AND FollowerID=:followerID LIMIT 1');

  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);

  $followerID = filter_var($followerID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':followerID', $followerID, PDO::PARAM_INT);

  $sql->execute();

  if ($sql->rowCount() == 1) {
    return true;
  } else {
    return false;
  }
}


function removeStudentFollower($studentID, $followerID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare("DELETE FROM Student_Followers WHERE StudentID=? AND FollowerID=?");
  $sql->execute([$studentID, $followerID]);
}

function printSchoolDepts($schoolID)
{
    $pdo = dbConnect();

    $sql = "SELECT Dept, Count(Dept) AS Count FROM Class WHERE SchoolID=$schoolID GROUP BY Dept ORDER BY Dept;";
    $depts = $pdo->query($sql);

    while ($row = $depts->fetch(PDO::FETCH_ASSOC)) {
        $dept = $row['Dept'];
        $count = $row['Count'];
        echo "<a href=\"school.php?sid=$schoolID&dept=$dept\" class=\"list-group-item\"><b>$dept</b>";
        echo "<span class=\"badge blue-button\">$count</span></a>";
    }
}

function getCourseInformation($classID)
{
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Class.ClassID, Class.Dept, Class.Number, Class.Title, count(Enrolled.StudentID) as count from Class left join Enrolled on Class.ClassID=Enrolled.ClassID where Class.ClassID=:classID GROUP by Class.ClassID LIMIT 1');
  $classID = filter_var($classID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':classID', $classID, PDO::PARAM_INT);
  $sql->execute();
  return $sql;
}

// searches for a student given user submitted keyword
function printStudentSearchResults($keyword)
{
    // connect to database
    $pdo = dbConnect();

    $sql = "SELECT StudentID, First, Last, Email FROM Student WHERE First LIKE \"%$keyword%\" OR Last LIKE \"%$keyword%\" OR Email LIKE \"%$keyword%\" ORDER BY Last";
    $result = $pdo->query($sql);

    while ($row = $result->fetch(PDO::FETCH_ASSOC))
    {
      $studentID = $row['StudentID'];
      $fname = $row['First'];
      $lname = $row['Last'];
      $email = $row['Email'];

      echo "<a href=\"student.php?studentID=$studentID\" class=\"list-group-item\">";
      echo "<h4 class=\"list-group-item-heading\">$fname $lname</h4>";
      echo "<p class=\"list-group-item-text\">$email</p></a>";
    }
}

// get a studentId from a given email
function getStudentID($email)
{
  $pdo = dbConnect();
  $result = $pdo->query("SELECT StudentID FROM Student WHERE Email=\"$email\";");
  $row = $result->fetch(PDO::FETCH_ASSOC);
  return $row['StudentID'];
}

function getStudentsEnrolledInClass($userID, $classID, $query = '') {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Student.StudentID as sid, Student.First, Student.Last, Student.Email, (SELECT IF(count(*) > 0, true, false) from Student_Followers where Student_Followers.FollowerID=:userID and Student_Followers.StudentID = sid) as following, (select count(Enrolled.ClassID) from Enrolled where Enrolled.StudentID=sid) as enrollmentCount, (select count(Student_Followers.FollowerID) from Student_Followers WHERE Student_Followers.StudentID=sid) as followersCount FROM Student WHERE Student.StudentID IN (SELECT Enrolled.StudentID FROM Enrolled WHERE Enrolled.ClassID=:classID) AND (Student.First LIKE :first OR Student.Last LIKE :last OR Student.Email LIKE :email)  ORDER BY Last ASC, First ASC');

  $userID = filter_var($userID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':userID', $userID, PDO::PARAM_INT);

  $classID = filter_var($classID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':classID', $classID, PDO::PARAM_INT);

  $first = "%$query%";
  $first = filter_var($first, FILTER_SANITIZE_STRING);
  $sql->bindValue(':first', $first, PDO::PARAM_STR);

  $last = "%$query%";
  $first = filter_var($last, FILTER_SANITIZE_STRING);
  $sql->bindValue(':last', $last, PDO::PARAM_STR);

  $email = "%$query%";
  $first = filter_var($email, FILTER_SANITIZE_STRING);
  $sql->bindValue(':email', $email, PDO::PARAM_STR);


  $sql->execute();
  return $sql;
}

function getEnrolledCourses($studentID, $query = '') {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Enrolled.ClassID as cid, (SELECT COUNT(Enrolled.StudentID) FROM Enrolled WHERE ClassID=cid) AS count, Class.Dept, Class.Number, Class.Title FROM Enrolled LEFT JOIN Class ON Enrolled.ClassID=Class.ClassID WHERE Enrolled.StudentID=:StudentID and (Class.Dept like :dept or Class.Title like :title) GROUP BY cid');

  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindValue(':StudentID', $studentID, PDO::PARAM_INT);

  $dept = "%$query%";
  $dept = filter_var($dept, FILTER_SANITIZE_STRING);
  $sql->bindValue(':dept', $dept, PDO::PARAM_STR);

  $title = "%$query%";
  $title = filter_var($title, FILTER_SANITIZE_STRING);
  $sql->bindValue(':title', $title, PDO::PARAM_STR);

  $sql->execute();
  return $sql;
}

function getDistinctDepts() {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT DISTINCT Dept FROM Class');
  $sql->execute();
  return $sql;
}

function getClassesInDept($dept) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Class.ClassID as cid, Class.Dept, Class.Number, Class.Title, (select count(*) from Enrolled where Enrolled.ClassID=cid) as count from Class where Dept=:dept ORDER BY NUMBER ASC');
  $dept = filter_var($dept, FILTER_SANITIZE_STRING);
  $sql->bindParam(':dept', $dept, PDO::PARAM_STR);
  $sql->execute();
  return $sql;
}

function searchForStudents($userID, $query) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Student.StudentID as sid, Student.First, Student.Last, Student.Email, (SELECT IF(count(*) > 0, true, false) from Student_Followers where Student_Followers.FollowerID=:userID and Student_Followers.StudentID = sid) as following, (select count(Enrolled.ClassID) from Enrolled where Enrolled.StudentID=sid) as enrollmentCount , (select count(Student_Followers.FollowerID) from Student_Followers WHERE Student_Followers.StudentID=sid) as followersCount FROM Student WHERE Student.First LIKE :first OR Student.Last LIKE :last');

  $userID = filter_var($userID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':userID', $userID, PDO::PARAM_INT);

  $first = "%$query%";
  $first = filter_var($first, FILTER_SANITIZE_STRING);
  $sql->bindValue(':first', $first, PDO::PARAM_STR);

  $last = "%$query%";
  $last = filter_var($last, FILTER_SANITIZE_STRING);
  $sql->bindValue(':last', $last, PDO::PARAM_STR);

  $sql->execute();
  return $sql;
}

function printStudentCardTable($students) {
  echo '<div class="table-responsive"><table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Courses</th>
            <th>Followers</th>
            <th>View</th>
          </tr>
        </thead><tbody>';

  while ($student = $students->fetch(PDO::FETCH_ASSOC)) {

    $id = $student['sid'];
    $enrollmentCount = $student['enrollmentCount'];
    $followerCount = $student['followersCount'];

    echo '<tr>';
    echo '<td>' . $student['First'] . '&nbsp;' . $student['Last'] . '</td>';
    echo '<td>' . $student['Email'] . '</td>';
    echo "<td><span class=\"badge badge-primary\"><i class='bx bx-chalkboard'></i> $enrollmentCount</span></td>";
    echo "<td><span class=\"badge badge-orange\"><i class='bx bx-glasses'></i> $followerCount</span></td>";
    echo "<td><a href=\"student.php?studentID=$id\" data-toggle=\"tooltip\" title=\"View student\"><i class='bx bx-link-external'></i></a></td>";
    echo '</tr>';
  }

  echo '</tbody></table></div>';
}

function printCourseCardTable($courses) {
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
      echo '<td><span class="badge badge-orange"><i class="bx bxs-user"></i>&nbsp;' . $course['count'] . '</span></td>';
      echo "<td><a href=\"class.php?classID=$classID\"><i class='bx bx-link-external'></i></a></td>";
      echo '</tr>';

    }
  echo '</tbody></table>';
}

function printClassCardDeck($cards) {
  echo '<div class="card-deck">';

  $count = 0;
  while ($card = $cards->fetch(PDO::FETCH_ASSOC)) {
    if ($count == 3) {
      echo '</div><div class="card-deck">';
      $count = 0;
    }

    echo getClassCard($card['cid'], $card['Dept'], $card['Number'], $card['Title'], $card['count']);
    $count++;
  }
}

function printStudentCardDeck($students) {
  echo '<div class="card-deck">';
  $count = 0;

  while ($student = $students->fetch(PDO::FETCH_ASSOC)) {
    if ($count == 3) {
      echo '</div><div class="card-deck">';
      $count = 0;
    }

    echo getStudentCard($student['sid'], $student['First'], $student['Last'], $student['Email'], $student['enrollmentCount'], $student['followersCount'], $student['following']);
    $count++;
  }

  echo '</div>';
}

function getStudentCard($studentID, $first, $last, $email, $enrollmentCount, $followerCount, $following) {

  if ($following == 1) {
    return "<div class=\"card student-card\" data-student-id=\"$studentID\">
    <div class=\"card-header\">
      <h3 class=\"custom-font\">$first $last</h3>
    </div>
    <div class=\"card-body\">
      <p>$email</p>
    </div>
    <div class=\"card-footer\">
      <span class=\"badge badge-secondary\">Following</span>
      <span class=\"badge badge-primary\"><i class='bx bx-chalkboard'></i> $enrollmentCount</span>
      <span class=\"badge badge-orange\"><i class='bx bx-glasses'></i> $followerCount</span>
      <a href=\"student.php?studentID=$studentID\" class=\"float-right\" data-toggle=\"tooltip\" title=\"View student\"><i class='bx bx-link-external' ></i></a>
    </div>
  </div>";
}

  else {
    return "<div class=\"card student-card\" data-student-id=\"$studentID\">
    <div class=\"card-header\">
      <h3 class=\"custom-font\">$first $last</h3>
    </div>
    <div class=\"card-body\">
      <p>$email</p>
    </div>
    <div class=\"card-footer\">
      <span class=\"badge badge-primary\"><i class='bx bx-chalkboard'></i> $enrollmentCount</span>
      <span class=\"badge badge-orange\"><i class='bx bx-glasses'></i> $followerCount</span>
      <a href=\"student.php?studentID=$studentID\" class=\"float-right\" data-toggle=\"tooltip\" title=\"View student\"><i class='bx bx-link-external' ></i></a>
    </div>
  </div>";
  }
}

function getClassCard($classID, $dept, $number, $title, $count) {
  return "<div class=\"card class-card\">
  <div class=\"card-header\">
    <h3>$dept-$number</h3>
  </div>
  <div class=\"card-body\">
    <h5>$title</h5>
   </div>
    <div class=\"card-footer\">
      <span class=\"badge badge-orange\"><i class='bx bxs-user'></i> $count</span>
      <a href=\"class.php?classID=$classID\" class=\"float-right\" data-toggle=\"tooltip\" title=\"View course\"><i class='bx bx-link-external' ></i></a>
    </div>
  </div>";
}

function getStudentInfo($studentID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Student.StudentID, Student.First, Student.Last, Student.Email, (SELECT COUNT(Enrolled.ClassID) FROM Enrolled WHERE Enrolled.StudentID = Student.StudentID) AS coursesCount, (SELECT COUNT(Student_Followers.StudentID) FROM Student_Followers WHERE Student_Followers.StudentID=Student.StudentID) AS followersCount, (SELECT COUNT(Student_Followers.StudentID) FROM Student_Followers WHERE Student_Followers.FollowerID=Student.StudentID) AS followingCount FROM Student WHERE Student.StudentID=:studentID');
  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);
  $sql->execute();
  return $sql;
}

function getStudentFollowers($userID, $studentID, $query = '') {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Student.StudentID as sid, Student.First, Student.Last, Student.Email, (SELECT IF(count(*) > 0, true, false) from Student_Followers where Student_Followers.FollowerID=:userID and Student_Followers.StudentID = sid) as following, (select count(Enrolled.ClassID) from Enrolled where Enrolled.StudentID=sid) as enrollmentCount, (select count(Student_Followers.FollowerID) from Student_Followers WHERE Student_Followers.StudentID=sid) as followersCount from Student where Student.StudentID in (select Student_Followers.FollowerID from Student_Followers where Student_Followers.StudentID = :studentID) AND (Student.First like :first OR Student.Last LIKE :last) ORDER BY Student.Last ASC, Student.First ASC');

  $userID = filter_var($userID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':userID', $userID, PDO::PARAM_INT);

  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);

  $first = "%$query%";
  $first = filter_var($first, FILTER_SANITIZE_STRING);
  $sql->bindValue(':first', $first, PDO::PARAM_STR);

  $last = "%$query%";
  $last = filter_var($last, FILTER_SANITIZE_STRING);
  $sql->bindValue(':last', $last, PDO::PARAM_STR);


  $sql->execute();
  return $sql;
}

function getStudentFollowing($userID, $studentID, $query = '') {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Student.StudentID as sid, Student.First, Student.Last, Student.Email, (SELECT IF(count(*) > 0, true, false) from Student_Followers where Student_Followers.FollowerID=:userID and Student_Followers.StudentID = sid) as following, (select count(Enrolled.ClassID) from Enrolled where Enrolled.StudentID=sid) as enrollmentCount, (select count(Student_Followers.FollowerID) from Student_Followers WHERE Student_Followers.StudentID=sid) as followersCount from Student where Student.StudentID in (select Student_Followers.StudentID from Student_Followers where Student_Followers.FollowerID = :studentID) AND (Student.First like :first OR Student.Last LIKE :last) ORDER BY Student.Last ASC, Student.First ASC');

  $userID = filter_var($userID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':userID', $userID, PDO::PARAM_INT);

  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);

  $first = "%$query%";
  $first = filter_var($first, FILTER_SANITIZE_STRING);
  $sql->bindValue(':first', $first, PDO::PARAM_STR);

  $last = "%$query%";
  $last = filter_var($last, FILTER_SANITIZE_STRING);
  $sql->bindValue(':last', $last, PDO::PARAM_STR);


  $sql->execute();
  return $sql;
}

function updateStudentInfo($studentID, $first, $last, $email) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('UPDATE Student SET First=:first, Last=:last, Email=:email WHERE Student.StudentID=:studentID');

  $first     = filter_var($first, FILTER_SANITIZE_STRING);
  $last      = filter_var($last, FILTER_SANITIZE_STRING);
  $email     = filter_var($email, FILTER_SANITIZE_STRING);
  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);

  $sql->bindParam(':first', $first, PDO::PARAM_STR);
  $sql->bindParam(':last', $last, PDO::PARAM_STR);
  $sql->bindParam(':email', $email, PDO::PARAM_STR);
  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);

  return $sql->execute();
}

function getAlert($heading = '', $type = 'success', $message = '') {
  return "<div class=\"alert alert-$type alert-dismissible fade show\" role=\"alert\">
    <strong>$heading </strong>
    $message
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
      <span aria-hidden=\"true\">&times;</span>
    </button>
  </div>";
}

function updateStudentPassword($studentID, $newPassword) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('UPDATE Student SET Student.Password=:newPassword WHERE Student.StudentID=:studentID');

  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);

  // new password
  $newPassword = filter_var($newPassword, FILTER_SANITIZE_STRING);
  $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
  $sql->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);

  $sql->execute();
}

function isCorrectPassword($studentID, $passwordAttempt) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Student.Password FROM Student WHERE Student.StudentID=:studentID LIMIT 1');

  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);

  $sql->execute();

  if ($sql->rowCount() != 1) {
    return false;
  } else {

    $hash = $sql->fetch(PDO::FETCH_ASSOC);
    $hash = $hash['Password'];

    return password_verify($passwordAttempt, $hash);
  }

}

function validateLoginAttempt($email, $password) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Student.Password FROM Student WHERE Student.Email=:email LIMIT 1');

  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  $sql->bindParam(':email', $email, PDO::PARAM_STR);

  $sql->execute();

  if ($sql->rowCount() != 1) {
    return false;
  } else {

    $hash = $sql->fetch(PDO::FETCH_ASSOC);
    $hash = $hash['Password'];

    return password_verify($password, $hash);
  }
}

function insertStudent($first, $last, $email, $password) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('INSERT INTO Student (First, Last, Email, Password) VALUES (:first, :last, :email, :password)');

  $first    = filter_var($first, FILTER_SANITIZE_STRING);
  $last     = filter_var($last, FILTER_SANITIZE_STRING);
  $email    = filter_var($email, FILTER_SANITIZE_EMAIL);

  $password = filter_var($password, FILTER_SANITIZE_STRING);
  $password = password_hash($password, PASSWORD_DEFAULT);

  $sql->bindParam(':first', $first, PDO::PARAM_STR);
  $sql->bindParam(':last', $last, PDO::PARAM_STR);
  $sql->bindParam(':email', $email, PDO::PARAM_STR);
  $sql->bindParam(':password', $password, PDO::PARAM_STR);

  $sql->execute();
  $sql = null;
  $pdo = null;

}

function isStudentEnrolled($studentID, $classID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Enrolled.StudentID FROM Enrolled WHERE Enrolled.StudentID=:studentID AND Enrolled.ClassID=:classID LIMIT 1');

  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $classID = filter_var($classID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);
  $sql->bindParam(':classID', $classID, PDO::PARAM_INT);

  $sql->execute();

  if($sql->rowCount() == 1) {
    return true;
  } else {
    return false;
  }
}

function dropEnrolledCourse($studentID, $classID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('DELETE FROM Enrolled WHERE Enrolled.StudentID=:studentID AND Enrolled.ClassID=:classID');

  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);

  $classID = filter_var($classID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':classID', $classID, PDO::PARAM_INT);

  $sql->execute();
}

function enrollStudentInCourse($studentID, $classID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('INSERT INTO Enrolled (StudentID, ClassID) VALUES (:studentID, :classID)');

  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);

  $classID = filter_var($classID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':classID', $classID, PDO::PARAM_INT);

  $sql->execute();
}

function filterStudentsEnrolledInClass($classID, $query) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Student.StudentID as sid, Student.First, Student.Last, Student.Email, (select count(Enrolled.ClassID) from Enrolled where Enrolled.StudentID=sid) as enrollmentCount, (select count(Student_Followers.FollowerID) from Student_Followers WHERE Student_Followers.StudentID=sid) as followersCount from Student where Student.StudentID in (select Student_Followers.FollowerID from Student_Followers where Student_Followers.StudentID = :studentID) AND (Student.First like :first OR Student.Last LIKE :last) ORDER BY Student.Last ASC, Student.First ASC');


  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);

  $first = "%$query%";
  $first = filter_var($first, FILTER_SANITIZE_STRING);
  $sql->bindValue(':first', $first, PDO::PARAM_STR);

  $last = "%$query%";
  $last = filter_var($last, FILTER_SANITIZE_STRING);
  $sql->bindValue(':last', $last, PDO::PARAM_STR);


  $sql->execute();
  return $sql;
}

function isValidStudentID($studentID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Student.StudentID FROM Student WHERE Student.StudentID=:studentID LIMIT 1');
  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);
  $sql->execute();

  if ($sql->rowCount() == 1) {
    return true;
  } else {
    return false;
  }
}

function printFooter() {
  echo '<p class="footer">Made by&nbsp;<a href="https://www.ryanrickgauer.com/resume/index.html" target="_blank">Ryan Rickgauer</a>&nbsp;&copy; 2020</p>';
}


function insertActivity($studentID, $targetID, $type) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('INSERT INTO Activity (StudentID, TargetID, Type, Time) VALUES (:studentID, :targetID, :type, now())');

  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $targetID = filter_var($targetID, FILTER_SANITIZE_NUMBER_INT);
  $type = filter_var($type, FILTER_SANITIZE_STRING);

  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);
  $sql->bindParam(':targetID', $targetID, PDO::PARAM_INT);
  $sql->bindParam(':type', $type, PDO::PARAM_STR);

  $sql->execute();
}

function getActivity() {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Activity.ActivityID, Activity.StudentID, Student.First, Student.Last, Activity.Type, Activity.TargetID as tid, if (Activity.Type = "enrolled" or Activity.Type = "dropped", (select concat(Class.Dept, "-", Class.Number) FROM Class where Class.ClassID=tid), (select concat(Student.First, " ", Student.Last) FROM Student where Student.StudentID=tid) ) as target, Activity.Time, date_format(Activity.Time, "%c/%e/%y") as display_date, date_format(Activity.Time, "%r") display_time from Activity left join Student on Activity.StudentID=Student.StudentID order by Activity.Time desc, Activity.ActivityID desc');
}






?>
