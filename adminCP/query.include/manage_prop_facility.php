<?php
if($_POST['mode']=='update_general' && $_POST['act']=='manage_facility' && $_POST['request_page']=='manage_prop_facility')
{

$post=$_POST;

$error='';

foreach ($_POST as $key => $value) 
{
    $idd1 = explode("_", $key);
	$idd = $idd1[3];
	if($idd !== '' )
	{
	
	$update_img_query = "UPDATE ".$tblprefix."property_facilities  
						                                SET
														property_status = '".$value."'
														WHERE id = ".$idd." and property_fac_category='1'";
							$run_query = $db->Execute($update_img_query);
							
	}
}
								$okmsg = base64_encode("Status Changed successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							
	}
	
	
if($_POST['mode']=='del' && $_POST['act']=='manage_facility' && $_POST['request_page']=='manage_prop_facility'){
$pr_id = base64_decode($_POST['pr_id']);
$pm_id = base64_decode($_POST['pm_id']);
$post=$_POST;
			if (isset($post['activities'])){
			$flag=FALSE;
			foreach($post['activities'] as $key=>$activity)
			{
			$del_qry = " DELETE FROM ".$tblprefix."property_facilities WHERE id =".$activity;
			
			$rs_delete = $db->Execute($del_qry);	
			if($rs_delete){	
			$flag=TRUE;
			}
			}
			
			
			if($flag){
					   $okmsg = base64_encode("Sadržaj uspješno izbrisan. !");
					   header("Location: admin.php?okmsg=$okmsg&pr_id=".base64_encode($pr_id)."&pm_id=".base64_encode($pm_id)."&act=".$_POST['act']);
					   exit;			
			}
			else{
			$okmsg = base64_encode("Cijena nije izbrisana .!");
					header("Location: admin.php?okmsg=$okmsg&pr_id=".base64_encode($pr_id)."&pm_id=".base64_encode($pm_id)."&act=".$_POST['act']);
					exit;			
			
			}
			}else{
				$okmsg = base64_encode("Cijena nije izbrisana .!");
					header("Location: admin.php?okmsg=$okmsg&pr_id=".base64_encode($pr_id)."&pm_id=".base64_encode($pm_id)."&act=".$_POST['act']);
					exit;
			
			}
}
	


?>	