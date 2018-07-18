<?php


######################
#
# 	POST SECTION
#
######################
//---------Add property Feature---------

	if($_POST['mode']=='add' && $_POST['act']=='supplier_management' && $_POST['request_page']=='manage_supplier'){
        
		$agency = addslashes(trim($_POST['agency']));
		$supplier_name = addslashes(trim($_POST['supplier_name']));
		$supplier_details  = addslashes(trim($_POST['supplier_details']));
		
				
				if($agency == '' or $agency==0){
				$errmsg = base64_encode('Please Select Agency');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			
			
			if($supplier_name == ''){
				$errmsg = base64_encode('Please Enter Supplier Name');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			
			
			if($supplier_details == ''){
				$errmsg = base64_encode('Please Enter Supplier Details');
				header("Location: admin.php?act=".$_POST['act2']."&errmsg=$errmsg");
				exit;
			}
			
			
			$insert_supplier = "INSERT INTO ".$tblprefix."carsupplier  
										SET
										agency_id = '".$agency."',
										supplier_name = '".$supplier_name."',
										supplier_details = '".$supplier_details."'";
										
				
				$rs_insert = $db->Execute($insert_supplier);
				
				$okmsg = base64_encode("Supplier Information Add successfully. !");
				header("Location: admin.php?okmsg=$okmsg&act=supplier_management");
				exit;
				
	} 



//---------Update Equiipment---------
	   
	 if($_POST['mode'] == 'update' && $_POST['act'] == 'edit_supplier'){
		$id=base64_decode($_POST['id']);
		$agency  = addslashes(trim($_POST['agency']));
		$supplier_name  = addslashes(trim($_POST['supplier_name']));
		$supplier_details  = addslashes(trim($_POST['supplier_details']));
		
		
		if($agency == '' or $agency ==0 ){
			$errmsg = base64_encode('Please Select Agency');
			
			header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
			//header("Location: admin.php?act=edit_supplier&id=".$_POST['id']."&errmsg=$errmsg");
			exit;
		}
		
		
		if($supplier_name == ''){
			$errmsg = base64_encode('Please Enter Supplier Name');
			
			header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
			//header("Location: admin.php?act=edit_supplier&id=".$_POST['id']."&errmsg=$errmsg");
			exit;
		}
		
		if($supplier_details == ''){
			$errmsg = base64_encode('Please Enter Supplier Details');
			
			header("Location: admin.php?okmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
			//header("Location: admin.php?act=edit_supplier&id=".$_POST['id']."&errmsg=$errmsg");
			exit;
		}
		
		
		
		
		$sql_update = "UPDATE ".$tblprefix."carsupplier SET 
												 agency_id = '".$agency."',
												 supplier_name = '".$supplier_name."',
												 supplier_details = '".$supplier_details."'
		         								 WHERE id=".base64_decode($_POST['id']);
		
		$rs = $db->Execute($sql_update);
		
		
		if($rs){
		 $okmsg = base64_encode("Supplier Information Updated successfully. !");
		 header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
		exit;	  
	       }/* END: if($rs){ */
	
	   }
//.............Delet Equipment.........


if($_GET['mode']=='delete' && $_GET['act']=='supplier_management' && $_GET['request_page']=='manage_supplier'){
		$id=base64_decode($_GET['id']);
		
 

		  $del_qry = " DELETE FROM ".$tblprefix."carsupplier WHERE id = ".$id." ";
		
		
		$rs_del = $db->Execute($del_qry);				
				
		
		
		$okmsg = base64_encode("Supplier Information Deleted successfully. !");
					header("Location: admin.php?okmsg=$okmsg&act=supplier_management");
					exit;	  
} 


	   
?>