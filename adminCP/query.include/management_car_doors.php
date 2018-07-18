<?php


######################
#
# 	POST SECTION
#
######################
//---------Add property Feature---------

	if($_POST['mode']=='add' && $_POST['act']=='manage_car_doors' && $_POST['request_page']=='management_car_doors'){
        $equipment_name = addslashes(trim($_POST['equipment_name']));
		$supplier_id  = addslashes(trim($_POST['supplier_id']));
		$car_id = addslashes(trim($_POST['car_id']));
				
			if($equipment_name == ''){
				$errmsg = base64_encode('Please Enter No of Doors/Passengers');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			
			
			
		 $insert_car_equipment = "INSERT INTO ".$tblprefix."car_doors  
										SET
										car_id = '".$car_id."',
										supplier_id = '".$supplier_id."',
										number_doors = '".$equipment_name."'";
										
				
				$rs_insert = $db->Execute($insert_car_equipment);
				
				$okmsg = base64_encode("Car Doors/passengers Add successfully. !");
				header("Location: admin.php?okmsg=$okmsg&act=manage_car_doors");
				exit;
				
	} 



//---------Update Equiipment---------
	   
	 if($_POST['mode'] == 'update' && $_POST['act'] == 'manage_car_doors' && $_POST['request_page']=='management_car_doors'){
	 	$id = base64_decode($_POST['id']);
		$equipment_name = addslashes(trim($_POST['equipment_name']));
		$supplier_id  = addslashes(trim($_POST['supplier_id']));
		$car_id = addslashes(trim($_POST['car_id']));
		
		
		if($equipment_name == ''){
			$errmsg = base64_encode('Please Enter No of Doors/Passengers');
			header("Location: admin.php?act=edit_car_equipment&id=".$_POST['id']."&errmsg=$errmsg");
			exit;
		}
		
		
	 $sql_update = "UPDATE ".$tblprefix."car_doors 
													SET 
													car_id = '".$car_id."',
													supplier_id = '".$supplier_id."',
													number_doors = '".$equipment_name."'
													WHERE id=".$id;
													
													
		$rs = $db->Execute($sql_update);
		
		
		if($rs){
		 $okmsg = base64_encode("Car Doors/passengers Updated successfully. !");
		 header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
		exit;	  
	       }
	
	   }
//.............Delet Equipment.........


if($_GET['mode']=='del_doors' && $_GET['act']=='manage_car_doors' && $_GET['request_page']=='management_car_doors'){

		$id=base64_decode($_GET['id']);
		
 

		  $del_qry = " DELETE FROM ".$tblprefix."car_doors WHERE id = ".$id." ";
		
		
		$rs_del = $db->Execute($del_qry);				
				
		
		
		$okmsg = base64_encode("Cars Doors/passengers Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_car_doors");
					exit;	  
} 


	   
?>