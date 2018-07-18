<?php
$id=base64_decode($_GET['id']);
 $qry_limit = "SELECT * From ".$tblprefix."type_mediafiles WHERE mf_id=".$id; 
$rs_limit = $db->Execute($qry_limit);


$qry_supplier = "SELECT
                    tbl_supplier.id,
					tbl_supplier.supplier_name  
					FROM
					tbl_supplier WHERE tbl_supplier.agency_id='".$rs_limit->fields['agncy_id']."'"; 					
$rs_supplier = $db->Execute($qry_supplier);

$qry_yacht = "SELECT
                    tbl_yatch.id,
					tbl_yatch.yatch_name  
					FROM
					tbl_yatch"; 
								
$rs_yacht = $db->Execute($qry_yacht);




  $qry_yacht_agn = "SELECT
                    tbl_yatchagency.agn_id,
					tbl_yatchagency.agn_name
					FROM
					tbl_yatchagency";  
$rs_yacht_agn = $db->Execute($qry_yacht_agn);

$qry_property_manag = "SELECT
                    tbl_users.id,
					tbl_users.first_name,
					tbl_users.last_name
					FROM
					tbl_users"; 
$rs_property_manag = $db->Execute($qry_property_manag);

$totalcountpropertymanag =  $rs_yacht_agn->RecordCount();


?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit Yacht Video media Section</td>
 	</tr>
	<tr>
		<td>
	 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_content()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >	
<tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
	<tr>
					<td class="txt1" style="color:#FF0000;">All fields are Required.</td>
					<td>&nbsp;
									
					</td>
				</tr>
					
		
		<tr>
					<td class="txt1">PM Name</td>
					<td>
					<select name="first_name" class="fields" id="first_name" onchange="get_agency_name('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_agencyy_name.php"?>')">
				 	<option value="0">Select PM</option>
					<?php while(!$rs_property_manag->EOF)
					{
					?>
		  			<option value="<?php echo $rs_property_manag->fields['id'];?>" 
					<?php 
					if($rs_property_manag->fields['id'] == $rs_limit->fields['pm_id'])
					{
						echo 'selected="selected"';
					}
					?>><?php echo $rs_property_manag->fields['first_name'] ;?>
					</option>
	                <?php $rs_property_manag->MoveNext();
					} ?>			
					</select>					
					</td>
				</tr>
		
				<tr>
					<td class="txt1">Agency Name</td>
					<td>
					<div id="agency_name">
					<select name="agency_id" class="fields" id="agency_id">
							
							
					<?php while(!$rs_yacht_agn->EOF)
					{
					?>
						<option value="<?php echo $rs_yacht_agn->fields['agn_id'];?>" 
						<?php 
						if($rs_yacht_agn->fields['agn_id'] == $rs_limit->fields['agncy_id'])
						{
							echo 'selected="selected"';
						}
						?>><?php echo $rs_yacht_agn->fields['agn_name'] ;?>
						</option>
	                <?php $rs_yacht_agn->MoveNext();
					} ?>			
					</select>
					</div>
					
					</td>
				</tr>
				

				
				<tr>
					<td class="txt1">Yatch/Brand Type</td>
					<td>
					
					
					<!--<div id="supplierdiv">
						<select name="supplier_id" class="fields" id="supplier_id">
							<option value="0">First Select Agency</option>
						</select>
					</div>-->
					
					
					<div id="supplierdiv">
						<select name="supplier_id" class="fields" id="supplier_id">
							
					<?php while(!$rs_supplier->EOF)
					{
					?>
						<option value="<?php echo $rs_supplier->fields['id'];?>" 
						<?php 
						if($rs_supplier->fields['id'] == $rs_limit->fields['supplier_id'])
						{
							echo 'selected="selected"';
						}
						?>><?php echo $rs_supplier->fields['supplier_name'] ;?>
						</option>
	                <?php $rs_supplier->MoveNext();
					} ?>			
						</select>
					</div>
					
					</td></tr>
				
				<tr>
					<td class="txt1">Yacht Model</td>
					<td>
					
					<!--<div id="yatchdiv">
						<select name="yatch_id" class="fields" id="yatch_id">
							<option value="0">First Select Type</option>
						</select>
					</div>-->
					
					<div id="yatchdiv">
						<select name="yatch_id" class="fields" id="yatch_id">
							
					<?php 
					
					 while(!$rs_yacht->EOF)
					{
					?>
						<option value="<?php echo $rs_yacht->fields['id'];?>" 
						<?php 
						
						if($rs_yacht->fields['id'] == $rs_limit->fields['car_yatch_id'])
						{
							echo 'selected="selected"';
						}
						?>><?php echo $rs_yacht->fields['yatch_name'] ;?>
						</option>
	                <?php $rs_yacht->MoveNext();
					} ?>
						</select>
					</div>
					
					</td>
				</tr>
				
				
		<tr>
        <td class="txt1">Video</td>
		<td><input type="file" name="video" class="fields" />
		<br /><br />
		<?php 
					  if($rs_limit->fields['fileurl']!=NULL)
					  {
					   ?>
					   
					<div id="mediaplayer"></div>
					<script type="text/javascript" src="<?php echo MYSURL; ?>media/videos/jwplayer.js"></script>
					<script type="text/javascript">
						jwplayer("mediaplayer").setup({
							flashplayer: "<?php echo MYSURL; ?>media/videos/player.swf",
							file: "<?php echo $rs_limit->fields['fileurl']; ?>",
							image: "preview.jpg",
							width:150,
							height:100
						});
					</script>
							   
			   
			  		 <?php 
					  }
					  ?>
		
		</td>
		</tr>
		<tr>
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Video" class="button" />
			</td>
        </tr>
</table>				

</div>
<tr>
					<td>&nbsp;</td>
					<td>
					
					
		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="edit_yachttype_video">
		<input type="hidden" name="act2" value="mng_yachttype_video">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="old_image" value="<?php echo $rs_limit->fields['fileurl']; ?>" />
		<input type="hidden" name="request_page" value="mngyachttypvideos" />
					</td>
				</tr>
</form> 


		
		</td>
	</tr>
</table>





