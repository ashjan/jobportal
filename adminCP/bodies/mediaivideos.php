<?php
//Query for the Property Manager that will be dynamically populated in the add and edit form
$qry_users = "SELECT
                    ".$tblprefix."users.id,
					".$tblprefix."users.first_name,
					".$tblprefix."users.last_name 
					FROM
					".$tblprefix."users"; 
					
$rs_users = $db->Execute($qry_users);
$totalcountpropertymanager =  $rs_users->RecordCount();
 
 
 	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;
if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE mv.pm_id = '.$_SESSION[SESSNAME]['pm_id']." AND pr.pm_type=1";
}else{
	$module_pm_where = ' WHERE pr.pm_type=1 ';
}

 $qry_faq = "SELECT mv.*,pm.id as pid,pm.first_name,pm.last_name,room_id,room_type,pr.id as prid,pr.property_name  FROM `".$tblprefix."mediaivideos` as mv INNER JOIN ".$tblprefix."properties as pr ON pr.id=mv.property_id LEFT JOIN tbl_rooms as ro ON ro.id=mv.room_id INNER JOIN ".$tblprefix."users as pm ON pm.id=mv.pm_id  
 $module_pm_where 
"; 


/*


SELECT mv . * , pm.id AS pid, pm.first_name, pm.last_name, room_id, room_type, pr.id AS prid, pr.property_name
FROM `tbl_mediaivideos` AS mv
INNER JOIN tbl_properties AS pr ON pr.id = mv.property_id
LEFT JOIN tbl_rooms AS ro ON ro.id = mv.room_id
INNER JOIN tbl_users AS pm ON pm.id = mv.pm_id
LIMIT 0 , 30


*/


$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

 
$qry_limit = "SELECT mv.*,pm.id as pid,pm.first_name,pm.last_name,room_id,room_type,pr.id as prid,pr.property_name  FROM `".$tblprefix."mediaivideos` as mv INNER JOIN ".$tblprefix."properties as pr ON pr.id=mv.property_id LEFT JOIN ".$tblprefix."rooms as ro ON ro.id=mv.room_id INNER JOIN ".$tblprefix."users as pm ON pm.id=mv.pm_id ".
 $module_pm_where." LIMIT ".$startRow.",".$maxRows."";

 $rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

if($_SESSION[SESSNAME]['pm_moduleid']==2){
 $qry_property_manag = "SELECT
                    ".$tblprefix."properties.id,
					".$tblprefix."properties.property_name
					FROM
					".$tblprefix."properties
					WHERE  
					pm_id = ".$_SESSION[SESSNAME]['pm_id']." AND pm_type=1"; 
} else {
$qry_property_manag = "SELECT
                    ".$tblprefix."users.id,
					".$tblprefix."users.first_name,
					".$tblprefix."users.last_name
					FROM
					".$tblprefix."users"; 
}

