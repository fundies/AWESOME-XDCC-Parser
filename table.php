<?php

require_once('config.php');

//parse page parameters for vars
if (isset($_REQUEST['start'])) $start = $_REQUEST['start'];
if (isset($_REQUEST['num'])) $num = $_REQUEST['num'];
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
 global $showCols, $colum, $sortBy, $sortDesc, $colnames, $filter, $search;
 echo '<table class="center" border="0">';
 echo " <tr>\n<th id=\"left\"></th>";
 foreach ($showCols as $col) {
  $col = htmlspecialchars($col);
  $phpargs = "sort=$col";
  if ($sortBy == $col && !$sortDesc) $phpargs .= '&amp;desc';
  if (!empty($_REQUEST['filter']))
    $phpargs .= '&amp;filter=' . urlencode($filter);
  if (!empty($_REQUEST['search']))
    $phpargs .= '&amp;search=' . urlencode($search);
  echo "  <th id=\"$col\"><a href=\"index.php?" . $phpargs . '" onclick="return jqSort==undefined?true:jqSort(\'' . $phpargs . '\');">'
     . ucwords($colnames[$colum]) ;
  if ($sortBy == $col) echo $sortDesc ? " <img alt=\"up\" src=\"img/sorter.png\" />" : " <img alt=\"down\" src=\"img/sorter2.png\" />";
  echo "</a></th>\n";
  $colum++;
 }
 echo " </tr>\n";
}

//display sorted rows
function showTableRows() {
 global $rows, $start, $num, $showCols, $rainbow;
 $beg = max(0,min(count($rows),$start));
 $end = max(0,min(count($rows),$num + $start));
 //color counter
 $countcolour = 0;
 date_default_timezone_set('EST');
 for ($ind = $beg; $ind < $end; $ind++) {
  //check for end of array and repeat if necessary
  if ($countcolour > sizeof($rainbow)-1) $countcolour = 0;
  
  $r = $rows[$ind];
  echo "\n<tr onclick=\"prompt('Paste this into your IRC client:','/msg A-T|Poliwag xdcc send $r->rid');\" class='$rainbow[$countcolour]'>";

 echo "\n  <td class=\"icons\"><img class=\"img\" alt=\"$r->rgroup\" src=\"icons/$r->rgroup.png\" /></td>\n";
 foreach ($showCols as $col) {
  echo '  <td class="' . $col . '">';
  if ($col == 'ADDDATE') echo date("Y-m-d H:i:s",$r->rdate);
  else if ($col == 'PACKNAME') echo "<a onclick='return false;' href=\"command.php?pack=\">$r->rname</a>";
  else echo $r->getField($col);
  echo "</td>\n";
 }
echo "</tr>\n";

  $countcolour++;
 }
 if ($beg >= $end)
  echo "<tr><td colspan='5'>No Results</td></tr>\n";
}

//show Prev/Next
function showPrevNext() {
 global $rows, $start, $num, $num, $sortBy, $filter, $search;
 $beg = max(0,min(count($rows),$start));
 $end = max(0,min(count($rows),$num + $start));
 echo "</table>\n";
 echo '<p class="searchtext">Showing results ' . ($beg+1) . " to $end of " . count($rows) . ".</p>";
 echo '<p class="searchtext">';
 $sortInfo = '';
 if (isset($_REQUEST['num'])) $sortInfo .= '&num=' . $num;
 if (isset($_REQUEST['sort'])) $sortInfo .= '&sort=' . $sortBy;
 if (isset($_REQUEST['desc'])) $sortInfo .= '&desc';
 if (isset($_REQUEST['filter'])) $sortInfo .= '&filter=' . urlencode($filter);
 if (isset($_REQUEST['search'])) $sortInfo .= '&search=' . urlencode($search);
 if ($start > 0) {
  echo "<a href=\"index.php?start=" . ($start - $num) . $sortInfo;
  echo "\" onclick=\"return jqSort==undefined?true:jqPrev('" . ($start + $num) . $sortInfo . "')\">Previous $num</a>  \n";
 }
 if ($start + $num < count($rows)) {
  echo "<a href=\"index.php?start=" . ($start + $num) . $sortInfo;
  echo "\" onclick=\"return jqSort==undefined?true:jqNext('" . ($start + $num) . $sortInfo . "')\">Next $num</a>\n";
 }
 echo '</p>';
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
