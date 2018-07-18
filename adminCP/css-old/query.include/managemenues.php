<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Menu Item---------
	if($_POST['mode']=='add' && $_POST['act']=='managemenues' && $_POST['request_page']=='managemenues'){
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
		$footer_menu  = addslashes(trim($_POST['footer_menu']));
		$main_menu  = addslashes(trim($_POST['main_menu']));
				$qry_menu_exist= "SELECT
							".$tblprefix."menu.menu_title 
							FROM
							".$tblprefix."menu where menu_slug ='".$menu_slug."' ";
				$rs_menu_exist=$db->Execute($qry_menu_exist);
				$count_rec =  $rs_menu_exist->RecordCount();
				if($count_rec > 0){
					$errmsg = base64_encode('This menu title already exist. Try another one');
					header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
					exit;
				}	
				$sql_menu= "INSERT INTO ".$tblprefix."menu  
														SET 
												
														 menu_title = '".$menu_title."',
														 menu_slug  = '".$menu_slug ."',
														 content_id =".$content_id.",
														 menu_link ='".$menu_link."',
														 
														 footer_menu ='".$footer_menu."'
														 
														";
				
				$rs_ins_menu = $db->Execute($sql_menu);
				if($rs_ins_menu){
				
				
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();
		/*echo '<pre>';
		print_r($my_post);
		echo $id;*/
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"menu_title") and strlen($key)>strlen("menu_title")){ 
			$language_id = substr($key,strpos($key,"_",9)+1);
			//$language_id = substr($language_id,strpos($language_id,"_")+1);
			
			// Now that we have got the Language IDs we will need to update the language content table
			// Find whether the field already exist or not 
			$language_qry = "SELECT id,
				language_id,
				page_id,
				field_name,
				translation_text,
				translated_text,
				fld_type 
				FROM 
				".$tblprefix."language_contents 
				WHERE   
				language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='menu_title' 
				AND fld_type='menu_footer_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='menu_title',
				translation_text ='".addslashes($menu_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='menu_footer_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='menu_title',
				translation_text ='".addslashes($menu_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='menu_footer_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='menu_title'  
				AND fld_type='menu_footer_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
				
				
				
				
				
					$okmsg = base64_encode("Menu Item Added successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				}else{
					$errmsg = base64_encode("Menu Item Not Added. !");
					header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
					exit;
				} 
	} 
//---------Edit Menu---------
	if($_POST['mode']=='update' && $_POST['act']=='managemenues' && $_POST['request_page']=='managemenues'){
	

		$menu_title = addslashes(trim($_POST['menu_title']));
		$content_id = addslashes(trim($_POST['content_id']));
		$parent = addslashes(trim($_POST['parent']));
		$footer_menu = addslashes(trim($_POST['footer_menu']));
		$main_menu = addslashes(trim($_POST['main_menu']));
		$menu_slug  = slugcreation($menu_title);
		
		
		$menu_link = $menu_slug;
		$id=base64_decode($_POST['id']);
		
		//validating the fields
		
		if($menu_title == ''){
				$errmsg = base64_encode('Please Enter Menu Title ');
				header("Location: admin.php?act=managemenues&errmsg=$errmsg");
				exit;
			}
												 $sql_update = "UPDATE ".$tblprefix."menu SET	
												 menu_title = '".$menu_title."', 
												 menu_slug = '".$menu_slug."', 
												 content_id =".$content_id.", 
												 menu_link ='".$menu_link."', 
												 footer_menu ='".$footer_menu."'
												 WHERE
												 id=".$id; 
											
											
		$rs_update = $db->Execute($sql_update);
		    if($rs_update){
			
			
			
			
					
		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		//$id = mysql_insert_id();
		/*echo '<pre>';
		print_r($my_post);
		echo $id;*/
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"menu_title") and strlen($key)>strlen("menu_title")){ 
			$language_id = substr($key,strpos($key,"_",9)+1);
			//$language_id = substr($language_id,strpos($language_id,"_")+1);
			
			// Now that we have got the Language IDs we will need to update the language content table
			// Find whether the field already exist or not 
			$language_qry = "SELECT id,
				language_id,
				page_id,
				field_name,
				translation_text,
				translated_text,
				fld_type 
				FROM 
				".$tblprefix."language_contents 
				WHERE   
				language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='menu_title' 
				AND fld_type='menu_footer_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='menu_title',
				translation_text ='".addslashes($menu_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='menu_footer_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='menu_title',
				translation_text ='".addslashes($menu_title)."',
				translated_text ='".addslashes($val)."',
				fld_type='menu_footer_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='menu_title'  
				AND fld_type='menu_footer_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  // foreach($my_post as $key=>$val)
			
			
			
			$okmsg = base64_encode(" Menu item Updated successfully. !");
			header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
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
if($_GET['mode']=='del_menu' && $_GET['act']=='managemenues' && $_GET['request_page']=='managemenues'){
		$id=base64_decode($_GET['id']);
		if($id!=129){
		$del_qry = " DELETE FROM ".$tblprefix."menu WHERE id = ".$id;
		
		$rs_newsletter = $db->Execute($del_qry);
		
		$del_qry = '';
		$rs_newsletter = '';
		
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id = ".$id." AND fld_type='menu_footer_type'";
		
		$rs_newsletter = $db->Execute($del_qry);
		
						
		$okmsg = base64_encode("Menu Deleted Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=managemenues");
					exit;	  
					}else{
						 $errmsg = base64_encode("Home Menu item is not deletable. !");
						 header("Location: admin.php?errmsg=$errmsg&act=managemenues");
						 exit;	  	
					  	 } 

}

//----------  Change Ordering Code     
if($_POST['mode']=='change_ordering' && $_POST['act']=='managemenues' && $_POST['request_page']=='managemenues'){
	$menu_order=$_POST['menu_order'];
    
	if($id == 129){
				$errmsg = base64_encode('Home\'s order is not changeable!');
				header("Location: admin.php?act=managemenues&errmsg=$errmsg");
				exit;
			}
	
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
					header("Location: admin.php?okmsg=$okmsg&act=managemenues");
					exit;	
}
//---------Status Code---------		
if($_GET['mode']=='change_default' && $_GET['act']=='managemenues' && $_GET['request_page']=='managemenues'){
	// First disable the default language status of all the languages  
	$id=base64_decode($_GET['id']);
	
	/*   if($id == 129){
				$errmsg = base64_encode('We are unable to change the Home menu Status!');
				header("Location: admin.php?act=managemenues&errmsg=$errmsg");
				exit;
			}  */
	
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
				/*if($status_parent==0){
						$errmsg = base64_encode("Status Could not be Acitvated.Activate Parent First. !");
						header("Location: admin.php?errmsg=$errmsg&act=managemenues");
						exit;				
				}*/
				
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
						header("Location: admin.php?okmsg=$okmsg&act=managemenues");
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
					header("Location: admin.php?okmsg=$okmsg&act=managemenues");
					exit;	  
				}			
		}
	
	}
	
	//*****************************************
	//---------footer menu Status Code---------	
	//*****************************************
		