$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();
$totalcountalpha =  $rs_limit->RecordCount();
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Managing Videos</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Videos Found: <?php echo $totalcountalpha ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
<!--<a   href="<?php //MYSURL?>admin.php?act=add_categories"   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  ><img src="<?php //MYSURL?>graphics/add.png" border="0" title="Add Country" /></a>-->
		
		
		<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" />
		</a>
		
		</td>
	</tr>
	<tr>
	<td colspan="6">
    <?php 
	    $style_err='';
		if(isset($_GET['errmsg']))
		{
			$style_err= 'style="display:block;"'; 
		}
	
	?>
    
 <div id="controls" class="add_subscriber" <?php echo $style_err;?>>

	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
	<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
	<input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
	<?php } else {?>
	<div class="image_div_title">The owner</div>
	<div class="image_div_title_text"><select class="fields" name="pm_id" id="pm_id" onchange="get_prop_name('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name.php"?>')">
	<option value="0">Select property</option>
	<?php while(!$rs_property_manag->EOF){?>
	<option value="<?php echo $rs_property_manag->fields['id'];?>">
	<?php echo $rs_property_manag->fields['first_name']." ".$rs_property_manag->fields['last_name'];?>
					</option>
	                <?php $rs_property_manag->MoveNext();
					} ?>	
	</select>
	</div>
	<div class="clear"></div>
	<?php }?>
	<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
	<div class="image_div_title">Name</div>
	<div class="image_div_title_text">
	<select name="property_id" id="property_id" class="fields" onchange="get_room_type1('room_id', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type12.php"?>')">
	<option value="0">Select the object</option>
	<?php $rs_property_manag->MoveFirst();?>
					<?php while(!$rs_property_manag->EOF){ ?>
 <option value="<?php echo $rs_property_manag->fields['id']; ?>"><?php echo $rs_property_manag->fields['property_name']; ?></option>
					<?php 
					$rs_property_manag->MoveNext();
					} ?>
	</select>
	</div>
	<div class="clear"></div>
	<div class="image_div_title">Room / building</div>
	<div class="image_div_title_text">
	 <div id="room_idd">
			<select name="room_id" id="room_id" class="dropfields" >
			  <option value="0">All Rooms</option>
			</select>
     </div>
      </div>
      <div class="clear"></div>
	<?php }else {?>
	<div class="image_div_title">Name</div>
	<div class="image_div_title_text">
	<div id="property_name">
	<select name="property_id" class="fields" id="property_id">
	<option value="0">Select property</option>
	</select>
	</div>
	</div>
	<div class="clear"></div>
     <!--room type dropdown start from here-->
    
  	<div class="image_div_title">Room / building</div>
	<div class="image_div_title_text">
	 <div id="room_id">
			<select name="room_id" id="sel_room_id" class="dropfields" >
			  <option value="0">All Rooms</option>
			</select>
     </div>
      </div>
	<div class="clear"></div>	
	
     <!--room type dropdown upto here-->
    
	<?php }?>
        <div class="image_div_title">Title</div>
		<div class="image_div_title_text"><input type="text" name="video_title" class="fields" value="" id="video_title" /></div>
		<div class="clear"></div>
        <div class="image_div_title">Video</div>
		<div class="image_div_title_text"><input type="file" name="video" class="fields" /></div>
		<div class="clear"></div>
		<div id="dynamicInput">
		</div>

	
		<div class="clear"></div>
	<div class="image_div_title">&nbsp;</div>
		<div class="image_div_title_text">
		<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Upload Video" class="button"/>
		<input type="hidden" name="act" value="mediaivideos" />
		 <input type="hidden" name="theValue" id="theValue" value="0" />
		<input type="hidden" name="request_page" value="media_upload" />
		<input type="hidden" name="mode" value="add">
		</div>
		</form>
</div>
		 </td>
		 </tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
            
            <tr>
				<td width="20%" class="txt2">Select property :</td>
				<td width="60%" align="center">
                <select name="pm_id" class="fields" id="pm_id" onchange="get_prop_video('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name_videos.php"?>')">
					<option value="0">Select property</option>
				 	<?php
						while(!$rs_users->EOF){?>
					    <option value="<?php echo $rs_users->fields['id'];?>"><?php echo $rs_users->fields['first_name'].' '.$rs_users->fields['last_name'];  ?></option>
						<?php
						$rs_users->MoveNext();
						}?>		
				</select><br />
                </td>
             </tr>
            
            <tr>
				<td width="20%" class="txt2">Select the object :</td>
				<td width="60%" align="center">
                <div id="property_id1">
			   
			    <select name="property_id" id="property_id" class="fields"  />
					<option value="0">Select the object</option>
				</select>
				
				</div>
                </td>
		    </tr>
            <tr>
				<td width="20%" class="txt2">Choose a room :</td>
				<td width="60%" align="center">
                <div id="rooms_id1">
			    <select name="room_id" id="room_id" class="fields"  />
					<option value="0">Select Room</option>
				</select>
				</div>
                </td>
		    </tr>
            
			
            
			
		</table>	</td>
  </tr>
</table>

<div id="get_rates_videos"></div>

<?php //echo $where;?>
