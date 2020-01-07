<?php

session_start();

// if the form is filled out add the school to the table Add_School_Forms in database
if (isset($_POST['name']) && isset($_POST['state']) && isset($_POST['city']) && isset($_POST['website']))
{
  include('functions.php');
  add_school_forms_submission($_POST['name'], $_POST['state'], $_POST['city'], $_POST['website']);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include('head.php'); ?>
    <title>Add school</title>
  </head>
  <body>
    <div class="container">
      <?php include('navbar.php'); ?>

      <h1 class="custom-font text-center">Add school</h1>

      <div class="row">
        <div class="col-sm-12 col-lg-3"></div>

        <div class="col-sm-12 col-lg-6">

          <form action="add-school.php" method="post">
            <input type="text" name="name" placeholder="School name" class="form-control" required autofocus><br>
            <select class="form-control" name="state" required>
              <option value="AL">AL</option>
              <option value="AK">AK</option>
              <option value="AZ">AZ</option>
              <option value="AR">AR</option>
              <option value="CA">CA</option>
              <option value="CO">CO</option>
              <option value="CT">CT</option>
              <option value="DE">DE</option>
              <option value="FL">FL</option>
              <option value="GA">GA</option>
              <option value="HI">HI</option>
              <option value="ID">ID</option>
              <option value="IL">IL</option>
              <option value="IN">IN</option>
              <option value="IA">IA</option>
              <option value="KS">KS</option>
              <option value="KY">KY</option>
              <option value="LA">LA</option>
              <option value="ME">ME</option>
              <option value="MD">MD</option>
              <option value="MA">MA</option>
              <option value="MI">MI</option>
              <option value="MN">MN</option>
              <option value="MS">MS</option>
              <option value="MO">MO</option>
              <option value="MT">MT</option>
              <option value="NE">NE</option>
              <option value="NV">NV</option>
              <option value="NH">NH</option>
              <option value="NJ">NJ</option>
              <option value="NM">NM</option>
              <option value="NY">NY</option>
              <option value="NC">NC</option>
              <option value="ND">ND</option>
              <option value="OH">OH</option>
              <option value="OK">OK</option>
              <option value="OR">OR</option>
              <option value="PA">PA</option>
              <option value="RI">RI</option>
              <option value="SC">SC</option>
              <option value="SD">SD</option>
              <option value="TN">TN</option>
              <option value="TX">TX</option>
              <option value="UT">UT</option>
              <option value="VT">VT</option>
              <option value="VA">VA</option>
              <option value="WA">WA</option>
              <option value="WV">WV</option>
              <option value="WI">WI</option>
              <option value="WY">WY</option>
            </select><br>

            <input type="text" name="city" class="form-control" placeholder="City" required><br>
            <input type="url" name="website" class="form-control" placeholder="School website" required> <br>
            <input type="submit" value="Submit" class="form-control btn blue-button">
          </form>
        </div>

        <div class="col-sm-12 col-lg-3"></div>

      </div>

    </div>

  </body>
</html>
