<?php
  ini_set('display_errors', 1);
  ini_set('log_errors', 1);
  ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
  error_reporting(E_ALL);
  require_once('config.php');
  if (isset($_REQUEST['theme'])) $theme = $_REQUEST['theme'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns='http://www.w3.org/1999/xhtml' lang='en-US' xml:lang='en-US'>
<head>
  <?php 
    echo "<title>$title</title>\n"; 
    echo "  <link rel='stylesheet' href=\"css/$theme/stylesheet.css\" type='text/css' />\n";
    echo "  <script type='text/javascript' src='http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js'></script>\n";
    if (${$theme}["carousel"]) echo "  <script type='text/javascript' src='js/carousel.js'></script>\n";
  ?>
  <script type='text/javascript' src='js/search.js'></script>
  <meta http-equiv='Content-Style-Type' content='text/css' />
  <meta http-equiv='Content-Type' content='text/html;charset=utf-8' />
  <link rel='icon' type='image/png' href='img/favicon.png' />
</head>

<?php
  if (${$theme}["carousel"]) echo '<body onload="make_carousel();">'; else echo '<body>';
  echo "\n  <div id='newpagewidth'>\n";
    include('xml.php');
    $parser = new Parser($xmlfile);
    if (!empty(${$theme}['header'])) include('header.php');
    if (${$theme}['carousel']) include('carousel.php');
    include('search.php');
    include('footer.php');
?>
  </div>
</body>
</html>
