<?php
 $id =  base64_decode($_GET['id']);
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE pr.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' AND pr.pm_type=0';
}else{
	$module_pm_where = ' WHERE pr.pm_type=0 ';
}



  $maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;
 $qry_faq = "SELECT mi.*,
                   pm.id as pid,
				   pm.first_name,
				   pm.last_name,
				   pr.id as prid,
				   pr.pm_type as pmtype,
				   ".$tblprefix."rooms.room_type,
				   pr.property_name  
            FROM `tbl_mediaimages` as mi 
			INNER JOIN tbl_properties as pr ON pr.id=mi.property_id 
			LEFT JOIN ".$tblprefix."rooms ON ".$tblprefix."rooms.id = mi.room_id 
            INNER JOIN tbl_property_manager as pm ON pm.id=mi.pm_id  
 $module_pm_where 
";  

$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = " SELECT mi.*,
			        pm.id as pid,
					pm.first_name,
					pm.last_name,
					".$tblprefix."rooms.room_type,
					pr.id as prid,
					pr.pm_type as pmtype,
					pr.property_name  
			 FROM `tbl_mediaimages` as mi 
			 INNER JOIN tbl_properties as pr ON pr.id=mi.property_id 
			 LEFT JOIN ".$tblprefix."rooms ON ".$tblprefix."rooms.id = mi.room_id 
			 INNER JOIN tbl_property_manager as pm ON pm.id=mi.pm_id ".
 $module_pm_where." ORDER BY mi.id DESC LIMIT ".$startRow.",".$maxRows."";

$rs_limit = $db->Execute($qry_limit);


 $qry_property = "SELECT
                    tbl_properties.id,
					tbl_properties.property_name
					FROM
					tbl_properties WHERE pm_type=0"; 

$rs_property = $db->Execute($qry_property);
$totalcountproperty =  $rs_property->RecordCount();
//pm id
if($_SESSION[SESSNAME]['pm_moduleid']==2){
 $qry_property_manag = "SELECT
                    tbl_property_manager.id,
					tbl_property_manager.first_name,
					tbl_property_manager.last_name
					FROM
					tbl_property_manager 
					"; 
} else {

	$qry_property_manag = "SELECT
                    tbl_property_manager.id,
					tbl_property_manager.first_name,
					tbl_property_manager.last_name
					FROM
					tbl_property_manager
					"; 
}
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();
$totalcountalpha =  $rs_limit->RecordCount();

$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." AND pm_type=0";
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();

?>




<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Give Rating to Property</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	
	
	<tr>
	<td colspan="6">
 
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
		<table>
		<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		    <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
<?php	}else{ ?>
		
				<?php }?>
				
                <!--room type dropdown start from here-->
    
                
                <!--room type dropdown upto here-->
				
				<tr>
		<td></td>
		<td>Please give rating to property [1 to 5]</td>
		</tr>
		<?php 
        for($i=0;$i<5;$i++){
		?>
        <tr>
         <?php 
        if($i==0){
		$select_option= "resrvation_0";
		$select_option_label= "Resrvation";
		}
		
		if($i==1){
		$select_option= "bookingfreq_1";
		$select_option_label= "Booking";
		}
		
		
		if($i==2){
		$select_option= "canclfreg_2";
		$select_option_label= "Cancellation";
		}
		
		if($i==3){
		$select_option= "mavail_3";
		$select_option_label= "Availaible";
		}
		
		if($i==4){
		$select_option= "custcomplain_4";
		$select_option_label= "Customer Complaints";
		}
		?>
		<td><?php echo $select_option_label; ?>: </td>
		<td>
        <?php 
        if($i==0){
		$select_option= "resrvation_0";
		}
		
		if($i==1){
		$select_option= "bookingfreq_1";
		}
		
		
		if($i==2){
		$select_option= "canclfreg_2";
		}
		
		if($i==3){
		$select_option= "mavail_3";
		}
		
		if($i==4){
		$select_option= "custcomplain_4";
		}
		?>
        <select name="<?php echo $select_option; ?>" id="<?php echo $select_option; ?>" class="fields">
		<option value="0">No Rating</option>
        <?php 
		       $qry_rating = "SELECT * FROM tbl_admn_proprating WHERE proprty_id= ".$id." AND criteria_id=".$i;
			  $row = $db->GetRow($qry_rating);
		for($y=1;$y<6;$y++){
		?>	  
        <option <?php if($row['rating']==($y-1)){echo "selected";}?> value="<?php echo ($y-1); ?>"><?php echo $y ;?></option>
        <?php } ?>
		</select>
        </td>
		</tr>
       <?php } ?> 
		
		
        <tr><td></td>
		<td></td></tr>
		<tr><td></td>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Submit" class="button"/>
		<input type="hidden" name="act2" value="score_property" />
		<input type="hidden" name="act" value="manage_properties" />
		<input type="hidden" name="theValue" id="theValue" value="0"/>
        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
		<input type="hidden" name="request_page" value="mngscore_property"/>
		<input type="hidden" name="mode" value="add">
		</td>
		</tr>
		</table>
		</form>

		 </td>
		 </tr>
  
</table>
<?php //echo $where;?>
