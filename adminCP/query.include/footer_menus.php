<?php
if($_GET['mode'] == 'edit' && $_GET['act'] == 'managemenues' && $_GET['request_page'] == 'footer_menus' && $_GET['id'] != '' && $_GET['changevalue'] != '')
{
	

$id=base64_decode($_GET['id']);

$footer_menu = $_GET['changevalue'] ;

$sql_update = "UPDATE ".$tblprefix."menu SET	
												 
												
												 footer_menu ='".$footer_menu."'
												 
												 WHERE
												 id=".$id; 
											
											
			$rs_update = $db->Execute($sql_update);
		    if($rs_update){
			$okmsg = base64_encode(" Menu item Updated successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
			exit;	  
				}else{
			$errmsg = base64_encode(" Menu item not updated. !");
			header("Location: admin.php?errmsg=$errmsg&act=".$_GET['act']);
			exit;	  	
			} 
			} 






	
	
	/*echo '<pre>';
	print_r($_GET);
	exit();
}*/
?>