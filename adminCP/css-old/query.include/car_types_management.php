<?php
if($_POST['mode']=='add' && $_POST['act']=='car_types' && $_POST['request_page']=='car_types_management')
	{    
	    
		$car_agency = addslashes(trim($_POST['car_agency'])); 
	 	$car_types = addslashes(trim($_POST['car_types']));  
		$category = addslashes(trim($_POST['category']));
		$produced = addslashes(trim($_POST['produced']));
		$doors = addslashes(trim($_POST['doors']));
		$passengers = addslashes(trim($_POST['passengers']));
		
		

		//$pm_id = addslashes(trim($_POST['pm_id']));	
		$slug=slugcreation($event_category_name);
		
			/*if($car_agency == ''){
				$errmsg = base64_encode('Please Enter Car Type');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}*/
			
			
			if($car_types == ''){
				$errmsg = base64_encode('Please Enter Car Type');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			 if($category == ''){
						$errmsg = base64_encode('Please Select Car Category Type');
						header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
						exit;
					}
	 
	 
			if($produced == ''){
				$errmsg = base64_encode('Please Enter Cars produced');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($doors == ''){
				$errmsg = base64_encode('Please Enter Car Doors');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
			if($passengers == ''){
				$errmsg = base64_encode('Please Enter Numbers of Passengers');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
	 
				 	$qry_already_event= "SELECT ".$tblprefix."car_types.id 
					FROM
					".$tblprefix."car_types where car_types='".$car_types."' ";
				 
					$rs_already_event=$db->Execute($qry_already_event);
					$count_add =  $rs_already_event->RecordCount();
				
					if($count_add > 0){
					$errmsg = base64_encode('This Service already exist.');
					header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
					exit;
	 				}
	 		
	 			
	 
	 
			  	 $sql_category= "INSERT INTO ".$tblprefix."car_types  
														SET
														car_agency = '".$car_agency."',
														car_types = '".$car_types."',
														category = '".$category."',
														produced = '".$produced."',
														doors = '".$doors."',
														passengers = '".$passengers."'
														";
            
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
					$okmsg = base64_encode("Car Type Added Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
					exit;	  
				}else{
				      $okmsg = base64_encode("Car Type Not Added .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			} 
//---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='update_car_type' && $_POST['request_page']=='car_types_management'){
	   
		$car_agency = addslashes(trim($_POST['car_agency'])); 
		$car_types = addslashes(trim($_POST['car_types']));
		$category = addslashes(trim($_POST['category']));
		$produced = addslashes(trim($_POST['produced']));
		$doors = addslashes(trim($_POST['doors']));
		$passengers = addslashes(trim($_POST['passengers']));
		$id=base64_decode($_POST['id']);
		 $_SESSION['post']=$_POST;
		 		
			$slug=slugcreation($car_types);
			
			if($car_agency == ''){
				$errmsg = base64_encode('Please Enter Car Type');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			/*echo 'accessed';
		exit();*/
			
			if($car_types == ''){
				$errmsg = base64_encode('Please Enter Car Type');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			 if($category == ''){
						$errmsg = base64_encode('Please Select Car Category Type');
						header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
						exit;
					}
	 
	 
			if($produced == ''){
				$errmsg = base64_encode('Please Enter Cars produced');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($doors == ''){
				$errmsg = base64_encode('Please Enter Car Doors');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
			if($passengers == ''){
				$errmsg = base64_encode('Please Enter Numbers of Passengers');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			
			
		 	 	 $sql_category= "UPDATE ".$tblprefix."car_types 
				 
														SET
														car_agency = '".$car_agency."', 
														car_types = '".$car_types."',
														category = '".$category."',
														produced = '".$produced."',
														doors = '".$doors."',
														passengers = '".$passengers."'
														WHERE
														id=".$id;
														
													
 
			 		
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
						$okmsg = base64_encode("Car Types Updated successfully!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else{
					      
						$okmsg = base64_encode("Car Types Is Not Updated!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit; 
					}
			 
	
	} 	
######################
#
# 	GET SECTION
#
######################
//---------Delete THe Property Category ---------
if($_GET['mode']=='del_xtra' && $_GET['act']=='car_types' && $_GET['request_page']=='car_types_management'){
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."car_types WHERE id = ".$id; 
		$rs_del = $db->Execute($del_qry);					
		
					if($rs_del){
					   $okmsg = base64_encode("Car Types Deleted successfully. !");
					   header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					   exit;			
		}
					
					
					
					  
} 

?>