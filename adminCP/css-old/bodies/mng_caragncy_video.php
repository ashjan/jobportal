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

$qry_faq = "SELECT amf.mf_id,amf.fileurl,pm.first_name,agn.agn_name,suplr.supplier_name,amf.status,yat.car_type FROM `tbl_agncy_mediafiles` as amf,`tbl_carsupplier` as suplr,`tbl_car` as yat,`tbl_agency` as agn, `tbl_property_manager` as pm WHERE amf.pm_id=pm.id and amf.agncy_id=agn.agn_id and amf.supplier_id=suplr.id and amf.car_yatch_id=yat.id and yat.agency=suplr.id and amf.which_agency='1' and amf.aflag='1'" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT amf.mf_id,amf.fileurl,pm.first_name,agn.agn_name,suplr.supplier_name,amf.status,yat.car_type FROM `tbl_agncy_mediafiles` as amf,`tbl_carsupplier` as suplr,`tbl_car` as yat,`tbl_agency` as agn, `tbl_property_manager` as pm WHERE amf.pm_id=pm.id and amf.agncy_id=agn.agn_id and amf.supplier_id=suplr.id and amf.car_yatch_id=yat.id and yat.agency=suplr.id and amf.which_agency='1' and amf.aflag='1' LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

$qry_property = "SELECT
                    tbl_properties.id,
					tbl_properties.property_name
					FROM
					tbl_properties"; 

$rs_property = $db->Execute($qry_property);
$totalcountproperty =  $rs_property->RecordCount();
//pm id
$qry_property_manag = "SELECT
                    tbl_property_manager.id,
					tbl_property_manager.first_name,
					tbl_property_manager.last_name
					FROM
					tbl_property_manager"; 
$rs_property_manag = $db->Execute($qry_property_manag);

$totalcountpropertymanag =  $rs_property_manag->RecordCount();

?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Car Agency Videos</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Videos Found: <?php echo $totalcountalpha ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
<!--		<a   href="<?php //MYSURL?>admin.php?act=add_categories"   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  ><img src="<?php //MYSURL?>graphics/add.png" border="0" title="Add Country" /></a>-->
		
		
		<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" />
		</a>
		
		</td>
	</tr>
	<tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber">

	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
        <!--<div class="image_div_title">Title</div>
		<div class="image_div_title_text"><input type="text" name="video_title" class="fields" value="" /></div>
		<div class="clear"></div>
        <div class="image_div_title">Video</div>
		<div class="image_div_title_text"><input type="file" name="video" class="fields" /></div>
		<div class="clear"></div>
		<div id="dynamicInput">
		</div>

	
		<div class="clear"></div>
	<div class="image_div_title">&nbsp;</div>
		<div class="image_div_title_text">-->
		 <table><tr>
					<td class="txt1" style="color:#FF0000;">All fields are Required.</td>
					<td>&nbsp;
									
					</td>
				</tr>
				
		<tr>
					<td class="txt1">PM Name</td>
					<td>
					<select name="first_name" class="fields" id="first_name" onchange="get_caragency_name('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_caragencyy_name.php"?>')">
				 	<option value="">Select PM</option>
					<?php while(!$rs_property_manag->EOF){$is_manager_selected = '';
							/*if($rs_property_manag->fields['id']==$rs_content->fields['page_category']){
							   $is_manager_selected = 'selected="selected"';
							}*/
                     ?>
		  			<option value="<?php echo $rs_property_manag->fields['id'];?>" 
					<?php //echo $is_cat_selected; ?>><?php echo $rs_property_manag->fields['first_name'] ;?>
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
							<option value="">First Select PM</option>
						</select>
					</div>
					
					</td>
				</tr>
				
				<tr>
					<td class="txt1">Car/Brand Type</td>
					<td>
					<div id="supplierdiv">
						<select name="supplier_id" class="fields" id="supplier_id">
							<option value="">First Select Agency</option>
						</select>
					</div>
					
					</td>
				</tr>
				
				<tr>
					<td class="txt1">Car Model</td>
					<td>
					<div id="yatchdiv">
						<select name="yatch_id" class="fields" id="yatch_id">
							<option value="">First Select Type</option>
						</select>
					</div>
					
					</td>
				</tr>
				
				
		<tr>
        <td class="txt1">Video</td>
		<td><input type="file" name="video" class="fields" /></td>
		</tr>
		<tr><td>&nbsp;</td>
		<td>
		<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Upload Video" class="button" />
		<input type="hidden" name="act" value="mng_caragncy_video" />
		 <input type="hidden" name="theValue" id="theValue" value="0" />
		<input type="hidden" name="request_page" value="mngcaragncyvideo" />
		<input type="hidden" name="mode" value="add">
		<!--</div>-->
		</td></tr></table>
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
			
				<td width="5%">Sr#</td>
				<td width="20">PM</td>
				<td width="20">Car </td>
                <td width="30%">Video</td>
                <td width="20%">Agency</td>
				<td width="5%">Options</td>
				
				<!--<td width="10%">Sr#</td>
                <td width="30%">Video</td>
                <td width="50%">Titles</td>
				<td width="10%">Options</td>-->
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
                        <td valign="middle"><?php echo $rs_limit->fields['first_name']; ?></td>
						 <td valign="middle"><?php echo $rs_limit->fields['car_type']; ?></td>
						<td valign="middle">
	<div id="mediaplayer<?php echo $i;?>">JW Player goes here  <?php echo MYSURL; ?>media/videos/jwplayer.js</div>
	<script type="text/javascript" src="<?php echo MYSURL; ?>media/videos/jwplayer.js"></script>
	<script type="text/javascript">
		jwplayer("mediaplayer<?php echo $i;?>").setup({
			flashplayer: "<?php echo MYSURL; ?>media/videos/player.swf",
			file: "<?php echo $rs_limit->fields['fileurl']; ?>",
			image: "<?php echo MYSURL; ?>media/videos/preview.jpg",
			width:150,
			height:100
		});
	</script>
<!--<video height="100" src="<?php //echo $rs_limit->fields['fileurl']; ?>" width="200" controls>
  <a href="/static/bunny.mp4">Download the video</a> for local playback.
</video> -->
</td>
						 <td valign="middle"><?php echo $rs_limit->fields['agn_name']; ?></td>
						<td valign="middle">
						<a href="admin.php?act=edit_caragncy_video&amp;id=<?php echo base64_encode($rs_limit->fields['mf_id']);?> &amp;request_page=mngcaragncyvideo"  ><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=mng_caragncy_video&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['mf_id']); ?>&amp;request_page=mngcaragncyvideo" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
							<!-- END: Pagination Code -->						</td>
					</tr>
			
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Videos Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>