if($_GET['mode']=='change_default' && $_GET['act']=='managemenues' && $_GET['request_page']=='managemenues'){
	// First disable the default language status of all the languages  
	$id=base64_decode($_GET['id']);
	$status=$_GET['fm_status'];
	
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
				/*if($status_parent==0){
						$errmsg = base64_encode("Status Could not be Acitvated.Activate Parent First. !");
						header("Location: admin.php?errmsg=$errmsg&act=managemenues");
						exit;				
				}*/
				
				// Now activate the status of the currently selected default language 
				$sql_currencies= "UPDATE ".$tblprefix."menu 
													SET 
													footer_menu=".$status."
													WHERE
													id=".$id;
				$rs_currencies = $db->Execute($sql_currencies);
				//to disable child
				if($status==0){
						$sql_parent= "UPDATE ".$tblprefix."menu 
													SET 
													footer_menu=".$status."
													WHERE
													parent=".$id;
						$db->Execute($sql_parent);
				}
		
				if($rs_currencies){
						$okmsg = base64_encode("Status updated successfully. !");
						header("Location: admin.php?okmsg=$okmsg&act=managemenues");
						exit;	  
				}
		}else{
			$sql_currencies= "UPDATE ".$tblprefix."menu 
												SET 
												footer_menu=".$status."
												WHERE
												id=".$id;
			$rs_currencies = $db->Execute($sql_currencies);

		//to diable child
		if($status==0){
	 			$sql_parent= "UPDATE ".$tblprefix."menu 
												SET 
												footer_menu=".$status."
												WHERE
												parent=".$id;
					$db->Execute($sql_parent);
					}

				if($rs_currencies){
					$okmsg = base64_encode("Status updated successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=managemenues");
					exit;	  
				}			
		}
	
	}
	
	//*****************************************
	//---------Main Menu Status Code---------	
	//*****************************************
		
if($_GET['mode']=='change_default' && $_GET['act']=='managemenues' && $_GET['request_page']=='managemenues'){
	// First disable the default language status of all the languages  
	$id=base64_decode($_GET['id']);
	$status=$_GET['mm_status'];
	
	if($id == 129){
				$errmsg = base64_encode('We are unable to disable Home menu!');
				header("Location: admin.php?act=managemenues&errmsg=$errmsg");
				exit;
			}
	
	
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
				/*if($status_parent==0){
						$errmsg = base64_encode("Status Could not be Acitvated.Activate Parent First. !");
						header("Location: admin.php?errmsg=$errmsg&act=managemenues");
						exit;				
				}*/
				// For Home menu
				
				// Now activate the status of the currently selected default language 
				$sql_currencies= "UPDATE ".$tblprefix."menu 
													SET 
													main_menu=".$status."
													WHERE
													id=".$id;
				$rs_currencies = $db->Execute($sql_currencies);
				//to disable child
				if($status==0){
						$sql_parent= "UPDATE ".$tblprefix."menu 
													SET 
													main_menu=".$status."
													WHERE
													parent=".$id;
						$db->Execute($sql_parent);
				}
		
				if($rs_currencies){
						$okmsg = base64_encode("Status updated successfully. !");
						header("Location: admin.php?okmsg=$okmsg&act=managemenues");
						exit;	  
				}
		}else{
			$sql_currencies= "UPDATE ".$tblprefix."menu 
												SET 
												main_menu=".$status."
												WHERE
												id=".$id;
			$rs_currencies = $db->Execute($sql_currencies);

		//to diable child
		if($status==0){
	 			$sql_parent= "UPDATE ".$tblprefix."menu 
												SET 
												main_menu=".$status."
												WHERE
												parent=".$id;
					$db->Execute($sql_parent);
					}

				if($rs_currencies){
					$okmsg = base64_encode("Status updated successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=managemenues");
					exit;	  
				}			
		}
	
	}
	
?>