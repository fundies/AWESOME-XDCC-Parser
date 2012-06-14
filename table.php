<?php

require_once('config.php');

//parse page parameters for vars
if (isset($_REQUEST['start'])) $start = $_REQUEST['start'];
if (isset($_REQUEST['num'])) $num = $_REQUEST['num'];
if (isset($_REQUEST['theme'])) $theme = $_REQUEST['theme'];
if (isset($_REQUEST['sort'])) $sortBy = $_REQUEST['sort'];
if (isset($_REQUEST['desc'])) $sortDesc = true;
else if (isset($_REQUEST['sort'])) $sortDesc = false; //override default
if (isset($_REQUEST['filter']) && !empty($_REQUEST['filter'])) $filter = $_REQUEST['filter'];
if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) $search = $_REQUEST['search'];
$page = $_SERVER['PHP_SELF'];

// Code below //

//parse xml into $rows
if (isset($_REQUEST['show'])) {
 require_once('xml.php');
 if (!isset($parser))
  $parser = new Parser($xmlfile);
}
$rows = $parser->rows;
$filters = $parser->filters;

//sort rows
usort($rows,"compareRows");

//filter/search rows
if (!empty($filter) || !empty($search)) {
 $r2 = array();
 foreach ($rows as $r)
  if (
     (empty($filter) || $r->rgroup == $filter)
  && (empty($search) || stripos($r->rname,$search) !== false)
     )
   $r2[] = $r;
 $rows = $r2;
}

if (isset($_REQUEST['show'])) showTable();

function showTable() { showTableHeader(); showTableRows(); showPrevNext(); }

//set up table header
function showTableHeader() {
 global $colum, $sortBy, $sortDesc, $filter, $search, $theme, ${$theme};
 echo "  <table class='packlist' border='0'>";
 echo "\n         <tr class='tableheader'>";
 if (${$theme}['icons']) echo "\n           <th id='left'></th>\n";
 foreach (${$theme}['showCols'] as $col) {
  $col = htmlspecialchars($col);
  $phpargs = "sort=$col";
  if ($sortBy == $col && !$sortDesc) $phpargs .= '&amp;desc';
  if (!empty($_REQUEST['filter']))
    $phpargs .= '&amp;filter=' . urlencode($filter);
  if (!empty($_REQUEST['search']))
    $phpargs .= '&amp;search=' . urlencode($search);
  if (!empty($_REQUEST['theme']))
    $phpargs .= '&amp;theme=' . urlencode($theme);

  echo "           <th id=\"$col\"><a href=\"index.php?" . $phpargs . '" onclick="return jqSort==undefined?true:jqSort(\'' . $phpargs . '\');">'
     . ucwords(${$theme}['colnames'][$colum]) ;
  if ($sortBy == $col) echo $sortDesc ? " <img alt=\"up\" src=\"img/sorter.png\" />" : " <img alt=\"down\" src=\"img/sorter2.png\" />";
  echo "</a></th>\n";
  $colum++;
 }
 echo "         </tr>\n";
}

//display sorted rows
function showTableRows() {
 global $rows, $start, $num, $showCols, $theme, ${$theme}, $nick;

 if (isset($_REQUEST['num'])) $sortInfo .= '&amp;num=' . $num; 
 else if (${$theme}['num'] == 0) $num = count($rows);
 else $num = ${$theme}['num'];

 $beg = max(0,min(count($rows),$start));
 $end = max(0,min(count($rows),$num + $start));
 //color counter
 $countcolour = 0;
 date_default_timezone_set('EST');
 for ($ind = $beg; $ind < $end; $ind++) {
  //check for end of array and repeat if necessary
  if ($countcolour > sizeof(${$theme}['rainbow'])-1) $countcolour = 0;
  
  $r = $rows[$ind];
  echo "\n         <tr onclick=\"prompt('Paste this into your IRC client:','/msg $nick xdcc send $r->rid');\" class=\"".${$theme}['rainbow'][$countcolour]."\">";

 if (${$theme}['icons'])
 echo "\n           <td class=\"icons\"><img class=\"img\" alt=\"$r->rgroup\" src=\"icons/$r->rgroup.png\" /></td>\n";

 foreach (${$theme}['showCols'] as $col) {
  echo '           <td class="' . $col . '">';
  if ($col == 'ADDDATE') echo date("Y-m-d",$r->rdate);
  else if ($col == 'PACKNAME') echo "<a onclick='return false;' rel='external' href=\"command.php?pack=$r->rid\">" . htmlspecialchars($r->rname) . "</a>";
  else echo htmlspecialchars($r->getField($col));
  echo "</td>\n";
 }
echo "         </tr>\n";

  $countcolour++;
 }
 if ($beg >= $end)
  echo "<tr><td colspan='0'>No Results</td></tr>\n";
}

