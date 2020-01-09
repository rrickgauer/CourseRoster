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


function insertPotentialCourse($dept, $number, $title, $studentID)
{
    $pdo = dbConnect();

    $sql = $pdo->prepare("INSERT INTO Potential_Course values(0, ?, ?, ?, ?, CURDATE(), \"Working\")");
    $sql->execute(array($dept, $number, $title, $student));

    // potential course was submitted successfully
    if ($result > 0) return true;

    // error in submitting the potential course
    else return false;


}

// tests to see if a student is enrolled in a course
function isStudentEnrolled($studentID, $classID)
{
    // connect to database
    $pdo = dbConnect();

    // setup sql statement
    $sql = "SELECT COUNT(*) FROM Enrolled WHERE Enrolled.StudentID=$studentID AND Enrolled.ClassID=$classID";

    // get query
    $result = $pdo->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    // if the count is 1 then the student is enrolled
    if ($row['COUNT(*)'] == 1) return true;

    // anything besides 1 means student is not enrolled
    else return false;

}

function dropEnrolledCourse($studentID, $classID)
{
    $pdo = dbConnect();
    $sql = $pdo->prepare("DELETE FROM Enrolled WHERE StudentID=? AND ClassID=?");
    $sql->execute(array($studentID, $classID));
}

function getCourseListItem($id, $dept, $number, $title, $count)
{
  $listItem = "<a href=\"class.php?classID=$id\" class=\"list-group-item\"><b>$dept $number</b> - <i> $title</i><span class=\"badge blue-button\">$count</span></a>";
  return $listItem;
}




function insert_Student_Followers($studentID, $followerID)
{
  $pdo = dbConnect();

  // prepare sql and bind parameters
  $sql = $pdo->prepare("INSERT INTO Student_Followers (StudentID, FollowerID) VALUES (:StudentID, :FollowerID)");
  $sql->bindParam(':StudentID', $studentID);
  $sql->bindParam(':FollowerID', $followerID);

  // insert the row
  $sql->execute();

}

// checks if a student is follower of another student
function isFollowing($studentID, $followerID)
{
  $pdo = dbConnect();

  $sql = "SELECT 1 FROM Student_Followers WHERE StudentID=$studentID AND FollowerID=$followerID";
  $result = $pdo->query($sql);
  $row = $result->fetch(PDO::FETCH_ASSOC);

  if ($row['1'] == 1) return true;
  else return false;
}


function delete_Student_Followers($studentID, $followerID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare("DELETE FROM Student_Followers WHERE StudentID=? AND FollowerID=?");
  $sql->execute([$studentID, $followerID]);
}

// 'contact us' form processing
function contact_us_submission($first, $last, $email, $message)
{
  $pdo = dbConnect();
  $sql = $pdo->prepare("INSERT INTO Contact_Form VALUES(0, ?, ?, ?, ?, \"CURDATE()\")");
  $sql->execute([$first, $last, $email, $message]);
}


function add_school_forms_submission($name, $state, $city, $website)
{
  $pdo = dbConnect();
  $sql = "INSERT INTO Add_School_Forms values (0, \"$name\", \"$state\", \"$city\", \"$website\", 'Pending');";
  $result = $pdo->exec($sql);
}


function printSchoolSearchResults($schoolID, $name) {
    echo "<a href=\"school.php?sid=$schoolID\" class=\"list-group-item\"><b>$name</b></a>";
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
    $sql = "SELECT * FROM Class WHERE ClassID=\"$classID\"";
    $result = $pdo->query($sql);
    $class = $result->fetch(PDO::FETCH_ASSOC);
    return $class;
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

function getStudentsEnrolledInClass($classID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Student.StudentID, Student.First, Student.Last, Student.Email FROM Student WHERE Student.StudentID IN (SELECT Enrolled.StudentID FROM Enrolled WHERE Enrolled.ClassID=:classID) ORDER BY Last ASC');
  $classID = filter_var($classID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':classID', $classID, PDO::PARAM_INT);
  $sql->execute();
  return $sql;
}

function getEnrolledCourses($studentID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Enrolled.ClassID as cid, (SELECT COUNT(Enrolled.StudentID) FROM Enrolled WHERE ClassID=cid) AS count, Class.Dept, Class.Number, Class.Title FROM Enrolled LEFT JOIN Class ON Enrolled.ClassID=Class.ClassID WHERE Enrolled.StudentID=:StudentID GROUP BY cid');
  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':StudentID', $studentID, PDO::PARAM_INT);
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
  $sql = $pdo->prepare('SELECT Class.ClassID as cid, Class.Dept, Class.Number, Class.Title, (select count(*) from Enrolled where Enrolled.ClassID=cid) as enrollmentCount from Class where Dept=:dept ORDER BY NUMBER ASC');
  $dept = filter_var($dept, FILTER_SANITIZE_STRING);
  $sql->bindParam(':dept', $dept, PDO::PARAM_STR);
  $sql->execute();
  return $sql;
}

