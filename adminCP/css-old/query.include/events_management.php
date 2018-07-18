<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------

	if($_POST['mode']=='add' && $_POST['act']=='events_categories' && $_POST['request_page']=='events_management'){        $event_category_name = addslashes(trim($_POST['event_category_name']));
		//$pm_id = addslashes(trim($_POST['pm_id']));	
		$slug=slugcreation($event_category_name);
		
			if($event_category_name == ''){
				$errmsg = base64_encode('Please Enter Event Category Name');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
	 
					$qry_already_event= "SELECT ".$tblprefix."event_categories.id
					FROM
					".$tblprefix."event_categories where event_category_name ='".							 					$event_category_name."' ";
				
					$rs_already_event=$db->Execute($qry_already_event);
					$count_add =  $rs_already_event->RecordCount();
				
					if($count_add > 0){
					$errmsg = base64_encode('This Event Category already exist.');
					header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
					exit;
	 				}
	 		
	 			
	 
	 
			 	 $sql_category= "INSERT INTO ".$tblprefix."event_categories 
														SET
														event_category_name = '".$event_category_name."',
														
														event_category_slug ='".$slug."'
														";
            
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
					$okmsg = base64_encode("Event Category Added Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
					exit;	  
				}else{
				      $okmsg = base64_encode("Event Category Not Added .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			} 
//---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='update_events' && $_POST['request_page']=='events_management'){
	    $event_category_name = addslashes(trim($_POST['event_category_name']));
		//$pm_id = $_POST['pm_id'];
		$id=base64_decode($_POST['id']); 
//$_SESSION['id']=$id;
		 $_SESSION['event_category_name']= $event_category_name; 
			$slug=slugcreation($event_category_name);
			
			if($event_category_name == ''){
				$errmsg = base64_encode('Please Enter Event Category Name');
				header("Location: admin.php?act=update_events&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}else{
				 $sql_category= "UPDATE ".$tblprefix."event_categories 
														SET
														event_category_name = '".$event_category_name."',
														
														event_category_slug ='".$slug."'
														WHERE
														id=".$id;
														
														

					
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
						$okmsg = base64_encode("Event Category Updated successfully!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else{
					      
						$okmsg = base64_encode("Event Category Is Not Updated!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit; 
					}
			} 
	
	} 	
######################
#
# 	GET SECTION
#
######################
//---------Delete THe Property Category ---------
if($_GET['mode']=='del_event' && $_GET['act']=='events_categories' && $_GET['request_page']=='events_management'){
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."event_categories WHERE id = ".$id; 
		$rs_del = $db->Execute($del_qry);					
		
					if($rs_del){
					   $okmsg = base64_encode("Event Category Deleted successfully. !");
					   header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					   exit;			
		}
					
					
					
					  
} 

?>