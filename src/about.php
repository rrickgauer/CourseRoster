<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include('head.php'); ?>
    <title>About course roster</title>
  </head>
  <body>
    <div class="container">

      <?php

      if (isset($_SESSION['userID'])) {
        include('navbar.php');
      }

      ?>

      <h1 class="custom-font">About <span class="blue-font">course</span> <span class="orange-font"> roster</span></h1>

        <div class="col-sm-12" id="about-text">
            <p>
                Course roster is a free tool to help students enroll in the same courses as their friends. Students can see which courses their friends are taking by searching either for a specific course or for a friend and seeing their course roster.
            </p>

            <p>
                Course roster was written by <a href="https://www.ryanrickgauer.com/resume/index.html" target="_blank">Ryan Rickgauer</a> as a personal project in 2019:
                <blockquote>
                    I had an idea for building this website on my first day of class during my 2019 Spring semester at college. When I walked into my digital marketing calass I noticed that one of my friends was also in the course, and a few days later a second friend asked me what courses I was taking that semester. That's when it came to me. What if there was a way I could see what courses my friends were taking that semester.

                    <footer>Ryan Rickgauer</footer>
                </blockquote>
            </p>

            <p>
                Students spend much time checking out other students' reviews about a course and the professor, but that's only half the equation. The other half is seeing who else is taking that course. Knowing the course roster can help students know what kind of members could be part of their potential group project and other things of that nature. Let course roster hep you ease your college course scheudling process.
            </p>
        </div>




    </div>

  </body>
</html>
