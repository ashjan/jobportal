<?php
if($_POST['mode']=='add' && $_POST['act']=='yacht_models' && $_POST['request_page']=='yachtmodel_management')
	{        
		
	 	$modely = addslashes(trim($_POST['yatchmodel']));  
		$category = addslashes(trim($_POST['category']));
		$basey = addslashes(trim($_POST['basey']));
		$altbasey = addslashes(trim($_POST['altbasey']));
		$numy = addslashes(trim($_POST['numy']));
		$yagncy = addslashes(trim($_POST['agency_id']));
		$pmid = $_POST['first_name'];
		
		
		
		

		//$pm_id = addslashes(trim($_POST['pm_id']));	
		$slug=slugcreation($event_category_name);
		
			if($yagncy == '0'){
				$errmsg = base64_encode('Please Select Agency!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($pmid == '0'){
				$errmsg = base64_encode('Please Select PM!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			
			if($modely == ''){
				$errmsg = base64_encode('Please Enter Model!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			 if($category == '0'){
						$errmsg = base64_encode('Please Select Category!!');
						header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
						exit;
					}
	 
	 
			if($basey == ''){
				$errmsg = base64_encode('Please Enter Base!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($numy == ''){
				$errmsg = base64_encode('Please Enter Number of Yachts!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
		
	 
	 else
	 {
	 		
	 			
	 
	 
			 $sql_category= "INSERT INTO ".$tblprefix."yachtmodel  
														SET 
														pm_id= '".$pmid."',
														agncy_id = '".$yagncy."',
														categry = '".$category."',
														model = '".$modely."',
														basey = '".$basey."',
														numb_yacht = '".$numy."',
														alt_base = '".$altbasey."'
														";
           
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category)
				{
					$okmsg = base64_encode("Model Added Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
					exit;	  
				}
				else
				{
				      $okmsg = base64_encode("Model Not Added !!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
		} 
}
//---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='update_yachtmodel' && $_POST['request_page']=='yachtmodel_management'){        
		//echo 'accessed';die;
	 	$modely = addslashes(trim($_POST['yatchmodel']));  
		$category = addslashes(trim($_POST['category']));
		$basey = addslashes(trim($_POST['basey']));
		$altbasey = addslashes(trim($_POST['altbasey']));
		$numy = addslashes(trim($_POST['numy']));
		$yagncy = addslashes(trim($_POST['agency_id']));
		$pmid = $_POST['first_name'];
		$id=base64_decode($_POST['id']);
		
		$slug=slugcreation($event_category_name);
		
			if($yagncy == '0'){
				$errmsg = base64_encode('Please Select Agency!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($pmid == '0'){
				$errmsg = base64_encode('Please Select PM!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			
			if($modely == ''){
				$errmsg = base64_encode('Please Enter Model!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			 if($category == '0'){
						$errmsg = base64_encode('Please Select Category!!');
						header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
						exit;
					}
	 
	 
			if($basey == ''){
				$errmsg = base64_encode('Please Enter Base!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($numy == ''){
				$errmsg = base64_encode('Please Enter Number of Yachts!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
		
	 
	 else
	 {
	 			$sql_category= "UPDATE  ".$tblprefix."yachtmodel  
														SET
														agncy_id = '".$yagncy."',
														pm_id='".$pmid."',
														categry = '".$category."',
														model = '".$modely."',
														basey = '".$basey."',
														numb_yacht = '".$numy."',
														alt_base = '".$altbasey."'
														where id=".$id;
           
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category)
				{
					$okmsg = base64_encode("Model Updated Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
					exit;	  
				}
				else
				{
				      $okmsg = base64_encode("Model Not Updated !!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
		} } 	
######################
#
# 	GET SECTION
#
######################
//---------Delete THe Property Category ---------
if($_GET['mode']=='del_model' && $_GET['act']=='yacht_models' && $_GET['request_page']=='yachtmodel_management'){
		$id=base64_decode($_GET['id']); 
		$del_qry = " DELETE FROM ".$tblprefix."yachtmodel WHERE id = ".$id;  
		$rs_del = $db->Execute($del_qry);					
		
					if($rs_del){
					   $okmsg = base64_encode("Yacht Types Deleted successfully. !");
					   header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					   exit;			
		}
					
					
					
					  
} 

?>