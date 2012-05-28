<?php
//Some vars used by the program
$xmlfile = '../Poliwag.xml';
$showCols = array('PACKNR','PACKNAME','PACKSIZE','PACKGETS','CRC32','ADDDATE');
$colnames = array('#','Filename','Size','Gets','Checksum','Added');
$rainbow = array('row1','row2');
$colum = 0;

//Default Parameters
$theme = 'awesome';
$start = 0; //row to start with (0 = first
$num = 20; //number of rows to show
$sortBy = 'ADDDATE'; //column name to sort by
$sortDesc = true; //sort descending (True) or ascending (False)
$filter = null; //only show rows tagged with the filter
$search = null; //only show rows containing this text

//Theme Orientated Vaiables
$awesome = array(
  "icons" => true,
  "carousel" => true,
  "search" => true
);
$dialup = array(
  "icons" => false,
  "carousel" => false,
  "search" => false
);

?>
