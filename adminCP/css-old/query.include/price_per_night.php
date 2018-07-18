<?php
if($_POST['mode']=='add' && $_POST['act']=='price_per_night' && $_POST['request_page']=='price_per_night'){

$post=$_POST;
/*echo '<pre>';
print_r($post);
exit;*/
$error='';


$start_rating = addslashes($post['price_per_night']);

				if($post['price_per_night']==''){
					$error="Price Per Night is compulsory<br>";
				}
				
						
		if($error!=''){
					$msg=base64_encode($error);
					header("Location: admin.php?okmsg=$msg&act=".$post['act']);
		}else{

	
					echo  $start_rat  =  "INSERT INTO ".$tblprefix."price_per_night SET 
																price_per_night = '".$post['price_per_night']."',
													            sort_order= '".$post['sort_order']."'																							                                                                "; 
	 					
							$start_rat_res= $db->Execute($start_rat);
							
							
			if($run_query)
			{
										

		// collect all the posted values and get the translated language ids 
		$my_post = $_POST;
		$id = mysql_insert_id();
		
		/*echo '<pre>';
		print_r($my_post);
		echo $id;*/
		
		// Update or Add the language content for Property Name
		foreach($my_post as $key=>$val){}  // foreach($my_post as $key=>$val)

		// Update or Add the language content for Description
		foreach($my_post as $key=>$val){}  // foreach($my_post as $key=>$val)
								
								
								
								
								
								$okmsg = base64_encode("Price Per Night inserted successfully.!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
							else
							{
								$okmsg = base64_encode("Price Per Night Added Succesfully");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}
							
							echo "asdasd";

                            exit;

}

}




	


/****************************************************************************
*																			*
*                            Update Events 									*
*																			*
****************************************************************************/




if($_POST['mode']=='update' && $_POST['act']=='price_per_night' && $_POST['request_page']=='price_per_night')
{

$post=$_POST;
$error='';
$id=$_POST[page_id];

$price_per_night = addslashes($post['price_per_night']);


//regular exprission




				if($post['price_per_night']==''){
					$error="Price Per Night is compulsory<br>";
				}
				
	
		if($error!=''){
					$msg=base64_encode($error);
					header("Location: admin.php?okmsg=$msg&act=".$post['act']);
		}else{

		
				 	$update_gdt_query  =  "UPDATE ".$tblprefix."price_per_night SET 
																price_per_night = '".$post['price_per_night']."',
																sort_order = '".$post['sort_order']."'
																where id=".$id; 
	 						
							$start_rat_res= $db->Execute($update_gdt_query);
						
							if($run_query){
												
								$okmsg = base64_encode("Price Per Night updated successfully.");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$okmsg = base64_encode("Price Per Night updated successfully.");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}


}
}
	
	

/***************************************************************************
*
*                         Delete Events 
*
***************************************************************************/

if($_GET['mode']=='delete' && $_GET['act']=='price_per_night' && $_GET['request_page']=='price_per_night')
{


 	$id=base64_decode($_GET['id']); 
	
	
		
		$del_qry = " DELETE FROM ".$tblprefix."price_per_night WHERE id =".$id;  
		$rs_delete = $db->Execute($del_qry);
		
			
		$del_qry = '';
		$rs_delete = '';
			
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id =".$id." AND fld_type='gdtdescription_type' ";  
		$rs_delete = $db->Execute($del_qry);
		
		
		$del_qry = '';
		$rs_delete = '';
			
		$del_qry = " DELETE FROM ".$tblprefix."language_contents WHERE page_id =".$id." AND fld_type='gdt_type' ";  
		$rs_delete = $db->Execute($del_qry);
		if($rs_delete){	
			$okmsg = base64_encode("Price Per Night Deleted successfully. ");
			header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
			exit;			
		}else{
		$okmsg = base64_encode("Price Per Night Delete successfully.");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		
		
 	} 
} 






?>