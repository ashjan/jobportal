<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
      include("ENG_language.php");
$my_file = 'file.txt';
$handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
$data = 'New data line 1';
fwrite($handle, $data);
$new_data = "\n".'New data line 2';
fwrite($handle, $new_data);
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td colspan="8" id="heading">Front page Label and Titles Manager :</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 
  <tr>
    <td colspan="8">
	<form name="change_all_const">
      	 <?php  echo "TITLE_PM_SIGN_IN:"?><input type="text" value="<?php echo TITLE_PM_SIGN_IN; ?>" />
		 <input type="submit" value="Save"  /> 
	</form>	 
	</td>
  </tr>
  
</table>