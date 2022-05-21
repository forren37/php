<?php 
    session_start();
    if (!isset($_SESSION['name'])) {
        die("Please login");
    };
    require_once "pdo.php";
    if ($_POST) {
        switch ($_POST) {
            case (isset($_POST["cancel"])):
                header('Location: view.php');
                return;
            case (count(array_filter($_POST)) != 4):
                $_SESSION['mess'] = '<span style="color:red;">Input data is missing</span>';
                header('Location: edit.php?autos_id='.$_GET['autos_id']);
                return;
            case (!is_numeric($_POST["year"]) || !is_numeric($_POST["mileage"])):
                $_SESSION['mess'] = '<span style="color:red;">Year and mileage must be numeric</span>';
                header('Location: edit.php?autos_id='.$_GET['autos_id']);
                return;
            default:
                $stmt = $pdo->prepare("
                    UPDATE autos
                    SET make = :mk
                        ,model = :md
                        ,year = :yr
                        ,mileage = :mi
                    where autos_id = :id"
                );
                $stmt->execute(array(
                    ':mk' => $_POST['make'],
                    ':md' => $_POST['model'],
                    ':yr' => $_POST['year'],
                    ':mi' => $_POST['mileage'],
                    ':id' => $_GET['autos_id']
                ));
                $_SESSION['mess'] = '<span style="color:green;">Record for auto '.$_GET['autos_id'].' updated</span>';
                header('Location: view.php', true, 303 );
                return;
        }
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Log in</title>
    <meta name="description" content="This is an example of a meta description.">
    <link rel="stylesheet" type="text/css" href="theme.css">
  </head>
  <body>
      <?php echo "<h1>Edit $_GET[autos_id] auto</h1></br>"; 
            if (isset($_SESSION['mess'])) {
                echo $_SESSION['mess'];
                unset($_SESSION['mess']);
            }
      ?>
      <form method='post'>
          <label>Make:</label><input type="text" name="make" size="60"/></br>
          <label>Model:</label><input type="text" name="model" size="60"/></br>
          <label>Year:</label><input type="number" name="year"/></br>
          <label>Mileage:</label><input type="number" name="mileage"/></br>
          <input type="submit" value="Add">
          <input type="submit" name="cancel" value="Cancel">
    </body>    
</html>