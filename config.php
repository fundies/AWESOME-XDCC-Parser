<?php
//Some vars used by the program
$xmlfile = '../Poliwag.xml';
$colum = 0;

//Default Parameters
$title = '#Awesome-Toons -- irc.rizon.net';
$theme = 'awesome';
$start = 0; //row to start with (0 = first
$sortBy = 'ADDDATE'; //column name to sort by
$sortDesc = true; //sort descending (True) or ascending (False)
$filter = null; //only show rows tagged with the filter
$search = null; //only show rows containing this text

//Theme Orientated Vaiables
$awesome = array(
  "showCols" => array('PACKNR','PACKNAME','PACKSIZE','PACKGETS','CRC32','ADDDATE'),
  "colnames" => array('#','Filename','Size','Gets','Checksum','Added'),
  "rainbow" => array('red','orange','yellow','green','blue','purple'),
  "icons" => true,
  "carousel" => true,
  "search" => true,
  "num" => 20,
  "header" => "header/scaleheader.svg",
  "botname" => false
);
$dialup = array(
  "showCols" => array('PACKNR','PACKNAME','PACKSIZE','PACKGETS','CRC32','ADDDATE'),
  "colnames" => array('#','Filename','Size','Gets','Checksum','Added'),
  "rainbow" => array('row1','row2'),
  "icons" => false,
  "carousel" => false,
  "search" => false,
  "num" => 0,
  "header" => null,
  "botname" => true
);
?>
