<?php	


if($_POST['mode']=='add' && $_POST['act']=='manage_rates1' && $_POST['request_page']=='rates_management1'){

        $room_type_id = $_POST['room_type'];
		$first_name          = addslashes(trim($_POST['first_name']));
		$property_name       = $_POST['property_id'];
		$standard_start_date = addslashes(trim($_POST['standard_start_date']));
		$standard_end_date   = addslashes(trim($_POST['standard_end_date']));
		$standard_rate_price = addslashes(trim($_POST['standard_rate_price']));
		$single_use_option   = addslashes(trim($_POST['single_use_option']));
		$single_rate_price   = addslashes(trim($_POST['single_rate_price']));
		$rooms_for_sale      = addslashes(trim($_POST['stndrd_rooms_for_sale']));
		if(empty($rooms_for_sale)){$rooms_for_sale=0;}elseif($rooms_for_sale==''){$rooms_for_sale=0;}
		
		$advance_use_option  = 0;
		$advance_start_date  = '';
		$advance_end_date = '';
		$advance_rate_price = 0;
		$single_adv_use_option  = 0;
		$single_adv_rate_price = 0;
		$strooms_for_sale = 0;
		if(empty($strooms_for_sale)){$strooms_for_sale=0;}elseif($strooms_for_sale==''){$strooms_for_sale=0;}
		
		$advrooms_for_sale = addslashes(trim($_POST['advnc_rooms_for_sale']));
			
			if($single_use_option==0){
              $standard_date_price=0;
			}
       
			if($standard_start_date == ''){
				//$errmsg = base64_encode('Please Enter Standard Start dates');
				$errmsg = base64_encode('Molimo unesite pocetni datum za osnovnu cijenu');
				header("Location: admin.php?act=manage_rates1&errmsg=$errmsg");
				exit;
			}
			
			if($room_type_id == 0){
				//$errmsg = base64_encode('Please Enter Room Type');
				$errmsg = base64_encode('Molimo unesite tip sobe');
				header("Location: admin.php?act=manage_rates1&errmsg=$errmsg");
				exit;
			}
			
			if($standard_end_date == ''){
				$errmsg = base64_encode('Please Enter Standard End date ');
				header("Location: admin.php?act=manage_rates1&errmsg=$errmsg");
				exit;
			}
			if($standard_rate_price == ''){
				//$errmsg = base64_encode('Please Enter Standard Rate Price ');
				$errmsg = base64_encode('Molimo unesite krajnji datum za osnovnu cijenu');
				header("Location: admin.php?act=manage_rates1&errmsg=$errmsg");
				exit;
			}elseif(!is_numeric($standard_rate_price)){
			
			   //$errmsg = base64_encode('Please Enter Numeric Value In  Standard Rate Price ');
			   $errmsg = base64_encode('Osnovna cijena mora da bude numericka ');
				header("Location: admin.php?act=manage_rates1&errmsg=$errmsg");
				exit;
			
			}
			
			/*if($single_start_date == '' and $single_use_option==1 ){
				$errmsg = base64_encode('Please Enter Single Start Date');
				header("Location: admin.php?act=manage_rates&errmsg=$errmsg");
				exit;
			}
			
			if($single_end_date == '' and $single_use_option==1 ){
				$errmsg = base64_encode('Please Enter Single End Date');
				header("Location: admin.php?act=manage_rates&errmsg=$errmsg");
				exit;
			}*/
			
			if($single_use_option==0){
			$single_rate_price=0;
			}
			if($advance_use_option==0){
			$advance_rate_price=0;
			}
			if($single_adv_use_option==0){
			$single_adv_rate_price = 0;
			}
			
			if($single_rate_price == '' and $single_use_option==1){
				//$errmsg = base64_encode('Please Enter Single Rate Price ');
				$errmsg = base64_encode('Molimo unesite cijenu za jednu osobu');
				header("Location: admin.php?act=manage_rates1&errmsg=$errmsg");
				exit;
			}elseif(!is_numeric($single_rate_price) and $single_user_option==1){
			
			     //$errmsg = base64_encode('Please Enter Numeric Value In  Single Rate Price ');
			   $errmsg = base64_encode('Cijena mora biti numericka ');
				header("Location: admin.php?act=manage_rates1&errmsg=$errmsg");
				exit;
			
			}
			
			
		   
		    $check_standard_start_date=strtotime($standard_start_date);
			$check_standard_end_date=strtotime($standard_end_date);
			
			if($check_standard_start_date >= $check_standard_end_date){
			    //$errmsg = base64_encode('Standard  Start date should must be less than Standard End date'); 
				$errmsg = base64_encode('Pocetni datum za osnovnu cijenu mora biti manji od krajnjeg datuma');
				header("Location: admin.php?act=manage_rates&errmsg=$errmsg");
				exit;
			}
			
			/*$check_advance_start_date=strtotime($advance_start_date);
			$check_advance_end_date=strtotime($advance_end_date);
			
			if($check_advance_start_date >= $check_advance_end_date){
			    //$errmsg = base64_encode('Advance Start date should must be less than  Advance End date');
				$errmsg = base64_encode('Pocetni datum za naprednu cijenu mora biti manji od krajnjeg datuma');
				header("Location: admin.php?act=manage_rates&errmsg=$errmsg");
				exit;
			}*/
			
			
			
			/*if($standard_start_date ==''){
				$standard_start_date = date("m/d/Y");
			}
			if($standard_end_date ==''){
				$standard_end_date = date("m/d/Y");
			}
			if($single_start_date ==''){
				$single_start_date = date("m/d/Y");
			}
			if($single_end_date ==''){
				$single_end_date = date("m/d/Y");
			}
		    if($advance_start_date ==''){
				$advance_start_date = date("m/d/Y");
			}	
			
			if($advance_end_date ==''){
				$advance_end_date = date("m/d/Y");
			}
			if($single_adv_start_date ==''){
				$single_adv_start_date = date("m/d/Y");
			}
			if($single_adv_end_date ==''){
				$single_adv_end_date = date("m/d/Y");
			}*/
		
			/*$insert_tariff_cal = "INSERT INTO ".$tblprefix."standard_rates1 
			                      SET
			                      room_type_id ='".$room_type_id."',
			                      pm_id ='".$first_name."',
			                      property_id ='".$property_name."',
			                      single_use_option ='".$single_use_option."',
			                      single_adv_use_option = '".$single_adv_use_option."',
			                      rooms_for_sale ='".$rooms_for_sale."',
								  stndrd_rooms_for_sale = '".$strooms_for_sale."',
								  adv_rooms_for_sale = '".$advrooms_for_sale."',
								  advance_use_option = '".$advance_use_option."'
			                     ";
			                     */
			
         					 $insert_tariff_cal = "INSERT INTO ".$tblprefix."standard_rates  
										SET
										room_type_id ='".$room_type_id."',
										pm_id ='".$first_name."',
										property_id ='".$property_name."',
										standard_start_date ='".date("Y-m-d",strtotime($standard_start_date))."',
										standard_end_date ='".date("Y-m-d",strtotime($standard_end_date))."',
										standard_rate_price ='".$standard_rate_price."',
										single_use_option ='".$single_use_option."',
										single_rate_price ='".$single_rate_price."',
										rooms_for_sale ='".$rooms_for_sale."',
										stndrd_rooms_for_sale = '".$strooms_for_sale."',
										adv_rooms_for_sale = '".$advrooms_for_sale."',
										advance_use_option = '".$advance_use_option."',
										advance_start_date  = '".date("m/d/Y",strtotime($advance_start_date))."',
										advance_end_date = '".date("m/d/Y",strtotime($advance_end_date))."',
										advance_rate_price ='".$advance_rate_price."',
										single_adv_use_option = '".$single_adv_use_option."',
										single_adv_rate_price ='".$single_adv_rate_price."'										
										";
				$rs_tariff      =  $db->Execute($insert_tariff_cal);
				
				$last_insert_id =  $db->Insert_ID('tbl_standard_rates','id'); 
				$ranges = DatesBetween($standard_start_date,$standard_end_date);
				
				$query_check_update = "SELECT standard_date FROM ".$tblprefix."changed_standard_rates 
				                       WHERE property_id=".$property_name." 
				                       AND room_type_id=".$room_type_id."
				                       AND pm_id=".$first_name."
				                       ";
				$rs_check_update = $db->Execute($query_check_update);
				$check_date_array = array();
				$rs_check_update->MoveFirst();
				while (!$rs_check_update->EOF) {
					$check_date_array[] = $rs_check_update->fields['standard_date'];
					$rs_check_update->MoveNext();
				}
				
				if(!empty($ranges))
				{
					for($i=0;$i<count($ranges);$i++){
						if(in_array($ranges[$i],$check_date_array)){
							
							$update_query = "UPDATE ".$tblprefix."changed_standard_rates 
							                 SET standard_rate_price =".$standard_rate_price.",
							                 rooms_for_sale =".$rooms_for_sale."
							                 WHERE standard_date='".$ranges[$i]."'
							                 AND room_type_id=".$room_type_id."
							                 AND property_id=".$property_name."
							                 AND pm_id=".$first_name."
							                 ";
							
							$db->Execute($update_query);
							
						}else {
						$insert_standard_date = "INSERT INTO ".$tblprefix."changed_standard_rates
						                         SET
						                         room_type_id =".$room_type_id.",
						                         pm_id = ".$first_name.",
						                         standard_rate_price =".$standard_rate_price.",
						                         property_id =".$property_name.",
						                         standard_rate_id ='".$last_insert_id."',
						                         standard_date = '".$ranges[$i]."',
						                         rooms_for_sale = ".$rooms_for_sale;
						$db->Execute($insert_standard_date);
					}
						
					
					
				}
				}
				
				$query_check_advance_update ="SELECT advance_date FROM ".$tblprefix."changed_advance_rates 
				                       WHERE property_id=".$property_name." 
				                       AND room_type_id=".$room_type_id."
				                       AND pm_id=".$first_name."
				                       ";
				
				$rs_check_advance_update = $db->Execute($query_check_advance_update);
				$check_advance_date_array = array();
				$rs_check_advance_update->MoveFirst();
				while (!$rs_check_advance_update->EOF) {
					$check_advance_date_array[] = $rs_check_advance_update->fields['advance_date'];
					$rs_check_advance_update->MoveNext();
				}
				
				/*$last_insert_id =  $db->Insert_ID('tbl_standard_rates1','id'); 
				
				if(!empty($standard_start_date) && !empty($standard_end_date)){	
					$standard_days = DatesBetween($standard_start_date,$standard_end_date);
                    if(!empty($standard_days)){
					foreach ($standard_days as $s_days){
						$insert_standard_date = "INSERT INTO ".$tblprefix."standard_date
						                         SET
						                         room_type_id ='".$room_type_id."',
						                         pm_id = '".$first_name."',
						                         standard_rate_price ='".$standard_rate_price."',
						                         standard_rate_id ='".$last_insert_id."',
						                         standard_date = '".$s_days."'
						                         ";
						
						$db->Execute($insert_standard_date);
					}
                    }
				}
				
				
					if(!empty($single_start_date) && !empty($single_end_date)){	
					$single_days = DatesBetween($single_start_date,$single_end_date);
					if(!empty($single_days)){
					foreach ($single_days as $si_days){
						$insert_single_date = "INSERT INTO ".$tblprefix."single_date
						                         SET
						                         room_type_id ='".$room_type_id."',
						                         pm_id = '".$first_name."',
						                         single_rate_price ='".$single_rate_price."',
						                         standard_rate_id ='".$last_insert_id."',
						                         single_date = '".$si_days."'
						                         ";
						$db->Execute($insert_single_date);
					}
					}
					}
				
				
					if(!empty($advance_start_date) && !empty($advance_end_date)){	
					$adv_days = DatesBetween($advance_start_date,$advance_end_date);
					if(!empty($adv_days)){
					foreach ($adv_days as $a_days){
						$insert_adv_date = "INSERT INTO ".$tblprefix."adv_use_date
						                         SET
						                         room_type_id ='".$room_type_id."',
						                         pm_id = '".$first_name."',
						                         advance_rate_price ='".$advance_rate_price."',
						                         standard_rate_id ='".$last_insert_id."',
						                         adv_use_date = '".$a_days."'
						                         ";
						
						$db->Execute($insert_adv_date);
					}
					}
					}
				
				
				
				if(!empty($single_adv_start_date) && !empty($single_adv_end_date)){		
					$adv_single_days = DatesBetween($single_adv_start_date,$single_adv_end_date);
					if(!empty($adv_single_days)){
					foreach ($adv_single_days as $as_days){
						$insert_s_adv_date = "INSERT INTO ".$tblprefix."adv_single_date
						                         SET
						                         room_type_id ='".$room_type_id."',
						                         pm_id = '".$first_name."',
						                         single_adv_rate_price ='".$single_adv_rate_price."',
						                         standard_rate_id ='".$last_insert_id."',
						                         adv_single_date = '".$as_days."'
						                         ";
						
						$db->Execute($insert_s_adv_date);
					}
					}
				}
				*/
				
				if($rs_tariff){
				//$okmsg = base64_encode("Standard Rates Add Successfully !");
				$okmsg = base64_encode("Osnovna cijena uspješno dodata !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_rates1");
					exit;
				}else{
				
				   //$errmsg = base64_encode('Standard Rates Not Added ');
				   $errmsg = base64_encode('Osnovna cijena nije dodata');
				      header("Location: admin.php?act=manage_rates1&errmsg=$errmsg");
				      exit;
				
				}					

} 


