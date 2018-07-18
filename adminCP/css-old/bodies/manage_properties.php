<?php
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
	$module_pm_where = ' WHERE '.$tblprefix.'properties.pm_id = '.$_SESSION[SESSNAME]['pm_id'] . ' 
						 AND '.$tblprefix.'properties.pm_type=1 
						 AND '.$tblprefix.'properties.property_category=24';
	$module_pm_where1 = 'WHERE '.$tblprefix.'property_manager.id = '.$_SESSION[SESSNAME]['pm_id'];
}else{
	$module_pm_where = 'WHERE '.$tblprefix.'properties.pm_type=1 
						AND '.$tblprefix.'properties.property_category=24';
		$module_pm_where1 = ' WHERE '.$tblprefix.'properties.pm_type =1 AND '.$tblprefix.'properties.property_category =24 ';
}

//Dropdown for parent
$pm_qry = " SELECT ".$tblprefix."property_manager.*,
   				   	  ".$tblprefix."properties.property_name ,
				      ".$tblprefix."properties.pm_type ,
				      ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."property_manager 
						 INNER JOIN ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id".$module_pm_where;
$rs_pm = $db->Execute($pm_qry); 



 $qry_prop = "SELECT ".$tblprefix."property_category.property_category_name,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name,
					".$tblprefix."properties.id,
					".$tblprefix."properties.property_code,
					".$tblprefix."properties.property_category,
					".$tblprefix."properties.property_name,
					".$tblprefix."properties.region,
					".$tblprefix."properties.street,
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
					$module_pm_where
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
					LEFT Join ".$tblprefix."property_manager ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id					$module_pm_where
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
if($rs_feature){
    $count_feature =  $rs_feature->RecordCount();
}
 else {
     $count_feature = 0;
}
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


$qry_pm = "SELECT ".$tblprefix."property_manager.*  
           FROM ".$tblprefix."property_manager"." 
           LEFT JOIN ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id 
           ".$module_pm_where1." GROUP BY ".$tblprefix."property_manager.id";

$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPM = $count_pm;

//   List down all Property category 


$qry_category = "SELECT * FROM ".$tblprefix."property_category ";

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

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	
	<tr>
    	<td id="heading">Manage Properties &nbsp;[Podešavanje objekta]</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Properties Found: <?php echo $totalcountalpha ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
		<!--Add New Code from here -->
		<a href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" />
		</a>
		</td>
	</tr>
	<tr>
 <td colspan="6">
  <!--form open-->
 <?php
	if(isset($_SESSION['addproperty'])){
	?>
	<div style="background-color:#E7DAE7;"></div>
	<?php 
	}else{ 
	?>
	
 <div id="controls" class="add_subscriber">
 <?php
	}
	?>
 <!--form end-->
    <script language="javascript"> 
		$(document).ready(function() {
			$("#postcode").keydown(function(event) {
				// Allow only backspace and delete
				if ( event.keyCode == 46 || event.keyCode == 8 ) {
					// let it happen, don't do anything
				}
				else {
					// Ensure that it is a number and stop the keypress
					if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
						event.preventDefault(); 
					}   
				}
			});
		});
		
		$(document).ready(function() {
			$("#telephone").keydown(function(event) {
				// Allow only backspace and delete
				if ( event.keyCode == 46 || event.keyCode == 8 ) {
					// let it happen, don't do anything
				}
				else {
					// Ensure that it is a number and stop the keypress
					if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
						event.preventDefault(); 
					}   
				}
			});
		});
		
		$(document).ready(function() {
			$("#fax").keydown(function(event) {
				// Allow only backspace and delete
				if ( event.keyCode == 46 || event.keyCode == 8 ) {
					// let it happen, don't do anything
				}
				else {
					// Ensure that it is a number and stop the keypress
					if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
						event.preventDefault(); 
					}   
				}
			});
		});
</script>
    <script type="text/javascript">
$(document).ready(function() {
			$("#no_property_roomss").keydown(function(event) {
				// Allow only backspace and delete
				if ( event.keyCode == 46 || event.keyCode == 8 ) {
					// let it happen, don't do anything
				}
				else {
					// Ensure that it is a number and stop the keypress
					if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
						event.preventDefault(); 
					}   
				}
			});
		});
