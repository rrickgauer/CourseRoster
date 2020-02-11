<?php  

session_start();

include('functions.php');




?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include('head.php'); ?>  
    <title>About course roster</title>
  </head>
  <body>
    <?php include('navbar.php'); ?>

    <div class="container">
      <h1 class="custom-font blue-font text-center">About Course Roster</h1>

      <h2 class="custom-font">Background</h2>

      <p>Hi! My name is <a href="https://www.ryanrickgauer.com/resume/index.html" target="_blank">Ryan Rickgauer</a>, and I am the creator of Course Roster!</p>

      <p>Course Roster is a project I created for <a href="https://www.niu.edu/index.shtml" target="_blank">Northern Illinois University</a> students to see what courses other NIU students are taking in a given semester. After <a href="createAccount.php">signing up</a> for an account, students can then search for a course by dept and add it to their “roster”. Users can also search for other users by first and last name, or email to see what courses they are registered for. Users also have the option to follow other students so they can quickly reference them whenever they choose.</p>

      <p>Every semester I found myself asking several of my friends if they were taking a certain class. I thought if there was some way that I could just look the information up online and see for myself, instead of pestering my friends, it would make everyone’s life a little easier. That’s how I came up with the idea for Course Roster.</p>

      <p>I put the source code on github, and it can be viewed <a href="https://github.com/rrickgauer/CourseRoster" target="_blank">here</a>.</p>

      <h2 class="custom-font">Technologies</h2>
      <p>In order to get all the class information such as the department, course number, and title, I wrote a simple python script that scrapes NIU’s <a href="http://catalog.niu.edu/content.php?catoid=48&navoid=2305" target="_blank">course catalog</a> on their website that has all the information listed. Then I saved them all into a mysql table.</p>

      <h5>Back-end</h5>
      <ul>
        <li>PHP</li>
        <li>MySQL</li>
      </ul>

      <h5>Front-end</h5>
      <ul>
        <li>HTML/CSS</li>
        <li>Javascript</li>
        <li>Bootstrap 4</li>
        <li>Boxicons</li>
        <li>Select2</li>
      </ul>





      <?php printFooter(); ?>
    </div>

    <script>
      $(document).ready(function() {
        $("#nav-item-about").addClass("active");
      });
    </script>

  </body>
</html>
