<?php
$signData = $_POST["ctlSignature_data"]; // the data that comes from client side
$fileName = $_POST["ctlSignature_file"]; // the name of file for reference that comes from client side
$cal_date = $_POST["calendarss"];
  session_start();
  if(strlen($signData) > 0){
	include 'license.php';
  	$im = GetSignatureImage($signData);
  	$_SESSION['im'] = $im; // store session data
	if(null != $im){
	  if(strlen($fileName) > 0){
	  // Process the $im object here on your server you can save, email, store in DB etc.
   	  imagepng($im,$fileName,0,NULL);
   	  // Please see http://php.net/manual/en/function.imagepng.php
	  // You can also use JPEG  http://www.php.net/manual/en/function.imagejpeg.php
	  // For DB, http://forum.codecall.net/php-tutorials/6937-tutorial-storing-images-mysql-php.html
	  }
     Header("Content-type: image/png");
	 imagepng($im);
     ImageDestroy($im);  
     }else{
     echo "<h3>Error generating signature. Check license.</h3>";
     }
  echo "<br/>  Date : ".$cal_date; 		
}
else{
 echo "<h3>Invalid or missing signature data.</h3>";
}
?>