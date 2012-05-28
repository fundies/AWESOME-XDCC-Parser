<script type="text/javascript" src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>
<?php require_once('table.php');

// Show Icons //
//Open images directory
echo '<div onmouseover="carousel_stop();" onmouseout="carousel_start();" id="newcarousel">';

//List files in images directory
    foreach ($filters as $f) {
     echo '<img alt="' .htmlspecialchars($f->name) .  '" class="icons" src="icons/' . htmlspecialchars($f->name) . '.png"/>';
    }

echo '</div>';

?>
