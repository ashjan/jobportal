<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Property Manager---------
	
	if($_POST['mode']=='add' && $_POST['act']=='manage_landmarks' && $_POST['request_page']=='landmarks_management'){
	
	/*echo 'successful';
	exit();*/
	
		$_SESSION['add_sees'] = $_POST;
		
		$region_id       = addslashes(trim($_POST['region_id']));
		$landmark_name   = addslashes(trim($_POST['landmark_name']));
		$landmark_type   = addslashes(trim($_POST['landmark_type']));
		$landmark_lat    = addslashes(trim($_POST['landmark_lat']));
		$landmark_long   = addslashes(trim($_POST['landmark_long']));
		$landmark_status = addslashes(trim($_POST['landmark_status']));
		
		
		if($region_id == '0'){
				$errmsg = base64_encode('Please Select Region');
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
				exit;
		}
		
		if($landmark_name == ''){
				$errmsg = base64_encode('Please Enter Landmark  Name');
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
				exit;
		}
		
		if($landmark_type == '0'){
				$errmsg = base64_encode('Please Select Landmark Type');
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
				exit;
		}
		
		if($landmark_lat == ''){
				$errmsg = base64_encode('Please Enter Landmark Latitude');
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
				exit;
		}
		
		if($landmark_long == ''){
				$errmsg = base64_encode('Please Enter Landmark Longtitude');
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
				exit;
		}
		
				$qry_landmark_exist= "SELECT
							".$tblprefix."landmarks.id 
							FROM
							".$tblprefix."landmarks where landmark_name ='".$landmark_name."' ";
				$rs_landmark_exist=$db->Execute($qry_landmark_exist);
				$count_rec =  $rs_landmark_exist->RecordCount();
				if($count_rec > 0){
					$errmsg = base64_encode('This Landmark Recorod already exist. Try another one');
					header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
					exit;
				}	
				$sql_property= "INSERT INTO ".$tblprefix."landmarks 
														SET 
														 region_id       = '".$region_id."',
														 landmark_name   = '".$landmark_name ."',
														 landmark_type   = ".$landmark_type.",
														 landmark_lat    = '".$landmark_lat."',
														 landmark_long   = '".$landmark_long."',
														 landmark_status = '".$landmark_status."'"; 
				$rs_ins_menu = $db->Execute($sql_property);
				if($rs_ins_menu){
					$okmsg = base64_encode("Landmarks Record Added successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				} 
				
				
			 
	} 
//---------Edit Property Managers---------
	if($_POST['mode']=='update' && $_POST['act']=='edit_landmarks' && $_POST['request_page']=='landmarks_management'){
		
		$region_id = addslashes(trim($_POST['region_id']));
		$landmark_name = addslashes(trim($_POST['landmark_name']));
		$landmark_type = addslashes(trim($_POST['landmark_type']));
		$landmark_lat = addslashes(trim($_POST['landmark_lat']));
		$landmark_long = addslashes(trim($_POST['landmark_long']));
		$landmark_status = addslashes(trim($_POST['landmark_status']));
				$id=base64_decode($_POST['id']);
		
				
		/*$_SESSION['first_name']= $first_name;
		$_SESSION['last_name']= $last_name; 
		$_SESSION['email_address']=$email_address;
		$_SESSION['business_email']=$business_email;
		
		$_SESSION['town']= $town;
		$_SESSION['phone_number']= $phone_number;
		$_SESSION['id']= $id;*/
		
		$_SESSION['add_sees'] = $_POST;
	
		if($region_id == '0'){
				$errmsg = base64_encode('Please Select Region');
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
				exit;
		}
		
		if($landmark_name == ''){
				$errmsg = base64_encode('Please Enter Landmark  Name');
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
				exit;
		}
		
		if($landmark_type == '0'){
				$errmsg = base64_encode('Please Select Landmark Type');
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
				exit;
		}
		
		if($landmark_lat == ''){
				$errmsg = base64_encode('Please Enter Landmark Latitude');
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
				exit;
		}
		
		if($landmark_long == ''){
				$errmsg = base64_encode('Please Enter Landmark Longtitude');
				header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
				exit;
		}
		
		
	 	 $sql_update= "UPDATE ".$tblprefix."landmarks  SET	
														region_id = '".$region_id."', 
														landmark_name = '".$landmark_name."', 
														landmark_type ='".$landmark_type."', 														
														landmark_lat ='".$landmark_lat."',
														landmark_long ='".$landmark_long."',
														landmark_status ='".$landmark_status."'																												                                                        WHERE
														id=".$id;
													 
														
		$rs_update = $db->Execute($sql_update);
		    if($rs_update){
			$okmsg = base64_encode(" Manager Record updated successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
			exit;	  
				}
				
			else{
			$errmsg = base64_encode(" Property Manager Record not updated!");
			header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
			exit;	  	
				
			} 
			
			} 

	   
######################
#
# 	GET SECTION
#
######################

//---------Delete Service Provider---------
if($_GET['mode']=='delete' && $_GET['act']=='manage_landmarks' && $_GET['request_page']=='landmarks_management'){
		
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."landmarks WHERE id = '".$id."' ";
		
		$rs_newsletter = $db->Execute($del_qry);				
		$okmsg = base64_encode("Record successfully deleted. !");
					header("Location: admin.php?errmsg=$okmsg&act=".$_GET['act']);
					exit;	  
} 


//---------Status Code---------		
if($_GET['mode']=='change_default' && $_GET['act']=='manage_landmarks' && $_GET['request_page']=='landmarks_management'){

		$id=base64_decode($_GET['id']);
        $status=$_GET['landmark_status'];
		if($status == 1){
		$newstatus = 0;
		}elseif( $status == 0){
		$newstatus = 1;
		}
		
		$update_qry = " UPDATE ".$tblprefix."landmarks SET
		                                                  landmark_status = '".$newstatus."'
														  WHERE id          = '".$id."' ";
														  
		$rs_newsletter = $db->Execute($update_qry);				
		
		if($rs_newsletter){
						$okmsg = base64_encode("Status updated successfully. !");
						header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
						exit;	  
				}
		  
 }
?>