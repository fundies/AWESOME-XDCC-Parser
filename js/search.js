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