function searchForStudents($query) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Student.StudentID, Student.First, Student.Last, Student.Email FROM Student WHERE Student.First LIKE :first OR Student.Last LIKE :last');

  $first = "%$query%";
  $first = filter_var($first, FILTER_SANITIZE_STRING);
  $sql->bindValue(':first', $first, PDO::PARAM_STR);

  $last = "%$query%";
  $last = filter_var($last, FILTER_SANITIZE_STRING);
  $sql->bindValue(':last', $last, PDO::PARAM_STR);

  $sql->execute();
  return $sql;
}

function getStudentCard($studentID, $first, $last, $email) {
  return "<div class=\"card student-card\" data-student-id=\"$studentID\" onclick=\"gotoStudentPage(this)\">
          <div class=\"card-body\">
            <h3 class=\"custom-font header\">$first $last</h3>
            <p>$email</p>
          </div>
        </div>";
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
      <span class=\"badge badge-orange\"><i class='bx bxs-user' ></i> $count</span>
      <a href=\"class.php?classID=$classID\" class=\"float-right\"><i class='bx bx-link-external' ></i></a>
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

function getStudentFollowers($studentID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Student.StudentID, Student.First, Student.Last, Student.Email from Student where Student.StudentID in (select Student_Followers.FollowerID from Student_Followers where Student_Followers.StudentID = :studentID) ORDER BY Student.Last ASC, Student.First ASC');
  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);
  $sql->execute();
  return $sql;
}

function getStudentFollowing($studentID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Student.StudentID, Student.First, Student.Last, Student.Email from Student where Student.StudentID in (select Student_Followers.StudentID from Student_Followers where Student_Followers.FollowerID = :studentID) ORDER BY Student.Last ASC, Student.First ASC');
  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);
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

function updateStudentPassword($studentID, $oldPassword, $newPassword) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('UPDATE Student SET Student.Password=:newPassword WHERE Student.StudentID=:studentID AND Student.Password=:oldPassword');

  $studentID = filter_var($studentID, FILTER_SANITIZE_NUMBER_INT);
  $oldPassword = filter_var($oldPassword, FILTER_SANITIZE_STRING);
  $newPassword = filter_var($newPassword, FILTER_SANITIZE_STRING);

  $sql->bindParam(':studentID', $studentID, PDO::PARAM_INT);
  $sql->bindParam(':oldPassword', $oldPassword, PDO::PARAM_STR);
  $sql->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);

  $sql->execute();

  if ($sql->rowCount() == 1) {
    return true;
  } else {
    return false;
  }
}

function validateLoginAttempt($email, $password) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Student.StudentID FROM Student WHERE Student.Email=:email AND Student.Password=:password LIMIT 1');
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  $password = filter_var($password, FILTER_SANITIZE_STRING);
  $sql->bindParam(':email', $email, PDO::PARAM_STR);
  $sql->bindParam(':password', $password, PDO::PARAM_STR);
  $sql->execute();
  return $sql;
}

function insertStudent($first, $last, $email, $password) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('INSERT INTO Student (First, Last, Email, Password) VALUES (:first, :last, :email, :password)');

  $first    = filter_var($first, FILTER_SANITIZE_STRING);
  $last     = filter_var($last, FILTER_SANITIZE_STRING);
  $email    = filter_var($email, FILTER_SANITIZE_EMAIL);
  $password = filter_var($password, FILTER_SANITIZE_STRING);

  $sql->bindParam(':first', $first, PDO::PARAM_STR);
  $sql->bindParam(':last', $last, PDO::PARAM_STR);
  $sql->bindParam(':email', $email, PDO::PARAM_STR);
  $sql->bindParam(':password', $password, PDO::PARAM_STR);

  $sql->execute();
  $sql = null;
  $pdo = null;

}






?>
