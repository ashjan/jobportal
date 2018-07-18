<?php
if($_POST['mode']=='add' && $_POST['act']=='manage_car_rates' && $_POST['request_page']=='car_rates_management'){


$pm_id = addslashes(trim($_POST['pm_id']));
$agency = addslashes(trim($_POST['agency']));
$supplier_id = addslashes(trim($_POST['supplier_id']));
$car_id = addslashes(trim($_POST['car_id']));
$number_cars = addslashes(trim($_POST['number_cars']));
$starting_days = addslashes(trim($_POST['starting_days']));
$ending_days = addslashes(trim($_POST['ending_days']));
$days_extra = addslashes(trim($_POST['days_extra']));
$per_month = addslashes(trim($_POST['per_month']));
$car_rate = addslashes(trim($_POST['car_rate']));




		if($pm_id == '' or $pm_id==0){
				$errmsg = base64_encode('Please Select PM');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}
		

		
		if($car_id == '' or $car_id==0){
				$errmsg = base64_encode('Please Select Car Type');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}


if($agency == '' or $agency==0){
				$errmsg = base64_encode('Please Select Agency');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}
		
if($supplier_id == '' or $supplier_id==0){
				$errmsg = base64_encode('Please Select Supplier');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}

if($number_cars == '' or !is_numeric($number_cars)){
				$errmsg = base64_encode('Please enter Number Of Cars  With Numeric Value');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}
		
if($starting_days == ''){
				$errmsg = base64_encode('Please Select Starting Date');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}
/*if($starting_days <1 or $starting_days >31){
				$errmsg = base64_encode('Please enter Starting Days  Between 1 to 31');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}*/	
		
if($ending_days == ''){
				$errmsg = base64_encode('Please Select Ending Date');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}	
		
/*		
if($ending_days <1 or $ending_days >31){
				$errmsg = base64_encode('Please enter Ending Days  Between 1 to 31');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}
		*/
		
if($days_extra == /*'' or*/ !is_numeric($days_extra)){
				$errmsg = base64_encode('Please enter Days Extra  With Numeric Value');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}
		
		
if($per_month == /*'' or */!is_numeric($per_month)){
				$errmsg = base64_encode('Please enter Per Month  With Numeric Value');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}	
		
		if($car_rate == '' or !is_numeric($car_rate)){
				$errmsg = base64_encode('Please enter Car Rate  With Numeric Value');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}	
		
		
		
 	$sql_car= "INSERT INTO ".$tblprefix."car_rates 
														SET
														 pm_id = ".$pm_id.",
														 supplier = ".$supplier_id.",
														 agency = ".$agency.",
														 car_id = ".$car_id.",
														 number_cars  = ".$number_cars .",
														 starting_days ='".$starting_days."',
														 ending_days ='".$ending_days."',
														 days_extra =".$days_extra.",
														 per_month = ".$per_month.",
														 car_rate = ".$car_rate."
														 "; 
														
				$rs_ins_car = $db->Execute($sql_car);
				if($rs_ins_car){
					$okmsg = base64_encode("Car Record Added successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				}else{
				
					$errmsg = base64_encode("Car Record Not Added successfully. !");
					header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
					exit;	
				}
			
				
		
		
		
		
		
				
			
					

}


//////////////////////////////////
/////Update Section              /////////////////////////
//////////////////////////////////
if($_POST['mode']=='update' && $_POST['act']=='edit_car_rates' && $_POST['request_page']=='car_rates_management'){



$id = base64_decode($_POST['id']);


$pm_id = addslashes(trim($_POST['pm_id']));
$agency = addslashes(trim($_POST['agency']));
$supplier_id = addslashes(trim($_POST['supplier_id']));
$car_id = addslashes(trim($_POST['car_id']));  
$number_cars = addslashes(trim($_POST['number_cars']));
$starting_days = addslashes(trim($_POST['starting_days']));
$ending_days = addslashes(trim($_POST['ending_days']));
$days_extra = addslashes(trim($_POST['days_extra']));
$per_month = addslashes(trim($_POST['per_month']));
$car_rate = addslashes(trim($_POST['car_rate']));




if($pm_id == '' or $pm_id==0){
				$errmsg = base64_encode('Please Select PM Name');
				header("Location: admin.php?act=edit_car_rates&errmsg=".$errmsg."&id=".base64_encode($id)."");
				exit;
		}
		



if($agency == '' or $agency==0){
				$errmsg = base64_encode('Please Select Car Agency');
				header("Location: admin.php?act=edit_car_rates&errmsg=".$errmsg."&id=".base64_encode($id)."");
				exit;
		}
		
		
if($supplier_id == '' or $supplier_id==0){
				$errmsg = base64_encode('Please Select Supplier');
				header("Location: admin.php?act=edit_car_rates&errmsg=".$errmsg."&id=".base64_encode($id)."");
				exit;
		}
			
		 
		if($car_id == '' or $car_id==0){
				$errmsg = base64_encode('Please Select Car Type');
				header("Location: admin.php?act=edit_car_rates&errmsg=".$errmsg."&id=".base64_encode($id)."");
				exit;
		}
		



if($number_cars == '' or !is_numeric($number_cars)){
				$errmsg = base64_encode('Please enter Number Of Cars  With Numeric Value');
				header("Location: admin.php?act=edit_car_rates&errmsg=".$errmsg."&id=".base64_encode($id)."");
				exit;
		}
		
		
if($starting_days == ''){
				$errmsg = base64_encode('Please Select Starting Date');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=".$errmsg."&id=".base64_encode($id)."");
				exit;
		}
/*if($starting_days <1 or $starting_days >31){
				$errmsg = base64_encode('Please enter Starting Days  Between 1 to 31');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}*/	
		
if($ending_days == ''){
				$errmsg = base64_encode('Please Select Ending Date');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=".$errmsg."&id=".base64_encode($id)."");
				exit;
		}	
		
/*		
if($ending_days <1 or $ending_days >31){
				$errmsg = base64_encode('Please enter Ending Days  Between 1 to 31');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}
		*/
		
if($days_extra == ''){
				$errmsg = base64_encode('Please enter Days Extra  With Numeric Value');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=".$errmsg."&id=".base64_encode($id)."");
				exit;
		}
		
		
if($per_month == !is_numeric($per_month)){
				$errmsg = base64_encode('Please enter Per Month  With Numeric Value');
				header("Location: admin.php?act=".$_POST['act']."&errmsg==".$errmsg."&id=".base64_encode($id)."");
				exit;
		}
		
	
		
		  $sql_car= "UPDATE ".$tblprefix."car_rates 
													SET 
													 pm_id = '".$pm_id."',
													 agency = '".$agency."',
													 supplier = '".$supplier_id."',
													 car_id = '".$car_id."',
													 number_cars  = '".$number_cars ."',
													 starting_days ='".$starting_days."',
													 ending_days ='".$ending_days."',
													 days_extra ='".$days_extra."',
													 per_month = '".$per_month."',
													 car_rate = '".$car_rate."'
													 WHERE id=".$id; 
														  
				$rs_upd_car = $db->Execute($sql_car);
				if($rs_upd_car){
					$okmsg = base64_encode("Car Record Updated successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
					exit;	  
				}else{
				
					$errmsg = base64_encode("Car Record Not Updated successfully. !");
					header("Location: admin.php?act=edit_car_rates&errmsg=".$errmsg."&id=".base64_encode($id)."");
					exit;	
				}


}

######################
# 	GET SECTION
######################

// Delete Function
if($_GET['mode']=='delete' && $_GET['act']=='manage_car_rates' && $_GET['request_page']=='car_rates_management'){
	$id=base64_decode($_GET['id']);
	$del_qry = " DELETE FROM ".$tblprefix."car_rates WHERE id =".$id;
	$rs_delete = $db->Execute($del_qry);
	if($rs_delete){
		$okmsg = base64_encode("Car Rate  Deleted successfully!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;
	}else{
		$okmsg = base64_encode("Cijena nije izbrisana!");
		header("Location: admin.php?act=".$_GET['act']."&errmsg=".$errmsg."&id=".base64_encode($id)."");
		exit;
	}
}
	?>