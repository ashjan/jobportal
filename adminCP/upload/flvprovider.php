<?php
	
    // ----- NO CACHE -----
	session_cache_limiter('nocache');

	// General header for no caching
	$now = gmdate('D, d M Y H:i:s') . ' GMT';
	header('Expires: ' . $now); // rfc2616 - Section 14.21
	header('Last-Modified: ' . $now);
	header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
	header('Pragma: no-cache'); // HTTP/1.0

	// ----- Seek position -----
	$seekat = 0;
	if (isset($_GET["pos"])) {
		$position = $_GET["pos"];
		if (is_numeric ($position)) {
			$seekat = intval($position);
		}
		if ($seekat < 0) $seekat = 0;
	}

	// ----- file -----
	$filename = "";
	if (isset($_GET["file"])) {
		$filename = htmlspecialchars($_GET["file"]);
	}
	$ext = strrchr($filename, ".");
	// to hide the video file. For example: $prefix = "hide_" 
	// to get the video file in a directory. For example: $prefix = "videos/" 
	$prefix = "";
	$file = $prefix . $filename;

	if (($filename != "") && (file_exists($file)) && ($ext==".flv")) {
		header("Content-Type: video/x-flv");
		//header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
		
		//Be sure to post the correct Content Length.
		if ($seekat > 0) header('Content-Length: ' . (filesize($file)-$seekat));
		else header('Content-Length: ' . filesize($file));
		
		if ($seekat != 0) {
			print("FLV");
			print(pack('C', 1 ));
			print(pack('C', 1 ));
			print(pack('N', 9 ));
			print(pack('N', 9 ));
		}
		$fh = fopen($file, "rb");
		fseek($fh, $seekat);
		while (!feof($fh)) {
 	 		print (fread($fh, 16384));
  			// print (fread($fh, filesize($file)));
		}
		fclose($fh);
	}
	else {
		print("<html><body>");
		print("Page not found.");
		print("</body></html>");
	}
?>
