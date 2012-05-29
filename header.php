<?php
if (!preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT'])) { 
echo "    <div id='newheader'><img id='header' alt='Awesome-Toons' src='header/scaleheader.svg' /></div>";
}
?>
