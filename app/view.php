<?php 
    session_start();
    if (!isset($_SESSION['name'])) {
        die("Please login");
    };
    require_once "pdo.php"
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
      <?php echo "<h1>Tracking autos for $_SESSION[name]</h1>" ?>
      <?php if (isset($_SESSION['mess'])) {
         echo $_SESSION['mess']."</br>";
         unset($_SESSION['mess']);
        } ?>
      <?php 
        $stmt = $pdo->query("select * from autos");
        if ($stmt->rowCount()>0) {
            echo '<table border="1"'."\n";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>";
                echo($row['autos_id']);
                echo "</td><td>";
                echo($row['make']);
                echo "</td><td>";
                echo($row['model']);
                echo "</td><td>";
                echo($row['year']);
                echo "</td><td>";
                echo($row['mileage']);
                echo("</td><td>");
                echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
                echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
                echo "</td></tr>\n";
            }
        } else {echo "<p>No entries found</p>";}
        ?>
        <a href="add.php">Add new</a> </br> 
        <a href="logout.php">Logout</a>



    </body>    
</html>