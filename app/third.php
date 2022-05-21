<?php setcookie("user","12345"); 
    function dehash() {
        $try = 0;
        if(!empty($_POST['md5'])) {
            $txt = str_split('0123456789');
            foreach ($txt as $i) {
                foreach($txt as $j) {
                    foreach($txt as $k) {
                        foreach($txt as $l) {
                            $hash = md5($i . $j . $k . $l);
                            $try += 1;
                            if ($hash == $_POST['md5']) {
                                echo "PIN: $i$k$k$l \nTotal tries: $try";
                                break;
                            }
                            if ($k+$i+$j == 0) {
                                echo "$hash \t $i$j$k$l</br>";
                            }
                        }
                    }
                }
            }
            $_POST = array();
        }
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Untitled</title>
    <meta name="description" content="This is an example of a meta description.">
    <link rel="stylesheet" type="text/css" href="theme.css">
  </head>
  <body>
      <h1>MD5 cracker</h1>
      <p>This application dehashes MD5hash of a four digit pin using dictionary attack</p>
      <p style="font-style: italic;">Debug output:</p>
      <pre>
        <?php dehash(); ?>
      </pre>
      <form method='post'>    
      <input type="text" name="md5" size="60"/>
      <input type="submit" value="Crack!" />
      </form>
      
    




  </body>
</html>