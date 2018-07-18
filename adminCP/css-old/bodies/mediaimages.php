<?php

	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
//----------------------------------------------------------------------//
//Query for the Property Manager that will be dynamically populated in the add and edit form
$qry_property_manager = "SELECT ".$tblprefix."property_manager.*,
							  ".$tblprefix."properties.property_name ,
							  ".$tblprefix."properties.pm_type ,
							  ".$tblprefix."properties.property_category 
								FROM ".$tblprefix."property_manager 
								inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
								WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
								GROUP BY ".$tblprefix."properties.pm_id";
					
$rs_property_manager = $db->Execute($qry_property_manager);
 $totalcountpropertymanager =  $rs_property_manager->RecordCount();






if($_SESSION[SESSNAME]['pm_moduleid']==2){
		$module_pm_where = " WHERE mi.pm_id = ".$_SESSION[SESSNAME]['pm_id'] ." 
								AND pr.pm_type=1 AND pr.property_category =24";
	}else{
		$module_pm_where = " WHERE pr.pm_type=1 AND pr.property_category =24";
	}	


$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;
 

$qry_limit = "
             SELECT mi.*,
			        pm.id as pid,
					pm.first_name,
					pm.last_name,
					".$tblprefix."rooms.room_type,
					pr.id as prid,
					pr.property_name  
			 FROM `".$tblprefix."mediaimages` as mi 
			 LEFT JOIN ".$tblprefix."properties as pr ON pr.id=mi.property_id 
			 LEFT JOIN ".$tblprefix."rooms ON ".$tblprefix."rooms.id = mi.room_id 
			 LEFT JOIN ".$tblprefix."property_manager as pm ON pm.id=mi.pm_id ".
             $module_pm_where." ORDER BY mi.id DESC LIMIT ".$startRow.",".$maxRows."";

$rs_limit = $db->Execute($qry_limit);


  if($_SESSION[SESSNAME]['pm_moduleid']==2){
    $pm_where = " AND tbl_properties.pm_id = ".$_SESSION[SESSNAME]['pm_id'];
  }else{
    $pm_where = " ";
  }


 $qry_property = "SELECT
                    tbl_properties.id,
					tbl_properties.property_name,
					tbl_properties.pm_id 
					FROM
					tbl_properties 
					WHERE property_category =24
					AND pm_type=1 ".$pm_where.""; 

$rs_property = $db->Execute($qry_property);
$totalcountproperty =  $rs_property->RecordCount();
//pm id
if($_SESSION[SESSNAME]['pm_moduleid']==2){
 $qry_property_manag = "SELECT ".$tblprefix."property_manager.*,
							  ".$tblprefix."properties.property_name ,
							  ".$tblprefix."properties.pm_type ,
							  ".$tblprefix."properties.property_category 
								FROM ".$tblprefix."property_manager 
								INNER JOIN ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
 					            WHERE  
					".$tblprefix."properties.id = ".$_SESSION[SESSNAME]['pm_id']." AND ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24                                GROUP BY ".$tblprefix."properties.pm_id" ; 
} else {
	$qry_property_manag = "SELECT ".$tblprefix."property_manager.*,
							  ".$tblprefix."properties.property_name ,
							  ".$tblprefix."properties.pm_type ,
							  ".$tblprefix."properties.property_category 
								FROM ".$tblprefix."property_manager 
								INNER JOIN	 ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
								WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
								GROUP BY ".$tblprefix."properties.pm_id"; 
}

$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();
$totalcountalpha =  $rs_limit->RecordCount();

/*$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'];
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();*/

?>




