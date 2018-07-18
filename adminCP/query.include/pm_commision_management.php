<?php	
if($_POST['mode']=='add' && $_POST['act']=='manage_pm_commission' && $_POST['request_page']=='pm_commision_management'){
$_SESSION["addpcommision"] = $_POST;
$post=$_POST;
$error='';
$first_name = $_POST['first_name'];
$property_name = $_POST['property_name'];
//$property_name = $_POST['property_id'];

if($post['commission']==''){
	//$error="commission not inserted<br>";
	$error="Molimo unesite proviziju<br>";
}

if($post['first_name']==''|| $post['first_name']==0){
	//$error="Please Select Project Manager<br>";
	$error="Molimo izaberite vlasnika objekta<br>";
}



if($post['from_date']==''){
	//$error="Please Select Starting Date<br>";
	$error="Molimo izaberite pocetni datum<br>";
}

if($post['to_date']==''){
	//$error="Please Select Ending Date<br>";
	$error="Please Select Ending Date<br>";
}

if($post['commission'] < 0 || $post['commission'] > 100){
	//$error="Commission can’t be less than  0% or greater than 100% <br>";
	$error="Provizija mora biti veca od 0% i manja od 100%<br>";
}


$qry_comm = "SELECT * FROM ".$tblprefix."default_commission  LIMIT 1 ";
$rs_comm = $db->Execute($qry_comm);
$count_add =  $rs_comm->RecordCount();
$totalRows = $count_add;

$default_commission=$rs_comm->fields['default_commission_rate'];

/*echo $default_commission."<br>";
echo $post['commission'];
exit;*/


if($post['commission'] < $default_commission){
	//$error="Commission can’t be Less than ".$default_commission."%  <br>";
	$error="Provizija ne može biti manja od ".$default_commission."%  <br>";
}


  $to_date= strtotime($post['to_date']);
  $from_date= strtotime($post['from_date']);
  
  
  
if($to_date<$from_date){
	//$error="Commission starting date can not exceed ending date <br>";
	$error="Pocetni datum provizije ne može biti veci od krajnjeg datuma<br>";
}


if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']);
			exit;
}else{
                  
		$post_from_date=date("Y-m-d",strtotime($post['from_date']));
		$post_to_date=date("Y-m-d",strtotime($post['to_date']));
  $check_duplicate = "SELECT id FROM ".$tblprefix."users_commission WHERE pm_id=".$first_name." AND pt_id=".$property_name." AND ((from_date='".$post_from_date."' AND to_date='".$post_to_date."')  
 OR
 (from_date>'".$post_from_date."' AND to_date<'".$post_to_date."')
 OR
 (from_date>'".$post_from_date."' AND from_date<'".$post_to_date."' AND to_date>'".$post_to_date."')
 OR
 (from_date<'".$post_from_date."' AND to_date>'".$post_from_date."' AND  to_date<'".$post_to_date."')
 OR
 (
 from_date <= '".$post_from_date."' AND to_date >= '".$post_to_date."'
 )       
)";


                  echo $check_duplicate;
                  $rs_query = $db->Execute($check_duplicate);
                  $rs_total=$rs_query->RecordCount();
                  
				  if($rs_total>0){
                  	//$error = base64_encode("Commission for this property has already been entered <br>
					$error = base64_encode("Proviija za ovaj objekat je vec unijeta<br>
					OR may be the commission rate is repeated for some dates .");
                  	header("Location: admin.php?errmsg=$error&act=".$post['act']);
                  	exit;
                  }else {
	              $update_img_query = "INSERT ".$tblprefix."users_commission 
									                                SET
																	pm_id = ".$first_name.",
																	pt_id = ".$property_name.",
																	from_date ='".date("Y-m-d",strtotime($post['from_date']))."', 
																	to_date = '".date("Y-m-d",strtotime($post['to_date']))."',
																	commission = ".$post['commission'].",
																	status = 1";
							 
							
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$id= mysql_insert_id();
								//$okmsg = base64_encode("Commision inserted successfully!");
								$okmsg = base64_encode("Provizija uspješno dodata!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']."&id=".base64_encode($id));
								exit;
							}else{
								//$errmsg = base64_encode("Unable to add Commision in database!");
								$errmsg = base64_encode("Provizija nije dodata!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							
							}
							
							}
	}
}
//Update Section

