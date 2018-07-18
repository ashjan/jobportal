<?php
$id=base64_decode($_GET['id']);

  $qry_limit = "SELECT *
				FROM ".$tblprefix."footer_banner WHERE id=".$id;  
  $rs_limit = $db->Execute($qry_limit);

  $qry_pm = "SELECT id,first_name,last_name FROM ".$tblprefix."property_manager" ;
  $rs_pm = $db->Execute($qry_pm);


?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Manage Footer Banner &nbsp;[Footer banner]</td>
 	</tr>
	
	<tr>
		<td>
		
	<form name="managemenufrm" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
					<tr>
						<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?> </td>
					</tr>
					
					
					<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			Property <br/>[Kategorije ]
		   	</td>
        </tr>
        <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php } else {?>
		<tr>
		<td class="txt" width="35%">Property Manager:<br/>[vlasnika objekta]:</td>
		<td width="65%">
		<select name="first_name" class="fields" id="first_name"  onchange="get_prop_name3('property_name', this.value, '<?php echo MYSURL.							  		"ajaxresponse/get_prop_name3.php"?>')">
		<option value="0">Izaberite vlasnika objekta</option>
		<?php 
    	while(!$rs_pm->EOF){?>
		<option value="<?php echo $rs_pm->fields['id']; ?>" <?php 
		if($rs_pm->fields['id'] == $rs_limit->fields['pm_id']){
		echo "selected='selected'";
		}
		?>
		 ><?php echo $rs_pm->fields['first_name']." ".$rs_pm->fields['last_name'];?></option>
		<?php 
		$rs_pm->MoveNext();
		}
		?>	
</select>				
            </td>
				</tr>
				<?php }?>
				<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
				<tr>
				<td class="txt">Property Name:</td>
				<td>
				<select name="property_name" class="fields"   id="property_name">
						<option value="0">izaberite vlasnika </option>
						<?php 
						$qry_prop = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' AND pm_type=1';
						$rs_prop = $db->Execute($qry_prop);
						
						$rs_prop->MoveFirst();
						while(!$rs_prop->EOF){
						?>
						<option value="<?php echo $rs_prop->fields['id'];?>" <?php if($rs_prop->fields[id] == $rs_limit->fields['property_id']){ $sel='selected="selected"'; }else{$sel='';} echo $sel;?>><?php echo $rs_prop->	  		 						fields['property_name']; ?></option>
						<?php
						$rs_prop->MoveNext();
						} 
						 ?>
						</select>
				</td>
				</tr>
				<?php } else {?>
				<tr>
					<td class="txt">Property Name</td>
					<td>               
			            <div id="property_name"> 
						<select name="property_id" class="fields"   id="property_id">
						<option value="0">izaberite vlasnika </option>
						<?php 
						$qry_prop = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$rs_limit->fields['pm_id']; 
                        $rs_prop = $db->Execute($qry_prop);
						$count_prop =  $rs_prop->RecordCount();
						$totalprop = $count_prop;
						$rs_prop->MoveFirst();
						while(!$rs_prop->EOF){
						?>
						<option value="<?php echo $rs_prop->fields['id'];?>" <?php if($rs_limit->fields['property_id'] == $rs_prop->fields[id]){ $sel='selected="selected"'; }else{$sel='';} echo $sel;?>><?php echo $rs_prop->fields['property_name']; ?></option>
						<?php
						$rs_prop->MoveNext();
						} 
						?>
						</select>
						</div> 				
				    </td>
				</tr>
				<?php } ?>
					
					<tr>
					
<tr>
      <td>Image Title<br/>[Naziv slike]</td>
      <td><input type="text" name="image_title" class="fields" id="image_title" value="<?php echo $rs_limit->fields['image_title']; ?>" />
      </td>
    </tr>
	
	
				<tr>
      <td class="txt">Price<br/>[Cijena]</td>
      <td><input type="text" name="price" class="fields" id="price" value="<?php echo $rs_limit->fields['price']; ?>" />
      </td>
    </tr>
	
    <tr>
      <td>Image Status<br/>[Status slike]</td>
    <td>
	  <select name="image_status" class="fields"   id="image_status">
         <option value="0" <?php if($rs_limit->fields['image_status']==0){echo 'selected="selected"';} ?>>Disable</option>
          <option value="1" <?php if($rs_limit->fields['image_status']==1){echo 'selected="selected"';} ?>>Enable</option>
		</select>
		</td>
    </tr>
  
    <tr>
      <td>Image Ordering<br/>[Redosljed slika]</td>
      <td><input type="text" name="image_ordering" class="fields" id="image_ordering" value="<?php echo $rs_limit->fields['image_ordering']; ?>" /></td>
    </tr>
    
					<tr>
						<td>Footer Images<br/>[Slike ]</td>
						<td><input type="file" name="image_name" class="fields" id="image_name" value="<?php echo $rs_limit->fields['image_name']; ?>" />
						 </td><td> </td>
						 
					<tr><td></td>
						<td> 
			<img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL."media/slider/footer_images/".$rs_limit->fields['image_name'];?>&w=50&h=40&zc=1" border="0" />
					 </td><td></td><td> </td><td> </td>
					</tr> 
					     
	   				
               
	        <td>&nbsp;</td>
			<td>
			<input style="margin:5px; width:200px; float:none; text-align:center;" type="submit" name="submit" id="sumbit" value="Update footer image &nbsp;[A&#382;uiraj sliku]" class="button" />			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="edit_footer_banner" />
			<input type="hidden" name="act2" value="footer_banner" />
			<input type="hidden" name="request_page" value="mng_footer_banner" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['car_picture']; ?>" />
			<input type="hidden" name="mode" value="update">
			
		</form>
		</td>
	</tr>
</table>

