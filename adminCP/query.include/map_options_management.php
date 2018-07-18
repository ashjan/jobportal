<?php
error_reporting(E_ALL);
######################
#
# 	POST SECTION
#
######################
//---------Add Map Options---------

	if($_POST['mode']=='add' && $_POST['act']=='map_options' && $_POST['request_page']=='map_options_management'){
		$post=$_POST;
        $site_name = addslashes(trim($post['site_name']));
	 	$map_key = addslashes(trim($post['map_key']));   
		 //$id= base64_decode($_POST['id']); 
		 $slug= "montengro";
		
		
		 if($site_name == '')
		{
				$msg = base64_encode('Please Enter Site URL');
				header("Location: admin.php?okmsg=$msg&act=".$_POST['act']."&id=".base64_encode($id));
				exit;
		}
		
		function isValidURL($site_name)
		{
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $site_name);
		}
		
		if(!isValidURL($site_name))
		{
		$msg .= base64_encode("Please enter valid URL including http://<br>");
		header("Location: admin.php?okmsg=$msg&act=".$_POST['act']."&id=".base64_encode($id));
		 exit;
		 }
		
		if($map_key == '')
		{
				$msg = base64_encode('Please Enter Map Key');
				header("Location: admin.php?okmsg=$msg&act=".$_POST['act']."&id=".base64_encode($id));
				exit;
		}
		

			
				 $insert_property_feature = "INSERT INTO ".$tblprefix."map_options  
										SET
										site_name = '".$site_name."',
										map_key = '".$map_key."',
										slug = '".$slug."'
										"; 
				$rs_insert = $db->Execute($insert_property_feature);
				
				$okmsg = base64_encode("Map Options Added successfully!");
					header("Location: admin.php?okmsg=$okmsg&act=map_options");
					exit;
				
	} 
	
	
	
	
//---------Update Map Options---------

	if($_POST['mode']=='update' && $_POST['act']=='edit_map_options' && $_POST['request_page']=='map_options_management'){
		
		$site_name = addslashes(trim($_POST['site_name']));
		$map_key = addslashes(trim($_POST['map_key']));	
		$id=base64_decode($_POST['id']);
		$post=$_POST;
		$slug= "montengro";
		if($site_name == '')
		{
				$msg = base64_encode('Please Enter Site Name');
				header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".base64_encode($id));
				exit;
		}
		
		
		if (!preg_match("#^http://www\.[a-z0-9-_.]+\.[a-z]{2,4}$#i",$site_name)) {
		$msg .= base64_encode("Please enter valid URL including http://<br>");
			header("Location: admin.php?okmsg=$msg&act=".$_POST['act']."&id=".base64_encode($id));
			 exit;
			} 
			
		/*if(!isValidURL($site_name))
		{
		$msg .= base64_encode("Please enter valid URL including http://<br>");
		header("Location: admin.php?okmsg=$msg&act=".$_POST['act']."&id=".base64_encode($id));
		 exit;
		 }*/
		
		if($map_key == '')
		{
				$msg = base64_encode('Please Enter Map Key');
				header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".base64_encode($id));
				exit;
		}
		
		
		
				$sql_category= "UPDATE ".$tblprefix."map_options 
												SET
												site_name = '".$site_name."',
												map_key = '".$map_key."',
												slug = '".$slug."'
												WHERE
												id=".$id;
														
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category)
					{
						$okmsg = base64_encode("Map Options Updated successfully. !");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else
					{
						$errmsg = base64_encode('Unable to Update Map Options in database!!');
						header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
						exit;
					}
			} 
	
	


	   
######################
#
# 	GET SECTION
#
######################

//---------Delete Map Options---------
if($_GET['mode']=='delete' && $_GET['act']=='map_options' && $_GET['request_page']=='map_options_management'){
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."map_options WHERE id = ".$id." ";
		$rs_del = $db->Execute($del_qry);				
		$okmsg = base64_encode("Map Options Deleted successfully!");
					header("Location: admin.php?okmsg=$okmsg&act=map_options");
					exit;	  
} 
	
?>