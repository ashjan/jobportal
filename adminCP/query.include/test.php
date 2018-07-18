<?php 
if($_GET['mode']=='add' && $_GET['act']=='lang_cont_managment' && $_GET['request_page']=='test'){
echo 'here';die;
		$pageid=base64_decode($_GET['pageid']);
		$del_qry = " DELETE FROM ".$tblprefix."pagecontent WHERE id = ".$pageid;
		$rs_newsletter = $db->Execute($del_qry);				
		$okmsg = base64_encode("Deleted Content Page successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;	  
} 



?>