</script>
	<form name="managecontentfrm" action="admin.php" method="post"  enctype="multipart/form-data">
        <table cellpadding="1" cellspacing="0" border="0" class="txt" width="98%" align="center" >
          <tr>
		  <td height="1px;">
		  </td>
		  </tr>
		   <tr>
	<td colspan="2" style="font-weight:bold; text-align:left; border:1px solid #999999; border-bottom:none;">Property Owner</td>
        	<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php
			}else{
			?>
			<tr>
	        <td style="border-left:1px solid #999999;">
  			Property Manager<br/>[vlasnika objekta]
		   	</td>
			<td style="border-right:1px solid #999999;">
			<select name="first_name" class="fields"   id="first_name">
				<option value="0">Izaberite vlasnika objekta</option>
				<?php 
			    while(!$rs_pm->EOF){
				?>
				<option value="<?php echo $rs_pm->fields['id'];?>"
				<?php
				if(isset($_SESSION["addproperty"]["first_name"]) and $_SESSION["addproperty"]["first_name"]==$rs_pm->fields['id']){                echo 'selected="selected"';
				}
				?>><?php echo $rs_pm->fields['first_name']." ".$rs_pm->fields['last_name'];?></option>
				<?php
				$rs_pm->MoveNext();
				}
				?>					
			</select>					
			</td>
        </tr>	
		<?php
		}?>
	<tr>
	        <td style="border-left:1px solid #999999;">
  			Property Category<br/>[Izaberite objekta]
		   	</td>
			<td style="border-right:1px solid #999999;">
			<select name="property_category" class="fields" id="property_category" onchange="get_accommadation('business_type', this.value, '<?php echo MYSURL."ajaxresponse/get_accommadation.php"?>')">
				<option value="0">Odaberite kategoriju</option>
				<?php
				 
				while(!$rs_category->EOF){?>
					<option value="<?php echo $rs_category->fields['id'];?>"
					<?php
					if(isset($_SESSION["addproperty"]["property_category"]) and $_SESSION["addproperty"]["property_category"]==$rs_category->fields['id']){
					echo 'selected="selected"';
					}
					?>
					><?php echo $rs_category->fields['property_category_name'];?></option>
					<?php
					$rs_category->MoveNext();
					}
				
				?>					
			</select>					
			</td>
        </tr>      
			<tr>
	        <td style="border-left:1px solid #999999; border-bottom:0px solid #999999;">
  			Business Type<br/>[Vrsta objekta]</td>
			<td style="border-right:1px solid #999999; border-bottom:0px solid #999999;">
			<div id="business_type">
			<select name="business_type" class="fields"   id="business_type" onchange="get_businesssubtype('business_subtype', this.value,'<?php echo MYSURL."ajaxresponse/get_businesssubtype.php"?>')">
				<option value="0">Izaberite vrstu objekta</option>
			
			<?php
			if(isset($_SESSION["addproperty"]["business_type"]) and $_SESSION["addproperty"]["business_type"]!=0){
			 while(!$rs_accommodation->EOF){?>
					<option value="<?php echo $rs_accommodation->fields['id'];?>"
					<?php
					if(isset($_SESSION["addproperty"]["business_type"]) and $_SESSION["addproperty"]["business_type"]==$rs_accommodation->fields['id']){
					echo 'selected="selected"';
					}
					?>
					><?php echo $rs_accommodation->fields['accomm_name'];?></option>
					<?php
					$rs_accommodation->MoveNext();
					}
					}
				?>
			
			</select>
			</div>
			</td>
        </tr>
		<tr>
	        <td style="border-left:1px solid #999999; border-bottom:1px solid #999999;">
  			Business Sub Type<br/>[Podvrsta objekta]
            </td>
			<td style="border-right:1px solid #999999; border-bottom:1px solid #999999;">
			<div id="business_subtype">
			<select name="business_subtype" class="fields"   id="business_subtype">
				<option value="0">Izaberite podvrstu objekta</option>
				
				<?php 
				if(isset($_SESSION["addproperty"]["business_subtype"])){
					$rs_sub_type->MoveFirst();
			     	while(!$rs_sub_type->EOF){
					
					?>
					<option value="<?php echo $rs_sub_type->fields['id']; ?>" 
					<?php if($_SESSION["addproperty"]["business_subtype"]==$rs_sub_type->fields['id']){echo "selected=\"selected\"";}?>
					
					>
					<?php echo $rs_sub_type->fields['business_subtype'];?>
					</option>
				 
					<?php
			   	
					$rs_sub_type->MoveNext();
					}
				}
				?>					
			</select>
            </div>  
			</td>
        </tr>
		
		
		<tr><td height="1px;"></td></tr>		
	     <tr>
		<td colspan="2" style="font-weight:bold; text-align:left; border:1px solid #999999; border-bottom:none;">Property Details<br/>[Detalji o objektu]
        </td></tr>
		 <tr>
	        <td style="border-left:1px solid #999999;">
  			Property Name
		   	</td>
			<td style="border-right:1px solid #999999;">
			<input type="text" name="property_name" class="fields" id="property_name" value="<?php echo $_SESSION["addproperty"]["property_name"];?>" />
			</td>
        </tr>
		<?php 
				if($totallanguages>0){ 
				$rs_language->MoveFirst();
				while(!$rs_language->EOF){
                // Get the currently selected translated text if exist in language content table 
                $language_id=$rs_language->fields['id'];
				
				if($mode == "update"){
					$id = $pageid;
					$language_qry = "SELECT id,
					language_id,
					page_id,
					field_name,
					translation_text,
					translated_text,
					fld_type 
					FROM 
					".$tblprefix."language_contents 
					WHERE   
					language_id=".$language_id." 
					AND page_id='".$id."'  
					AND field_name='page_title' 
					AND fld_type='content_type'"
					;

					$rs_lang_text = $db->Execute($language_qry);
					$totallang_flds =  $rs_lang_text->RecordCount();
					if($totallang_flds > 0){
						$value = $rs_lang_text->fields['translated_text'];
					}else{
						$value='';
					}
				}else{
					$value='';
				}
				
			echo '<tr>
			<td class="txt1" style="border-left:1px solid #999999;">('.$rs_language->fields['Lan_name'].') </td>
			<td style="border-right:1px solid #999999;">
			<input  class="fields" name="property_name_'.$rs_language->fields['id'].'" id="property_name_'.$rs_language->fields['id'].'" value="'.stripslashes($value).$_SESSION["addproperty"]["property_name_".$rs_language->fields['id'].""].'" type="text"  />
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
		
	
		<tr>
	        <td style="border-left:1px solid #999999;">
  			Region
		   	</td>
			<td style="border-right:1px solid #999999;">
			<select name="region" class="fields"   id="region">
				<option value="0">Izaberite Region</option>
				<?php 
			     	while(!$rs_region->EOF){?>
					<option value="<?php echo $rs_region->fields['id'];?>" 
					<?php if($_SESSION["addproperty"]["region"]==$rs_region->fields['id']){ echo "selected=\"selected\"";}?>
					><?php echo $rs_region->fields['region_name'];?></option>
					
					<?php
					$rs_region->MoveNext();
					}
				?>					
			</select>					

			</td>
        </tr>
		<tr>
	        <td style="border-left:1px solid #999999;">
  			Street<br/>[ulica]
		   	</td>
			<td style="border-right:1px solid #999999;">
			<input type="text" name="street" class="fields"  id="street" value="<?php echo $_SESSION["addproperty"]["street"];?>" />
			</td>
        </tr>
		<tr>
	        <td style="border-left:1px solid #999999;">
  			Town<br/>
		   	</td>
			<td style="border-right:1px solid #999999;">
			<input type="text" name="town" class="fields"  id="town" value="<?php echo $_SESSION["addproperty"]["town"];?>" />
			</td>
        </tr>
		<tr>
	        <td style="border-left:1px solid #999999;">
  			Postcode
		   	</td>
			<td style="border-right:1px solid #999999;">
			<input type="text" name="postcode" class="fields"  id="postcode" value="<?php echo $_SESSION["addproperty"]["postcode"];?>" />
			</td>
        </tr>
		<tr>
	        <td style="border-left:1px solid #999999;">
  			Telephone<br/>[Telefon]
		   	</td>
			<td style="border-right:1px solid #999999;">
			<input type="text" name="telephone" class="fields"  id="telephone" value="<?php echo $_SESSION["addproperty"]["telephone"];?>" />
			</td>
        </tr>
		<tr>
	        <td style="border-left:1px solid #999999;">
  			Fax
		   	</td>
			<td style="border-right:1px solid #999999;">
			<input type="text" name="fax" class="fields"  id="fax" value="<?php echo $_SESSION["addproperty"]["fax"];?>" />
			</td>
        </tr>
		<tr>
	        <td style="border-left:1px solid #999999;">
  			Email
		   	</td>
			<td style="border-right:1px solid #999999;">
			<input type="text" name="email" class="fields"  id="email" value="<?php echo $_SESSION["addproperty"]["email"];?>" />
			</td>
        </tr>
		
		
		<tr>
		<td colspan="2" style="border-left:1px solid #999999; border-right:1px solid #999999;">
			<!--<div id="stardiv"<?php //if(!empty($_SESSION["addproperty"]["no_property_rooms"]) or !empty($_SESSION["addproperty"]["numbers_of_stars"])){echo "style=\"display:block\"";}else{?> style="display:none;" <?php //}?>>-->
			<div id="stardiv">
		<table cellpadding="1" cellspacing="0" border="0" class="txt" width="44%" >
		<tr>
		
	
		
	        <td width="28%">
  			No. Of Property Rooms<br/>[Broj soba u objektu]
		   	</td>
			<td width="72%">
			<input type="text" name="no_property_rooms" id="no_property_roomss" class="field2" maxlength="4"  size="10" 
			value="<?php echo trim($_SESSION["addproperty"]["no_property_rooms"]);?>"/> Rooms&nbsp;[Sobe]
			</td>
        </tr>
		<tr>
	        <td>
  			Numbers Of Stars<br/>[Kategorija]
		   	</td>
			<td>
		    <select name="numbers_of_stars" class="fields"   id="numbers_of_stars" >
				<option value="0">No Categorization</option>
				<option value="1" <?php if($_SESSION["addproperty"]["numbers_of_stars"]==1){echo "selected=\"selected\"";}?>>1</option>
				<option value="2" <?php if($_SESSION["addproperty"]["numbers_of_stars"]==2){echo "selected=\"selected\"";}?>>2</option>
				<option value="3" <?php if($_SESSION["addproperty"]["numbers_of_stars"]==3){echo "selected=\"selected\"";}?>>3</option>
				<option value="4" <?php if($_SESSION["addproperty"]["numbers_of_stars"]==4){echo "selected=\"selected\"";}?>>4</option>
				<option value="5" <?php if($_SESSION["addproperty"]["numbers_of_stars"]==5){echo "selected=\"selected\"";}?>>5</option>		
			</select>
							
			</td>
        </tr>
		
		</table>
		</div></td>
	
		</tr>
		
		
		<tr>
	        <td style="border-left:1px solid #999999;">
  			Thumbnail<br/>[Glavna slika]
		   	</td>
			<td style="border-right:1px solid #999999;">
			<input type="file" name="property_thumbnail" class="fields"  id="property_thumbnail" value="<?php echo $_SESSION["addproperty"]["property_thumbnail"];?>" />
	<?php
	if(isset($_SESSION['addproperty']['property_thumbnail'])){
    ?>
<img src="<?php echo  MYSURL ; ?>graphics/thumbnail_upload/<?php echo $_SESSION['addproperty']['property_thumbnail']; ?>" width="100" height="50" />
    <?php
    
	}
    ?>

			
			
			</td>
		</tr>
		
		<tr>
	        <td style="border-left:1px solid #999999; border-bottom:1px solid #999999;">
  			Property URL<br/>[Web adresa]
		   	</td>
			<td style="border-right:1px solid #999999; border-bottom:1px solid #999999;">
			<input type="text" name="property_url" class="fields"  id="property_url" value="<?php echo $_SESSION["addproperty"]["property_url"];?>" />
			</td>
        </tr>
		
		
		
		<tr><td height="1px;"></td></tr>
		
	
	
		<tr><td height="1px;"></td></tr>
		<tr>
<td colspan="2" style="font-weight:bold; text-align:left; border:1px solid #999999; border-bottom:none;">Location<br/>[lokacija]</td>
		</tr>
		
		<tr>
	        <td style="border-left:1px solid #999999;">
  			Local Bank Account<br/>[Bankovni račun]
		   	</td>
			<td style="border-right:1px solid #999999;">
			<input type="text" name="local_bank_account" class="fields"  id="local_bank_account" value="<?php echo $_SESSION["addproperty"]["local_bank_account"];?>" />
			</td>
        </tr>
		<tr>
	        <td style="border-left:1px solid #999999;">
  			Latitude<br/>[Geografska širina]
		   	</td>
			<td style="border-right:1px solid #999999;">
			<input type="text" name="latitude" class="fields"  id="latitude" value="<?php echo $_SESSION["addproperty"]["latitude"];?>" />
			</td>
        </tr>
		
		<tr>
	        <td style="border-left:1px solid #999999;">
  			Longitude<br/>[Geografska du&#382;ina]
		   	</td>
			<td style="border-right:1px solid #999999;">
			<input type="text" name="longitude" class="fields"  id="longitude" value="<?php echo $_SESSION["addproperty"]["longitude"];?>" />
			</td>
        </tr>
		
		<tr>
	        <td style="border-left:1px solid #999999; border-bottom:1px solid #999999;">
  			Contact languages<br/>[Jezici za kontakt]
		   	</td>
			<td style="border-right:1px solid #999999; border-bottom:1px solid #999999;">
			<?php 
			  if($count_lang >0){
			   $rs_lang->MoveFirst();
			   while(!$rs_lang->EOF){
			?>
			<input type="checkbox" name="contact_language[]" value="<?php echo $rs_lang->fields['id'];?>" <?php 
			
			if(is_array($_SESSION['addproperty']['contact_language'])){
			if(in_array(
			$rs_lang->fields['id'],$_SESSION['addproperty']['contact_language'])){echo "checked=checked";}}?>  /> 
			<?php echo $rs_lang->fields['Lan_name'];?><br />
			<?php
			 $rs_lang->MoveNext();
					}
					}
			?>
			</td>
        </tr>
		<tr><td height="1px;"></td></tr>		
		<tr>
		<td colspan="2" style="font-weight:bold; text-align:left; border:1px solid #999999; border-bottom:none;">Description<br/>[opis]</td>
		</tr>
		<tr>
		<td  style="border-left:1px solid #999999; border-bottom:1px solid #999999;" >
		Short Description<br/>[Kratki opis objekta]
		</td>
		<td  style="border-right:1px solid #999999; border-bottom:1px solid #999999;">
		<textarea rows="8" cols="45" name="short_description" id="short_descriptions" class="smalltxtareas"><?php echo $_SESSION["addproperty"]["short_description"];?></textarea>
		</td>
		</tr>
		<tr>
		<td>
<?php   if($totallanguages>0){ 
				$rs_language->MoveFirst();
				while(!$rs_language->EOF){
 // Get the currently selected translated text if exist in language content table 
                $language_id=$rs_language->fields['id'];
				//$id=$rs_content->fields['id'];    
				$language_qry = "SELECT id,
				language_id,
				page_id,
				field_name,
				translation_text,
				translated_text,
				fld_type 
				FROM 
				".$tblprefix."language_contents 
				WHERE   
				language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='short_description' 
				AND fld_type='property_type'";
			$rs_lang_text = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			if($totallang_flds>0){
		    $value=$rs_lang_text->fields['translated_text'];
			}else{
			$value='';
			}
			echo '<tr>
			<td class="txt1" style="border-left:1px solid #999999; border-bottom:1px solid #999999;">('.$rs_language->fields['Lan_name'].') </td>
			<td style="border-right:1px solid #999999; border-bottom:1px solid #999999;">
			<textarea id="short_description_'.$rs_language->fields['id'].'" name="short_description_'.$rs_language->fields['id'].'" rows="8" cols="45">'.stripslashes($value).$_SESSION["addproperty"]["short_description_".$rs_language->fields['id'].""].'</textarea>
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // END  while(!$rs_language->EOF)
                } // END if($totallanguages>0 	
				
?>					</td>
		</tr>
		
		
		
		

		
		<input type="hidden" value="1" name="propertystatus" id="propertystatus" />
		<tr>
	        <td colspan="2" style="border-left:1px solid #999999; border-right:1px solid #999999; border-bottom:1px solid #999999;">
  			
			<input type="checkbox" name="trmcond1" class="fields"  id="trmcond1" value="term" <?php if($_SESSION["addproperty"]["trmcond1"]=='term')
			{echo "checked=\"checked\"";}?>/>
			I agree to the <a href="#" onclick="return show_terms();">Terms and Conditions</a> of property.
             [Sla&#382;em se sa Uslovima i odredbama.]
            
			<div id="terms" style="display:none;margin-left:10px;float:left;margin-top:20px;">
			<div style="float:left;width:600px;"><?php echo $rs_terms->fields['description'];?></div>
			</div>
				
			</td>
        </tr>
		
		<tr>
	        <td>&nbsp;
				
			</td>
			<td>
			<input style="margin:5px; width:176px; float:none; text-align:center;" type="submit" name="submit" id="submit"  value="Insert Property &nbsp;[Dodaj objekat]" class="button" />
			</td>
        </tr>

		</table>
			<input type="hidden" name="act" value="manage_properties" />
			<input type="hidden" name="request_page" value="properties_management" />
			<input type="hidden" name="mode" value="add">
		</form>
 </div>
 <!--Add New Code from here -->
 <tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber">
  <table cellpadding="1" cellspacing="1" border="0" width="100%" >
  <tr>
  <td colspan="2">
  </td>
  </tr>     
  </table>
</div>
		 </td>
		 </tr>
   <?php 
   if($_SESSION[SESSNAME]['pm_moduleid']!=2){ 
   ?>		 
	<tr>
    <td>
<b>Property Manager::</b> &nbsp;&nbsp;&nbsp;&nbsp; 
         <select name="pm_id" class="fields" id="pm_id" onchange="get_prop_name23('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name23.php"?>')">
				 	<option value="0">Izaberite vlasnika objekta</option>
					<?php
					if(isset($_GET['pm_id'])){
						$pm_id = base64_decode($_GET['pm_id']);
						}else{
						$pm_id = 0;
						}
					$rs_pm->MoveFirst();
					while(!$rs_pm->EOF){
					?><option value="<?php echo $rs_pm->fields['id'];?>"<?php
					  if($pm_id==$rs_pm->fields['id']){echo 'selected="selected"';}
					?>><?php echo $rs_pm->fields['first_name']."  ".$rs_pm->fields['last_name'];  ?></option>
					<?php
					$rs_pm->MoveNext();
					}
					?>			
		</select>
		  </td>
		 </tr>
	     <?php } ?>		 	 
		 </table>
	<div id="property_id1">	
  <table>
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
				<td width="5%">Town</td>
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
	<?php
	//$qry_regionsel = "SELECT * FROM ".$tblprefix."property_regions where id = '".$rs_limit->fields['region']."' " ;
   // $rs_regionsel = $db->Execute($qry_regionsel);
	?>
	<td valign="top"><?php echo $rs_limit->fields['town'];  //echo $rs_regionsel->fields['region_name']; ?></td>
	<td valign="top">
	<?php 
	if($_SESSION[SESSNAME]['pm_moduleid']!=2){
	if($rs_limit->fields['permission_status']==0){ 
	?>
	<a href="admin.php?act=manage_properties&amp;m_status=0&amp;mode=change_properystatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=properties_management">
	<img src="<?php MYSURL?>graphics/deactivate.gif" title="Make Default" border="0" /></a>
	<?php }else{ ?>
    <a href="admin.php?act=manage_properties&amp;m_status=1&amp;mode=change_properystatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=properties_management">
	<img src="<?php MYSURL?>graphics/activate.gif" title="Make Default" border="0" /></a>
	<?php }} ?>
	<a href="admin.php?act=editproperties&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>&amp;request_page=properties_management">
	<img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>
	<a href="admin.php?act=del_properties&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>">
	<img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
	<a href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_limit->fields['id']; ?>').slideToggle('fast'); return false"  >
	<img src="<?php MYSURL?>graphics/data.gif" border="0" title="Open Details" /></a></td>
	<td align="center">
	<?php
	if($rs_limit->fields['topoffr_flag']==0){ 
	?>
	  <a href="admin.php?act=manage_properties&amp;m_status=0&amp;mode=topoffer_status&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=properties_management">
	  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make it Top Offer" border="0" />					  </a>
	  <?php 
	}else{ ?>
      <a href="admin.php?act=manage_properties&amp;m_status=1&amp;mode=topoffer_status&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=properties_management">
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
	  <a href="admin.php?act=manage_properties&amp;m_status=0&amp;mode=goldoffer_status&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=properties_management">
	  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make it Gold Offer" border="0" />					  </a>
	  <?php 
	}
	else
	{ ?>
      <a href="admin.php?act=manage_properties&amp;m_status=1&amp;mode=goldoffer_status&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=properties_management">
	  <img src="<?php MYSURL?>graphics/activate.gif" title="Remove from Gold Offers" border="0" />						</a>
		<?php 
	}
	
	?>
	</td>
	
	<td align="center">
	 <a href="admin.php?act=score_property&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>&actred=manage_properties">
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
  </table>
  </div>

<?php //echo $where;?>
