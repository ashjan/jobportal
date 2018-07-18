<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------
if(!empty($_POST)){
	if($_POST['mode']=='add' && $_POST['act']=='manage_jobs_review_criteria' && $_POST['request_page']=='jobs_review_criteria_management'){
		
	//echo "<pre>";        print_r($_POST); exit;
		
	        $review_criteria_name = addslashes(trim($_POST['review_criteria_name']));
		//$pm_id = addslashes(trim($_POST['pm_id']));	
		$slug=slugcreation($review_criteria_name);
		
			if($review_criteria_name == ''){
				$errmsg = base64_encode('Please Enter Property Category Name');
				//$errmsg = base64_encode('Unesite naziv kategorije');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
			 	 $sql_category= "INSERT INTO ".$tblprefix."jobs_review_criteria 
														SET
														criteria = '".$review_criteria_name."',
														slug ='".$slug."',
                                                                                                                status=1
														";
            
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
				
										

		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();
		/*echo '<pre>';
		print_r($my_post);
		echo $id;*/
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){
			if(strstr($key,"review_criteria_name") and strlen($key)>strlen("review_criteria_name")){ 
			$language_id = substr($key,strpos($key,"_",9)+1);
			$language_id = substr($language_id,strpos($language_id,"_")+1);
			
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
				AND field_name='cate_title' 
				AND fld_type='cate_type'"
				;
				
			$rs_language = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			
            if($totallang_flds <= 0){
			// There is no field exists so create one for this language
			$insert_lang_fld = "INSERT INTO ".$tblprefix."language_contents  
                SET
				language_id = ".$language_id.",
				page_id =".$id.",
				field_name ='cate_title',
				translation_text ='".addslashes($review_criteria_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='cate_type'
				";
			$rs_ins_lang_fld = $db->Execute($insert_lang_fld);
			}else{
			$update_lang_fld= "UPDATE ".$tblprefix."language_contents  
                SET
				field_name ='cate_title',
				translation_text ='".addslashes($review_criteria_name)."',
				translated_text ='".addslashes($val)."',
				fld_type='cate_type' 
				WHERE language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='cate_title'  
				AND fld_type='cate_type'";
	        $rs_upd_lang_fld = $db->Execute($update_lang_fld); 
			}// END if($totallanguages<=0)
			}// END if(strstr($key,"categoryname") and strlen($key)>strlen("categoryname"))
		}  
			
		
				
					$okmsg = base64_encode("Review Criteria added successfully. !");
					//$okmsg = base64_encode("Kategorija objeCriteria addedkta uspješno dodata. !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
					exit;	  
				}else{
				      $okmsg = base64_encode("Could not add Review Criteria, please try again.!");
					   //$okmsg = base64_encode("Kategorija nije dodata, molimo pokušajte ponovo!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			} 
                        }
//---------Edit Category---------
       if(!empty($_POST)){
	if($_POST['mode']=='update' && $_POST['act']=='update_jobs_review_criteria' && $_POST['request_page']=='jobs_review_criteria_management'){
	    $review_criteria_name = addslashes(trim($_POST['review_criteria_name']));
		//$pm_id = $_POST['pm_id'];
	 $id=base64_decode($_POST['id']);
		
		
		//$_SESSION['id']=$id;
		$_SESSION['review_criteria_name']= $review_criteria_name;
			$slug=slugcreation($review_criteria_name);
			
			if($review_criteria_name == ''){
				$errmsg = base64_encode('Please Enter Review Criteria Name');
				
				header("Location: admin.php?act=update_jobs_review_criteria&errmsg=$errmsg&id=".base64_encode($_POST['id']));
				exit;
			}else{
				$sql_category= "UPDATE ".$tblprefix."jobs_review_criteria 
														SET
														criteria = '".$review_criteria_name."',
														slug ='".$slug."'
														WHERE
														id=".$id;
														
														

					
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category){
					
		$my_post = $_POST;

					
					
						$okmsg = base64_encode("Review Criteria updated successfully!");
						//$okmsg = base64_encode("Kategorija uspješno ažurirana!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else{
					      
						$okmsg = base64_encode("Could not update Review Criteria, please try again!");
						//$okmsg = base64_encode("Kategorija nije ažurirana, molimo pokušajte ponovo!");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
						exit; 
					}
			} 
	
	} 	
        }
	
// Ordering section 
//----------  Change Ordering Code  
if(!empty($_POST)){
if($_POST['mode']=='order_menu' && $_POST['act']=='manage_jobs_review_criteria' && $_POST['request_page']=='jobs_review_criteria_management'){
	$menu_order=$_POST['menu_order'];
	foreach($menu_order as $key=>$val){
	$id=$key;
	// Now activate the status of the currently selected default language 
	$sql_change_order= "UPDATE ".$tblprefix."jobs_review_criteria  
													SET 
													criteria_ordering=".$val." 
													WHERE  
													id=".$id;
	$rs_change_order = $db->Execute($sql_change_order);
	}
	$okmsg = base64_encode(" Ordering Set Successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_jobs_review_criteria");
					exit;	
}}
######################
#
# 	GET SECTION
#
######################
//---------Delete THe Property Category ---------
if(isset($_GET['mode']))
{
if($_GET['mode']=='del_review_criteria' && $_GET['act']=='manage_jobs_review_criteria' && $_GET['request_page']=='jobs_review_criteria_management'){
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."jobs_review_criteria WHERE id = ".$id;
		$rs_del = $db->Execute($del_qry);
							
		$del_qry = '';
		$rs_del = '';
		
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id = ".$id." AND fld_type='cate_type'";
		$rs_del = $db->Execute($del_qry);
		
		$okmsg = base64_encode("Review Criteria deleted successfully!");
		
					header("Location: admin.php?okmsg=$okmsg&act=manage_jobs_review_criteria");
					exit;	  
}
}

//--------------------- Change Status ----------------------
if(isset($_GET)){
if($_GET['mode']=='change_status' && $_GET['act']=='manage_jobs_review_criteria' && $_GET['request_page']=='jobs_review_criteria_management'){
		$id=base64_decode($_GET['id']);
		$status=$_GET['m_status'];
		
		if($status == 1){
		$newstatus = 0;
		}elseif( $status == 0){
		$newstatus = 1;
		}
		$update_qry = " UPDATE ".$tblprefix."jobs_review_criteria SET
		                                                  status = '".$newstatus."'
														  WHERE id  = '".$id."' ";
		$rs_pmqry = $db->Execute($update_qry);			
		
		 
			
		$okmsg = base64_encode("Revview Criteria`s status successfully UPDATED. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_jobs_review_criteria");
					exit;	  
} 
}

?>