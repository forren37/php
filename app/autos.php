<?php 
    if (empty($_GET)) {
        die("Name parameter missing");
    };

    $pdo = new PDO('mysql:host=php_mysql_1;port=3306;dbname=test', 'dev', 'secret');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($_POST) {
        switch ($_POST) {
            case (isset($_POST["logout"])):
                header('Location: login.php');
                break;
            case (count(array_filter($_POST)) != 3):
                $mess = '<span style="color:red;">Input data is missing';
                break;
            case (!is_numeric($_POST["year"]) || !is_numeric($_POST["mileage"])):
                $mess = '<span style="color:red;">Year and number must be numeric';
                break;
            default:
                $stmt = $pdo->prepare('INSERT INTO autos
                    (make, year, mileage) VALUES ( :mk, :yr, :mi)');
                $stmt->execute(array(
                    ':mk' => $_POST['make'],
                    ':yr' => $_POST['year'],
                    ':mi' => $_POST['mileage'])
                );
                header('Location: autos.php?name='.urlencode($_GET["name"]), true, 303 );
                $mess = '<span style="color:green;">Record inserted';
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
      <?php echo "<h1>Tracking autos for $_GET[name]</h1>" ?>
      <form method='post'>
          <label>Make:</label><input type="text" name="make" size="60"/></br>
          <label>Year:</label><input type="number" name="year"/></br>
          <label>Mileage:</label><input type="number" name="mileage"/></br>
          <input type="submit" value="Add">
          <input type="submit" name="logout" value="Logout">
      </form>
      <?php print_r($_GET) ?>
      <?php print_r($_POST) ?>
      <?php if (!empty($mess)) {echo $mess;} ?>
      <?php echo count($_POST); ?>
      <?php 
        $stmt = $pdo->query("select * from autos");
        echo '<table border="1"'."\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>";
            echo($row['make']);
            echo "</td><td>";
            echo($row['year']);
            echo "</td><td>";
            echo($row['mileage']);
            echo "</td></tr>\n";
        }
        ?>



    </body>    
</html>