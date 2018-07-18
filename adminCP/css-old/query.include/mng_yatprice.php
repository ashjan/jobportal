<?php
######################
#
# 	POST SECTION
#
######################
//---------Add Category---------

if($_POST['mode']=='add_price' && $_POST['act']=='manage_yatprice' && $_POST['request_page']=='mng_yatprice')
	{
			$post=$_POST;
			$errmsg = '';
			
			
	        if($post['first_name']==0)
	        {
	        	$errmsg = base64_encode('Please select PM name');
	        	header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
	        	exit();
	        }
	        if($post['agency']==0){
	        	$errmsg = base64_encode('Please select agency');
	        	header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
	        	exit();
	        }
	        if($post['model']==0){
	        	$errmsg = base64_encode('Please select model');
	        	header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
	        	exit();
	        }
	        if($post['standard_start_date']==''){
	        	$errmsg = base64_encode('Please select start date');
	        	header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
	        	exit();
	        }
	        
	        if($post['standard_end_date']==''){
	        	$errmsg = base64_encode('Please select end date');
	        	header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
	        	exit();
	        }
	        if($post['standard_rate_price']==''){
	        	$errmsg = base64_encode('Please enter rate');
	        	header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
	        	exit();
	        }
	        $current_date = strtotime(date("m/d/Y"));	         
	        $start_date =  strtotime($post['standard_start_date']);
	       
	        if($current_date>$start_date)
	        {
	        	$errmsg = base64_encode('You cannot select start date from past');
	        	header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
	        	exit();
	        	
	        }
	        
	        $end_date = strtotime($post['standard_end_date']);
	        if($end_date<$start_date){
	        	$errmsg = base64_encode('End date is less than start date');
	        	header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
	        	exit();	        	
	        }
	        
	        if($post['price_style']==0)
	        {
	        	$rent_start_day = 0;
	        }else {
	        	$rent_start_day = $post['days_in_week'];
	        }
	        $agency_id = $post['agency'];
	        $model = $post['model'];
	        $price_style = $post['price_style'];
	        $start_date = date("Y-m-d",strtotime($post['standard_start_date']));
	        $end_date = date("Y-m-d",strtotime($post['standard_end_date']));
	        $price = $post['standard_rate_price'];
	        $pm_id = $post['first_name'];
	        
	        
	        $duplicate = "SELECT id FROM ".$tblprefix."yatmng_price
	                      WHERE pm_id=".$pm_id."
	                      AND agn_id =".$agency_id."
	                      AND yat_model=".$model."
	                      AND start_date='".$start_date."'
	                      AND end_date ='".$end_date."'
	                      ";
	        
	        
	        $rs_duplicate = $db->Execute($duplicate);
	        $total = $rs_duplicate->RecordCount();
	        if($total>0)
	        {
	        	$errmsg = "Price Rates already exists ";
	        	header("Location:admin.php?act=".$_POST['act']."&errmsg=".$errmsg);
	        	exit();	        	
	        }else {
	        
			/*if($post['prw_prday']==1 and $post['weekdays']==0){
				$errmsg = base64_encode('Please select Renting start day!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['ymodel'] == 0){
				$errmsg = base64_encode('Please select Yacht Model!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['agency_id'] == 0){
				$errmsg = base64_encode('Please select Agency!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
			if($post['start_range'] == ''){
				$errmsg = base64_encode('Please Enter Start date!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['end_range'] == ''){
				$errmsg = base64_encode('Please Enter End Date!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['yatprice'] == ''){
				$errmsg = base64_encode('Please Enter Price!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}*/
			
			
			 	  $sql_category= "INSERT INTO ".$tblprefix."yatmng_price 
														SET
														yat_model = '".$model."',
														agn_id = '".$agency_id."',
														day_weekflag = '".$price_style."',
														rent_start_day = '".$rent_start_day."',
														start_date = '".$start_date."',
														end_date = '".$end_date."',
														price = '".$price."',
														pm_id=".$pm_id."
														";
			 	 
           
			   
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
					$okmsg = base64_encode("Price Set Successfully");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				}else{
				      $okmsg = base64_encode("Price Not Set!!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			}
	}

	if($_POST['mode']=='update' && $_POST['act']=='edit_yachtprice' && $_POST['request_page']=='mng_yatprice')
	{
		
	$post=$_POST;
			$errmsg = '';
			$id = base64_decode($_POST['id']);
			
	        if($post['first_name']==0)
	        {
	        	$errmsg = base64_encode('Please select PM name');
	        	header("Location: admin.php?act=".$_POST['act']."&id=".$_POST['id']."&errmsg=$errmsg");
	        	exit();
	        }
	        if($post['agency']==0){
	        	$errmsg = base64_encode('Please select agency');
	        	header("Location: admin.php?act=".$_POST['act']."&id=".$_POST['id']."&errmsg=$errmsg");
	        	exit();
	        }
	        if($post['model']==0){
	        	$errmsg = base64_encode('Please select model');
	        	header("Location: admin.php?act=".$_POST['act']."&id=".$_POST['id']."&errmsg=$errmsg");
	        	exit();
	        }
	        if($post['standard_start_date']==''){
	        	$errmsg = base64_encode('Please select start date');
	        	header("Location: admin.php?act=".$_POST['act']."&id=".$_POST['id']."&errmsg=$errmsg");
	        	exit();
	        }
	        
	        if($post['standard_end_date']==''){
	        	$errmsg = base64_encode('Please select end date');
	        	header("Location: admin.php?act=".$_POST['act']."&id=".$_POST['id']."&errmsg=$errmsg");
	        	exit();
	        }
	        if($post['standard_rate_price']==''){
	        	$errmsg = base64_encode('Please enter rate');
	        	header("Location: admin.php?act=".$_POST['act']."&id=".$_POST['id']."&errmsg=$errmsg");
	        	exit();
	        }
	        $current_date = strtotime(date("m/d/Y"));	         
	        $start_date =  strtotime($post['standard_start_date']);
	       
	        if($current_date>$start_date)
	        {
	        	$errmsg = base64_encode('You cannot select start date from past');
	        	header("Location: admin.php?act=".$_POST['act']."&id=".$_POST['id']."&errmsg=$errmsg");
	        	exit();
	        	
	        }
	        
	        $end_date = strtotime($post['standard_end_date']);
	        if($end_date<$start_date){
	        	$errmsg = base64_encode('End date is less than start date');
	        	header("Location: admin.php?act=".$_POST['act']."&id=".$_POST['id']."&errmsg=$errmsg");
	        	exit();	        	
	        }
	        
	        if($post['price_style']==0)
	        {
	        	$rent_start_day = 0;
	        }else {
	        	$rent_start_day = $post['days_in_week'];
	        }
	        $agency_id = $post['agency'];
	        $model = $post['model'];
	        $price_style = $post['price_style'];
	        $start_date = date("Y-m-d",strtotime($post['standard_start_date']));
	        $end_date = date("Y-m-d",strtotime($post['standard_end_date']));
	        $price = $post['standard_rate_price'];
	        $pm_id = $post['first_name'];
	        
	        
	        $duplicate = "SELECT id FROM ".$tblprefix."yatmng_price
	                      WHERE pm_id=".$pm_id."
	                      AND agn_id =".$agency_id."
	                      AND yat_model=".$model."
	                      AND start_date='".$start_date."'
	                      AND end_date ='".$end_date."'
	                      AND id !=".$id."	                      
	                      ";
	        
	        
	        
	        $rs_duplicate = $db->Execute($duplicate);
	        $total = $rs_duplicate->RecordCount();
	        if($total>0)
	        {
	        	$errmsg = "Price Rates already exists ";
	        	header("Location:admin.php?act=".$_POST['act']."&id=".$_POST['id']."&errmsg=".$errmsg);
	        	exit();	        	
	        }else {
	        
			/*if($post['prw_prday']==1 and $post['weekdays']==0){
				$errmsg = base64_encode('Please select Renting start day!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['ymodel'] == 0){
				$errmsg = base64_encode('Please select Yacht Model!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['agency_id'] == 0){
				$errmsg = base64_encode('Please select Agency!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
			if($post['start_range'] == ''){
				$errmsg = base64_encode('Please Enter Start date!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['end_range'] == ''){
				$errmsg = base64_encode('Please Enter End Date!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['yatprice'] == ''){
				$errmsg = base64_encode('Please Enter Price!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}*/
			
			
			 	  $sql_category= "UPDATE ".$tblprefix."yatmng_price 
														SET
														yat_model = '".$model."',
														agn_id = '".$agency_id."',
														day_weekflag = '".$price_style."',
														rent_start_day = '".$rent_start_day."',
														start_date = '".$start_date."',
														end_date = '".$end_date."',
														price = '".$price."',
														pm_id=".$pm_id."
														WHERE id=".$id."
														";
			 	 
			 	  
           
			   
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
					$okmsg = base64_encode("Price Set Successfully");
					header("Location: admin.php?okmsg=$okmsg&act=manage_yatprice");
					exit;	  
				}else{
				      $okmsg = base64_encode("Price Not Set!!");
					header("Location: admin.php?okmsg=$okmsg&act=manage_yatprice");
					exit;
				} 
				
			}
				
			} 
	/*if($_POST['mode']=='add' && $_POST['act']=='manage_yatprice' && $_POST['request_page']=='mng_yatprice')
	{
			$post=$_POST;
			
	        $facility_name = addslashes(trim($_POST['facility_name']));
			$property_fac_category = addslashes(trim($_POST['property_fac_category']));
			
		
		
			
			
			if($post['prw_prday']==1 and $post['weekdays']==0){
				$errmsg = base64_encode('Please select Renting start day!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['ymodel'] == 0){
				$errmsg = base64_encode('Please select Yacht Model!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['agency_id'] == 0){
				$errmsg = base64_encode('Please select Agency!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
			if($post['start_range'] == ''){
				$errmsg = base64_encode('Please Enter Start date!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['end_range'] == ''){
				$errmsg = base64_encode('Please Enter End Date!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['yatprice'] == ''){
				$errmsg = base64_encode('Please Enter Price!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			
			 	  $sql_category= "INSERT INTO ".$tblprefix."yatmng_price 
														SET
														yat_model = '".$post['ymodel']."',
														agn_id = '".$post['agency_id']."',
														day_weekflag = '".$post['prw_prday']."',
														rent_start_day = '".$post['weekdays']."',
														start_date = '".$post['start_range']."',
														end_date = '".$post['end_range']."',
														price = '".$post['yatprice']."'";
           
			   
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
					$okmsg = base64_encode("Price Set Successfully");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				}else{
				      $okmsg = base64_encode("Price Not Set!!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;
				} 
				
			} */

	
	 	
		
		if($_POST['mode']=='update' && $_POST['act']=='change_yatprices' && $_POST['request_page']=='mng_yatprice')
	{
	
	$id=base64_decode($_POST['id']);
			$post=$_POST;
	        $facility_name = addslashes(trim($_POST['facility_name']));
			$property_fac_category = addslashes(trim($_POST['property_fac_category']));
			
		
		
			
			
			if($post['prw_prday']==1 and $post['daysofweek']==0){
				$errmsg = base64_encode('Please select Renting start day!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['ymodel'] == 0){
				$errmsg = base64_encode('Please select Yacht Model!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['agency_id'] == 0){
				$errmsg = base64_encode('Please select Agency!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
	 
			if($post['start_range'] == ''){
				$errmsg = base64_encode('Please Enter Start date!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['end_range'] == ''){
				$errmsg = base64_encode('Please Enter End Date!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			if($post['yatprice'] == ''){
				$errmsg = base64_encode('Please Enter Price!!');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
			}
			
			
			 	  $sql_category= "UPDATE ".$tblprefix."yatmng_price 
														SET
														yat_model = '".$post['ymodel']."',
														agn_id = '".$post['agency_id']."',
														day_weekflag = '".$post['prw_prday']."',
														rent_start_day = '".$post['daysofweek']."',
														start_date = '".$post['start_range']."',
														end_date = '".$post['end_range']."',
														price = '".$post['yatprice']."'
														WHERE id='".$id."'
														";
           
			   
				$rs_category = $db->Execute($sql_category);
				
				if($rs_category){
					$okmsg = base64_encode("Price Set Successfully");
					header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
					exit;	  
				}else{
				      $okmsg = base64_encode("Price Not Set!!");
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
if($_GET['mode']=='delete' && $_GET['act']=='manage_yatprice' && $_GET['request_page']=='mng_yatprice'){
		$id=base64_decode($_GET['id']);
		$del_qry = " DELETE FROM ".$tblprefix."yatmng_price WHERE id = ".$id;
		$rs_del = $db->Execute($del_qry);					
		
		$okmsg = base64_encode("Price Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=manage_yatprice");
					exit;	  
} 

?>