<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Images</td>
  	</tr>
    <tr>
        <td colspan="8" align="center" <?php if(isset($_GET['msg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(isset($_GET['errmsg']) && isset($_GET['msg'])){echo base64_decode($_GET['errmsg']).base64_decode($_GET['msg']);}?></td>
  </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Images Found: <?php echo $totalcountalpha ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
		<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" />
		</a>
		</td>
	</tr>
	<tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber">
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
		<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		    <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
<?php	}else{ ?>
		<tr>
					<td class="txt1">Property Manager Name</td>
					<td>
					<select name="first_name" class="fields" id="first_name" onchange="get_prop_media_nam_image('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_media_nam_image.php"?>')">
				 	<option value="">Izaberite vlasnika objekta</option>
					<?php while(!$rs_property_manag->EOF){$is_manager_selected = '';
							/*if($rs_property_manag->fields['id']==$rs_content->fields['page_category']){
							   $is_manager_selected = 'selected="selected"';
							}*/
                     ?>
		  			<option value="<?php echo $rs_property_manag->fields['id'];?>" 
					<?php //echo $is_cat_selected; ?>><?php echo $rs_property_manag->fields['first_name']." ".$rs_property_manag->fields['last_name'];?>
					</option>
	                <?php $rs_property_manag->MoveNext();
					} ?>			
					</select>					
					</td>
				</tr>
				<?php }?>
				
				
				<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
				<tr>
					<td class="txt1">Property Name</td>
					<td>
					<div id="property_name">
						<select name="property_id" class="fields" id="property_id" onchange="get_room_type_0('room_id', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type_0.php"?>')">
					<option value="0">Izaberite objekat</option>		
					<?php 
					$rs_property->MoveFirst();
					while(!$rs_property->EOF){ ?>
 <option value="<?php echo $rs_property->fields['id']; ?>"><?php echo $rs_property->fields['property_name']; ?></option>
					<?php 
					$rs_property->MoveNext();
					} ?>
						</select>
					</div>
					
					</td>
				</tr>
				<?php } else {?>
				<tr>
					<td class="txt1">Property Name</td>
					<td>
					<div id="property_name">
						<select name="property_name" class="fields" id="property_name">
							<option value="0">Izaberite objekat</option>
						</select>
					</div>
					
					</td>
				</tr>
				<?php }?>
                
                <!--room type dropdown start from here-->
    <tr>
	    <td class="txt1">
  			Room/Property Type
	   	</td>
	<td>
	<div id="room_id">
			<select name="room_id" class="dropfields" >
			  <option value="0000">All Rooms</option>
			</select>
    </div>
			
							
			</td>
        </tr>
                
                <!--room type dropdown upto here-->
				
				<tr>
		<td>Title</td>
		<td><input type="text" name="images_title" class="fields" value="" /></td>
		</tr>
		<tr>
        <td>Image</td>
		<td><input type="file" name="image[]" class="fields" /></td>
		</tr>
        <tr><td></td>
		<td></td></tr>
		<tr><td></td>
		<td><input style="margin:5px; width:162px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Upload Image" class="button" />
		<input type="hidden" name="act" value="mediaimages" />
		 <input type="hidden" name="theValue" id="theValue" value="0" />
                 <input type="hidden" name="id" value="<?php if(isset($id)){ echo base64_encode($id); } ?>" />
		<input type="hidden" name="request_page" value="media_upload" />
		<input type="hidden" name="mode" value="add">
		</td>
		</tr>
		</table>
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
            
           <?php  if($_SESSION[SESSNAME]['pm_moduleid']!=2){ ?>
            
            <tr>
				<td width="20%" class="tabheading">Select PMs</td>
				<td width="60%" align="center">
                
                
                <select name="pm_id" class="fields" id="pm_id" onchange="get_prop_name_image('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name_image.php"?>')">
					<option value="0">Izaberite vlasnika objekta</option>
				 	<?php
						while(!$rs_property_manager->EOF){?>
					    <option value="<?php echo $rs_property_manager->fields['id'];?>"><?php echo $rs_property_manager->fields['first_name'].' '.$rs_property_manager->fields['last_name'];  ?></option>
						<?php
						$rs_property_manager->MoveNext();
						}?>		
				</select><br />
                </td>
             </tr>
             
            <?php }else{ ?>
            <tr>
            <td width="20%" class="tabheading">Select Property</td>
            <td width="60%" align="center">
            
            <div id="property_id1">
            <?php 
                $qry_content = "SELECT * FROM  ".$tblprefix."properties 
                                WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." 
                                AND ".$tblprefix."properties.pm_type=1
                                AND ".$tblprefix."properties.property_category =24"; 
                $rs_content = $db->Execute($qry_content);
                $count_add =  $rs_content->RecordCount();
            ?>		
            <select name="property_id" class="fields" id="property_id" onChange="get_room_pm('rooms_id1', this.value,<?php echo $_SESSION[SESSNAME]['pm_id']; ?>, '<?php echo MYSURL."ajaxresponse/get_rooms_image.php"?>')">
            <?php
            if($count_add<=0){?>
            <option value="0">Select Property</option>
            <?php
            }else{?>
            <option value="0">Izaberite objekat</option>	
                <?php while(!$rs_content->EOF){
            ?>
            <option value="<?php echo $rs_content->fields['id'];?>"><?php echo $rs_content->fields['property_name'] ;?></option>
                <?php $rs_content->MoveNext();
                }
                }
            ?>
            </select>	
            </div>
            </td>
            </tr>
            <?php } ?>
          <?php  if($_SESSION[SESSNAME]['pm_moduleid']!=2){ ?>  
          
            <tr>
				<td width="20%" class="tabheading">Select Property</td>
				<td width="60%" align="center">
                <div id="property_id1">
			   
			    <select name="property_id" id="property_id" class="fields"  />
					<option value="0">Izaberite objekat</option>
				</select>
				
				</div>
                </td>
		    </tr>
			<?php } ?>
            
            <tr>
				<td width="20%" class="tabheading">Select Room</td>
				<td width="60%" align="center">
                <div id="rooms_id1">
			    <select name="room_id" id="room_id" class="fields"  />
					<option value="0">Izaberite sobu</option>
				</select>
				</div>
                </td>
		    </tr>
            
          
			
		</table>	</td>
  </tr>
</table>
<div id="get_rates_image">

</div>

