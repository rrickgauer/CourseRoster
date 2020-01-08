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

function updatePassword($userID, $old, $new, $new2)
{

    $pdo = dbConnect();

    // get the users current password
    $sql = "SELECT Password FROM Student WHERE StudentID=$userID";
    $result = $pdo->query($sql);
    $dbPassword = $result->fetch(PDO::FETCH_ASSOC);

    // check if old password passed in equals password in the database
    if ($old == $dbPassword['Password'] && $new == $new2) {

      // update user's password
      $sql = $pdo->prepare("UPDATE Student SET Password=? WHERE StudentID=?");
      $sql->execute(array($new, $userID));

      return true;
    }

    // passwords do not match
    // return to the update password page and do nothing
    else
        return false;
}

function quote($s) {
  $quotes = "\"$s\"";
  return $quotes;
}


function studentExists($email)
{
  include('db-info.php');

  try {
    // connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName",$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // retrieve user info
    $sql = "SELECT * FROM Student where Email=\"$email\"";
    $result = $pdo->query($sql);
    $dbPassword = $result->fetch(PDO::FETCH_ASSOC);

    // check if old password passed in equals password in the database
    if ($old == $dbPassword['Password'] && $new == $new2)
    {
      // update user's password
      $sql = "UPDATE Student SET Password=\"$new\" WHERE StudentID=$userID";
      $return = $pdo->exec($sql);

      return true;
    }

    // passwords do not match
    // return to the update password page and do nothing
    else {
      return false;
    }

  // could not connect to database
  } catch(PDOexception $e) {
      echo "connection failed" . $e->getMessage();
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


function createNewStudentAccount($first, $last, $email, $studentPassword)
{

    $pdo = dbConnect();
    // prepare an insert statement
    $sql = $pdo->prepare("INSERT INTO Student (StudentID, First, Last, Email, Password) VALUES (:UserID, :First, :Last, :Email, :Password)");

    // clean up and bind input data
    $zero = 0;
    $sql->bindParam(':UserID', $zero);
    $sql->bindParam(':First', $first);
    $sql->bindParam(':Last', $last);
    $sql->bindParam(':Email', $email);
    $sql->bindParam(':Password', $studentPassword);

    // execute insert statement
    $sql->execute();
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



// searches for a school
function schoolSearchString($items)
{
  $sql = "SELECT SchoolID, Name, State, City FROM School";
  $result = " WHERE Name LIKE \"%". $items[0] . "%\"";
  $count = 1;

  while($count < count($items)) {
    $item = $items[$count];
    $result = $result . " AND Name LIKE \"%$item%\"";
    $count++;
  }

  $result = $result . ";";
  $sql = $sql . $result;
  return $sql;
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

// prints all courses in a given department
function printSchoolCourses($schoolID, $dept)
{
    $pdo = dbConnect();

    echo "<div class=\"panel-heading\"><h4 class=\"custom-font\">$dept</h4></div>";

    $sql = "SELECT Class.ClassID, Dept, Number, Title, COUNT(Enrolled.ClassID) AS Count FROM Class LEFT JOIN Enrolled ON Class.ClassID=Enrolled.ClassID WHERE Dept=\"$dept\" AND SchoolID=$schoolID GROUP BY Class.ClassID;";

    $result = $pdo->query($sql);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo getCourseListItem($row['ClassID'], $row['Dept'], $row['Number'], $row['Title'], $row['Count']);
    }
}


function printStudentCourses($studentID)
{
    // connect to database
    $pdo = dbConnect();

    // sql select statement
    $sql = "SELECT Class.ClassID, Class.Dept, Class.Number, Class.Title, COUNT(Enrolled.ClassID) as \"Count\" FROM Class LEFT JOIN Enrolled on Class.ClassID=Enrolled.ClassID WHERE Class.ClassID IN (SELECT Enrolled.ClassID FROM Enrolled WHERE Enrolled.StudentID=$studentID) GROUP BY Class.ClassID ORDER BY Class.Dept, Class.Number;";
    $result = $pdo->query($sql);

    // print out list of courses the student is enrolled
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      echo "<a class=\"list-group-item\" href=\"class.php?classID=".$row['ClassID']."\">";
      echo "<b>" . $row['Dept'] . " " . $row['Number'] . "</b> - <i>" . $row['Title'] . "</i> <span class=\"badge blue-button\">" .$row['Count'] . "</span>";
      echo '</a>';
    }
}

function getStudentFirstLastNames($studentID)
{
    $pdo = dbConnect();
    $sql = "SELECT First, Last FROM Student WHERE StudentID=\"$studentID\"";

    $names = $pdo->query($sql);
    $names2 = $names->fetch(PDO::FETCH_ASSOC);
    return $names2;
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



function getSchoolInfo($schoolID)
{
    $pdo = dbConnect();
    $results = $pdo->query("SELECT * FROM School WHERE SchoolID=$schoolID;");
    return $results->fetch(PDO::FETCH_ASSOC);
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
  return "<div class=\"card\" data-student-id=\"$studentID\">
          <div class=\"card-body\">
            <h3>$first $last</h3>
            <p>$email</p>
          </div>
        </div>";
}




















?>
