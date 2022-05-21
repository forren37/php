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
                $_SESSION['mess'] = '<span style="color:red;">Input data is missing';
                header('Location: add.php', true, 303 );
                return;
            case (!is_numeric($_POST["year"]) || !is_numeric($_POST["mileage"])):
                $_SESSION['mess'] = '<span style="color:red;">Year and number must be numeric';
                return;
            default:
                $stmt = $pdo->prepare('INSERT INTO autos
                    (make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)');
                $stmt->execute(array(
                    ':mk' => $_POST['make'],
                    ':md' => $_POST['model'],
                    ':yr' => $_POST['year'],
                    ':mi' => $_POST['mileage'])
                );
                $_SESSION['mess'] = '<span style="color:green;">Record inserted</span>';
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
      <?php echo "<h1>Add new auto</h1>";
            if (isset($_SESSION['mess'])) {
                echo "</br>".$_SESSION['mess'];
                unset($_SESSION['mess']);
            };
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