if($_POST['mode']=='update' && $_POST['act']=='edit_pm_commision' && $_POST['request_page']=='pm_commision_management'){
$post=$_POST;

$error='';
$first_name = addslashes(trim($_POST['first_name']));
if(isset($_POST['property_id'])){
$property_name = addslashes(trim($_POST['property_id']));
}else {
$property_name = addslashes(trim($_POST['property_name']));	
}
$id=base64_decode($post['id']);






if($post['commission']==''){
	//$error="commission not inserted<br>";
	$error="Molimo unesite proviziju<br>";

}

if($post['first_name']==''|| $post['first_name']==0){
	//$error="Please Select Project Manager<br>";
	$error="Molimo izaberite vlasnika objekta<br>";
}


if($post['from_date']==''){
	//$error="Please Select Starting Date<br>";
	$error="Molimo izaberite pocetni datum<br>";
}

if($post['to_date']==''){
	$error="Please Select Ending Date<br>";
}

if($post['commission'] < 0 || $post['commission'] > 100){
	//$error="Commission can't be less than  0% or greater than 100% <br>";
	$error="Provizija mora biti veca od 0% i manja od 100%<br>";
}


  $to_date= strtotime($post['to_date']);
  $from_date= strtotime($post['from_date']);
  
  
  
if($to_date<$from_date){
	//$error="Commission starting date can not exceed ending date <br>";
	$error="Pocetni datum provizije ne može biti veci od krajnjeg datuma<br>";
}


if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".base64_encode($id));
			exit;
			}else{
			
$qry_comm = "SELECT * FROM ".$tblprefix."default_commission  LIMIT 1 ";
$rs_comm = $db->Execute($qry_comm);
$count_add =  $rs_comm->RecordCount();
$totalRows = $count_add;
$default_commission=$rs_comm->fields['default_commission_rate'];


	if($post['commission'] < $default_commission)
	{
		//$error="Commission can’t be Less than ".$default_commission."%  <br>";
		$error="Provizija ne može biti manja od ".$default_commission."%  <br>";
	}


	if($error!='')
	{
		$msg=base64_encode($error);
		header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".$post['id']);
		exit;
	}
	$check_duplicate = "SELECT id FROM ".$tblprefix."users_commission WHERE pm_id=".$first_name." AND pt_id=".$property_name." 
                  AND from_date='".date("Y-m-d",strtotime($post['from_date']))."' AND to_date='".date("Y-m-d",strtotime($post['to_date']))."'
                  AND id!=".$id."
                  ";

                  $rs_query = $db->Execute($check_duplicate);
                  $rs_total=$rs_query->RecordCount();
                  
                  if($rs_total>0){
                  //$msg=base64_encode("Commission already entered"); 
				  $msg=base64_encode("Proviija je vec ušao");
		          header("Location: admin.php?okmsg=$msg&act=".$post['act']."&id=".$post['id']);
		          exit;     	
                  }else {
						 $update_img_query = "UPDATE ".$tblprefix."users_commission 
							SET
							pm_id = ".$first_name.",
							pt_id = ".$property_name.",
							from_date ='".date("Y-m-d",strtotime($post['from_date']))."', 
							to_date = '".date("Y-m-d",strtotime($post['to_date']))."',
							commission = '".$post['commission']."' 
							WHERE id =".$id;
						
											
							$run_query = $db->Execute($update_img_query);
							
							if($run_query){
								//$okmsg = base64_encode("Commission Updated successfully.!");
								$okmsg = base64_encode("Provizija uspješno ažurirana.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
								exit;
							}else{
								//$okmsg = base64_encode("Unable to Update in database.!");
								$okmsg = base64_encode("Sadržaj nije ažuriran.!");
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
			$update_qry = "UPDATE ".$tblprefix."users_commission SET 
														   status = '".$newstatus."' WHERE id = '".$id."'";
				$update_rs = $db->Execute($update_qry);
				
				if($update_rs){
				   //$okmsg = base64_encode('Status updated successfully.');
				   $okmsg = base64_encode('Status uspješno ažuriran.');
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

if($_GET['mode']=='delete' && $_GET['act']=='manage_pm_commission' && $_GET['request_page']=='pm_commision_management')
{
$id=base64_decode($_GET['id']); 
	
	
	$sel_qry = "SELECT commission FROM ".$tblprefix."users_commission WHERE id =".$id;
		$rs_select = $db->Execute($sel_qry);
		$del_qry = " DELETE FROM ".$tblprefix."users_commission WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		
		if($rs_delete)
		{
				//$okmsg = base64_encode("Commision Deleted successfully. !");
				$okmsg = base64_encode("Provitzija uspješno izbrisana. !");
				header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
				exit;			
		}
		else
		{
				//$okmsg = base64_encode("Unable to Delete!");
				$okmsg = base64_encode("Cijena nije izbrisana!");
				header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
				exit;			
		}
		
 }
			
			
?>