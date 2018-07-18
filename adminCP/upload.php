<?php
// Path to our font file
$font     = 'arial.ttf';
$fontsize = 10;

// array of random quotes
$quotes = array(
"http://www.flingbits.com is the greatest invention since sliced bread! Except you can't slice it...",
"Did you hear about the guy whose whole left side was cut off? He's all right now.",
"There was a sign on the lawn at a drug re-hab center that said 'Keep off the Grass'.",
"Police were called to a daycare where a three-year-old was resisting a rest.",
"A hole has been found in the nudist camp wall. The police are looking into it.",
"When a clock is hungry it goes back four seconds.",
"Time flies like an arrow. Fruit flies like a banana.",
"Local Area Network in Australia: the LAN down under.",
"Alcohol and calculus don't mix so don't drink and derive.");

// generate a random number with range of # of array elements
$pos       = rand(0,count($quotes)-1);
// get the quote and word wrap it
$quote     = wordwrap($quotes[$pos],20);

// create a bounding box for the text
$dims      = imagettfbbox($fontsize, 0, $font, $quote);

// make some easy to handle dimension vars from the results of imagettfbbox
// since positions aren't measures in 1 to whatever, we need to
// do some math to find out the actual width and height
$width     = $dims[4] - $dims[6]; // upper-right x minus upper-left x 
$height    = $dims[3] - $dims[5]; // lower-right y minus upper-right y

// Create image
$image     = imagecreatetruecolor($width,$height);

// pick color for the background
$bgcolor   = imagecolorallocate($image, 100, 100, 100);
// pick color for the text
$fontcolor = imagecolorallocate($image, 255, 255, 255);

// fill in the background with the background color
imagefilledrectangle($image, 0, 0, $width, $height, $bgcolor);

// x,y coords for imagettftext defines the baseline of the text: the lower-left corner
// so the x coord can stay as 0 but you have to add the font size to the y to simulate
// top left boundary so we can write the text within the boundary of the image
$x         = 0; 
$y         = $fontsize;
imagettftext($image, $fontsize, 0, $x, $y, $fontcolor, $font, $quote);

// tell the browser that the content is an image
header('Content-type: image/jpg');
// output image to the browser
imagejpg($image);

// delete the image resource 
imagedestroy($image);
?>