<?php   include('include/file_include.php');
        if(isset($_SESSION[SESSNAME])){
	//session_unregister(SESSNAME);
	unset($_SESSION[SESSNAME]);
	//$msg=base64_encode("You have successfully logged out.");
	$msg=base64_encode("You are now logout successfully");
	header("Location: index.php?msg=$msg");
        exit;
}
?>