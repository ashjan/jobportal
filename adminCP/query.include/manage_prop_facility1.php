<?php
	
if($_POST['mode']=='del' && $_POST['act']=='manage_facility1' && $_POST['request_page']=='manage_prop_facility1'){
$post=$_POST;

if($_SESSION[SESSNAME]['pm_moduleid']==2)
{
$pr_id = $post['pr_id'];
}else {
$pr_id = base64_decode($post['pr_id']);
}

$pm_id = base64_decode($_POST['pm_id']);

      
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
					header("Location: admin.php?errmsg=$okmsg&pr_id=".base64_encode($pr_id)."&pm_id=".base64_encode($pm_id)."&act=".$_POST['act']);
					exit;			
			
			}
			}else{
			
			$okmsg = base64_encode("Cijena nije izbrisana .!");
					header("Location: admin.php?errmsg=$okmsg&pr_id=".base64_encode($pr_id)."&pm_id=".base64_encode($pm_id)."&act=".$_POST['act']);
					exit;			
			
			}
}
	


?>	