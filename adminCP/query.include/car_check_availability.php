<?php

// S E A R C H       R O O M            A V A I L A B I L I T Y
if($_POST['mode']=='search' && $_POST['act']=='car_availability' && $_POST['request_page']=='car_check_availability'){
$post=$_POST;

$pm_id=base64_encode($_POST['pm_id']);
$ag_id=base64_encode($_POST['agency']);
$cr_id=base64_encode($_POST['car_id']);

$error='';
if($_POST['car_id']==0){
	$error.="Pleae select Car<br/>";
}
if($post['start_date']==''){
  $error.="Please select start date<br>";	
}
if($post['end_date'] == ''){
	$error.="Please select end date<br>";
}
$start_date = strtotime($post['start_date']);
$end_date = strtotime($post['end_date']);
if($end_date<$start_date){
	$error.="End date is less then start date";
}
if($error!=''){
 $msg=base64_encode($error);
 header("Location: admin.php?errmsg=$msg&act=".$post['act']);
 exit();
}else{
$start_date =base64_encode($_POST['start_date']);
$end_date=base64_encode($_POST['end_date']);
header("Location:admin.php?start_date=".$start_date."&end_date=".$end_date."&act=".$_POST['act']."&ag_id=".$ag_id."&cr_id=".$cr_id);
exit;
	}
} 
	
?>	