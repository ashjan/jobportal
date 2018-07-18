<?php
// ADD Function	
if($_POST['mode']=='add' && $_POST['act']=='discount_management' && $_POST['request_page']=='manage_discount_management'){
$_SESSION["sessdiscount"] = $_POST;
$post=$_POST;


if($post['discount_percentage']==NULL  or $post['discount_percentage']==''){
	$post['discount_percentage']=0; 
}				 

if($post['lastminute_discount_rate']==NULL  or $post['lastminute_discount_rate']==''){
	$post['lastminute_discount_rate']=0; 
}


if($post['lmin_lastminuteoffer']==0){
  $post['lastminute_threshold']=0;
  $post['lastminute_discount_rate']=0;
}


if($post['threshold_last_minute1']==NULL  or $post['threshold_last_minute1']==''){
	$post['threshold_last_minute1']=0; 
}


if($post['lmin_discount_percentage1']==NULL  or $post['lmin_discount_percentage1']==''){
	$post['lmin_discount_percentage1']=0; 
}

 
 

if($post['early_booking']==0){
		$early_threshold =0;
		$early_discount = 0;
		$early_refund = 0;
	 }else {
		$early_threshold =$post['threshold'];
		$early_discount = $post['discount_percentage'];
		$early_refund = $post['refundable'];
	 }
	 if($post['lmin_lastminuteoffer']==0){
		
		$last_threshold = 0;
		$last_discount = 0;
		$last_refund = 0;
	 }else {
		$last_threshold = $post['lastminute_threshold'];
		$last_discount = $post['lastminute_discount_rate'];
		$last_refund = $post['lmin_refundable'];
	 }
	 if($post['long_stay']==0){
		
		$long_threshold = 0;
		$long_discount = 0;
		$long_refund = 0;
	 }else {
		$long_threshold = $post['threshold_last_minute1'];
		$long_discount = $post['lmin_discount_percentage1'];
		$long_refund = $post['lmin_refundable1'];
	 }
	 
$error='';
if($post['early_booking']=='1' or $post['lmin_lastminuteoffer'] == '1' or $post['long_stay']=='1' or $post['property_name']!='0' or $post['pm_id']!='0')
{
if($post['early_booking']=='1')
{
	if($post['threshold']==''){
		 //$error.="Early booking threshold Required!!<br>";	
		 $error.="Potrebno je unijeti uslov za Ranu rezervaciju!<br>";	
	}
	if($post['discount_percentage']==''){
		//$error.="Early booking Discount percentage Required!!<br>";
		$error.="Potrebno je unijeti procenat popusta za Ranu rezervaciju!<br>";
	} 
}

if($post['lmin_lastminuteoffer']=='1')
{
	if($post['lastminute_threshold']=='')
	{
		 //$error.="Last minute threshold Required!!<br>";	
		 $error.="Potrebno je unijeti uslov za Last minute popust!<br>";
	}
	if($post['lastminute_discount_rate']=='')
	{
		//$error.="Last minute Discount percentage Required!!<br>";
		$error.=" Potrebno je unijeti procenat popusta za Last minute!<br>";
	}
 
}
if($post['long_stay']=='1')
{
	if($post['threshold_last_minute1']=='')
	{
		 //$error.="Early booking threshold Required!!<br>";	
		  $error.="Potrebno je unijeti uslov za Ranu rezervaciju!<br>";	
	}
	if($post['lmin_discount_percentage1']=='')
	{
		//$error.="Early booking Discount percentage Required!!<br>";
		$error.="Potrebno je unijeti procenat popusta za Ranu rezervaciju !<br>";
	}
 
}

if($post['early_booking']=='1' or $post['lastmintoffer'] == '1' or $post['long_stay']=='1')
{
	if($post['pm_id']=='0')
	{
		//$error.="Select Property Manager!<br>";
		$error.="izaberite vlasnika objekta!<br>";
	}
	if($post['property_name']=='0')
	{
		//$error.="Select Property Name!<br>";
		$error.="izaberite objekat!<br>";
	}
}

if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?errmsg=$msg&act=".$post['act']);
			exit();
}
					$qry_already_event= "SELECT ".$tblprefix."rooms.discount_percentage 
					FROM
					".$tblprefix."rooms WHERE discount_percentage <> 0 AND id=".$post['room_type'].""; 
					
				  
					$rs_already_event=$db->Execute($qry_already_event);
					$count_add =  $rs_already_event->RecordCount();
				
					if($count_add > 0){
					//$errmsg = base64_encode('Discount already exist.');
					$errmsg = base64_encode('Popust već postoji.');
					header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
					exit;
	 				}
		           
				    if($post['lastminute_discount_rate']==NULL  or $post['lastminute_discount_rate']==''){
					$post['lastminute_discount_rate']=0; 
					}
				    
					if($post['threshold_last_minute1']==NULL  or $post['threshold_last_minute1']==''){
					$post['threshold_last_minute1']=0; 
					}
					
					
					if($post['lmin_discount_percentage1']==NULL  or $post['lmin_discount_percentage1']==''){
					$post['lmin_discount_percentage1']=0; 
					}
							
				   	$update_img_query = "UPDATE ".$tblprefix."rooms SET 
												early_booking = ".$post['early_booking'].",
												threshold = ".$post['threshold'].",
												discount_percentage =".$post['discount_percentage'].",
												refundable =".$post['refundable'].",
												lmin_lastminuteoffer =".$post['lmin_lastminuteoffer'].",
												lastminute_threshold =".$post['lastminute_threshold'].",
												lastminute_discount_rate =".$post['lastminute_discount_rate'].",
												lmin_refundable =".$post['lmin_refundable'].",
												long_stay =".$post['long_stay'].",
												threshold_last_minute1 =".$post['threshold_last_minute1'].",
												lmin_discount_percentage1 =".$post['lmin_discount_percentage1'].",
												lmin_refundable1 =".$post['lmin_refundable1']." 
												WHERE id= ".$post['room_type']." AND pm_id=".$post['pm_id']."
												AND property_id= ".$post['property_name']."";  
		//										echo	   	$update_img_query; die;
		
		$run_query = $db->Execute($update_img_query);
				
			if($run_query){
				//$okmsg = base64_encode("Discount Inserted Successfully.!");
				$okmsg = base64_encode("Popust uspješno dodat.!");
				header("Location: admin.php?okmsg=$okmsg&act=discount_management&id=".base64_encode($_POST['id']));
				exit;
			}else{
					
					$update_img_query = "INSERT ".$tblprefix."rooms SET 
																early_booking = '".$post['early_booking']."',
																threshold ='".$post['threshold']."',
																discount_percentage ='".$post['discount_percentage']."',
																refundable ='".$post['refundable']."',
																lmin_lastminuteoffer ='".$post['lmin_lastminuteoffer']."',
																lastminute_threshold ='".$post['lastminute_threshold']."',
																lastminute_discount_rate ='".$post['lastminute_discount_rate']."',
																lmin_refundable ='".$post['lmin_refundable']."',
																long_stay ='".$post['long_stay']."',
																threshold_last_minute1 ='".$post['threshold_last_minute1']."',
																lmin_discount_percentage1 ='".$post['lmin_discount_percentage1']."',
																lmin_refundable1 ='".$post['lmin_refundable1']."' 
																"; 
					$run_query = $db->Execute($update_img_query);
								
							if($run_query){
								//$okmsg = base64_encode("Discount Record inserted successfully.!");
								$okmsg = base64_encode("Podaci o popustu uspješno dodati.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								//$okmsg = base64_encode("Unable to add Discount Record in database.!");
								$okmsg = base64_encode("Podaci o popustu nisu dodati.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
	
	}
}
else
{
	//$okmsg = base64_encode("Nothing is specified to insert in database!");
	$okmsg = base64_encode("Podaci nisu unijeti!");
	header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
	exit;
}	
	
} 
//Update Section
if($_POST['mode']=='update' && $_POST['act']=='edit_discount' && $_POST['request_page']=='manage_discount_management'){
$post=$_POST;
$error='';
                 
	             if($post['discount_percentage']==NULL  or $post['discount_percentage']==''){
					$post['discount_percentage']=0; 
					}
				 				 
				 
				 if($post['lastminute_discount_rate']==NULL  or $post['lastminute_discount_rate']==''){
					$post['lastminute_discount_rate']=0; 
					}
				    
				if($post['threshold_last_minute1']==NULL  or $post['threshold_last_minute1']==''){
					$post['threshold_last_minute1']=0; 
					}
					
					
				if($post['lmin_discount_percentage1']==NULL  or $post['lmin_discount_percentage1']==''){
					$post['lmin_discount_percentage1']=0; 
					}


$_SESSION[lmin_lastminuteoffer]=$post['lmin_lastminuteoffer'];
$_SESSION[pm_id]=$post['pm_id'];
$_SESSION[property_name]=$post['property_name'];
$_SESSION[early_booking]=$post['early_booking'];
$_SESSION[room_type]=$post['room_type'];
$_SESSION[threshold]=$post['threshold'];
$_SESSION[discount_percentage]=$post['discount_percentage'];
$_SESSION[refundable]=$post['refundable'];
$_SESSION[long_stay] =$post['long_stay'];
$_SESSION[discount_long_stay]=$post['discount_long_stay'];
$_SESSION[elmin_lastminuteoffer]=$post['elmin_lastminuteoffer'];
$_SESSION[lastminute_threshold]=$post['lastminute_threshold'];
$_SESSION[lastminute_discount_rate]=$post['lastminute_discount_rate'];
$_SESSION[threshold_last_minute]=$post['threshold_last_minute'];
$_SESSION[lmin_discount_percentage]=$post['lmin_discount_percentage'];
$_SESSION[lmin_refundable]=$post['lmin_refundable'];
$_SESSION[lmin_lastminuteoffer]=$post['lmin_lastminuteoffer'];
$_SESSION[threshold_last_minute1]=$post['threshold_last_minute1'];
$_SESSION[lmin_discount_percentage1]=$post['lmin_discount_percentage1'];
$_SESSION[lmin_refundable1]=$post['lmin_refundable1'];
$_SESSION[long_stay]=$post['long_stay'];

if($post['early_booking']=='1')
{
	if($post['threshold']=='')
	{
		 //$error.="Early booking threshold Required!!<br>";	
		 $error.="Potrebno je unijeti uslov za Ranu rezervaciju!<br>";	
	}
	if($post['discount_percentage']=='')
	{
		//$error.="Early booking Discount percentage Required!!<br>";
		$error.="Potrebno je unijeti procenat popusta za Ranu rezervaciju !<br>";
	}
 
}
if($post['lastmintoffer']=='1')
{
	if($post['lastminute_threshold']=='')
	{
		 //$error.="Last minute threshold Required!!<br>";
		 $error.="Potrebno je unijeti uslov za Last minute popust!<br>";	
	}
	if($post['lastminute_discount_rate']=='')
	{
		//$error.="Last minute Discount percentage Required!!<br>";
		$error.=" Potrebno je unijeti procenat popusta za Last minute!<br>";
	}
 
}
if($post['long_stay']=='1')
{
	if($post['threshold_last_minute1']=='')
	{
		 //$error.="Early booking threshold Required!!<br>";	
		 $error.="Potrebno je unijeti uslov za Ranu rezervaciju!<br>";
	}
	if($post['lmin_discount_percentage1']=='')
	{
		//$error.="Early booking Discount percentage Required!!<br>";
		$error.="Potrebno je unijeti procenat popusta za Ranu rezervaciju !<br>";
	}
 
}
if($post['pm_id']=='0')
{
	//$error.="Select Property Manager!!<br>";
	$error.="izaberite vlasnika objekta!<br>";
}
if($post['property_name']=='0' or $post['property_name']== '')
{
	//$error.="Select Property Name!<br>";
	$error.="izaberite objekat!<br>";
}

if($post['room_type']=='0' or $post['room_type']== '')
{
	//$error.="Select Room Type!!<br>";
	$error.="Izaberite sobu Vrsta !<br>";
}


if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
}else{
					
				 /*	$qry_already_event= "SELECT ".$tblprefix."rooms.discount_percentage 
					FROM
					".$tblprefix."rooms WHERE discount_percentage <> 0 AND id = '".$post['room_type']."'"; 
				   
				$rs_already_event=$db->Execute($qry_already_event); 
					$count_add =  $rs_already_event->RecordCount(); 
				
					if($count_add > 0){
					$errmsg = base64_encode('Discount already exist.');
					header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
					exit;
	 				}
					
					*/
				 if($post['early_booking']==0){
				 	
				 	$early_threshold =0;
				 	$early_discount = 0;
				 	$early_refund = 0;
				 }else {
				 	$early_threshold =$post['threshold'];
				 	$early_discount = $post['discount_percentage'];
				 	$early_refund = $post['refundable'];
				 }
				 if($post['lmin_lastminuteoffer']==0){
				 	
				 	$last_threshold = 0;
				 	$last_discount = 0;
				 	$last_refund = 0;
				 }else {
				 	$last_threshold = $post['lastminute_threshold'];
				 	$last_discount = $post['lastminute_discount_rate'];
				 	$last_refund = $post['lmin_refundable'];
				 }
				 if($post['long_stay']==0){
				 	
				 	$long_threshold = 0;
				 	$long_discount = 0;
				 	$long_refund = 0;
				 }else {
				 	$long_threshold = $post['threshold_last_minute1'];
				 	$long_discount = $post['lmin_discount_percentage1'];
				 	$long_refund = $post['lmin_refundable1'];
				 }
					
						$update_img_query = "UPDATE ".$tblprefix."rooms SET 
														early_booking = '".$post['early_booking']."',
														threshold ='".$early_threshold."',
														discount_percentage ='".$early_discount."',
														refundable ='".$early_refund."',
														lmin_lastminuteoffer ='".$post['lmin_lastminuteoffer']."',
														lastminute_threshold ='".$last_threshold."',
														lastminute_discount_rate ='".$last_discount."',
														lmin_refundable ='".$last_refund."',
														long_stay ='".$post['long_stay']."',
														threshold_last_minute1 ='".$long_threshold."',
														lmin_discount_percentage1 ='".$long_discount."',
														lmin_refundable1 ='".$long_refund."' 
														WHERE id=".base64_decode($_POST['id']);	 
						
														
						$run_query = $db->Execute($update_img_query);
						
						if($run_query){
							//$okmsg = base64_encode("Discount Updated Successfully.!");
							$okmsg = base64_encode("Popust uspješno ažuriran!");
							header("Location: admin.php?okmsg=$okmsg&act=discount_management&id=".base64_encode($_POST['id']));
							exit;
						}else{
							//$okmsg = base64_encode("Unable to Update Discount in database.!");
							$okmsg = base64_encode("Popust nije ažuriran!");
							header("Location: admin.php?okmsg=$okmsg&act=edit_discount&id=".base64_encode($_POST['id']));
							exit;
						}
					
						
	}
} 

// Delete Function

if($_GET['mode']=='delete' && $_GET['act']=='discount_management' && $_GET['request_page']=='manage_discount_management'){
	$id=base64_decode($_GET['id']);
	$post=$_POST;
					  $sel_qry = "UPDATE ".$tblprefix."rooms SET 		
														discount_percentage = 0,
														lastminute_discount_rate = 0,
														threshold_last_minute1 = 0,
														lmin_discount_percentage1 = 0
														WHERE id=".$id;	
	 				  $rs_select = $db->Execute($sel_qry);
		if($rs_select){
		//$okmsg = base64_encode("Discount Record Deleted successfully. !");
		$okmsg = base64_encode("Podaci o popustu uspješno izbrisani!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;			
		}else{
		//$okmsg = base64_encode("Unable to Delete .!");
		$okmsg = base64_encode("Cijena nije izbrisana!");
		header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
		exit;			
		}
  
} 	
	

?>	
	
