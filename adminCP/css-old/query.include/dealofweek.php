<?php	
#############################
#  ADD
#############################


if($_POST['mode'] == 'add' && $_POST['act'] == 'deal_of_week' && $_POST['request_page'] == 'dealofweek'){
//$id=base64_decode($_POST['id']);


$error='';
$pm_id=$_POST['pm_id']; 
$property_id=$_POST['property_id']; 
$deals_status=$_POST['deals_status']; 
$dprice = $_POST['dprice'];
$pprice = $_POST['pprice'];


/*if($pprice < $dprice){
	$error="Discounted price is Grater than original price!!<br>";
}
*/
$today= date("m/d/Y");
$deal_end_date= $_POST['deal_end_date'];     
$todayc=strtotime($today);
/*$deal_end_datec=strtotime($deal_end_date);

if($todayc<$deal_end_datec){
	$error="The Bid End Date is less than Current Date!!<br>";
}
if($deal_end_date==NULL or $deal_end_date==""){
	$error="Please! Enter the Bid End Date !!<br>";
}*/

	
	$result = mysql_query("SELECT * FROM tbl_standard_rates WHERE pm_id='".$pm_id."' AND property_id='".$property_id."'");

while($row = mysql_fetch_array($result))
  {
    	$oldprice = $row['standard_rate_price'] ;
	   
  
  }
  	
	if($dprice >$oldprice )
	{
		$error ="Discount Price must be less then Actual Price.";
	}


if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$_POST['act']);
}else{
//$deal_end_date=date('Y-m-d H:i:s',strtotime($deal_end_date));
	 $deal_end_date = date('Y-m-d', strtotime('+6 day', strtotime($deal_end_date)));
	 $sql_update = "INSERT ".$tblprefix."offer_of_week SET	
												 pm_id ='".$pm_id."',
												 property_id  ='".$property_id."',
												 discount_price ='".$dprice."',
												 pprice='".$pprice."',
												 deals_status='".$deals_status."',
												 deal_end_date ='".$deal_end_date."'" ; 
			$rs_add = $db->Execute($sql_update);
		    if($rs_add){
			$okmsg = base64_encode("Discounted Price Added successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&disflag=1");
			exit;	  
				}else{
			$errmsg = base64_encode("Discounted Price not added. !");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
			exit;	  	
			} 
 }
}


#############################
#  UPDATE
#############################

if($_POST['mode'] == 'update' && $_POST['act'] == 'editdeal_of_week' && $_POST['request_page'] == 'dealofweek'){
$id=base64_decode($_POST['id']);
$msg='';
/*if($_POST['pprice']<$_POST['dprice']){
	$error="Discounted price must be less than original price!!<br>";
}*/


if($dprice >$oldprice )
	{
		$error ="Discount Price must be less then Actual Price.";
	}


$pm_id=$_POST['pm_id'];
$property_id=$_POST['property_id'];
$deals_status=$_POST['deals_status'];
$dprice = $_POST['dprice'];
//$pprice = $_POST['pprice'];


$today= date("m/d/Y");

$deal_end_date= $_POST['deal_end_date'];     

$todayc=strtotime($today);
$deal_end_datec=strtotime($deal_end_date);

/*if($todayc<$deal_end_datec){
	$msg="The Bid End Date is less than Current Date!!<br>";
}*/

//if($dprice>$pprice && $dprice != ""){
	 //$msg="The Discount price should be less than property prices !!<br>";
	//$error="Discount Price must be less the actual price. !!<br>";
//}

if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$_POST['act']);
			exit();
}else{
/*$deal_end_date=date('Y-m-d H:i:s',strtotime($deal_end_date));

$sql_update = "UPDATE ".$tblprefix."offer_of_week SET	
												 discount_price ='".$_POST['dprice']."',
												 deal_end_date ='".$deal_end_date."'
												 WHERE
												 id=".$id; */
											
				$deal_end_date = date('Y-m-d', strtotime('+6 day', strtotime($deal_end_date)));
								  $sql_update = "UPDATE ".$tblprefix."offer_of_week SET	
												 discount_price ='".$dprice."',
												 deal_end_date ='".$deal_end_date."'
												 WHERE
												 id=".$id; 	
												 						
																
			$rs_update = $db->Execute($sql_update);
		    if($rs_update){
			$okmsg = base64_encode("Discounted Price Updated successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']."&disflag=1");
			exit;	  
				}else{
			$errmsg = base64_encode("Discounted Price not updated. !");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act2']);
			exit;	  	
			} 
 }
}
	
	
#############################
#  Delete Function
#############################

// Delete Function

if($_GET['mode']=='deloffr' && $_GET['act']=='deal_of_week' && $_GET['request_page']=='dealofweek'){
	$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."offer_of_week WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){
		$okmsg = base64_encode("Deal of Week deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}else{
		$okmsg = base64_encode("Cijena nije izbrisana .!");
					header("Currency: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		}
  
} 

	
	
//---------Change  Default Language Status---------
	if($_GET['mode']=='change_pmstatus' && $_GET['act']=='deal_of_week' && $_GET['request_page']=='dealofweek'){
	
	// First disable the default language status of all the languages  

	$id=base64_decode($_GET['id']);
	$status = $_GET['m_status'];
	
	
	if($status == 1){
		$newstatus = 0;
		}elseif( $status == 0){
		$newstatus = 1;
		}
		
	 
	$qry_offer_of_week1= "UPDATE ".$tblprefix."offer_of_week  
					SET 
					".$tblprefix."offer_of_week.deals_status=0";
		
    $rs_offer_of_week1=$db->Execute($qry_offer_of_week1);
	
	
	 
	$qry_offer_of_week= "UPDATE ".$tblprefix."offer_of_week  
					SET ".$tblprefix."offer_of_week.deals_status=".$newstatus." WHERE  
													    ".$tblprefix."offer_of_week.id=".$id;"";
		
    $rs_offer_of_week=$db->Execute($qry_offer_of_week);
	$total_offer_of_week =  $rs_offer_of_week->RecordCount();
	
	// Now activate the status of the currently selected default language 			
	/*$sql_offer_of_week= "UPDATE ".$tblprefix."offer_of_week 
														SET 
														".$tblprefix."offer_of_week.deals_status=".$status." 
														WHERE  
													    ".$tblprefix."offer_of_week.id=".$id;
				$rs_offer_of_week = $db->Execute($sql_offer_of_week);*/
				
				if($rs_offer_of_week){
					$okmsg = base64_encode("Deal of Week updated successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=deal_of_week&pageNum=".$_GET['pageNum']);
					exit;	  
				}
	}// END if($_POST['mode']=='change_default' && $_POST['act']=='manage_language' 


?>