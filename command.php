<?php 
  require_once('config.php');
  require_once('xml.php');
  $pack = $_REQUEST['pack'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns='http://www.w3.org/1999/xhtml' lang='en-US' xml:lang='en-US'>
<head>
  <?php echo "<title>$title</title>"; ?>
  <meta http-equiv='Content-Type' content='text/html;charset=utf-8' />
  <link rel='icon' type='image/png' href='img/favicon.png' />
</head>
<body>
  <h1>Paste this into your IRC client:</h1>
<?php
 echo "<h2>/msg $nick xdcc send $pack</h2>";
?>
</body>
</html>
