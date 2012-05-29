
    <div id='newsearch'>
      <form action='index.php' id='searchform'>
        <p class='searchtext'>Show : 
          <select name='filter' id='searchfilter'>
            <option value="">All</option>
            <?php
              require_once('table.php');
              foreach ($filters as $f) {
                echo '            <option value="' . $f->name . '"';
                if ($filter == $f->name) echo ' selected="selected"';
                echo '>' . htmlspecialchars($f->desc) . "</option>\n";
              } 
           ?>
           </select> (and/or) Search: 
           <input type='text' name='search' id='searchtext'/>
           <input type='submit' value='Go' />
         </p>
       </form>
     </div>

     <div id='ajaxsearch'>
     <?php
       require_once('table.php');
       showTable();
     ?>
     </div>
