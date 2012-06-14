    <?php
	if (${$theme}['botname']) echo "<h1>$nick</h1>\n";
    ?>
    <div id='newsearch'>
      <form action='index.php' id='searchform'>
        <div class='searchtext'><div id='pulldown'>Show : 
          <select name='filter' id='searchfilter' onchange='doAjax()'>
            <option value="">All</option>
            <?php
              require_once('table.php');
              foreach ($filters as $f) {
                echo '            <option value="' . $f->name . '"';
                if ($filter == $f->name) echo ' selected="selected"';
                echo '>' . htmlspecialchars($f->desc) . "</option>\n";
              } 
           ?>
           </select></div>
           <script type="text/javascript">
             var delayTimer = null;
             function delayAjax() {
               if (delayTimer) clearTimeout(delayTimer);
               delayTimer = setTimeout("doAjax()", 500);
             }
           </script>
           <div id='searchinput'> (and/or) Search: 
           <input type='text' name='search' id='searchtext' onkeypress='delayAjax()' />
           <input type='submit' value='Go' /></div>
         </div>
       </form>
     </div>

     <div id='ajaxsearch'>
     <?php
       require_once('table.php');
       showTable();
       showinfo();
     ?>
     </div>
