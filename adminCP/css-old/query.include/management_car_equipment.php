<?php


######################
#
# 	POST SECTION
#
######################
//---------Add property Feature---------

	if($_POST['mode']=='add' && $_POST['act']=='manage_car_equipment' && $_POST['request_page']=='management_car_equipment'){
        $equipment_name = addslashes(trim($_POST['equipment_name']));
		$agency  = addslashes(trim($_POST['agency']));
		$supplier_id  = addslashes(trim($_POST['supplier_id']));
		$car_id = addslashes(trim($_POST['car_id']));
		$pm_id = addslashes(trim($_POST['pm_id']));
		
		
		if($pm_id == '' or $pm_id == 0){
				$errmsg = base64_encode('Please Select PM');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
		if($agency == '' or $agency == 0){
				$errmsg = base64_encode('Please Select Car Agency');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
		if($supplier_id == '' or $supplier_id == 0){
				$errmsg = base64_encode('Please Select Car Supplier');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($car_id == '' or $car_id == 0){
				$errmsg = base64_encode('Please Select Car Type');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}


		//$_SESSION['add_sees'] = $_POST;
			
		/*		
			if($equipment_name == ''){
		s		$errmsg = base64_encode('Please Enter Equipment Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}*/
			
			if(count($_POST['equipments']) > 1)
				{
					$equipments = implode(",",$_POST['equipments']);
				}
					elseif(count($_POST['equipments']) == 1)
				{
					$equipments = $_POST['equipments'];
				}
				else
				{
					$equipments = "";
				}


			$qry_already_event= "SELECT ".$tblprefix."car_equipment.id 
				FROM
				".$tblprefix."car_equipment where car_id='".$car_id."' ";  
			
				$rs_already_event=$db->Execute($qry_already_event);
				$count_add =  $rs_already_event->RecordCount();
			
				if($count_add > 0){
				$errmsg = base64_encode('This Car Type Equipments already exist.');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
				}



 				$insert_car_equipment = "INSERT INTO ".$tblprefix."car_equipment  
										SET
										pm_id = '".$pm_id."',
										agency = '".$agency."',
										car_id = '".$car_id."',
										equipments = '".$equipments."',
										supplier_id = '".$supplier_id."'";
										
		 
				$rs_insert = $db->Execute($insert_car_equipment);
				unset($_SESSION['add_sees']);
				$okmsg = base64_encode("Car Equipment Add successfully. !");
				header("Location: admin.php?okmsg=$okmsg&act=manage_car_equipment");
				exit;
				
	} 



//---------Update Equiipment---------

	 
	 if($_POST['mode']=='update' && $_POST['act']=='edit_car_equipment' && $_POST['request_page']=='management_car_equipment'){
		$agency  = addslashes(trim($_POST['agency']));
		$equipment_name = addslashes(trim($_POST['equipment_name']));
		$supplier_id  = addslashes(trim($_POST['supplier_id']));
 		$car_id = addslashes(trim($_POST['car_id']));  
		$_SESSION['add_sees'] = $_POST;
		$id = base64_decode($_POST['id']);
		$pm_id = addslashes(trim($_POST['pm_id'])); 
		/*if($equipment_name == ''){
			$errmsg = base64_encode('Please Enter Car Equipment');
			header("Location: admin.php?act=edit_car_equipment&id=".$_POST['id']."&errmsg=$errmsg");
			exit;
		}*/
		
		
		if(count($_POST['equipments']) > 1)
				{
					$equipments = implode(",",$_POST['equipments']);
				}
					elseif(count($_POST['equipments']) == 1)
				{
					$equipments = $_POST['equipments'];
				}
				else
				{
					$equipments = "";
				}
		
		
		
		if($pm_id == '' or $pm_id == 0){
				$errmsg = base64_encode('Please Select PM');
				header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
				exit;
			}
			
		if($agency == '' or $agency == 0){
				$errmsg = base64_encode('Please Select Car Agency');
				header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
				exit;
			}
		if($supplier_id == '' or $supplier_id == 0){
				$errmsg = base64_encode('Please Select Car Supplier');
				header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
				exit;
			}
			
			if($car_id == '' or $car_id == 0){
				$errmsg = base64_encode('Please Select Car Type');
				header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
				exit;
			}
		
	 echo	$sql_update = "UPDATE ".$tblprefix."car_equipment SET 
												 pm_id = '".$pm_id."', 
												 agency = '".$agency."',
												 supplier_id = '".$supplier_id."',
												 equipments = '".$equipments."',
												 car_id = '".$car_id."'
		         								 WHERE id=".$id; 
			
		$rs = $db->Execute($sql_update);
		
		
		if($rs){
		 $okmsg = base64_encode("Car Equipment Updated successfully. !");
		 header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act2']);
		exit;	  
	       }/* END: if($rs){ */
	
	   }
//.............Delet Equipment.........


if($_GET['mode']=='del_equipment' && $_GET['act']=='manage_car_equipment' && $_GET['request_page']=='management_car_equipment'){
		$id=base64_decode($_GET['id']);
		
 

		  $del_qry = " DELETE FROM ".$tblprefix."car_equipment WHERE id = ".$id." ";
		
		
		$rs_del = $db->Execute($del_qry);				
				
		
		
		$okmsg = base64_encode("Cars Equipment Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_car_equipment");
					exit;	  
} 


	   
?>