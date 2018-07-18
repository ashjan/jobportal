<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
$maxRows  = 50;
$pageNum  = $_GET['pageNum'];
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

 $qry_regions     = "SELECT * from ".$tblprefix."property_regions";  
	$rs_regions   = $db->Execute($qry_regions);

 $qry_lndmaktyp   = "SELECT * from ".$tblprefix."landmark_type";  
	$rs_lndmaktyp = $db->Execute($qry_lndmaktyp);
	
$qry_faq    = "SELECT * FROM ".$tblprefix."landmarks" ;
$rs_faq     = $db->Execute($qry_faq);
$count_add  =  $rs_faq->RecordCount();
$totalRows  = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit  = "SELECT * FROM ".$tblprefix."landmarks LIMIT $startRow,$maxRows"; 
$rs_limit   = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Landmarks</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Landmarks Found: <?php echo $totalcountalpha ?></td>
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
        <table cellpadding="1" cellspacing="1" border="0" class="txt" >
        <tr>
	        <td class="txt2">
  			Region
		   	</td>
			<td>
			
			<select name="region_id" class="fields" id="region_id" onchange="">
				 	<option value="0">Select Region</option>
					<?php
					$rs_regions->MoveFirst();
					while(!$rs_regions->EOF){
										?>
		  			<option value="<?php echo $rs_regions->fields['id'];?>"
					 ><?php echo $rs_regions->fields['region_name'];  ?></option>
					<?php
					$rs_regions->MoveNext();
					}
					?>			
					</select>
			
			</td>
        </tr>                    
        <tr>
	        <td class="txt2">
  			Landmark Name
		   	</td>
			<td><input type="text" name="landmark_name" class="fields" value="" /></td>
        </tr>
		<tr>
	        <td class="txt2">
  			Landmark Type
			</td>
			<td>
			<select name="landmark_type" class="fields" id="landmark_type" onchange="">
				 	<option value="0">Select Landmark Type</option>
					<?php
					$rs_lndmaktyp->MoveFirst();
					while(!$rs_lndmaktyp->EOF){
					?>
		  			<option value="<?php echo $rs_lndmaktyp->fields['id'];?>"><?php echo $rs_lndmaktyp->fields['landmark_type_name'];  ?></option>
					<?php
					$rs_lndmaktyp->MoveNext();
					}
					?>			
			</select>
			</td>
        </tr>
		<tr>
	        <td class="txt2">
  			Landmark Latitude
		   	</td>
			<td>
			<input type="text" name="landmark_lat" class="fields" value="" />
			</td>
        </tr>
		
		
		<tr>
	        <td class="txt2">
  			Landmark Longtitude
		   	</td>
			<td>
			<input type="text" name="landmark_long" class="fields" value="" />
			</td>
        </tr>
		
		<tr>
	        <td class="txt2">
  			Landmark Status
		   	</td>
			<td>
			<select name="landmark_status" class="fields">
				<option value="1">Yes</option>
				<option value="0" selected="selected">No</option>
			</select>
			</td>
        </tr>
		
		<tr>
	        <td>&nbsp;
				
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Landmarks" class="button" />
			</td>
        </tr>

		</table>
			<input type="hidden" name="act" value="manage_landmarks" />
			<input type="hidden" name="request_page" value="landmarks_management" />
			<input type="hidden" name="mode" value="add">

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
			<tr class="tabheading">
				<td width="10%">Sr#</td>
                <td width="20%">Region</td>
                <td width="20%">Landmark Name</td>
				<td width="10%">Landmark Type</td>
				<td width="10%">Landmark Latitude</td>
				<td width="10%">Landmark Longtitude</td>
				<td width="10%">Landmark Status</td>
				<td width="10%">Options</td>
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
						<td valign="middle"><?php $qry_lregion = "SELECT * FROM
						 ".$tblprefix."property_regions WHERE 
						 id=".$rs_limit->fields['region_id'];
						$rs_lregion = $db->Execute($qry_lregion);
						echo $rs_lregion->fields['region_name']; ?> </td>
						<td valign="middle"><?php echo $rs_limit->fields['landmark_name']; ?> </td>
						
						<td valign="middle"><?php $qry_lndmaktyp = "SELECT * FROM
						 ".$tblprefix."landmark_type WHERE 
						 id=".$rs_limit->fields['landmark_type'];;
						$rs_lndmaktyp = $db->Execute($qry_lndmaktyp);
						echo $rs_lndmaktyp->fields['landmark_type_name']; ?></td>
						<td valign="middle"><?php echo $rs_limit->fields['landmark_lat']; ?></td>
						<td valign="middle"><?php echo $rs_limit->fields['landmark_long']; ?></td>
						<td align="center"> 
					  
					 <?php  if($rs_limit->fields['landmark_status']==0){ ?>
					  <a href="admin.php?act=manage_landmarks&amp;landmark_status=0&amp;mode=change_default&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=landmarks_management">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make Default" border="0" />					  </a>
					  <?php }else{ ?>
                        <a href="admin.php?act=manage_landmarks&amp;landmark_status=1&amp;mode=change_default&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=landmarks_management">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Make Default" border="0" />						</a>
						<?php } ?>
					  </td>
					   <td valign="middle" text align="center">
							<a href="admin.php?act=edit_landmarks&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?> &amp;request_page=landmarks_management"  ><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=manage_landmarks&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=landmarks_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } 
							?>
							</div>
							</div>	
							<!-- END: Pagination Code -->
							</td>
					</tr>
			
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Landmarks Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>
