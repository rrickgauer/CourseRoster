<?php session_start(); ?>
<?php include('functions.php'); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <?php include('head.php'); ?>
        <title>School search</title>
    </head>
    <body>
        <div class="container">
            <?php include('navbar.php'); ?>
            <h1 class="custom-font">Select your school</h1>

            <input class="form-control" id="myInput" type="text" placeholder="Search.." autofocus><br>

            <div class="list-group" id="myList">
                <?php printSchoolListNames(); ?>
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
