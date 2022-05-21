<?php
    session_start();
    if ($_POST) {
        switch ($_POST) {
            case (isset($_POST['cancel'])):
                $_SESSION['mess'] = '<span style="color:red;">Logged out</span>';
                header("Location: third.php", true, 303);
                session_destroy;
                return;
            case (empty($_POST['who']) || empty($_POST['pass'])):
                $_SESSION['mess'] = '<span style="color:red;">Email and password are required</span>';
                header("Location: login.php", true, 303);
                return;
            case (empty(stristr($_POST['who'], '@')) || empty(stristr($_POST['who'], '@', true))):
                $_SESSION['mess'] = '<span style="color:red;">Please enter valid email</span>';
                header("Location: login.php", true, 303);
                return;
            case (md5('XyZzy12*_' . $_POST['pass']) == '1a52e17fa899cf40fb04cfc42e6352f1'):
                error_log("Login success ".$_POST['who']);
                $_SESSION['name'] = $_POST['who'];
                header("Location: view.php", true, 303);
                return;
            case (md5('XyZzy12*_' . $_POST['pass']) != '1a52e17fa899cf40fb04cfc42e6352f1'):                
                $_SESSION['mess'] = '<span style="color:red;">Incorrect password</span>';
                error_log("Login fail ".$_POST['who']." $check");
                header("Location: login.php", true, 303);
                return;
            default:
                # code...1
                #break;
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
      <h1>Please login</h1>
      <form method='post'>
          <label>Login</label><input type="text" name="who" size="60"/></br>
          <label>Pass</label><input type="text" name="pass"/></br>
          <input type="submit" value="Log In">
          <input type="submit" name="cancel" value="Cancel">
      </form>
      <?php 
      if (isset($_SESSION['mess'])) {
          echo($_SESSION['mess']);
          unset($_SESSION['mess']);
        }
      ?>

    



    </body>    
</html>