<?php

// yeah... we know :-O This is a dummy app, cut some slack

$noDatabase = true;
if (isset($_SERVER['DB1_HOST']) && isset($_SERVER['DB1_USER']) && isset($_SERVER['DB1_PASS']) && isset($_SERVER['DB1_NAME'])) {
  $con = mysql_connect($_SERVER['DB1_HOST'], $_SERVER['DB1_USER'], $_SERVER['DB1_PASS']);
  if (!$con) {
    $noDatabase = true;
    die('Could not connect: ' . mysql_error());
  }

  $noDatabase = !mysql_select_db($_SERVER['DB1_NAME'], $con);

  if (isset($_POST['Content'])) {
    // Create Table if not exist
    $sql = 'CREATE TABLE IF NOT EXISTS `Message` (`Content` text NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8';
    mysql_query($sql, $con);

    if ($content = $_POST['Content']) {
      $sql = "INSERT INTO Message (Content) VALUES ('" . mysql_real_escape_string($content, $con) . "')";
      mysql_query($sql, $con);
    }
  }
}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>Pagoda Message App</title>
  <link rel="stylesheet" type="text/css" href="css/layout.css" media="all" />
  <script type="text/javascript" src="http://use.typekit.com/hai1jyh.js"></script>
  <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
</head>
<body>
  <div class="wrapper">
    <div class="content">
      <? if ($noDatabase): ?>
        <div class="moon"></div>
        <div class="box">
          <p>We were unable to locate your database. You can create one in your <a href="http://dashboard.pagodabox.com" target="_blank">admin panel</a>, Pagoda Box will automatically make the database credentials available tot his application.</p>
          <p>No need to move in haste, the universe is patient.</p>
        </div>
      <? else: ?>
        <form action="index.php" method="post">
          <div class="border">
            <input type="text" name="Content" class="textarea" />
          </div>
          <input class="btn" type="image" value="" src="images/btn.png" border="0" name="btn">
          <div class="message-box">
            <?          
            $count  = 0;
            $cssClass  = array("yellow", "orange");
            $result = mysql_query("SELECT * FROM `Message`", $con);
            $valAr = array();

            // Pull values out of db and put in array
            while ($result and $row = mysql_fetch_array($result))
            {
              array_push($valAr, $row['Content']);
            }

            // Reverse array and print values as html
            $valAr = array_reverse( $valAr );
            $len = count($valAr);
            for ($i = 0; $i < $len; $i++) { 
              echo  "<div class='message " . $cssClass[$count] . "'>";
              echo  "  <span class='top'></span>";
              echo  $valAr[$i];
              echo  "  <span class='bottom'></span>";
              echo  "</div>";

              $count++;
              if ($count == (count($cssClass))){
                $count = 0;
              }
            }

            mysql_close($con);
            ?>
          </div>
        </form>
      <? endif ?>
    </div>
  </div>
</body>
</html>
