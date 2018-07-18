<?php	
if($_POST['mode']=='add' && $_POST['act']=='manage_car_commission' && $_POST['request_page']=='car_commision_management'){
$_SESSION["addpcommision"] = $_POST;
$post=$_POST;
$error='';
$first_name = $_POST['first_name'];
$agency_id = $_POST['agency_id'];
//$property_name = $_POST['property_id'];


if($post['commission']==''){
	$error="commission not inserted<br>";
}

if($post['first_name']==''|| $post['first_name']==0){
	$error="Please Select Project Manager<br>";
}

if($agency_id==''|| $first_name==0){
	$error="Please Select Agency Name<br>";
}

if($post['from_date']==''){
	$error="Please Select Starting Date<br>";
}

if($post['to_date']==''){
	$error="Please Select Ending Date<br>";
}


if($post['commission'] < 0 || $post['commission'] > 100){
	$error="Commission can’t be less than  0% or greater than 100% <br>";
}


$qry_comm = "SELECT * FROM ".$tblprefix."cardef_commission  LIMIT 1 ";
$rs_comm = $db->Execute($qry_comm);
$count_add =  $rs_comm->RecordCount();
$totalRows = $count_add;

$default_commission=$rs_comm->fields['default_commission_rate'];

/*echo $default_commission."<br>";
echo $post['commission'];
exit;*/


if($post['commission'] < $default_commission){
	$error="Commission can’t be Less than ".$default_commission."%  <br>";
}


  $to_date= strtotime($post['to_date']);
  $from_date= strtotime($post['from_date']);
  
  
  
if($to_date<$from_date){
	$error="Commission Starting Date can not exceed ending date <br>";
}


if($error!=''){
			
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
			exit;
			
			}else{

          $check_duplicate = "SELECT id FROM ".$tblprefix."car_commission WHERE pm_id='".$first_name."' AND pt_id='".$property_name."' 
                  AND from_date='".date("Y-m-d",strtotime($post['from_date']))."' AND to_date='".date("Y-m-d",strtotime($post['to_date']))."'";
                  
                  $rs_query = $db->Execute($check_duplicate);
                  $rs_total=$rs_query->RecordCount();
                  if($rs_total>0){
                  	
                  	$error = base64_encode("Commission for this property has already been entered");
                  	header("Location: admin.php?errmsg=$error&act=".$post['act']);
                  	exit;
                  }else{
				 
	
	                       $update_img_query = "INSERT ".$tblprefix."car_commission 
									                                SET
																	pm_id = '".$first_name."',
																	pt_id = '".$agency_id."',
																	from_date ='".date("Y-m-d",strtotime($post['from_date']))."', 
																	to_date = '".date("Y-m-d",strtotime($post['to_date']))."',
																	commission = '".$post['commission']."',
																	status = '1'";
							
							
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$id= mysql_insert_id();
								$okmsg = base64_encode("Commision inserted successfully!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$errmsg = base64_encode("Unable to add Commision in database!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							
							}
							
							}
	}
}
//Update Section

