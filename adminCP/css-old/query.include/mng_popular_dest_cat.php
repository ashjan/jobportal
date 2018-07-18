<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------

	if($_POST['mode']=='add' && $_POST['act']=='popular_dest_cat' && $_POST['request_page']=='mng_popular_dest_cat'){       
	
	
		$popular_category_name = addslashes(trim($_POST['popular_category_name']));	
		$slug=slugcreation($popular_category_name); 
				if($popular_category_name == ''){
				//$errmsg = base64_encode('Please Enter Popular Destination Category Name');
				$errmsg = base64_encode('Molimo unesite naziv');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}	 
			
			 $sql_category= "INSERT INTO ".$tblprefix."popular_dest_cat 
														SET
														popular_category_name = '".$popular_category_name."',
														
														popular_category_slug ='".$slug."'
														"; 
            
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
					//$okmsg = base64_encode("Popular Destination category added successfully. !");
					$okmsg = base64_encode("Kategorija uspješno dodata. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
					exit;	  
				}else{
				      //$errmsg = base64_encode("Could not add Category, please try again.!");
					  $errmsg = base64_encode("Kategorija nije dodata, molimo pokušajte ponovo.!");
					header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
					exit;
				} 
				
			} 
//---------Edit Category---------
	if($_POST['mode']=='update' && $_POST['act']=='update_popular_dest_cat' && $_POST['request_page']=='mng_popular_dest_cat'){
	    $popular_category_name = addslashes(trim($_POST['popular_category_name']));
		//$pm_id = $_POST['pm_id'];
	 $id=base64_decode($_POST['id']);
		
		
		//$_SESSION['id']=$id;
		$_SESSION['popular_category_name']= $popular_category_name;
			$slug=slugcreation($popular_category_name);
			
			if($popular_category_name == ''){
				//$errmsg = base64_encode('Please Enter Category Name');
				$errmsg = base64_encode('Molimo unesite naziv kategorije');
				header("Location: admin.php?act=update_popular_dest_cat&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}else{
				 $sql_category= "UPDATE ".$tblprefix."popular_dest_cat 
														SET
														popular_category_name = '".$popular_category_name."',
														
														popular_category_slug ='".$slug."'
														WHERE
														id=".$id; 
														
														

					
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
						//$okmsg = base64_encode("Property Category updated successfully!");
						$okmsg = base64_encode("Kategorija uspšeno ažurirana!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else{
					      
						//$errmsg = base64_encode("Could not update Property Category, please try again!");
						$errmsg = base64_encode("Kategorija nije ažurirana, molimo pokušajte ponovo!");
						header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
						exit; 
					}
			} 
	
	} 	
	
// Ordering section 
//----------  Change Ordering Code     
if($_POST['mode']=='order_menu' && $_POST['act']=='popular_dest_cat' && $_POST['request_page']=='mng_popular_dest_cat'){
	$menu_order=$_POST['menu_order'];
	foreach($menu_order as $key=>$val){
	$id=$key;
	// Now activate the status of the currently selected default language 
	$sql_change_order= "UPDATE ".$tblprefix."popular_dest_cat  
													SET 
													cat_orderdering=".$val." 
													WHERE  
													id=".$id; 
	$rs_change_order = $db->Execute($sql_change_order);
	}
	//$okmsg = base64_encode(" Ordering Set Successfully. !");
	$okmsg = base64_encode(" Redosljed uspješno postavljen. !");
					header("Location: admin.php?okmsg=$okmsg&act=popular_dest_cat");
					exit;	
}

//---------Delete THe Property Category ---------
if($_GET['mode']=='del_category' && $_GET['act']=='popular_dest_cat' && $_GET['request_page']=='mng_popular_dest_cat'){
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."popular_dest_cat WHERE id = ".$id;
		$rs_del = $db->Execute($del_qry);					
		
		//$okmsg = base64_encode("Popular Destination Category deleted successfully!");
		$okmsg = base64_encode("Kategorija uspješno izbrisana!");
					header("Location: admin.php?okmsg=$okmsg&act=popular_dest_cat");
					exit;	  
} 

?>