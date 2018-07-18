<?php
	
//---------Edit Sliding configuration---------

	if($_POST['mode']=='update' && $_POST['act']=='edit_slider_configuration' && $_POST['request_page']=='mng_slider_configuration'){

	    $duration = addslashes(trim($_POST['duration']));
				
	    $sliding_effect = addslashes(trim($_POST['sliding_effect']));
		
		$id=base64_decode($_POST['id']);
		
	

		
		if($duration == '')
		{
				//$errmsg = base64_encode('Please Enter Duration');
				$errmsg = base64_encode('Molimo unesite trajanje');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}
		
		if($sliding_effect == '')
		{
				//$errmsg = base64_encode('Please Enter Sliding Effect');
				$errmsg = base64_encode('Molimo unesite efekat');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
		}
		
		
				$sql_category= "UPDATE ".$tblprefix."slider_config 
												SET
												duration = '".$duration."',
												sliding_effect = '".$sliding_effect."'
												WHERE
												id=".$id;
														
				$rs_category = $db->Execute($sql_category);
				
					if($rs_category)
					{
						//$okmsg = base64_encode("Sliding Configuration Updated successfully. !");
						$okmsg = base64_encode("Podešavanje uspješno ažurirano. !");
						header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
						exit;	  
					}
					else
					{
						//$errmsg = base64_encode('Unable to Update Sliding Configuration in database!!');
						$errmsg = base64_encode('Ažuriranje nije moguće!');
						header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
						exit;
					}
			} 
	?>
	
	
	
	
	
	