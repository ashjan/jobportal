<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

$id=base64_decode($_GET['id']);

 $qrlinit = "SELECT 
            ym.*, 
			agn.agn_name,
			cat.yatch_category_name 
            FROM " 
			.$tblprefix."yachtmodel as ym 
			INNER JOIN ".$tblprefix."yatch_category as cat ON cat.id=ym.categry 
			INNER JOIN ".$tblprefix."yatchagency as agn ON  agn.agn_id=ym.agncy_id 
			WHERE ym.id=".$id;

$rs_limit = $db->Execute($qrlinit);



$qry_agncy = "SELECT
                    tbl_yatchagency.agn_id,
					tbl_yatchagency.agn_name 
					FROM
					tbl_yatchagency WHERE tbl_yatchagency.pm_id='".$rs_limit->fields['pm_id']."'"; 
					
$rs_agncy = $db->Execute($qry_agncy);


	$qry_yacht_model = "SELECT * from ".$tblprefix."yachtmodel";  
	$rs_yacht_model = $db->Execute($qry_yacht_model);

	$qry_cat= "SELECT * FROM ".$tblprefix."yatch_category"; 
	$rs_cat= $db->Execute($qry_cat);

	$qry_property_manag = "SELECT
						tbl_property_manager.id,
						tbl_property_manager.first_name,
						tbl_property_manager.last_name
						FROM
						tbl_property_manager"; 
	$rs_property_manag = $db->Execute($qry_property_manag);
	//$rs_limit = $db->Execute($qry_limit);
/*$qry_faq = "SELECT * FROM ".$tblprefix."car_types" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);
*/
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Yacht Models</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	
	
	<tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber" style="display:block;">
  <table cellpadding="1" cellspacing="1" border="0" width="100%" >
  <tr>
  <td colspan="2">
 <div style="width:100%; float:none; " align="center"> 
  
 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >		
	
			<tr>
			<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">			</td></tr>

		<tr>
		<td class="txt1">Agency Name</td>
		<td>
			 <?php    $qry_content = "SELECT * FROM  ".$tblprefix."yatchagency WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'];
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		?>
<select name="agency_id" class="fields" id="agency_id" onchange="">
<?php
if($count_add<=0){?>
<option value="0">No Agency Found</option>
<?php
}else{?>
<option value="0">Select Agency</option>	
	<?php while(!$rs_content->EOF)
	{
	?>
<option value="<?php echo $rs_content->fields['agn_id'];?>"><?php echo $rs_content->fields['agn_name'] ;?></option>
	<?php $rs_content->MoveNext();
	}
	}
    
?>
</select>
</td></tr>
		<?php
			}else{?>	
	<tr>
					<td class="txt1">PM Name</td>
					<td>
					<select name="first_name" class="fields" id="first_name" onchange="get_agency_name('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_agencyy_name.php"?>')">
				 	<option value="">Select Yatch Manager</option>
					<?php while(!$rs_property_manag->EOF)
					{
                     ?>
		  			<option value="<?php echo $rs_property_manag->fields['id'];?>" 
					<?php 
					if($rs_property_manag->fields['id'] == $rs_limit->fields['pm_id'])
					{
						echo 'selected="selected"';
					}
					?>
					><?php echo $rs_property_manag->fields['first_name'] ;?>					
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
							
							
					<?php while(!$rs_agncy->EOF)
					{
					?>
						<option value="<?php echo $rs_agncy->fields['agn_id'];?>" 
						<?php 
						if($rs_agncy->fields['agn_id'] == $rs_limit->fields['agncy_id'])
						{
							echo 'selected="selected"';
						}
						?>><?php echo $rs_agncy->fields['agn_name'] ;?>
						</option>
	                <?php $rs_agncy->MoveNext();
					} ?>			
					</select>
					</div>
					
					</td>
				</tr>
				
				<?php } ?>
				
				<tr>
				<td class="txt1">Yacht Category</td>
				
				<td>
				<select name="category" id="category"  class="dropfields"  onchange="">
		<option value="0">Select Yacht category</option>
	  <?php while(!$rs_cat->EOF){ ?>
		  <option value="<?php echo $rs_cat->fields['id'];?>"
				<?php if($rs_cat->fields['id'] == $rs_limit->fields['categry']){
					  echo 'selected="selected"';
				}?>><?php echo $rs_cat->fields['yatch_category_name'] ;?>
		</option>
	    <?php $rs_cat->MoveNext();
		} ?>			
	</select>
				
				
				
				
				<!--<input type="text" name="category" class="fields"  id="category" value=""  />-->
 				</td> 
				</tr>
				<tr>
				<td class="txt1">Yacht Model</td>
				<td>
			
				<input type="text" name="yatchmodel" class="fields" id="yatchmodel" value="<?php echo $rs_limit->fields['model']; ?>" />					

	
				
 				</td> 
				
				<!-- we have to make changes -->
				</tr>
				
				
				
				
				<tr>
				<td class="txt1">Base</td>
				<td>
					<input type="text" name="basey" class="fields"  id="basey" value="<?php echo $rs_limit->fields['basey']; ?>"  />
					</td> 
				</tr><tr>
				<td class="txt1">Alternate Base</td>
				<td>
				<input type="text" name="altbasey" class="fields"  id="altbasey" value="<?php echo $rs_limit->fields['alt_base']; ?> "  />
 				</td> 
				</tr>
				
				<tr>
				<td class="txt1">No. of Yachts</td>
				<td>
				<input type="text" name="numy" class="fields"  id="numy" value="<?php echo $rs_limit->fields['numb_yacht']; ?>"  />
 				</td> 
				</tr>
				
				<!--  changes ends here -->
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:150px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Update" class="button" />
		</td>
		</tr>
		</table>
</div>

		<input type="hidden" name="mode" value="update">
		<input type="hidden" name="act" value="update_yachtmodel">
		<input type="hidden" name="act2" value="yacht_models">
		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="request_page" value="yachtmodel_management" />
</form> 

  </div>  
  </td>
  </tr>     
  </table>
</div>
		 </td>
		 </tr>
  
</table>
<?php //echo $where;?>
