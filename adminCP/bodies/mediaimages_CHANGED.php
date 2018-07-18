<?php

	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
//----------------------------------------------------------------------//
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Images &nbsp;[Upravljanje slikama]</td>
  	</tr>
    <tr>
  <td colspan="8" align="center" <?php if(isset($_GET['msg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['msg']);?></td>
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
					<td class="txt1">Property Manager Name<br/>[Vlasnik objekta objekta]</td>
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
					<td class="txt1">Property Name<br/>[Naziv objekta]</td>
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
					<td class="txt1">Property Name<br/>[Naziv objekta]</td>
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
  			Room/Property Type<br/>[Tip sobe/objekta]
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
		<td>Title<br/>[naziv]</td>
		<td><input type="text" name="images_title" class="fields" value="" /></td>
		</tr>
		<tr>
        <td>Image<br/>[sliku]</td>
		<td><input type="file" name="image[]" class="fields" /></td>
		</tr>
        <tr><td></td>
		<td></td></tr>
		<tr><td></td>
		<td><input style="margin:5px; width:162px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Upload Image &nbsp;[Dodaj sliku]" class="button" />
		<input type="hidden" name="act" value="mediaimages" />
		 <input type="hidden" name="theValue" id="theValue" value="0" />
         <input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="request_page" value="media_upload" />
		<input type="hidden" name="mode" value="add">
		</td>
		</tr>
		</table>
		</form>
</div>
	  </td>
	</tr>
</table>

<?php 
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


$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT mi.*  
			 FROM `".$tblprefix."mediaimages` as mi  ORDER BY mi.id DESC LIMIT ".$startRow.",".$maxRows;
$rs_limit = $db->Execute($qry_limit);

?>
<div id="get_rates_image">
           <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
            <tr class="tabheading">
				<td width="5%">Sr#</td>
                <td width="20%">Image</td>
                <td width="20%">Titles</td>
				<td width="5%">Options</td>
		    </tr>
			<?php 
				if($totalcountalpha >0){
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   }
					while(!$rs_limit->EOF){
			?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
					   <td valign="middle"><?php echo ++$i; ?></td>
						<td valign="middle"><a href="<?php echo $rs_limit->fields['image_full_path']; ?>">
						<img  src="<?php echo SURL; ?>classes/phpthumb/phpThumb.php?src=<?php echo $rs_limit->fields['image_full_path']; ?>&w=50&h=40&zc=1" border="0"></a></td>
						<td valign="middle"><?php echo $rs_limit->fields['image_title']; ?></td>
						<td valign="middle">
							<a href="admin.php?act=editmediaimages&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;	
							<a href="admin.php?act=mediaimages&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=media_upload" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                       </td>
					</tr>
			<?php 
					  $rs_limit->MoveNext();
					}
			?>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="hidden" name="act" value="manageletter">		
							<input type="hidden" name="mode" value="delete">						</td>
					</tr>
					<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							
							<div id="txt" align="center"> Showing <?php 
							
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>" ><b>[Previous]</b></a>
							
							<?php }?>
							
							<?php
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
							<!-- END: Pagination Code -->						
							</td>
					</tr>
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Media Image Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
</div>		    