if($_POST['mode']=='update' && $_POST['act']=='edit_car_commision' && $_POST['request_page']=='car_commision_management'){
$post=$_POST;

$error='';
 $first_name = addslashes(trim($_POST['first_name'])); 
 $agency_id = addslashes(trim($_POST['agency_id']));
 $id=base64_decode($post['id']); 






if($post['commission']==''){
	$error="commission not inserted<br>";

}

if($post['first_name']==''|| $post['first_name']==0){
	$error="Please Select Project Manager<br>";
}

if($agency_id==''|| $agency_id==0){
	$error="Please Select Agency Name<br>";
}

if($post['from_date']==''){
	$error="Please Select Starting Date<br>";
}

if($post['to_date']==''){
	$error="Please Select Ending Date<br>";
}

if($post['commission'] < 0 || $post['commission'] > 100){
	$error="Commission can’t be less than  0% or greater than 100% <br>";
}


  $to_date= strtotime($post['to_date']); 
  $from_date= strtotime($post['from_date']);
  
  
  
if($to_date<$from_date){
	$error="Commission starting date can not exceed ending date <br>";
}


if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".base64_encode($id));
			exit;
			}else{
			
$qry_comm = "SELECT * FROM ".$tblprefix."cardef_commission  LIMIT 1 ";
$rs_comm = $db->Execute($qry_comm);
$count_add =  $rs_comm->RecordCount();
$totalRows = $count_add;
$default_commission=$rs_comm->fields['default_commission_rate'];


	if($post['commission'] < $default_commission)
	{
		$error="Commission can’t be Less than ".$default_commission."%  <br>";
	}


	if($error!='')
	{
		$msg=base64_encode($error);
		header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".$post['id']);
		exit;
	}
	$check_duplicate = "SELECT id FROM ".$tblprefix."car_commission WHERE pm_id=".$first_name." AND pt_id=".$agency_id." 
                  AND from_date='".date("Y-m-d",strtotime($post['from_date']))."' AND to_date='".date("Y-m-d",strtotime($post['to_date']))."'
                  AND id!=".$id."
                  "; 
	//echo $check_duplicate;
                  $rs_query = $db->Execute($check_duplicate);
                  $rs_total=$rs_query->RecordCount();
                  
                  if($rs_total>0){
                  $msg=base64_encode("Commission already entered");
		          header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".$post['id']);
		          exit;     	
                  }else {
					 	 $update_img_query = "UPDATE ".$tblprefix."car_commission 
							SET
							pm_id = ".$first_name.",
							pt_id = ".$agency_id.",
							from_date ='".date("Y-m-d",strtotime($post['from_date']))."', 
							to_date = '".date("Y-m-d",strtotime($post['to_date']))."',
							commission = '".$post['commission']."' 
							WHERE id =".$id;  
						
											
							$run_query = $db->Execute($update_img_query);
							
							if($run_query){
								$okmsg = base64_encode("Commission Updated successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
								exit;
							}else{
								$okmsg = base64_encode("Unable to Update in database.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($id));
								exit;
							}
							
							
		}					
	}
}


######################
#
# 	GET SECTION
#
######################

if($_GET['mode']=='updatestatus' && isset($_GET['status'])){

		$oldstatus = $_GET['status'];
		$id=base64_decode($_GET['id']);
		$act=$_GET['act'];
				
		if($oldstatus == '0'){
			$newstatus = 1;
		}else{
			$newstatus = 0;
				}
			$update_qry = "UPDATE ".$tblprefix."car_commission SET 
														   status = '".$newstatus."' WHERE id = '".$id."'";
				$update_rs = $db->Execute($update_qry);
				
				if($update_rs){
				   $okmsg = base64_encode('Status updated successfully.');
					header("Location: admin.php?act=$act&okmsg=$okmsg");
					exit;
				
				}//end if($update_rs)
				exit;
		
		}/*END: if($_GET['mode']=='updatenewsletterstatus' && isset($_GET['status'])) */

	
	   
######################
#
# 	GET SECTION
#
######################


// Delete Function

if($_GET['mode']=='delete' && $_GET['act']=='manage_car_commission' && $_GET['request_page']=='car_commision_management')
{
$id=base64_decode($_GET['id']); 
	
	
	$sel_qry = "SELECT commission FROM ".$tblprefix."car_commission WHERE id =".$id;
		$rs_select = $db->Execute($sel_qry);
		$del_qry = " DELETE FROM ".$tblprefix."car_commission WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		
		if($rs_delete)
		{
				$okmsg = base64_encode("Commision Deleted successfully. !");
				header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
				exit;			
		}
		else
		{
				$okmsg = base64_encode("Cijena nije izbrisana!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
				exit;			
		}
		
 }
			
			
?>