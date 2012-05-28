<?php 
  require_once('config.php');
  if (isset($_REQUEST['theme'])) $theme = $_REQUEST['theme'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<title>#Awesome-Toons -- irc.rizon.net</title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<?php echo "<link rel=\"stylesheet\" href=\"css/$theme/stylesheet.css\" type=\"text/css\" />"; ?>
<link rel="icon" type="image/png" href="img/favicon.png" />
<script type="text/javascript" src="js/carousel.js"></script>
<script type="text/javascript" src="js/randomimg.js"></script>

</head>

<body onload="make_carousel();">
<div id="newpagewidth">
	<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
		include('xml.php');
		$parser = new Parser($xmlfile);
		include('header.php');
		if ($$theme["carousel"]) include('carousel.php');
		include('search.php');
		include('footer.php');
	?>
</div>
</body>
</html>
