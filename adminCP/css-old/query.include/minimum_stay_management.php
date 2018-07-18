<?php
if($_POST['mode']=='add' && $_POST['act']=='manage_minimu_stay' && $_POST['request_page']=='minimum_stay_management'){

	$post=$_POST;
	$error='';
	$rate_type = $_POST['rate_type'];
	$night_stay = $_POST['night_stay'];



	$pm_id = $_POST['pm_id'];
	$property_id = $_POST['property_id'];
	$room_id = $_POST['room_id'];
	
	$repeated_flag=FALSE;
	if($room_id==0){
		$qry_check = "SELECT id FROM ".$tblprefix."property_minimum_stay
                       WHERE 
		               property_id = ".$_POST['property_id']."
					   AND  
					   pm_id = ".$_POST['pm_id'];
		
		$rs_query = $db->Execute($qry_check);
		
		while(!$rs_query->EOF){
		
			$update_query = "UPDATE ".$tblprefix."property_minimum_stay
																	   SET 
																		rate_type = ".$rate_type.",
																		night_stay = ".$night_stay.",
																		property_id = ".$_POST['property_id'].",
																		pm_id = ".$_POST['pm_id']."  
															            WHERE id=".$rs_query->fields['id'];
			$db->Execute($update_query);

			$rs_query->MoveNext();

		}
	}else {
		$qry_check_repeated = "SELECT * FROM ".$tblprefix."property_minimum_stay
                       WHERE 
		               room_id = ".$room_id."
					   AND  
					   property_id = ".$_POST['property_id']."
					   AND  
					   pm_id = ".$_POST['pm_id']." AND rate_type=".$rate_type." AND night_stay=".$night_stay."";
		$run_query = $db->Execute($qry_check_repeated);
		$rs_total=$run_query->RecordCount();

		if($rs_total){
			$repeated_flag=TRUE;
			//$okmsg = base64_encode("Minimum stay data already exists for this property!");
			$okmsg = base64_encode("Minimalan broj noćenja već postoji za ovaj objekat!");
			header("Location: admin.php?errmsg=$okmsg&act=manage_minimu_stay&id=".base64_encode($id)."&pm_id=".base64_encode($pm_id)."&property_id=".base64_encode($property_id)."&room_id=".$room_id);
			exit;
		}else{
			$repeated_flag=FALSE;
		}
	
	}

	if($post['pm_id']==0){
		//$error="Please select property manager<br>";
		$error="Molimo izaberite vlasnika objekta<br>";
	}
	if($post['property_id']==0){
		//$error="Please select property name<br>";
		$error="Molimo izaberite objekat<br>";
	}

	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=".$post['act']);
	}else{
		if($room_id==0){
			
			$qry_checks = "SELECT id,room_id FROM ".$tblprefix."property_minimum_stay
                       WHERE 
		               property_id = ".$_POST['property_id']."
					   AND  
					   pm_id = ".$_POST['pm_id'];
            
			$rs_checks = $db->Execute($qry_checks);
            
			$select_query = "SELECT id FROM ".$tblprefix."rooms WHERE property_id=".$_POST['property_id']." AND pm_id=".$_POST['pm_id'];
			$rs_select = $db->Execute($select_query);
			
			$added_id = array();
			$rs_select->MoveFirst();
			while(!$rs_select->EOF){
				$rs_checks->MoveFirst();
				while (!$rs_checks->EOF){
					$added_id[] = $rs_checks->fields['room_id'];
					$rs_checks->MoveNext();
				}
				
				if(!in_array($rs_select->fields['id'],$added_id)){
				$update_img_query = "INSERT ".$tblprefix."property_minimum_stay
									                                SET
																	room_id = ".$rs_select->fields['id'].",
																	rate_type = ".$rate_type.",
																	night_stay = ".$night_stay.",
																	property_id = ".$_POST['property_id'].",

																	pm_id = ".$_POST['pm_id']."";

                
				$run_query = $db->Execute($update_img_query);
				$rs_select->MoveNext();

			} 
			
			}
			//$okmsg = base64_encode("Successfully added Minimum Stay in database.!");
			$okmsg = base64_encode("Minimalan broj noćenja uspješno dodat.!");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
			exit();
			
	}else {
			if($repeated_flag==FALSE){
				$update_img_query = "INSERT ".$tblprefix."property_minimum_stay
									                                SET
																	room_id = ".$room_id.",
																	rate_type = ".$rate_type.",
																	night_stay = ".$night_stay.",
																	property_id = ".$_POST['property_id'].",
														            pm_id = ".$_POST['pm_id'];


				$run_query = $db->Execute($update_img_query);
				if($run_query){
					//$okmsg = base64_encode("Minimum Stay inserted successfully.!");
					$okmsg = base64_encode("Minimalan broj noćenja uspješno dodat.!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				}else{
					//$errmsg = base64_encode("Unable to add Minimum Stay in database.!");
					$errmsg = base64_encode("Minimalan broj noćenja nije dodat.!");
					header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
					exit;
				}
			}else{
				$errmsg = base64_encode("Minimalan broj noćenja nije dodat.!");
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
				exit;
			}
		}
	}
}


