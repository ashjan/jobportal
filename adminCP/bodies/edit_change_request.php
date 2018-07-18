<?php
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."change_request WHERE id=".$id;
$rs_limit = $db->Execute($qry_limit);

//   List down all Projecties
 
$qry_property_name = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_type=1" ;
  
$rs_property_name = $db->Execute($qry_property_name);
$count_property_name =  $rs_property_name->RecordCount();
$totalPM = $count_property_name;


//   List down all Project Manager


$qry_pm = "SELECT id,first_name FROM ".$tblprefix."users" ;

$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPM = $count_pm;


$qry_prop = "SELECT id,property_name FROM ".$tblprefix."properties where id = ".$rs_limit->fields['property_id']." AND pm_type=1" ;

$rs_prop = $db->Execute($qry_prop);
$count_prop =  $rs_prop->RecordCount();
$totalPM2 = $count_prop;

//Dropdown for parent 
$category_qry = "select * from ".$tblprefix."users ";
$rs_category = $db->Execute($category_qry);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Update Change Request</td>
 	</tr>
	<tr>
  		<td></td>
	</tr>
	<tr>
	<td>
	<form name="managemenufrm" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
					<tr>
						<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
						</td>
					</tr>
        		     <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php } else {?>
		<tr>
				<td class="txt2">Select Property Manager:</td>
					<td>
					<select name="pm_id" class="fields" id="pm_id" onchange="get_prop_name('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name.php"?>')">
				 	<option value="0">Izaberite vlasnika objekta</option>
					<?php
					while(!$rs_category->EOF){
										?>
		  			<option value="<?php echo $rs_category->fields['id'];?>"
					<?php
					if($rs_category->fields['id'] == $rs_limit->fields['pm_id'])
					{
						echo 'selected="selected"';
					}
					?>
					><?php echo $rs_category->fields['first_name']."  ".$rs_category->fields['last_name'];  ?></option>
					<?php
					$rs_category->MoveNext();
					}
					?>			
					</select>					
					</td>
				</tr>
				<?php }?>
				 <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
				 <tr>
					<td class="txt">Naziv objekta</td>
					<td>               
			            <div id="property_name"> 
						 <select name="property_name" class="fields"   id="property_name">
						<?php 
						$qry_property = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' AND pm_type=1';
						
                        $rs_property = $db->Execute($qry_property);
						$count_property =  $rs_property->RecordCount();
						$totalproperty = $count_property;
						$rs_property->MoveFirst();
						while(!$rs_property->EOF){
						?>
						<option value="<?php echo $rs_property->fields['id'];?>" <?php if($rs_property->fields['id']==$rs_prop->fields['id']){ $sel='selected="selected"'; }else{$sel='';} echo $sel;?>><?php echo $rs_property->fields['property_name']; ?></option>
						<?php
						$rs_property->MoveNext();
						} 
						 ?>
							
						 </select>
						</div> 				
				    </td>
				</tr>
				<?php } else {?>
				<tr>
					<td class="txt">Naziv objekta</td>
					<td>               
			            <div id="property_name"> 
						 <select name="property_id" class="fields"   id="property_id">
						<option value="<?php echo $rs_prop->fields['id']; ?>"><?php echo $rs_prop->fields['property_name']; ?></option>
							
						 </select>
						</div> 				
				    </td>
				</tr>
				<?php }?>
					
					  <tr>
                    <td>Request Text</td>
					<td>
						<input name="request_text" id="request_text" value="<?php echo $rs_limit->fields['request_text']?>" type="text" size="55"  maxlength="30" />*
						</td>
                        </tr>
						
						 <tr>
                    <td>Request Date</td>
					<td>
						<input readonly="readonly" name="request_date" id="request_date" value="<?php echo $rs_limit->fields['request_date']?>" type="text" size="55"  maxlength="30" />*
						</td>
                        </tr>
						

	        <td>&nbsp;
			</td>
			<td>
			<input type="submit" name="submit" value="Update Change Request"  />
			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="edit_change_request" />
			<input type="hidden" name="act2" value="change_request" />
			<input type="hidden" name="request_page" value="mng_chage_request" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['id']); ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>

