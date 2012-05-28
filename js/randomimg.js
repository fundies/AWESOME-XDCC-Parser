<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://www.javascriptsource.com -->
<!-- Original:  jsCode.com -->
<!-- Web Site:  http://jscode.com -->
<!--
// ==============================================
// Copyright 2003 by jsCode.com
// Source: jsCode.com
// Author: etLux
// Free for all; but please leave in the header.
// ==============================================

// Set up the image files to be used.
var theImages = new Array() // do not change this
// To add more image files, continue with the
// pattern below, adding to the array. Rememeber
// to increment the theImages[x] index!

// theImages[0] = 'header/newheader1.jpg'
// theImages[1] = 'header/newheader2.jpg'
// theImages[2] = 'header/newheader3.jpg'
// theImages[3] = 'header/newheader4.jpg'
theImages[0] = 'header/header.svg'

// ======================================
// do not change anything below this line
// ======================================

var j = 0
var p = theImages.length;

var preBuffer = new Array()
for (i = 0; i < p; i++){
   preBuffer[i] = new Image()
   preBuffer[i].src = theImages[i]
}

var whichImage = Math.round(Math.random()*(p-1));
function showImage(){
document.write('<img class="stretchimg" src="'+theImages[whichImage]+'">');
}

//-->