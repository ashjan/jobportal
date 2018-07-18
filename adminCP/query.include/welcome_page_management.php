<?php
######################
#
# 	POST SECTION
#
######################
//---------Edit Category---------

	if($_POST['mode']=='update' && $_POST['act']=='welcome_page' && $_POST['request_page']=='welcome_page_management'){

	    $page_title = addslashes(trim($_POST['page_title']));
		$page_description = addslashes(trim($_POST['page_description']));
		$language = addslashes(trim($_POST['language']));
		$id=base64_decode($_POST['id']);
		$page_slug=slugcreation($page_title);
		
	
		
		if($page_title == '')
		{
				$errmsg = base64_encode('Please Enter Page Title');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}
		
		if($page_description == '')
		{
				$errmsg = base64_encode('Please Enter Page Description');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}
		
		
		if($language == 0)
		{
				$errmsg = base64_encode('Please Select Language');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}
			 	
				$sql_category= "SELECT * FROM ".$tblprefix."welcome_page 
												WHERE
												language_id = '".$language."'";
				$rs_category = $db->Execute($sql_category);
				$language_id=$rs_category->fields['language_id'];
				$id=$rs_category->fields['id'];
				$sql_category= "UPDATE ".$tblprefix."welcome_page 
												SET
												page_title = '".$page_title."',
												page_description = '".$page_description."',
												language_id = '".$language_id."',		
												page_slug = '".$page_slug."'														
												WHERE
												id=".$id;  
			    										
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category)
					{
						$okmsg = base64_encode("Welcome Updated successfully. !");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else
					{
						$errmsg = base64_encode('Unable to Update Welcome Page in database!!');
						header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
						exit;
					}
			} 
	
	


	   
	
		 
		
		

?>