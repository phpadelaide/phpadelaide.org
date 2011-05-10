<?php
// yeah... we know. This is a dummy app, cut some slack

$con = mysql_connect("localhost:/tmp/mysql/talitha.sock","ruthann","r6QlmBW0");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("talitha", $con);
$sql = "CREATE TABLE IF NOT EXISTS Message (Content text)";
mysql_query($sql,$con);

if (isset($_POST['Content'])) {
	if ($content = $_POST['Content']) {
		$sql="INSERT INTO Message (Content)
		VALUES
		('$content')";

		mysql_query($sql,$con);
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
			<form action="index.php" method="post">
				<div class="border">
					<input type="text" name="Content" class="textarea" />
				</div>
				<input class="btn" type="image" value="" src="images/btn.png" border="0" name="btn">
				<div class="message-box">
					<?					
					$count  = 0;
					$cssClass  = array("yellow", "orange");
					$result = mysql_query("SELECT * FROM Message");
					$valAr = array();
					
					// Pull values out of db and put in array
					while($row = mysql_fetch_array($result))
					{
						array_push( $valAr, $row['Content'] );			 		    
					}
					
					// Reverse arry and print values as html
					$valAr = array_reverse( $valAr );
					$len = count($valAr);
					for ($i=0; $i < $len; $i++) { 
						echo  "<div class='message " . $cssClass[$count] . "'>";
						echo  "	<span class='top'></span>";
						echo  $valAr[$i];
						echo  "	<span class='bottom'></span>";
						echo  "</div>";
						
						$count++;
						if( $count == ( count($cssClass) ) ){
							$count = 0;
						}
					}
					
					
					mysql_close($con);
					?>
				</div>
			</form>
		</div>
	</div>
</body>
</html>