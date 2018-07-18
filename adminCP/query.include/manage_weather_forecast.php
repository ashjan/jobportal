<?php

// A D D      Weather Forcast    M A N A G E M E N T 	
if($_POST['mode']=='add' && $_POST['act']=='weather_forecast' && $_POST['request_page']=='manage_weather_forecast'){
$post=$_POST;
$error='';
$id=1;

$weather_forcast=$post['weather_forcast'];
if($weather_forcast==''){
$error="Weather Forecast Location field should not be empty<br>";
//$error="Polje lokacije za vremensku prognozu ne smije biti prazno <br>";
}


if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?errmsg=$msg&act=".$post['act']);
}else{
						
				$qry_already_event= "SELECT ".$tblprefix."weather_forcast.id 
				FROM
				".$tblprefix."weather_forcast where weather_forcast ='".$weather_forcast."' ";  
		 	
				$rs_already_event=$db->Execute($qry_already_event);
				$count_add =  $rs_already_event->RecordCount();
			
				if($count_add > 0){
				//$errmsg = base64_encode('This weather forcast city already exist.');
				$errmsg = base64_encode('Ovaj grad već ima podešenu vremensku prognozu.');
				header("Location: admin.php?act=".$_POST['act']."&errmsg=$errmsg");
				exit;
				}	
	
						
						
							$update_img_query   = 	"INSERT ".$tblprefix."weather_forcast SET
													
													weather_forcast = '".$weather_forcast."'"; 
														
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("Weather Forecast Location Updated successfully!");
								//$okmsg = base64_encode("Lokacija za vremensku prognozu uspješno ažurirana!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act']);
								exit;
							}else{
								$errmsg = base64_encode("Unable to Update  Weather Forecast Location in database.!");
								//$errmsg = base64_encode("Nije moguće ažurirati lokaciju za vremensku prognozu.!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']);
								exit;
							}
	}
} 


// A D D      Weather Forcast    M A N A G E M E N T 	
if($_POST['mode']=='update' && $_POST['act']=='edit_weather_forecast' && $_POST['request_page']=='manage_weather_forecast'){
$post=$_POST;
$error='';
$id=base64_decode($_POST['id']);

$weather_forcast=$post['weather_forcast'];
if($weather_forcast==''){
$error="Weather Forecast Location field should not be empty<br>";
//$error="Polje lokacije za vremensku prognozu ne smije biti prazno <br>";
}


if($error!=''){
			$msg=base64_encode($error);
			header("Location: admin.php?errmsg=$msg&act=".$post['act']."&id=".base64_encode($id));
}else{
							$update_img_query   = 	"UPDATE ".$tblprefix."weather_forcast SET
													
													weather_forcast = '".$weather_forcast."'
													
													WHERE id=".$id
													; 
							$run_query = $db->Execute($update_img_query);
							if($run_query){
								$okmsg = base64_encode("Weather Forecast Location Updated successfully!");
								//$okmsg = base64_encode("Lokacija za vremensku prognozu uspješno ažurirana!");
								header("Location: admin.php?okmsg=$okmsg&act=".$_POST['act2']);
								exit;
							}else{
								$errmsg = base64_encode("Unable to Update  Weather Forecast Location in database.!");
								//$errmsg = base64_encode("Nije moguće ažurirati lokaciju za vremensku prognozu.!");
								header("Location: admin.php?errmsg=$errmsg&act=".$_POST['act']."&id=".base64_encode($id));
								exit;
							}
	}
} 

// Delete Function

if($_GET['mode']=='delete' && $_GET['act']=='weather_forecast' && $_GET['request_page']=='manage_weather_forecast'){
	$id=base64_decode($_GET['id']);
		
		$del_qry = " DELETE FROM ".$tblprefix."weather_forcast WHERE id =".$id;
		$rs_delete = $db->Execute($del_qry);
		
		if($rs_delete){ 
		$okmsg = base64_encode("Weather Forcast Deleted successfully.!");
		//$okmsg = base64_encode("Vremenska prognoza uspješno izbrisana.!");
					header("Location: admin.php?okmsg=$okmsg&act=".$_GET['act']);
					exit;			
		}else{
		$errmsg = base64_encode("Unable to Delete Weather Forecast  city.!");
		//$errmsg = base64_encode("Nije moguće izbrisati grad.!");
					header("Location: admin.php?errmsg =$errmsg &act=".$_GET['act']);
					exit;	
}
}
?>	