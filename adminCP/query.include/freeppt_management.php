<?php
//---------Add Free Service ---------

if($_POST['mode']=='add' && $_POST['act']=='property_free_service' && $_POST['request_page']=='freeppt_management'){  
   
			$service_name = addslashes(trim($_POST['service_name'])); 
 		  	$service_name_5 = addslashes(trim($_POST['service_name_5'])); 
		  	$service_name_7 = addslashes(trim($_POST['service_name_7']));
			//$pm_id = addslashes(trim($_POST['pm_id']));		     
			  
		
			if($service_name == ''){
				//$errmsg = base64_encode('Please Enter Service Name');
				$errmsg = base64_encode('Molimo unesite naziv usluge');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
	 
					$qry_already_service= "SELECT ".$tblprefix."property_free_services.id 
					                       FROM
					".$tblprefix."property_free_services WHERE service_name='".$service_name."'";
				
					$rs_already_service=$db->Execute($qry_already_service);
					$count_add =  $rs_already_service->RecordCount();
				
					if($count_add > 0){
					//$errmsg = base64_encode('This Service already exist.');
					$errmsg = base64_encode('Ova usluga već postoji.');
					header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
					exit;
	 				}
	 		
			 	$sql_free_services= "INSERT INTO ".$tblprefix."property_free_services  
														SET
														service_name = '".$service_name."'
														";
				$rs_insert_free_services = $db->Execute($sql_free_services);
				$last_insert_id = mysql_insert_id();
				if($rs_insert_free_services){
					
					//  G  E T       A L L    T H E    L A N G U A G E        F I E L D S  
					$language_query = "SELECT * FROM  ".$tblprefix."language   
												WHERE ".$tblprefix."language.id<>4";
					$rs_language    = $db->Execute($language_query);
					$totallanguage  = $rs_language->RecordCount();						   
					
					while(!$rs_language->EOF){
					$language_content_query = "INSERT ".$tblprefix."language_contents SET 
					                           ".$tblprefix."language_contents.language_id = ".$rs_language->fields['id'].",
											   ".$tblprefix."language_contents.page_id = ".$last_insert_id.", 
											   ".$tblprefix."language_contents.field_name = 'service_name',
											   ".$tblprefix."language_contents.translation_text='".$service_name."',
											   ".$tblprefix."language_contents.translated_text='".addslashes(trim($_POST['service_name_'.$rs_language->fields['id']]))."',
											   ".$tblprefix."language_contents.fld_type = 'free_services'";
					
					
					$rs_language_content = $db->Execute($language_content_query);
					$rs_language->MoveNext();
					}
											   
					// ---			insert for Russian language 
						
					$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE `language_id`='5' 
										  AND `page_id`='".$last_id."' AND `field_name` = 'service_name_5' AND fld_type ='free_services'";
					$all_ready_exists = $db->Execute($property_name_qry);
					
					if($all_ready_exists->totallang > 0)
					{
						$language_id=5;  // for Russuan language
							$update_rus_fld= "UPDATE ".$tblprefix."language_contents  
									SET
									field_name ='service_name_5',
									translation_text ='".addslashes($service_name)."',
									translated_text ='".addslashes($service_name_5)."',
									fld_type='free_services' 
									WHERE language_id=".$language_id."
									AND field_name='service_name_5' 
									AND fld_type='free_services'
									AND page_id='".$last_id."'
									";
						  
							$rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
							
							
					}
					else
					{
					 $language_id=5;  // for Russian language
							$insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
									SET
									field_name ='service_name_5',
									translation_text ='".addslashes($service_name)."',
									translated_text ='".addslashes($service_name_5)."',
									fld_type='free_services', 
									language_id=".$language_id." ,
									page_id=".$last_id ." 
									
									";
							$rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);
						
					} 					
					
					
					// ---			Insert for Montenegro language 
						
					$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE `language_id`='7' 
										  AND `page_id`='".$last_id."' AND `field_name` = 'service_name_5' AND fld_type ='free_services'";
					$all_ready_exists = $db->Execute($property_name_qry);
					
					if($all_ready_exists->totallang > 0)
					{
						$language_id=7;  // for Russuan language
							$update_mon_fld= "UPDATE ".$tblprefix."language_contents  
									SET
									field_name ='service_name_7',
									translation_text ='".addslashes($service_name)."',
									translated_text ='".addslashes($service_name_7)."',
									fld_type='free_services' 
									WHERE language_id=".$language_id."
									AND field_name='service_name_7' 
									AND fld_type='free_services'
									AND page_id='".$last_id."'";
							$rs_upd_mon_lang_fld = $db->Execute($update_mon_fld);
					}else{
					 $language_id=7;  // for Montenegro language
							$insert_mon_fld= "INSERT INTO ".$tblprefix."language_contents  
									SET     
									field_name ='service_name_7', 
									translation_text ='".addslashes($service_name)."', 
									translated_text ='".addslashes($service_name_7)."', 
									fld_type='free_services', 
									language_id=".$language_id.", 
									page_id=".$last_id ." ";
							$rs_insert_mon_lang_fld = $db->Execute($insert_mon_fld);
					} 
					
											   
					
					//$okmsg = base64_encode("Service Added Successfully. !");
					$okmsg = base64_encode("Usluga uspješno dodata . !");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
					exit;	  
				}else{
				      //$okmsg = base64_encode("Service Not Added .!");
					  $okmsg = base64_encode("Usluga nije dodata.!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			} 			
			
//---------Edit Free Service---------

if($_POST['mode']=='update' && $_POST['act']=='update_ppt_freeservice' && $_POST['request_page']=='freeppt_management'){		
		
		$event_category_name = addslashes(trim($_POST['event_category_name']));
		$service_name = $event_category_name;
		$service_name_5 = addslashes(trim($_POST['service_name_5'])); 
		$service_name_7 = addslashes(trim($_POST['service_name_7']));
		$id=base64_decode($_POST['id']); 
       
		$_SESSION['event_category_name']= $event_category_name; 
			$slug=slugcreation($event_category_name);
			
			if($event_category_name == ''){
				//$errmsg = base64_encode('Please Enter Service Name');
				$errmsg = base64_encode('Molimo unesite naziv usluge');
				header("Location: admin.php?act=update_ppt_freeservice&errmsg=$errmsg&id=".$_POST['id']);
				exit;
			}else{
				$sql_category= "UPDATE ".$tblprefix."property_free_services 
														SET
														service_name = '".$event_category_name."' 
														WHERE
														id=".$id;
				$rs_category = $db->Execute($sql_category);
					if($rs_category){
					
						//  G  E T       A L L    T H E    L A N G U A G E        F I E L D S  
					$language_query = "SELECT * FROM  ".$tblprefix."language   
												WHERE ".$tblprefix."language.id<>4";
					$rs_language    = $db->Execute($language_query);
					$totallanguage  = $rs_language->RecordCount();						   
					/*  while(!$rs_language->EOF){
					$language_content_query = "UPDATE ".$tblprefix."language_contents SET 
					   ".$tblprefix."language_contents.language_id = ".$rs_language->fields['id'].",
					   ".$tblprefix."language_contents.page_id = ".$id.", 
					   ".$tblprefix."language_contents.field_name = 'service_name',
					   ".$tblprefix."language_contents.translation_text='".$event_category_name."',
					   ".$tblprefix."language_contents.translated_text='".addslashes(trim($_POST['service_name_'.$rs_language->fields['id']]))."',						   					   ".$tblprefix."language_contents.fld_type = 'free_services' 
					   WHERE  
					   ".$tblprefix."language_contents.field_name = 'service_name' 
					   AND 
					   ".$tblprefix."language_contents.fld_type = 'free_services'
					   AND 
					   ".$tblprefix."language_contents.language_id = ".$rs_language->fields['id']."
					   AND 
					   ".$tblprefix."language_contents.page_id = ".$id."";
					$rs_language->MoveNext();
				   }	 */
						
						
						
						//-- 		insert for Russian language for offline 
						$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE `language_id`='5' 
											 AND `page_id`='$id' AND `field_name` = 'service_name_5' AND fld_type ='free_services'";
						$all_ready_exists = $db->Execute($property_name_qry);
						if($all_ready_exists->fields['totallang'] > 0)
						{
							$language_id=5;  // for Russian language for offline
								
								 $update_rus_fld= "UPDATE ".$tblprefix."language_contents  
										SET 
										field_name ='service_name_5',
										translation_text ='".addslashes($service_name)."',
										translated_text ='".addslashes($service_name_5)."',
										fld_type='free_services' 
										WHERE language_id=".$language_id." 
										AND field_name='service_name_5' 
										AND fld_type='free_services' 
										AND page_id= ".$id."
										";
								$rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
						}else{
						 $language_id=5;  // for Russian language for offline
							
								 $insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
										SET
										field_name ='service_name_5',
										translation_text ='".addslashes($service_name)."',
										translated_text ='".addslashes($service_name_5)."',
										fld_type='free_services' ,
										language_id=".$language_id." ,
										page_id=".$id."
										";				
								$rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);	
								
						}

				   		
						//-- 		insert for Montenegro language for offline 
							
						$property_name_qry = "SELECT  count( * ) AS totallang FROM `tbl_language_contents` WHERE `language_id`='7' 
											 AND `page_id`='$id' AND `field_name` = 'service_name_7' AND fld_type ='free_services'";
						$all_ready_exists = $db->Execute($property_name_qry);
						if($all_ready_exists->fields['totallang'] > 0){
							$language_id=7;  // for Montenegro language for offline
								       $update_rus_fld= "UPDATE ".$tblprefix."language_contents  
										SET
										field_name ='service_name_7',
										translation_text ='".addslashes($service_name)."',
										translated_text ='".addslashes($service_name_7)."',
										fld_type='free_services' 
										WHERE language_id=".$language_id."  
										AND field_name='service_name_7'   
										AND fld_type='free_services'  
										AND page_id= ".$id." ";
								$rs_upd_rus_lang_fld = $db->Execute($update_rus_fld);
						}else{
						 $language_id=7;  // for Montenegro language for offline
							
								 $insert_rus_fld= "INSERT INTO ".$tblprefix."language_contents  
										SET
										field_name ='service_name_7',
										translation_text ='".addslashes($service_name)."',
										translated_text ='".addslashes($service_name_7)."',
										fld_type='free_services',
										language_id=".$language_id.",
										page_id=".$id."
										";				
								$rs_insert_rus_lang_fld = $db->Execute($insert_rus_fld);	
									
						}					
				   
				   
				        $rs_category = $db->Execute($sql_category);
						//$okmsg = base64_encode("Service Updated successfully!");
						  $okmsg = base64_encode("Usluga uspješno ažurirana!");
						
						
						
						
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}else{
					      
						//$okmsg = base64_encode("Service Is Not Updated!");
						  $okmsg = base64_encode("Usluga nije ažurirana!");
						header("Location: admin.php?errmsg=$okmsg&act=".$_POST['act']."&id=".$_POST['id']);
						exit; 
					}
			}	
} 	

//---------Delete THe Property Free Services ---------

if($_GET['mode']=='del_service' && $_GET['act']=='property_free_service' && $_GET['request_page']=='freeppt_management'){
		$id=base64_decode($_GET['id']);
		//echo "<br/>   id : ".$id;
		$sql_query = "SELECT * FROM  ".$tblprefix."property_policy";
		$rs_Sql_query    = $db->Execute($sql_query);
		$free_service_arr= array();
		
		while(!$rs_Sql_query->EOF){
			
			/*echo "id ".$rs_Sql_query->fields['id']."<br/>";
			echo "free service ".$rs_Sql_query->fields['free_service']."<br/>";*/
			
			$free_service =$rs_Sql_query->fields['free_service'];
			$free_service_arr =explode(",",$free_service);
			$key = array_search($id,$free_service_arr);
        if($key!==false){
       		unset($free_service_arr[$key]);
        }
		
		/*echo "<pre>";
		print_r($free_service_arr);
		echo "</pre>";*/
		
		$free_service=implode(",",$free_service_arr);
		$sql_qry = "UPDATE ".$tblprefix."property_policy SET ".$tblprefix."property_policy.free_service=".$free_service."  WHERE ".$tblprefix."property_policy.id=".$rs_Sql_query->fields['id'];
		$rs_update_policy    = $db->Execute($sql_qry);
		
		$rs_Sql_query->MoveNext();
		}
			
		
		$del_qry = " DELETE FROM ".$tblprefix."property_free_services WHERE id = ".$id; 
		$rs_del = $db->Execute($del_qry);				
		
					if($rs_del){
					   
					   $del_language_qry = " DELETE FROM ".$tblprefix."language_contents WHERE ".$tblprefix."language_contents.page_id = ".$id;
					   $rs_del_language = $db->Execute($del_language_qry);
					   
					   
					   
						$language_id=5;  // for russian
							 $del_qry1= "DELETE FROM ".$tblprefix."language_contents 
									WHERE language_id=".$language_id." 
									AND page_id=".$id."
									AND fld_type='free_services'
									";
						$rs_del1 = $db->Execute($del_qry1);
				
					
						$language_id=7; // Montenegro 
						$del_qry2= "DELETE FROM ".$tblprefix."language_contents  
							   WHERE language_id=".$language_id." 
								AND page_id=".$id." 
								AND fld_type='free_services'
								";
						$rs_del2 = $db->Execute($del_qry2);	
					   
					   $okmsg = base64_encode("Usluga uspješno izbrisana. !");
					   header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					   exit;			
		}
} 

?>