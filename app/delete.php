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
            case (isset($_POST["delete"])):
                $stmt = $pdo->prepare("
                    DELETE FROM autos
                    WHERE autos_id = :id"
                );
                $stmt->execute(array(
                    ':id' => $_GET['autos_id']
                ));
                $_SESSION['mess'] = '<span style="color:green;">Record for auto'.$_GET['autos_id'].' deleted</span>';
                header('Location: view.php', true, 303 );
                return;
            default:
                //break;
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
      <?php echo "<h1>Confirm deletion of $_GET[autos_id] auto</h1></br>"; 
      ?>
      <?php print_r($_SESSION);
        print_r($_POST);
        print_r($_GET); ?>
      <form method='post'>
          <input type="submit" name='delete' value="Delete">
          <input type="submit" name="cancel" value="Cancel">
        </form>
    </body>    
</html>