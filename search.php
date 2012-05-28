<script type="text/javascript">
  $(document).ready(function() { $("#searchform").bind("submit", 
function() {
    $.get('table.php', {
      filter: document.getElementById("searchfilter").value,
      search: document.getElementById("searchtext").value,
      show: 'show'
    }, doUpdate);
    return false;
  }); });
  function jqSort(phpargs) {
    $.get('table.php?show&' + phpargs, {}, doUpdate);
    return false;
  }
  function doUpdate(txt,sammat) {
    document.getElementById("ajaxsearch").innerHTML = txt;
  }
</script>
<div id="newsearch"><form action="index.php" id="searchform"><p 
class="searchtext">Show : <select name="filter" id="searchfilter">
 <option value="">All</option>
<?php
    foreach ($filters as $f) {
     echo ' <option value="' . $f->name . '"';
     if ($filter == $f->name)
      echo ' selected="selected"';
     echo '>' . htmlspecialchars($f->desc) . "</option>\n";
    } 
?>
</select> (and/or) Search: <input type="text" name="search" 
id="searchtext"/>
<input type="submit" value="Go" /></p></form><p />
</div>
<div id="ajaxsearch">
  <?php
    require_once('table.php');
    showTable();
  ?>
</div>
