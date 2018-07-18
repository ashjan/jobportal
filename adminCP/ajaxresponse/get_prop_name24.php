<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['id'];
       $property_name=$_GET['property_id'];
	   $qry_content = "SELECT * FROM  ".$tblprefix."properties WHERE pm_id=".$id." AND pm_type=0";
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
	
		
		if(!isset($_GET['okmsg']) and !isset($_GET['errmsg'])){
	unset($_SESSION["addproperty"]);
}

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
	$module_pm_where = ' WHERE '.$tblprefix.'properties.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' AND '.$tblprefix.'properties.pm_type=0';
}else{
	$module_pm_where = "WHERE ".$tblprefix."properties.pm_type=0";
}




$qry_prop = "SELECT ".$tblprefix."property_category.property_category_name,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name,
					".$tblprefix."properties.id,
					".$tblprefix."properties.property_code,
					".$tblprefix."properties.property_category,
					".$tblprefix."properties.property_name,
					".$tblprefix."properties.region,
					".$tblprefix."properties.street,
					".$tblprefix."properties.pm_id,
					".$tblprefix."properties.town,
					".$tblprefix."properties.postcode,
					".$tblprefix."properties.telephone,
					".$tblprefix."properties.permission_status,
					".$tblprefix."properties.fax,
					".$tblprefix."properties.email,
					".$tblprefix."properties.property_url,
					".$tblprefix."properties.numbers_of_stars,
					".$tblprefix."properties.property_thumbnail,
					".$tblprefix."properties.local_bank_account,
					".$tblprefix."properties.properties_slug,
					".$tblprefix."properties.business_type,
					".$tblprefix."properties.business_subtype,
					".$tblprefix."properties.latitude,
					".$tblprefix."properties.longitude,
					".$tblprefix."properties.no_property_rooms,
					".$tblprefix."properties.contact_language,
					".$tblprefix."properties.short_description,
					".$tblprefix."properties.topoffr_flag,
					".$tblprefix."properties.goldoffr_flag,
					".$tblprefix."property_accommodation.accomm_name,
					".$tblprefix."properties.pm_type	FROM
					".$tblprefix."properties
					LEFT Join ".$tblprefix."property_category ON ".$tblprefix."properties.property_category = ".$tblprefix."property_category.id
					Left Join ".$tblprefix."property_accommodation ON ".$tblprefix."properties.business_type = ".$tblprefix."property_accommodation.id 
					LEFT Join ".$tblprefix."property_manager ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
					$module_pm_where AND ".$tblprefix."properties.pm_id = ".$id."
					"; 

$rs_prop = $db->Execute($qry_prop);
$count_add =  $rs_prop->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);
$qry_limit = "SELECT ".$tblprefix."property_category.property_category_name,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name,
					".$tblprefix."properties.id,
					".$tblprefix."properties.property_code,
					".$tblprefix."properties.property_category,
					".$tblprefix."properties.property_name,
					".$tblprefix."properties.region,
					".$tblprefix."properties.street,
					".$tblprefix."properties.town,
					".$tblprefix."properties.pm_id,
					".$tblprefix."properties.postcode,
					".$tblprefix."properties.telephone,
					".$tblprefix."properties.permission_status,
					".$tblprefix."properties.fax,
					".$tblprefix."properties.email,
					".$tblprefix."properties.property_url,
					".$tblprefix."properties.numbers_of_stars,
					".$tblprefix."properties.property_thumbnail,
					".$tblprefix."properties.local_bank_account,
					".$tblprefix."properties.properties_slug,
					".$tblprefix."properties.business_type,
					".$tblprefix."properties.business_subtype,
					".$tblprefix."properties.latitude,
					".$tblprefix."properties.longitude,
					".$tblprefix."properties.topoffr_flag,
					".$tblprefix."properties.goldoffr_flag,
					".$tblprefix."properties.no_property_rooms,
					".$tblprefix."properties.contact_language,
					".$tblprefix."properties.short_description,
					".$tblprefix."property_accommodation.accomm_name,
					".$tblprefix."properties.pm_type	
					FROM
					".$tblprefix."properties
					LEFT Join ".$tblprefix."property_category ON ".$tblprefix."properties.property_category = ".$tblprefix."property_category.id
					Left Join ".$tblprefix."property_accommodation ON ".$tblprefix."properties.business_type = ".$tblprefix."property_accommodation.id 
					LEFT Join ".$tblprefix."property_manager ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id					$module_pm_where  AND ".$tblprefix."properties.pm_id = ".$id."
					ORDER BY ".$tblprefix."properties.id DESC LIMIT $startRow,$maxRows";
						
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

//List down all regions
$qry_region = "SELECT * FROM ".$tblprefix."property_regions" ;

$rs_region = $db->Execute($qry_region);
$count_region =  $rs_region->RecordCount();
$totalRegions = $count_region;


//List down all features
$qry_feature = "SELECT * FROM ".$tblprefix."property_features";
$rs_feature = $db->Execute($qry_feature);
$count_feature =  $rs_feature->RecordCount();
$totalFeature = $count_feature;


