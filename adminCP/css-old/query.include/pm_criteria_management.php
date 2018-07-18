<?php

/**********************************************************************
*		add PM Creteria
*
***********************************************************************/

if($_POST['mode']=='add' && $_POST['act']=='manage_pm_criteria' && $_POST['request_page']=='pm_criteria_management'){
	
	$property_id = $_POST['property_id']; 
	$first_name = $_POST['first_name'];
	$review = $_POST['review[]'];

	if($property_id == '' or $property_id == 0){
				$error	.= base64_encode('Please Enter Property Name<br>');
				
			}
			
	if($first_name == '' or $first_name == 0){
				$error	.= base64_encode('Please Enter PM Name<br>');
				
			}
			
			
	/*if($review == ''){
				$errmsg = base64_encode('Please Check The Review Checks');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}*/



	$review = $_POST['review'];
	
		$count = count($review);
		if(in_array(0,$review)){
			$data = 0;
		}else {
			$count_new=$count-1;
			for($i=0; $i<$count; $i++){
				if($count_new > $i){
					$data.= $review[$i].", ";
				}else{
					$data.=$review[$i];
				}
			}
		}


if($data == '' || $data==0){
				$error .= base64_encode('Please Check The Review Checks');
				
			}
if($error!=''){
header("Location: admin.php?act=".$_POST['act']."&errmsg=$error");
exit;
}

 $qry_already_event= "SELECT ".$tblprefix."pm_property_criteria.id 
					FROM
					".$tblprefix."pm_property_criteria where property_id='".$property_id."' or  pm_id='".$pm_id."' ";
				 
				$rs_already_event=$db->Execute($qry_already_event);
					$count_add =  $rs_already_event->RecordCount();
				
					if($count_add > 0){
					$errmsg = base64_encode('This Service already exist.');
					header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
					exit;
	 				}


	$insert_review = "INSERT INTO ".$tblprefix."pm_property_criteria
										SET
										property_id = ".$property_id.",
										pm_id = ".$first_name.",
										criteria_id ='".$data."'
										";

 	

	$rs_review = $db->Execute($insert_review);
	


	if($insert_review){
		$okmsg = base64_encode("PM Review Add successfully.!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit;
	}else{
		$errmsg.= base64_encode("Unable to Add PM Review!");
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
		exit;

	}
}




/**********************************************************************
*		Update PM Creteria
*
***********************************************************************/

if($_POST['mode']=='update' && $_POST['act']=='manage_pm_criteria' && $_POST['request_page']=='pm_criteria_management')
{

$post=$_POST;

$error='';

    $property_id = $_POST['property_id']; 
	$pm_id = $_POST['pm_id'];
	$review = $_POST['criteria'];

	if($property_id == ''){
				$errmsg = base64_encode('Please Select  Property Name');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
	if($pm_id == ''){
				$errmsg = base64_encode('Please Select PM Name');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	if($review==''){
		        $errmsg = base64_encode('Please Select Criteria');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
	}
			
	$count = count($review);
		if(in_array(0,$review)){
			$data = 0;
		}else {
			$count_new=$count-1;
			for($i=0; $i<$count; $i++){
				if($count_new > $i){
					$data.= $review[$i].", ";
				}else{
					$data.=$review[$i];
				}
			}
		}
		$id = base64_decode($_POST['id']);
		
	
	$update_img_query = "UPDATE ".$tblprefix."pm_property_criteria
										SET
										criteria_id ='".$data."'
										WHERE id = ".$id ;
							$run_query = $db->Execute($update_img_query);
							
	

								$okmsg = base64_encode("Pm Property Criteria Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							
	}else{
		$errmsg.= base64_encode("Unable to Update PM Review!");
		header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
		exit;

	}
	
	
/**********************************************************************
*		 delete PM Creteria
*
***********************************************************************/	
	
if($_POST['mode']=='del' && $_POST['act']=='manage_pm_criteria' && $_POST['request_page']=='pm_criteria_management'){
$post=$_POST;
			if (isset($post['activities'])){
			$flag=FALSE;
			foreach($post['activities'] as $key=>$activity)
			{
			$del_qry = " DELETE FROM ".$tblprefix."pm_property_criteria WHERE id =".$activity;
			
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