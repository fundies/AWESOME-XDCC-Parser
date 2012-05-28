var icondiv;
var carouseldiv;
var allicons = [];
var c_first = 0;
var c_show = 30;
var c_speed = 4;
var c_delay = 1000/20;
var c_overlap = 240;
var c_timer;

function make_carousel() {
  icondiv = document.getElementById('newcarousel');
  for (var i = 0; i < icondiv.childNodes.length; i++)
    allicons.push({
      'html': "<a href=\"index.php?filter=" + icondiv.childNodes[i].alt + "\" onclick=\"return jqFilter('" + icondiv.childNodes[i].alt + "');\"><img src=\"" + icondiv.childNodes[i].src + "\" alt=\"" + icondiv.childNodes[i].alt + "\"></a>",
      'width': icondiv.childNodes[i].clientWidth,
      'height': icondiv.childNodes[i].clientHeight 
    });
  icondiv.innerHTML = "";
  icondiv.innerHTML = '<div id="carousel" style="position: relative; right: 0; white-space: nowrap;"></div>';
  carouseldiv = document.getElementById("carousel");
  set_icons();
  
  icondiv.style.overflow = "hidden";
  icondiv.style.maxWidth = "3200px";
  icondiv.style.width = "100%";
  
  carousel_start();
}
function set_icons() {
  var end = c_first+c_show, res = "";
  for (var i = c_first; i < end; i++)
    res += allicons[i % allicons.length].html;
  carouseldiv.innerHTML = res;
}
function carousel_frame() {
  var right = carouseldiv.style.right.match(/-?[0-9]+/) - 0;
  if (right >= c_overlap + allicons[c_first].width) {
    right = carouseldiv.style.right = right - allicons[c_first].width;
    c_first = (c_first + 1) % allicons.length;
    set_icons();
  }
  carouseldiv.style.right = (right + c_speed) + "px";
  c_timer = setTimeout("carousel_frame();", c_delay);
}

function carousel_start() {
  c_timer = setTimeout("carousel_frame();", c_delay);
}
function carousel_stop() {
  clearTimeout(c_timer);
}

function jqFilter(filter) {
  document.getElementById("searchfilter").value = filter;
  $.get('table.php', {
    filter: filter,
    show: 'show'
  }, doUpdate);
  return false;
}
function doUpdate(txt,sammat) {
  document.getElementById("ajaxsearch").innerHTML = txt;
}