//Update Section

if($_POST['mode']=='update' && $_POST['act']=='edit_rates1' && $_POST['request_page']=='rates_management1'){
		$room_type_id = addslashes(trim($_POST['room_type']));
		$first_name = addslashes(trim($_POST['first_name']));
		$property_name = addslashes(trim($_POST['property_name']));
		$standard_start_date = addslashes(trim($_POST['standard_start_date']));
		$standard_end_date = addslashes(trim($_POST['standard_end_date']));
		$standard_rate_price = addslashes(trim($_POST['standard_rate_price']));
		$single_use_option = addslashes(trim($_POST['single_use_option']));
		$single_rate_price = addslashes(trim($_POST['single_rate_price']));
		$rooms_for_sale = addslashes(trim($_POST['stndrd_rooms_for_sale']));
        //$rooms_for_sale = addslashes(trim($_POST['rooms_for_sale']));
		if(empty($rooms_for_sale)){$rooms_for_sale=0;}elseif($rooms_for_sale==''){$rooms_for_sale=0;}
		$advance_use_option  = addslashes(trim($_POST['advance_use_option']));
		$advance_start_date  = addslashes(trim($_POST['advance_start_date']));
		$advance_end_date = addslashes(trim($_POST['advance_end_date']));
		$advance_rate_price = addslashes(trim($_POST['advance_rate_price']));
		$single_adv_use_option  = addslashes(trim($_POST['single_adv_use_option']));
		$single_adv_rate_price = addslashes(trim($_POST['single_adv_rate_price']));
		$advrooms_for_sale = addslashes(trim($_POST['advnc_rooms_for_sale']));
		
		$id=base64_decode($_POST['id']);
		
		//validation start
		    if($standard_start_date == ''){
				//$errmsg = base64_encode('Please Enter Standard Start Rate');
				$errmsg = base64_encode('Please Enter Standard Start Rate');
				header("Location: admin.php?act=edit_rates&errmsg=".$errmsg."&id=".base64_encode($id)."");
				exit;
			}
			
		    if($room_type_id == 0){
				//$errmsg = base64_encode('Please Enter Room Type');
				$errmsg = base64_encode('Molimo unesite tip sobe');
				header("Location: admin.php?act=edit_rates&errmsg=".$errmsg."&id=".base64_encode($id)."");
				exit;
			}
				
			if($standard_end_date == ''){
				//$errmsg = base64_encode('Please Enter Standard End Rate');
				$errmsg = base64_encode('Molimo unesite krajnji datum za osnovnu cijenu');
				header("Location: admin.php?act=edit_rates&errmsg=".$errmsg."&id=".base64_encode($id)."");
				exit;
			}
			if($standard_rate_price == ''){
				//$errmsg = base64_encode('Please Enter Standard Rate Price ');
				$errmsg = base64_encode('Molimo unesite osnovnu cijenu ');
				header("Location: admin.php?act=edit_rates&errmsg=".$errmsg."&id=".base64_encode($id)."");
				exit;
			}elseif(!is_numeric($standard_rate_price)){
			
			  //$errmsg = base64_encode('Please Enter Numeric Value In  Standard Rate Price ');
			   $errmsg = base64_encode('Osnovna cijena mora da bude numericka');
				header("Location: admin.php?act=edit_rates&errmsg".$errmsg."&id=".base64_encode($id)."");
				exit;
			
			}
			
			if($first_name == '' or $first_name == 0){
				//$errmsg = base64_encode('Please Select Valid PM ');
				$errmsg = base64_encode('Molimo izaberite postojeceg vlasnika ');
				header("Location: admin.php?act=edit_rates&errmsg=".$errmsg."&id=".base64_encode($id)."");
				exit;
			}
			
			if($single_rate_price == ''){
				//$errmsg = base64_encode('Please Enter Single Rate Price ');
				$errmsg = base64_encode('Molimo unesite cijenu za jednu osobu ');
				header("Location: admin.php?act=edit_rates&errmsg=".$errmsg."&id=".base64_encode($id)."");
				exit;
			}elseif(!is_numeric($single_rate_price)){
			
			  //$errmsg = base64_encode('Please Enter Numeric Value In Single Rate Price '); 
			   $errmsg = base64_encode('Cijena mora biti numericka');
				header("Location: admin.php?act=edit_rates&errmsg".$errmsg."&id=".base64_encode($id)."");
				exit;
			
			}
			
			//-------
			
			$check_standard_start_date=strtotime($standard_start_date);
			$check_standard_end_date=strtotime($standard_end_date);
			
			if($check_standard_start_date >= $check_standard_end_date){
			    //$errmsg = base64_encode('Standard  Start date should must be less than Standard End date'); 
				$errmsg = base64_encode('Pocetni datum za osnovnu cijenu mora biti manji od krajnjeg datuma');
				header("Location: admin.php?act=manage_rates&errmsg=$errmsg");
				exit;
			}
			
			
			//-------
			
			
			
			if($advance_use_option==0){
				$single_adv_use_option=0;
			}
			
			if($single_use_option==0){
			$single_rate_price=0;
			}
			if($advance_use_option==0){
			$advance_rate_price=0;
			}
			if($single_adv_use_option==0){
			$single_adv_rate_price = 0;
			}
			if($advance_use_option!=0){
				$advance_start_date = date("Y-m-d",strtotime($advance_start_date));
				$advance_end_date = date("Y-m-d",strtotime($advance_end_date));
			}else {
				
				$advance_start_date='';
				$advance_end_date = '';
			}
		
		//validation ends

        
        
		$_SESSION[room_type_id] = $room_type_id;
		$_SESSION[first_name] = $first_name;
		$_SESSION[property_name] = $property_name;
		$_SESSION[standard_start_date] = $standard_start_date;
		$_SESSION[standard_end_date ] = $standard_end_date;
		$_SESSION[standard_rate_price] = $standard_rate_price; 
		$_SESSION[single_use_option] = $single_use_option;
		$_SESSION[single_rate_price] = $single_rate_price;
		$_SESSION[rooms_for_sale ] = $rooms_for_sale;
		$_SESSION[advance_use_option] = $advance_use_option; 
		$_SESSION[advance_start_date] = $advance_start_date;  
		$_SESSION[advance_end_date] = $advance_end_date; 
		$_SESSION[advance_rate_price] = $advance_rate_price;
		$_SESSION[single_adv_use_option] = $single_adv_use_option; 
		$_SESSION[single_adv_rate_price] = $single_adv_rate_price; 

				
                $qry_standard_select = "SELECT id FROM ".$tblprefix."standard_rates 
                                       WHERE standard_start_date='".$standard_start_date."'
                                       AND standard_end_date ='".$standard_end_date."'
                                       AND standard_rate_price=".$standard_rate_price."
                                       AND id=".$id."
                                       ";
                $rs_standard_select = $db->Execute($qry_standard_select);
                $total_count = $rs_standard_select->RecordCount();
                
                $query_check_update = "SELECT standard_date FROM ".$tblprefix."changed_standard_rates 
				                       WHERE property_id=".$property_name." 
				                       AND room_type_id=".$room_type_id."
				                       AND pm_id=".$first_name."
				                       AND standard_rate_id=".$id."";
				
				$rs_check_update = $db->Execute($query_check_update);
				$check_date_array = array();
				$rs_check_update->MoveFirst();
				while (!$rs_check_update->EOF) {
					$check_date_array[] = $rs_check_update->fields['standard_date'];
					$rs_check_update->MoveNext();
				}
				
                if($total_count==0)
                {
                	
                	/*$qry_del_adv_use_date = "DELETE FROM ".$tblprefix."changed_standard_rates WHERE standard_rate_id=".$id."";
			        $rs_delete_adv_use_date = $db->Execute($qry_del_adv_use_date);*/
			        $standard_ranges = DatesBetween($standard_start_date,$standard_end_date);
			        
			        for($i=0;$i<count($standard_ranges);$i++){
			        	if(in_array($standard_ranges[$i],$check_date_array)){
							
							 $update_query = "UPDATE ".$tblprefix."changed_standard_rates 
							                 SET standard_rate_price =".$standard_rate_price.",
							                 rooms_for_sale =".$rooms_for_sale."
							                 WHERE standard_date='".$standard_ranges[$i]."'
							                 AND room_type_id=".$room_type_id."
							                 AND property_id=".$property_name."
							                 AND pm_id=".$first_name."
							                 AND standard_rate_id=".$id."
							                 ";
							
							
							
							
							$db->Execute($update_query);
							
						}else {
			        	$insert_standard_date = "INSERT INTO ".$tblprefix."changed_standard_rates
						                         SET
						                         room_type_id =".$room_type_id.",
						                         pm_id = ".$first_name.",
						                         standard_rate_price =".$standard_rate_price.",
						                         property_id =".$property_name.",
						                         standard_rate_id ='".$id."',
						                         standard_date = '".$standard_ranges[$i]."',
						                         rooms_for_sale = ".$rooms_for_sale."
						                         ";
						    
													 
												 
												 
						$db->Execute($insert_standard_date);
			        	
			        }
                	
                }
                }
                
               if($advance_use_option!=0){
               $qry_advance_select = "SELECT id FROM ".$tblprefix."standard_rates 
                                       WHERE advance_start_date='".$advance_start_date."'
                                       AND advance_end_date ='".$advance_end_date."'
                                       AND advance_rate_price=".$advance_rate_price."
                                       AND id=".$id."
                                       ";
                $rs_advance_select = $db->Execute($qry_advance_select);
                
                $total_adv_count = $rs_advance_select->RecordCount();
                $query_check_advance_update ="SELECT advance_date FROM ".$tblprefix."changed_advance_rates 
				                       WHERE property_id=".$property_name." 
				                       AND room_type_id=".$room_type_id."
				                       AND pm_id=".$first_name."
				                       AND standard_rate_id=".$id."
				                       ";
				
				$rs_check_advance_update = $db->Execute($query_check_advance_update);
				$check_advance_date_array = array();
				$rs_check_advance_update->MoveFirst();
				while (!$rs_check_advance_update->EOF) {
					$check_advance_date_array[] = $rs_check_advance_update->fields['advance_date'];
					$rs_check_advance_update->MoveNext();
				}
                if($total_adv_count==0)
                {
                	/*$qry_del_adv_use_date = "DELETE FROM ".$tblprefix."changed_advance_rates WHERE standard_rate_id=".$id."";
			        $rs_delete_adv_use_date = $db->Execute($qry_del_adv_use_date);*/
			        $advance_ranges = DatesBetween($advance_start_date,$advance_end_date);
			        
			     
				
			        for($i=0;$i<count($advance_ranges);$i++){
			        	if(in_array($advance_ranges[$i],$check_advance_date_array)){
							
							$update_advance_query = "UPDATE ".$tblprefix."changed_advance_rates 
							                 SET advance_rate_price =".$advance_rate_price.",
							                 adv_rooms_for_sale =".$advrooms_for_sale."
							                 WHERE advance_date='".$advance_ranges[$i]."'
							                 AND room_type_id=".$room_type_id."
							                 AND property_id=".$property_name."
							                 AND pm_id=".$first_name."
							                 ";
							// echo $update_advance_query;exit();
							
							$db->Execute($update_advance_query);
							
						}else {
						$insert_advance_date = "INSERT INTO ".$tblprefix."changed_advance_rates
						                         SET
						                         room_type_id =".$room_type_id.",
						                         pm_id = ".$first_name.",
						                         advance_rate_price =".$advance_rate_price.",
						                         property_id =".$property_name.",
						                         standard_rate_id ='".$id."',
						                         advance_date = '".$advance_ranges[$i]."',
						                         adv_rooms_for_sale = ".$advrooms_for_sale."
						                         ";
						$db->Execute($insert_advance_date);
			        	
			        }
                	
                }
               }
               }
		
					          $insert_tariff_cal = "UPDATE ".$tblprefix."standard_rates  
													SET
													room_type_id ='".$room_type_id."',
													pm_id ='".$first_name."',
													property_id ='".$property_name."',
													standard_start_date ='".date("Y-m-d",strtotime(trim($standard_start_date)))."',
													standard_end_date ='".date("Y-m-d",strtotime(trim($standard_end_date)))."',
													standard_rate_price ='".trim($standard_rate_price)."',
													single_use_option ='".trim($single_use_option)."',
													single_rate_price = '".trim($single_rate_price)."',
													rooms_for_sale ='".trim($rooms_for_sale)."',
										            stndrd_rooms_for_sale = '".trim($rooms_for_sale)."',
													advance_use_option = '".trim($advance_use_option)."',
													advance_start_date  = '".date("Y-m-d",strtotime(trim($advance_start_date)))."',
													advance_end_date = '".date("Y-m-d",strtotime(trim($advance_end_date)))."',
													advance_rate_price = '".trim($advance_rate_price)."',
													adv_rooms_for_sale = '".trim($advrooms_for_sale)."',
													single_adv_use_option = '".trim($single_adv_use_option)."',
													single_adv_rate_price ='".trim($single_adv_rate_price)."'
													WHERE
													id=".$id
													;
													
							
													
													
        unset($_SESSION[room_type_id]);  
		unset($_SESSION[first_name]);
		unset($_SESSION[property_name]);
		unset($_SESSION[standard_start_date]);
		unset($_SESSION[standard_end_date ]);
		unset($_SESSION[standard_rate_price]); 
		unset($_SESSION[single_use_option]);
		unset($_SESSION[single_rate_price]);
		unset($_SESSION[rooms_for_sale]);
		unset($_SESSION[advance_use_option]); 
		unset($_SESSION[advance_start_date]);  
		unset($_SESSION[advance_end_date]); 
		unset($_SESSION[advance_rate_price]);
		unset($_SESSION[single_adv_use_option]); 
		unset($_SESSION[single_adv_rate_price]); 
				$rs_tariff = $db->Execute($insert_tariff_cal);
				if($rs_tariff){
				//$okmsg = base64_encode("Standard Rates Updated successfully. !");
				$okmsg = base64_encode("Osnovna cijena uspješno ažurirana. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_rates1");
					exit;
					}else{
					 //$errmsg = base64_encode('Standard Rates Not Updated ');
					  $errmsg = base64_encode('Osnovna cijena nije ažurirana ');
				      header("Location: admin.php?act=edit_rates&errmsg=$errmsg");
				      exit;
					}
} 