//   List down all Accommudation

$qry_accommodation = "SELECT * FROM ".$tblprefix."property_accommodation WHERE property_cat=24" ;
$rs_accommodation = $db->Execute($qry_accommodation);
$count_accommodation =  $rs_accommodation->RecordCount();
$totalAccommodation = $count_accommodation;


//   List Business Sub  Types
$qry_sub_type = "SELECT * FROM ".$tblprefix."business_subtype WHERE business_category_id=24" ;
$rs_sub_type = $db->Execute($qry_sub_type);
$count_sub_type =  $rs_sub_type->RecordCount();
$totalsubtype = $count_sub_type;


$qry_terms = "SELECT description FROM ".$tblprefix."pagecontent WHERE page_type1='general-terms-and-conditions'";
$rs_terms = $db->Execute($qry_terms);

//   List down all Project Manager


$qry_pm = "SELECT * FROM ".$tblprefix."property_manager" ;

$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPM = $count_pm;

//   List down all Property category 


$qry_category = "SELECT * FROM ".$tblprefix."property_category WHERE id=24";

$rs_category = $db->Execute($qry_category);
$count_property_category =  $rs_category->RecordCount();
$totalCategory = $count_property_category;

// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE ALL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();



function get_lang_name($lang_id, $tblprefix){
	global $db;
	
	$qry_lang = "SELECT Lan_name FROM ".$tblprefix."language where id = ".$lang_id;
	
	$rs_lang = $db->Execute($qry_lang);
	$count_lang =  $rs_lang->RecordCount();
	if($count_lang > 0){
		return $rs_lang->fields['Lan_name'];
	}
}

//   List Room TYpes
$qry_roomtype = "SELECT * FROM ".$tblprefix."rooms" ;
$rs_roomtype = $db->Execute($qry_roomtype);
$count_room_type =  $rs_roomtype->RecordCount();
$totalRoomTypes = $count_room_type;


//   List down all Language

$qry_lang = "SELECT * FROM ".$tblprefix."language" ;

$rs_lang = $db->Execute($qry_lang);
$count_lang =  $rs_lang->RecordCount();
$totalPM = $count_lang;
?>	
		
