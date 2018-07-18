<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------

	if($_POST['mode']=='add' && $_POST['act']=='manage_car_categories' && $_POST['request_page']=='car_categories_management'){

	
	        $car_category_name = addslashes(trim($_POST['car_category_name']));
		//$pm_id = addslashes(trim($_POST['pm_id']));	
		$slug=slugcreation($car_category_name);
		
			if($car_category_name == ''){
				$errmsg = base64_encode('Please Enter Car Category Name');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
			 	 $sql_category= "INSERT INTO ".$tblprefix."car_categories 
														SET
														car_category_name = '".$car_category_name."',
														
														car_category_slug ='".$slug."'
														";
            
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
					$okmsg = base64_encode("Car Added Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
					exit;	  
				}else{
				      $okmsg = base64_encode("Car Not Added .!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			} 
//---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='update_car_categories' && $_POST['request_page']=='car_categories_management'){
	
	    $car_category_name = addslashes(trim($_POST['car_category_name']));
		//$pm_id = $_POST['pm_id'];
	 $id=base64_decode($_POST['id']);
		
		
		
		
			$slug=slugcreation($car_category_name);
			
			if($car_category_name == ''){
				$errmsg = base64_encode('Please Enter Car Category Name');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg&id=".base64_encode($id));
				exit;
			}else{
				 $sql_category= "UPDATE ".$tblprefix."car_categories 
														SET
														car_category_name = '".$car_category_name."',
														
														car_category_slug ='".$slug."'
														WHERE
														id=".$id;
														
														

					
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
						$okmsg = base64_encode("Car Category Updated successfully!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else{
					      
						$okmsg = base64_encode("Car Category Is Not Updated!");
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
if($_GET['mode']=='del_category' && $_GET['act']=='manage_car_categories' && $_GET['request_page']=='car_categories_management'){
	
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."car_categories WHERE id = ".$id;
		$rs_del = $db->Execute($del_qry);					
		
		$okmsg = base64_encode("Car Category Deleted successfully.!");
					header("Location: admin.php?okmsg=$okmsg&act=manage_car_categories");
					exit;	  
} 

?>