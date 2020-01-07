<?php session_start(); ?>
<?php include('functions.php'); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <?php include('head.php'); ?>
        <title>Test</title>
    </head>
    <body>
        <div class="container">

            <?php include('navbar.php'); ?>

            <h1 class="custom-font">Test</h1>

            <div class="panel-group">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse1">Collapsible list group</a>
                  </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse">
                  <div class="list-group">
                    <a class="list-group-item">One</li>
                    <a class="list-group-item">Two</li>
                    <a class="list-group-item">Three</li>
                </div>
                </div>
              </div>
            </div>
            </div>






        </div>

    </body>
</html>