<div id="property_id1">		
 <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="9" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="2%">Sr#</td>
                <td width="5%">Property Code</td>
                <td width="5%">PM</td>
				<td width="5%">Property Name</td>
				<td width="5%">Town<br /></td>
				<!--<td width="5%">PM Status</td>-->
				<td width="8%">Options</td>
				<td width="10%">Make Top Offer</td>
				<td width="10%">Make Gold Offer</td>
				<td width="10%">Score Property</td>
		    </tr>
		<?php 
		if($totalcountalpha >0){
		
		
			   $rs_limit->MoveFirst();
			   while(!$rs_limit->EOF){
		?>
	<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
	<td  valign="top"><?php echo ++$i; ?></td>
	<td valign="top"><?php echo $rs_limit->fields['property_code']; ?></td>
	<td valign="top"><?php echo $rs_limit->fields['first_name'];?>  <?php echo $rs_limit->fields['last_name']; ?> </td>
	<td valign="top"><?php echo $rs_limit->fields['property_name']; ?></td>
	<td valign="top"><?php echo $rs_limit->fields['town']; ?></td>
	
	<!--<td valign="top"><?php //if($rs_limit->fields['pm_type']==0){echo '<span style="color:#ff0000">OFF LINE</span>';}else{echo '<span style="color:#0000ff">ON LINE </span> ';} ?></td>-->
	<td valign="top">
	<?php 
	if($_SESSION[SESSNAME]['pm_moduleid']!=2){
	if($rs_limit->fields['permission_status']==0){ 
					  
					  ?>
					  <a href="admin.php?act=manage_properties1&amp;m_status=0&amp;mode=change_properystatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=properties_management1">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make Default" border="0" />					  </a>
					  <?php }else{ ?>
                        <a href="admin.php?act=manage_properties1&amp;m_status=1&amp;mode=change_properystatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=properties_management1">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Make Default" border="0" />						</a>
						<?php }} ?>
	<a href="admin.php?act=editproperties1&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>&amp;pm_id=<?php echo base64_encode($rs_limit->fields['pm_id']);?>&amp;request_page=properties_management1">
	<img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" />	</a>
    
	<a href="admin.php?act=del_properties1&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>">
	<img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" />	</a>
	
	
	<a href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_limit->fields['id']; ?>').slideToggle('fast'); return false"  >
	<img src="<?php MYSURL?>graphics/data.gif" border="0" title="Open Details" />	</a>	</td>
	
	<td align="center">
	<?php
	if($rs_limit->fields['topoffr_flag']==0)
	{ 
	?>
	  <a href="admin.php?act=manage_properties1&amp;m_status=0&amp;mode=topoffer_status&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=properties_management1">
	  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make it Top Offer" border="0" />					  </a>
	  <?php 
	}
	else
	{ ?>
      <a href="admin.php?act=manage_properties1&amp;m_status=1&amp;mode=topoffer_status&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=properties_management1">
	  <img src="<?php MYSURL?>graphics/activate.gif" title="Remove from Top Offers" border="0" />						</a>
		<?php 
	}
	
	?>
	</td>
	
	<td align="center">
	<?php
	if($rs_limit->fields['goldoffr_flag']==0)
	{ 
	?>
	  <a href="admin.php?act=manage_properties1&amp;m_status=0&amp;mode=goldoffer_status&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=properties_management1">
	  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make it Gold Offer" border="0" />					  </a>
	  <?php 
	}
	else
	{ ?>
      <a href="admin.php?act=manage_properties1&amp;m_status=1&amp;mode=goldoffer_status&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=properties_management1">
	  <img src="<?php MYSURL?>graphics/activate.gif" title="Remove from Gold Offers" border="0" />						</a>
		<?php 
	}
	
	?>
	</td>
	
	<td align="center">
	 <a href="admin.php?act=score_property&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>&actred=manage_properties1">
	 Score Property
	 </a>
		

	</td>
	
	
	</tr>
	<style>
	#controls_<?php echo $rs_limit->fields['id'] ?>{
	display:none;
	}
	</style>
	<tr>
				<td colspan="10">
				<div  id="controls_<?php echo $rs_limit->fields['id']; ?>">		
				<table cellpadding="2" cellpadding="2" border="1" bordercolor="#666666" bgcolor="#E7DAE7">
				<tr class="txt tabheading">
				<td width="5%">Email</td>
				<td width="5%">Property URL</td>
				<td width="5%">Number Of Stars</td>
				<td width="5%">Property Category</td>
				<td  width="5%">Street</td>
				<td width="5%">Town</td>
				<td width="5%">Postcode</td>
				<td width="5%">Telephone</td>
			    </tr>
				<tr class="txt">
				<td valign="top"><?php echo $rs_limit->fields['email']; ?></td>
				<td valign="top"><?php echo '&nbsp;&nbsp;';echo $rs_limit->fields['property_url']; ?></td>
				<td valign="top"><?php if($rs_limit->fields['numbers_of_stars']==0){echo "Not Categorized";}else{
				echo $rs_limit->fields['numbers_of_stars'];
				} ?></td>
				<td valign="top"><?php echo $rs_limit->fields['property_category_name']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['street']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['town']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['postcode']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['telephone']; ?></td>
				</tr>
				<tr class="txt tabheading" >
				
				<td width="5%">Fax</td>
				<td width="5%">Local Bank Account</td>
				<td width="5%">Property Slug</td>
				<td width="5%">Business Type</td>
				<td width="5%">Latitude</td>
				<td width="5%">Longitude</td>
				<td width="5%">No.of rooms</td>
				<td width="5%">Contact language</td>
				
				</tr>
				<tr class="txt">
				
				<td valign="top"><?php echo '&nbsp;&nbsp;';echo $rs_limit->fields['fax']; ?></td>
				<td valign="top"><?php echo '&nbsp;&nbsp;'; echo $rs_limit->fields['local_bank_account']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['properties_slug']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['accomm_name']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['latitude']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['longitude']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['no_property_rooms']; ?></td>
				<td valign="top">
					<?php
						if(trim($rs_limit->fields['contact_language']) != ""){
							if(strpos($rs_limit->fields['contact_language'], ",") > 0){
								$isolate_to_arr = explode(",", $rs_limit->fields['contact_language']);
								foreach($isolate_to_arr as $key=>$value){
									echo get_lang_name(trim($value), $tblprefix);
									echo '&nbsp;&nbsp;';
								}
							}else{
								
								echo get_lang_name($rs_limit->fields['contact_language'], $tblprefix);
							}
						}else{
							echo '&nbsp;&nbsp;';
							echo " ";
						}
					?>
				</td>
				</table>	
				</div>
	          </td>
					</tr>
			<?php $rs_limit->MoveNext();
			}
			?>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
						</td>
					</tr>
					<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							<div id="txt" align="center"> Showing <?php 
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>" ><b>[Previous]</b></a>
							<?php }
							///////////////////////////////
							
							if($pageNum>5){
							if($pageNum+5<$totalPages){	  
							$startPage=$pageNum-5;
							}else{ $startPage=($totalPages-10);  }
							}
							else $startPage=0;
							$count= $startPage;
							if($count+11<$totalPages){
							if($pageNum==0)
							$count= $count+10;
							else { $count= $count+11;}
							$showDot=1;
							}
							else { $count=$totalPages;
							$showDot =0;
							}
							if($pageNum>6)	
							{	?>
							<a id="<?php echo '0' ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a>
							&nbsp; <?php } 		
							
							
							for ($i=$startPage; $i< $count; $i=$i+1){
							if ($i!=$pageNum){
							?>
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $i; ?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>"><?php echo $i+1; ?></a>
							<?php 
							}else{
							echo ("<b class=txt>[". ($i + 1) ."]</b>");
							}
							} 
							?>
							

							<?php
							
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							
							?>
							<?php 
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Data  Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</div>
<?php 	
    }
?>
