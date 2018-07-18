<?php
if(!isset($_SESSION[SESSNAME])){
	$msg=base64_encode("Unauthorize Access! Please Login.");
	header("Location: index.php?msg=$msg");
	exit;
}
?>