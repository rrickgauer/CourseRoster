<?php

    session_start();

    // check if school id is set in the get
    if (isset($_GET['sid']) == false) {
        header("Location: school-search.php");
    }

    include('functions.php');

    $id = $_GET['sid'];
    $result = getSchoolInfo($id);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <?php include('head.php'); ?>
        <title><?php echo $result['Name']; ?></title>
    </head>
    <body>
        <div class="container">

            <?php include('navbar.php'); ?>

            <h1 class="custom-font"><?php echo $result['Name']; ?></h1>

            <input class="form-control" id="myInput" type="text" placeholder="Search.." autofocus><br>
                <?php
                    if (isset($_GET['dept']) == false) {
                        echo "<div class=\"list-group\" id=\"myList\">";
                        printSchoolDepts($id);
                    }
                    else {
                        echo "<div class=\"panel blue-background\">";
                        echo "<div class=\"list-group\" id=\"myList\">";
                        printSchoolCourses($id, $_GET['dept']);
                    }
                ?>
            </div>
        </div>
    </body>
</html>

<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myList a").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
