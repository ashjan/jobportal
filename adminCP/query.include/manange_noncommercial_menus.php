<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Menu Item---------
	if($_POST['mode']=='add' && $_POST['act']=='noncommercialmenus' && $_POST['request_page']=='manange_noncommercial_menus'){
		$menu_title = addslashes(trim($_POST['menu_title']));
		if($menu_title == ''){
				$errmsg = base64_encode('Please Enter Menu Title ');
				header("Location: admin.php?act=managemenues&errmsg=$errmsg");
				exit;
			}
		$menu_slug  = slugcreation($menu_title);
		
		
		
		
		$content_id = addslashes(trim($_POST['content_id']));
		$menu_link  = $menu_slug;
		$parent     = addslashes(trim($_POST['parent']));
				$qry_menu_exist= "SELECT
							".$tblprefix."menu.menu_title 
							FROM
							".$tblprefix."menu where menu_slug ='".$menu_slug."' ";
				$rs_menu_exist=$db->Execute($qry_menu_exist);
				$count_rec =  $rs_menu_exist->RecordCount();
				if($count_rec > 0){
					$errmsg = base64_encode('This menu title already exist. Try another one');
					header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
					exit;
				}	
				$sql_menu= "INSERT INTO ".$tblprefix."menu  
														SET 
												
														 menu_title = '".$menu_title."',
														 menu_slug  = '".$menu_slug ."',
														 content_id =".$content_id.",
														 menu_link ='".$menu_link."',
														 parent ='".$parent."'
														";
				$rs_ins_menu = $db->Execute($sql_menu);
				if($rs_ins_menu){
					$okmsg = base64_encode("Menu Item Added successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				} 
	} 
//---------Edit Menu---------
	if($_POST['mode']=='update' && $_POST['act']=='edit_noncommercial_menus' && $_POST['request_page']=='manange_noncommercial_menus'){

		$menu_title = addslashes(trim($_POST['menu_title']));
		$content_id = addslashes(trim($_POST['content_id']));
		$parent = addslashes(trim($_POST['parent']));
		
		$menu_slug  = slugcreation($menu_title);
		
		
		$menu_link = $menu_slug;
		$id=base64_decode($_POST['id']);
		
		//validating the fields
		
		if($menu_title == ''){
				$errmsg = base64_encode('Please Enter Menu Title ');
				header("Location: admin.php?act=noncommercialmenus&errmsg=$errmsg");
				exit;
			}
		
		$sql_update = "UPDATE ".$tblprefix."menu SET	
												 menu_title = '".$menu_title."', 
												 menu_slug = '".$menu_slug."', 
												 content_id =".$content_id.", 
												 menu_link ='".$menu_link."', 
												 parent ='".$parent."'
												 WHERE
												 id=".$id;
		$rs_update = $db->Execute($sql_update);
		    if($rs_update){
			$okmsg = base64_encode(" Menu item Updated successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=noncommercialmenus");
			exit;	  
				}else{
			$errmsg = base64_encode(" Menu item not updated. !");
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
if($_GET['mode']=='del_menu' && $_GET['act']=='noncommercialmenus' && $_GET['request_page']=='manange_noncommercial_menus'){
		$id=base64_decode($_GET['id']);
		
		$del_qry = " DELETE FROM ".$tblprefix."menu WHERE id = ".$id;
		
		$rs_newsletter = $db->Execute($del_qry);				
		$okmsg = base64_encode("Menu Deleted Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=managemenues");
					exit;	  
}


//----------  Change Ordering Code     
if($_POST['mode']=='change_ordering' && $_POST['act']=='noncommercialmenus' && $_POST['request_page']=='manange_noncommercial_menus'){
	$menu_order=$_POST['menu_order'];
    foreach($menu_order as $key=>$val){
	$id=$key;
	// Now activate the status of the currently selected default language 
	$sql_change_order= "UPDATE ".$tblprefix."menu 
													SET 
													menu_order =".$val." 
													WHERE  
													id=".$id;
	$rs_change_order = $db->Execute($sql_change_order);
	}
	$okmsg = base64_encode(" Ordering Set Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=noncommercialmenus");
					exit;	
}
//---------Status Code---------		
if($_GET['mode']=='change_default' && $_GET['act']=='noncommercialmenus' && $_GET['request_page']=='manange_noncommercial_menus'){
	// First disable the default language status of all the languages  
	$id=base64_decode($_GET['id']);
	$status=$_GET['m_status'];
//if parent is disable 
	 $sql_parent= "SELECT parent FROM ".$tblprefix."menu 
												WHERE
												id=".$id;
												
				$rs_sql_parent = $db->Execute($sql_parent);
				$parent = $rs_sql_parent->fields['parent'];

		if($parent!=0){
				$sql_status= "SELECT menu_status FROM ".$tblprefix."menu 
													WHERE
													id=".$parent;
													
				$rs_status = $db->Execute($sql_status);
				$status_parent = $rs_status->fields['menu_status'];
				if($status_parent==0){
						$errmsg = base64_encode("Status Could not be Acitvated.Activate Parent First. !");
						header("Location: admin.php?errmsg=$errmsg&act=noncommercialmenus");
						exit;				
				}
				
				// Now activate the status of the currently selected default language 
				$sql_currencies= "UPDATE ".$tblprefix."menu 
													SET 
													menu_status=".$status."
													WHERE
													id=".$id;
				$rs_currencies = $db->Execute($sql_currencies);
				//to disable child
				if($status==0){
						$sql_parent= "UPDATE ".$tblprefix."menu 
													SET 
													menu_status=".$status."
													WHERE
													parent=".$id;
						$db->Execute($sql_parent);
				}
		
				if($rs_currencies){
						$okmsg = base64_encode("Status updated successfully. !");
						header("Location: admin.php?okmsg=$okmsg&act=noncommercialmenus");
						exit;	  
				}
		}else{
			$sql_currencies= "UPDATE ".$tblprefix."menu 
												SET 
												menu_status=".$status."
												WHERE
												id=".$id;
			$rs_currencies = $db->Execute($sql_currencies);

		//to diable child
		if($status==0){
	 			$sql_parent= "UPDATE ".$tblprefix."menu 
												SET 
												menu_status=".$status."
												WHERE
												parent=".$id;
					$db->Execute($sql_parent);
					}

				if($rs_currencies){
					$okmsg = base64_encode("Status updated successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=noncommercialmenus");
					exit;	  
				}			
		}
	
	}
?>