//show Prev/Next
function showPrevNext() {
 global $rows, $start, $num, $sortBy, $filter, $search, $theme, ${$theme};
 $sortInfo = '';

 $beg = max(0,min(count($rows),$start));
 $end = max(0,min(count($rows),$num + $start));

 echo "       </table>\n\n";
 echo '       <p class="searchtext">Showing results ' . ($beg+1) . " to $end of " . count($rows) . ".</p>\n";
 //echo "       <p class='searchtext'>";
 
 if (isset($_REQUEST['sort'])) $sortInfo .= '&amp;sort=' . $sortBy;
 if (isset($_REQUEST['desc'])) $sortInfo .= '&amp;desc';
 if (isset($_REQUEST['filter'])) $sortInfo .= '&amp;filter=' . urlencode($filter);
 if (isset($_REQUEST['search'])) $sortInfo .= '&amp;search=' . urlencode($search);
 if (isset($_REQUEST['theme'])) $sortInfo .= '&amp;theme=' . urlencode($theme);

 if ($start > 0) {
  echo "<a href=\"index.php?start=" . ($start - $num) . $sortInfo;
  echo "\" onclick=\"return jqSort==undefined?true:jqPrev('" . ($start + $num) . $sortInfo . "')\">Previous $num</a>  \n";
 }
 if ($start + $num < count($rows)) {
  echo "<a href=\"index.php?start=" . ($start + $num) . $sortInfo;
  echo "\" onclick=\"return jqSort==undefined?true:jqNext('" . ($start + $num) . $sortInfo . "')\">Next $num</a>\n";
 }
}
function showinfo() {
  global $transfered, $offered, $slotsfree, $slotsmax, $uptime, $version;
  
  echo "\n       <table id='stats'>\n";
  echo "         <tr class='tableheader'>\n";
  echo "           <th>Slots Open</th>\n";
  echo "           <th>Total Slots</th>\n";
  echo "           <th>Total Transfered</th>\n";
  echo "           <th>Total Offered</th>\n";
  echo "           <th>Uptime</th>\n";
  echo "           <th>Version</th>\n";
  echo "         </tr>\n";

  echo "         <tr>\n";
  echo "           <td>$slotsfree</td>\n";
  echo "           <td>$slotsmax</td>\n";
  echo "           <td>$transfered</td>\n";
  echo "           <td>$offered</td>\n";
  echo "           <td>$uptime</td>\n";
  echo "           <td><a href='http://iroffer.dinoex.de/projects/show/iroffer'>$version</a></td>\n";
  echo "         </tr>\n";
  echo "       </table>\n";
}

//sort callback function
function compareRows($row1, $row2) {
 global $sortBy, $sortDesc;

 $sortStr = Row::isFieldStr($sortBy);
 $f1 = $row1->getField($sortBy);
 $f2 = $row2->getField($sortBy);
 if (!$sortStr) {
  $f1 = $f1 - 0;
  $f2 = $f2 - 0;
 }
 $r = 0;
 if ($sortStr) $r = strcmp($f1,$f2);
 else $r = ($f1 == $f2 ? 0 : $f1 > $f2 ? 1 : -1);
 if ($sortDesc) $r = -$r;
 return $r;
}

?>
