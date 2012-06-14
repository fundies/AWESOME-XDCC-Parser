function doAjax() {
  $.get('table.php', {
    filter: document.getElementById("searchfilter").value,
    search: document.getElementById("searchtext").value,
    show: 'show'
  }, doUpdate);
  return false;
}
$(document).ready(function() { $("#searchform").bind("submit", doAjax); });
function jqSort(phpargs) {
  $.get('table.php?show&' + phpargs, {}, doUpdate);
  return false;
}
function doUpdate(txt,sammat) {
  document.getElementById("ajaxsearch").innerHTML = txt;
}