// Delete Function

if($_GET['mode']=='delete' && $_GET['act']=='manage_rates1' && $_GET['request_page']=='rates_management1'){
	$id=base64_decode($_GET['id']);

		$del_qry = " DELETE FROM ".$tblprefix."standard_rates WHERE id =".$id;
		
		$rs_delete = $db->Execute($del_qry);
		
		    /*$qry_del_adv_single_date = "DELETE FROM ".$tblprefix."adv_single_date WHERE standard_rate_id='".$id."'";
			$rs_delete_adv_single_date = $db->Execute($qry_del_adv_single_date);
			
			$qry_del_adv_use_date = "DELETE FROM ".$tblprefix."adv_use_date WHERE standard_rate_id='".$id."'";
			$rs_delete_adv_use_date = $db->Execute($qry_del_adv_use_date);
			
			$qry_del_single_date = "DELETE FROM ".$tblprefix."single_date WHERE standard_rate_id='".$id."'";
			$rs_delete_single_date = $db->Execute($qry_del_single_date);
			
			
			$qry_del_standard_date = "DELETE FROM ".$tblprefix."standard_date WHERE standard_rate_id='".$id."'";
			$rs_delete_standard_date = $db->Execute($qry_del_standard_date);
			*/
			
		if($rs_delete){
					     //$okmsg = base64_encode("Standard Rates Record Deleted successfully!"); 
					   $okmsg = base64_encode("Osnovna cijena uspješno ažurirana!");
					   header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					   exit;			
		}
		else{
		//$okmsg = base64_encode("Unable to Delete!");
		$okmsg = base64_encode("Cijena nije izbrisana!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		}
  
}

function DatesBetween($startDate, $endDate){

	$dateMonthYearArr = array();
	$fromDateTS = strtotime($startDate);
	$toDateTS = strtotime($endDate);

	for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24)) {
		// use date() and $currentDateTS to format the dates in between
		$currentDateStr = date('Y-m-d',$currentDateTS);
		$dateMonthYearArr[] = $currentDateStr;
		//print $currentDateStr."<br />";
	}


	return $dateMonthYearArr;
} 	
	
?>	
	
