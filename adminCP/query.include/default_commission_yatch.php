<?php
######################
#
# 	POST SECTION
#
######################
//---------Add property Feature---------

	if($_POST['mode']=='add' && $_POST['act']=='default_commission' && $_POST['request_page']=='default_commission_management'){
        $default_commission_rate = addslashes(trim($_POST['default_commission_rate']));
		 //$id= base64_decode($_POST['id']); 
		 
		
		
		 if($default_commission_rate == ''){
				$errmsg = base64_encode('Please Enter Commission Rate');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			
		 $insert_property_feature = "INSERT INTO ".$tblprefix."default_commission  
										SET
										
										default_commission_rate = '".$default_commission_rate."'
										";
				
		
		 	
				
										
				$rs_insert = $db->Execute($insert_property_feature);
				
				$okmsg = base64_encode("Commission Added successfully!");
					header("Location: admin.php?okmsg=$okmsg&act=default_commission");
					exit;
				
	} 
	
	
	
	
//---------Edit Category---------

	if($_POST['mode']=='update' && $_POST['act']=='edit_defyatch' && $_POST['request_page']=='default_commission_yatch'){

	    $default_commission_rate = addslashes(trim($_POST['default_commission_rate']));
		
		
		 		
		$id=base64_decode($_POST['id']);
		
	
		
		$_SESSION['default_commission_rate']= $default_commission_rate;
		$_SESSION['id']= $id;
		
		if($default_commission_rate == '')
		{
				$errmsg = base64_encode('Please Enter Commission Rate');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}
		if($default_commission_rate==0 || $default_commission_rate > 100)
		{
				$errmsg = base64_encode('Commission rate must be greater than 0 and less than 100');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
		}
		
				$sql_category= "UPDATE ".$tblprefix."yatchdef_commission 
												SET
												default_commission_rate = '".$default_commission_rate."'
												WHERE
												id=".$id;
														
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category)
					{
						$okmsg = base64_encode("Commission Updated successfully. !");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else
					{
						$errmsg = base64_encode('Unable to Update commission in database!!');
						header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
						exit;
					}
			} 
	
	


	   
######################
#
# 	GET SECTION
#
######################

//---------Delete THe Category and its language contents---------
if($_GET['mode']=='del_region' && $_GET['act']=='default_commission' && $_GET['request_page']=='default_commission_management'){
		$id=base64_decode($_GET['id']);


		 $del_qry = " DELETE FROM ".$tblprefix."default_commission WHERE id = ".$id." ";
		
		$rs_del = $db->Execute($del_qry);				
				
		
		
		$okmsg = base64_encode("Default Commission Deleted successfully!");
					header("Location: admin.php?okmsg=$okmsg&act=default_commission");
					exit;	  
} 
		
//---------Service Provider Status---------		
		 
		
		

?>