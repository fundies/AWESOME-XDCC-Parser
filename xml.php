<?php
// Class Definitions //

class Row {
 public $rid, $rgets, $rdate, $rcrc, $rsize, $rgroup;
 public $rname, $rfilter;

 function setField($field,$val) {
  switch ($field) {
   case 'PACKNR': $this->rid = $val; break;
   case 'PACKNAME': $this->setName($val); break;
   case 'PACKGETS': $this->rgets = $val; break;
   case 'ADDDATE': $this->rdate = $val; break;
   case 'PACKSIZE': $this->rsize = $val; break;
   case 'CRC32': $this->rcrc = $val; break;
   case 'GROUPNAME': $this->rgroup = $val; break;
  }
 }

 function setName($val) {
  $regex = '/[\s_]*(.+?)[\s_]*-[\s_]*[0-9]/';
  $regex2 = '/[\s_]*(.+?)[\s_]*\[/';
  $this->rname = $val;
  if (preg_match($regex,$val,$matches))
   $this->rfilter = $matches[1];
  else if (preg_match($regex2,$val,$matches))
   $this->rfilter = $matches[1];
  else
   $this->rfilter = '_Other';
 }

 function getField($field) {
  switch ($field) {
   case 'PACKNR': return $this->rid;
   case 'PACKNAME': return $this->rname;
   case 'PACKGETS': return $this->rgets;
   case 'ADDDATE': return $this->rdate;
   case 'PACKSIZE': return $this->rsize;
   case 'CRC32': return $this->rcrc;
   case 'GROUPNAME': return $this->rgroup;
   default: return null;
  }
 }

 static function isFieldStr($field) {
  return $field == 'PACKNAME' || $field == 'CRC32';
 }
}

class Filter {
 public $name, $desc;

 function setField($field,$value) {
  switch ($field) {
   case 'GROUPNAME': $this->name = $value; break;
   case 'GROUPDESC': $this->desc = $value; break;
  }
 }
}

class Parser {
 public $rows, $filters;
 private $row, $filter, $field; //current

 function Parser($fname) {
  $parser = xml_parser_create();
  xml_set_object($parser,$this);
  xml_set_element_handler($parser, "startElement", "endElement");
  xml_set_character_data_handler($parser, "characterData");

  $file = fopen($fname, 'rb');
  while ($data = fread($file, 4096))
   xml_parse($parser, $data, feof($file));

  fclose($file);
  xml_parser_free($parser);
 } 

 //XML callback functions
 function startElement($parser_instance, $element_name, $attrs) {
  if ($element_name == 'PACK') {
   $this->rows[] = $this->row = new Row();
   return;
  }
  if ($element_name == 'GROUP') {
   $this->filters[] = $this->filter = new Filter();
   return;
  }

  if ($this->row != null || $this->filter != null)
   $this->field = $element_name;
  else
   $this->field = null;
 }

 function characterData($parser_instance, $xml_data) {
  if ($this->row != null)
   $this->row->setField($this->field,$xml_data);
  if ($this->filter != null)
   $this->filter->setField($this->field,$xml_data);
 }
 
 function endElement($parser_instance, $element_name) {
  if ($element_name == 'PACK') {
   $this->row = null;
   return;
  }
  if ($element_name == 'GROUP') {
   $this->filter = null;
   return;
  }
  if ($element_name == $this->field) {
   $this->field = null;
   return;
  }
 }
}
?>