//////////////////////////////////
/////Update Section //////////////
//////////////////////////////////

if($_POST['mode']=='update' && $_POST['act']=='manage_minimu_stay' && $_POST['request_page']=='minimum_stay_management'){
	//$post=$_POST;
	$error='';
	
	$id = base64_decode($_POST['id']);
	$pm_id = $_POST['pm_id'];
	$property_id = $_POST['property_id'];
	$room_id = $_POST['room_id'];
	
	$repeated_flag=FALSE;
	$qry_check_repeated = "SELECT * FROM ".$tblprefix."property_minimum_stay
                       WHERE
					   id <>".$id." 
					   AND 
					   (
					   room_id = ".$room_id."
					   AND  
					   property_id = ".$_POST['property_id']."
					   AND  
					   pm_id = ".$_POST['pm_id']."  
					   ) AND rate_type=".$_POST['rate_type']." AND night_stay=".$_POST['night_stay']."
					";
	
	
	$run_query = $db->Execute($qry_check_repeated);
	$rs_total=$run_query->RecordCount();
	if($rs_total){
		$repeated_flag=TRUE;
		//$errmsg = base64_encode("Minimum stay data already exists for this property!");
		$errmsg = base64_encode("Minimalan broj noćenja već postoji za ovaj objekat!");
		header("Location: admin.php?okmsg=$errmsg&act=edit_minimum_stay&id=".base64_encode($_POST['id']));	
		exit;
	}else{
		$repeated_flag=FALSE;
	}
	$rate_type = addslashes(trim($_POST['rate_type']));
	$night_stay = addslashes(trim($_POST['night_stay']));

	if($pm_id==0){
		//$error="Please select property manager<br>";
		$error="Molimo izaberite vlasnika objekta<br>";
	}

	if($property_id==0){
		//$error="Please select property name<br>";
		$error="Molimo izaberite objekat<br>";
	}
	if($error!=''){
		$msg=base64_encode($error);
		header("Location: admin.php?errmsg=$msg&act=edit_minimum_stay&id=".$_POST['id']);
	}else{
		if($repeated_flag==FALSE){
			$update_img_query = "UPDATE ".$tblprefix."property_minimum_stay
																	   SET 
																		room_id = ".$room_id.",
																		rate_type = ".$rate_type.",
																		night_stay = ".$night_stay.",
																		property_id = ".$_POST['property_id'].",
																		pm_id = ".$_POST['pm_id']."  
															WHERE id=".base64_decode($_POST['id']);
			$run_query = $db->Execute($update_img_query);
			if($run_query){
				//$okmsg = base64_encode("Minimum Stay Updated successfully!");
				$okmsg = base64_encode("Minimalan broj noćenja	uspješno ažuriran!");
				header("Location: admin.php?okmsg=$okmsg&act=manage_minimu_stay&id=".base64_encode($_POST['id']));	
				exit;
			}else{
				//$okmsg = base64_encode("Unable to Update in database!");
				$okmsg = base64_encode("Sadržaj nije ažuriran!");
				header("Location: admin.php?errmsg=$okmsg&act=edit_minimum_stay&id=".base64_encode($_POST['id']));
				exit;
			}
		}
		else{

			//$okmsg = base64_encode("Unable to Update in database!");
			$okmsg = base64_encode("Sadržaj nije ažuriran!");
			header("Location: admin.php?errmsg=$okmsg &act=edit_minimum_stay&id=".base64_encode($id)."&amp;pm_id=".base64_encode($pm_id)."&amp;property_id=".base64_encode($property_id)."&amp;room_id=".base64_encode($room_id));
			//header("Location: admin.php?errmsg=$okmsg&act=edit_minimum_stay&id=".base64_encode($_POST['id']));
			exit;

		}
	}
}

######################
# 	GET SECTION
######################

// Delete Function
if($_GET['mode']=='delete' && $_GET['act']=='manage_minimu_stay' && $_GET['request_page']=='minimum_stay_management'){
	$id=base64_decode($_GET['id']);
	$del_qry = " DELETE FROM ".$tblprefix."property_minimum_stay WHERE id =".$id;
	$rs_delete = $db->Execute($del_qry);
	if($rs_delete){
		//$okmsg = base64_encode("Minimum Stay Deleted successfully!");
		$okmsg = base64_encode("Minimalan broj noćenja uspješno izbrisan!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;
	}else{
		//$okmsg = base64_encode("Unable to Delete!");
		$okmsg = base64_encode("Cijena nije izbrisana!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;
	}
}
	?>