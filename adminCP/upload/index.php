<head>
<script type="text/javascript" src="swfobject.js"></script>
<script type="text/javascript">
var attributes = {};

var params = {}; 
// for fullscreen 
params.allowfullscreen = "true";

var flashvars = {}; 
// the video file or the playlist file 
flashvars.file = "video.flv"; 

// the PHP script (1.5 is a recommended value for PHP Streaming for bufferlength)
flashvars.streamscript = "flvprovider.php"; 
flashvars.bufferlength = "1.5"; 

// width and height of the player (h is height of the video + 20 for controlbar) 
// required for IE7 
flashvars.width = "320"; 
flashvars.height = "260"; 
// width and height of the video 
flashvars.displaywidth = "320"; 
flashvars.displayheight = "240"; 
flashvars.autostart = "true"; 
flashvars.showdigits = "true"; 

// for fullscreen 
flashvars.showfsbutton = "true"; 

// 9 for Flash Player 9 (for ON2 Codec and FullScreen)
swfobject.embedSWF("player.swf", "flashcontent", "320", "260", "9.0.0",                    "playerProductInstall.swf", flashvars, params, attributes);
</script>
</head>
<body>
<div id="flashcontent">
</div> 
...
</body>