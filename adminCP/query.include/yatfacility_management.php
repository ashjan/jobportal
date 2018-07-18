<?php	
if($_POST['mode']=='add' && $_POST['act']=='manageyacht_facility' && $_POST['request_page']=='yatfacility_management')
{
$_SESSION["addfacility"] = $_POST;
$post=$_POST;
$error='';


if($post['fac_id']==0){
	$error="Facility Name required<br>";
}
if($post['fac_cat_id']==0){
  $error="You forgot to select Category!<br>";
}

if($post['agency_id']==0){
  $error="You forgot to select Agency!<br>";
}
if($post['supplier_id']==0){
  $error="You forgot to select Supplier!<br>";
}
if($post['yatch_id']==0){
  $error="You forgot to select Yacht!<br>";
}

if($post['first_name']==0){
  $error="You forgot to select PM!<br>";
}
if(!isset($post['fac_id'])){
	$error="Facilities must be selected!<br>";
}

if($post['fac_id'][0]==0){
	$error="Facilities must be selected!<br>";
}

if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
						
				   $add_flag=0;
					foreach($post['fac_id'] as $key=>$value){
					 
				     $update_img_query = "INSERT ".$tblprefix."yacht_facility SET
														yatch_id = ".$post['yatch_id'].",
														pm_id = ".$post['first_name'].",
														fac_id = '".$value."',
														facility_type =".$post['fac_cat_id'].",
														supplierid =".$post['supplier_id'].",
														agency_id =".$post['agency_id'].",
														yacht_facility_status='1'"
														;
												
														
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$add_flag=1;
							}else{
								$add_flag=0;
							}
					}
					
							if($add_flag==1){
								$okmsg = base64_encode("Facility inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}elseif($add_flag==0){
								$okmsg = base64_encode("Unable to add Facility in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
						

	}
} 

//Update Section

if($_POST['mode']=='update' && $_POST['act']=='manage_facility' && $_POST['request_page']=='facility_management'){
$post=$_POST;
$error='';
if($post['facility_name']==''){
	$error="Facility  Name required<br>";
}
if($post['property_fac_category']==''){
	$error="Facility  category required<br>";
}
if($post['property_status']==''){
	$error="Facility  status required<br>";
}


if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=editfacility&");
}else{




$facility_name = addslashes(trim($_POST['facility_name']));
		$id=base64_decode($_POST['id']);
		$encryptedid=$_POST['id'];
		$property_fac_category = addslashes(trim($_POST['property_fac_category']));
		$pm_id = addslashes(trim($_POST['pm_id']));

		$_SESSION['p_id']=$id;
		//$_SESSION['editpropty']
		$_SESSION['facility_name']= $facility_name; 
		$_SESSION['property_fac_category']=$property_fac_category;
		$_SESSION['pm_id']=$pm_id;
		
		
		


						$update_img_query = "UPDATE ".$tblprefix."property_facilities SET
														pm_id = '".$post['pm_id']."',
														facility_name = '".$post['facility_name']."',
														property_fac_category = '".$post['property_fac_category']."',
														property_status = '".$post['property_status']."'
														WHERE id=".base64_decode($_POST['id'])
														;
												
												
							$run_query = $db->Execute($update_img_query);
							
							if($run_query){
								$okmsg = base64_encode("Facility Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}else{
								$okmsg = base64_encode("Unable to Update in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
								exit;
							}
						
			$update_img_query = "UPDATE ".$tblprefix."property_facilities SET
														facility_name = '".$post['facility_name']."'
														WHERE id=".$_POST['id']
														;
			$run_query = $db->Execute($update_img_query);
			if($run_query){
			$okmsg = base64_encode("Facility Updated successfully.!");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($_POST['id']));
			exit;
			}else{
								$errmsg = base64_encode("Unable to Update in database.!");
								header("Location: admin.php?errmsg=$errmsg&act=editfacility&id=encryptedid");
								exit;
							}						
//}
	}
} 






	   
######################
#
# 	GET SECTION
#
######################


// Delete Function

if($_GET['mode']=='delete' && $_GET['act']=='manage_facility' && $_GET['request_page']=='facility_management'){
	$id=base64_decode($_GET['id']);
		
		$del_qry = " DELETE FROM ".$tblprefix."property_facilities WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
		$okmsg = base64_encode("Sadržaj uspješno izbrisan. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}else{
		$okmsg = base64_encode("Unable to Delete.!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}
} 	

	
if($_POST['mode']=='del' && $_POST['act']=='manageyacht_facility' && $_POST['request_page']=='yatfacility_management')
{
	$post=$_POST;
			if (isset($post['activities'])){
			$flag=FALSE;
			foreach($post['activities'] as $key=>$activity)
			{
			$del_qry = " DELETE FROM ".$tblprefix."yacht_facility WHERE id =".$activity;
			
			$rs_delete = $db->Execute($del_qry);	
			if($rs_delete){	
			$flag=TRUE;
			}
			}
			
			
			if($flag){
					   $okmsg = base64_encode("Sadržaj uspješno izbrisan. !");
					   header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					   exit;			
			}
			else{
			$okmsg = base64_encode("Unable to Delete .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;			
			
			}
			}
}
	
	?>