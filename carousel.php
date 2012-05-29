<?php require_once('table.php');

// Show Icons //
//Open images directory
echo '<div onmouseover="carousel_stop();" onmouseout="carousel_start();" id="newcarousel">';

//List files in images directory
    foreach ($filters as $f) {
     echo "<img alt=\"" . htmlspecialchars($f->name) . "\" class='icons' src='icons/" . htmlspecialchars($f->name) . ".png' />";
    }

echo '</div>';

?>
