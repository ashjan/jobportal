<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------

	if($_POST['mode']=='add' && $_POST['act']=='yatchcategory' && $_POST['request_page']=='yatchcategorymanagement'){ 
		$yatch_category_name = addslashes(trim($_POST['yatch_category_name']));
		//$pm_id = addslashes(trim($_POST['pm_id']));	
		$slug=slugcreation($yatch_category_name);
		
			if($yatch_category_name == ''){
				$errmsg = base64_encode('Please Enter yatch Category Name');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
			 	 $sql_category= "INSERT INTO ".$tblprefix."yatch_category 
														SET
														yatch_category_name = '".$yatch_category_name."',
														
														yatch_category_slug ='".$slug."'
														";
            
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
					$okmsg = base64_encode("Yatch Added Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
					exit;	  
				}else{
				      $okmsg = base64_encode("Yatch Not Added .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			} 
//---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='edityatchcategory' && $_POST['request_page']=='yatchcategorymanagement'){
	    $yatch_category_name = addslashes(trim($_POST['yatch_category_name']));
		//$pm_id = $_POST['pm_id'];
	 $id=base64_decode($_POST['id']);
		
		
		//$_SESSION['id']=$id;
		//$_SESSION['yatch_category_name']= $property_category_name;
			$slug=slugcreation($yatch_category_name);
			
			if($yatch_category_name == ''){
				$errmsg = base64_encode('Please Enter Yatch Category Name');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".$_POST['id']);
				exit;
			}else{
					 $sql_category= "UPDATE ".$tblprefix."yatch_category 
														SET
														yatch_category_name = '".$yatch_category_name."',
														
														yatch_category_slug ='".$slug."'
														WHERE
														id=".$id;
														
														

					
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
						$okmsg = base64_encode("Yatch Category Updated successfully!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else{
					      
						$okmsg = base64_encode("Yatch Category Is Not Updated!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit; 
					}
			} 
	
	} 	
######################
#
# 	GET SECTION
#
######################
//---------Delete THe Property Category ---------
if($_GET['mode']=='del_category' && $_GET['act']=='yatchcategory' && $_GET['request_page']=='yatchcategorymanagement'){
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."yatch_category WHERE id = ".$id;
		$rs_del = $db->Execute($del_qry);					
		
		$okmsg = base64_encode("Yatch Category Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=yatchcategory");
					exit;	  
} 

?>