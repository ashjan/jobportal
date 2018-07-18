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

/*$qry_faq = "SELECT mi.*,pm.id as pid,pm.first_name,pr.id as prid,pr.property_name  FROM `tbl_type_mediafiles` as mi INNER JOIN tbl_properties as pr ON pr.id=mi.property_id INNER JOIN tbl_users as pm ON pm.id=mi.pm_id";*/

/*$qry_faq = "SELECT amf.mf_id,amf.fileurl,agn.agn_name,suplr.supplier_name,amf.status,yat.yatch_name FROM `tbl_type_mediafiles` as amf,`tbl_supplier` as suplr,`tbl_yatch` as yat,`tbl_yatchagency` as agn WHERE amf.agncy_id=agn.agn_id and amf.supplier_id=suplr.id and amf.car_yatch_id=yat.id and amf.which_type='0' and amf.aflag='0'";*/



/* $qry_faq = "SELECT
			".$tblprefix."yatchagency.agn_name,
			".$tblprefix."yatch.yatch_name,
			".$tblprefix."type_mediafiles.`status`,
			".$tblprefix."type_mediafiles.aflag,
			".$tblprefix."type_mediafiles.fileurl,
			".$tblprefix."type_mediafiles.which_type,
			".$tblprefix."type_mediafiles.pm_id,
			".$tblprefix."type_mediafiles.mf_id,
			".$tblprefix."yatchagency.agn_id
			FROM
			".$tblprefix."type_mediafiles
			Left Join ".$tblprefix."yatch ON ".$tblprefix."type_mediafiles.yatch_id = ".$tblprefix."yatch.id
			Left Join ".$tblprefix."yatchagency ON ".$tblprefix."type_mediafiles.agncy_id = ".$tblprefix."yatchagency.agn_id";*/
			
			


 $qry_faq = "SELECT
			".$tblprefix."yatchagency.agn_name,
			".$tblprefix."yachtmodel.model,
			".$tblprefix."type_mediafiles.`status`,
			".$tblprefix."type_mediafiles.aflag,
			".$tblprefix."type_mediafiles.fileurl,
			".$tblprefix."type_mediafiles.which_type,
			".$tblprefix."type_mediafiles.car_yatch_id,
			".$tblprefix."type_mediafiles.pm_id,
			".$tblprefix."type_mediafiles.mf_id,
			".$tblprefix."yatchagency.agn_id
			FROM
			".$tblprefix."type_mediafiles
			Left Join ".$tblprefix."yachtmodel ON ".$tblprefix."type_mediafiles.yatch_id = ".$tblprefix."yachtmodel.id
			Left Join ".$tblprefix."yatchagency ON ".$tblprefix."type_mediafiles.agncy_id = ".$tblprefix."yatchagency.agn_id";
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

/*$qry_limit = "SELECT amf.mf_id,amf.fileurl,agn.agn_name,suplr.supplier_name,amf.status,yat.yatch_name FROM `tbl_type_mediafiles` as amf,`tbl_supplier` as suplr,`tbl_yatch` as yat,`tbl_yatchagency` as agn WHERE amf.agncy_id=agn.agn_id and amf.supplier_id=suplr.id and amf.car_yatch_id=yat.id and amf.which_type='0' and amf.aflag='0'";
*/
/*$qry_limit = "SELECT
			".$tblprefix."yatchagency.agn_name,
			".$tblprefix."yatch.yatch_name,
			".$tblprefix."type_mediafiles.`status`,
			".$tblprefix."type_mediafiles.aflag,
			".$tblprefix."type_mediafiles.fileurl,
			".$tblprefix."type_mediafiles.which_type,
			".$tblprefix."type_mediafiles.pm_id,
			".$tblprefix."type_mediafiles.mf_id,
			".$tblprefix."yatchagency.agn_id
			FROM
			".$tblprefix."type_mediafiles
			Left Join ".$tblprefix."yatch ON ".$tblprefix."type_mediafiles.yatch_id = ".$tblprefix."yatch.id
			Left Join ".$tblprefix."yatchagency ON ".$tblprefix."type_mediafiles.agncy_id = ".$tblprefix."yatchagency.agn_id";*/
			
 $qry_limit = "SELECT
			".$tblprefix."yatchagency.agn_name,
			".$tblprefix."yachtmodel.model,
			".$tblprefix."type_mediafiles.`status`,
			".$tblprefix."type_mediafiles.aflag,
			".$tblprefix."type_mediafiles.fileurl,
			".$tblprefix."type_mediafiles.which_type,
			".$tblprefix."type_mediafiles.car_yatch_id,
			".$tblprefix."type_mediafiles.pm_id,
			".$tblprefix."type_mediafiles.mf_id,
			".$tblprefix."yatchagency.agn_id
			FROM
			".$tblprefix."type_mediafiles
			Left Join ".$tblprefix."yachtmodel ON ".$tblprefix."type_mediafiles.yatch_id = ".$tblprefix."yachtmodel.id
			Left Join ".$tblprefix."yatchagency ON ".$tblprefix."type_mediafiles.agncy_id = ".$tblprefix."yatchagency.agn_id";			
$rs_limit = $db->Execute($qry_limit);



 $qry_property = "SELECT
                    tbl_properties.id,
					tbl_properties.property_name
					FROM
					tbl_properties"; 

$rs_property = $db->Execute($qry_property);
$totalcountproperty =  $rs_property->RecordCount();
//pm id
 $qry_property_manag = "SELECT
                    tbl_yatchagency.agn_id,
					tbl_yatchagency.agn_name
					FROM
					tbl_yatchagency"; 
$rs_property_manag = $db->Execute($qry_property_manag);

$totalcountpropertymanag =  $rs_property_manag->RecordCount();



$totalcountalpha =  $rs_limit->RecordCount();

?>




<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Yacht Type Images</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Yacht Images Found: <?php echo $totalcountalpha ?></td>
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
        
		<table>
		
		<tr>
					<td class="txt1" style="color:#FF0000;">All fields are Required.</td>
					<td>&nbsp;
									
					</td>
				</tr>
				
		
				<tr>
					<td class="txt1">Agency Name</td>
					<td>
					<div id="agency_name">
					<select name="agency_id" class="fields" id="agency_id" onchange="get_yatches('yatchdiv', this.value, '<?php echo MYSURL."ajaxresponse/get_yatchess.php"?>')">
					<option value="0">Select Agency</option>
					<?php while(!$rs_property_manag->EOF){
                     ?>
		  			<option value="<?php echo $rs_property_manag->fields['agn_id'];?>" 
					<?php //echo $is_cat_selected; ?>><?php echo $rs_property_manag->fields['agn_name'] ;?>
					</option>
	                <?php $rs_property_manag->MoveNext();
					} ?>	
						</select>
					</div>
					
					</td>
				</tr>
				
				
				<tr>
					<td class="txt1">yacht Type</td>
					<td>
					<div id="yatchdiv">
						<select name="yatch_id" class="fields" id="yatch_id">
							<option value="0">First Select Type</option>
						</select>
					</div>
					
					</td>
				</tr>
				
				
		<tr>
        <td class="txt1">Image</td>
		<td><?php echo uploadForm();?></td>
		</tr>
        <tr><td></td>
		<td></td></tr>
		<tr><td></td>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Upload Images" class="button" />
		<input type="hidden" name="act" value="yatchtypesimages" />
		 <input type="hidden" name="theValue" id="theValue" value="0" />
		<input type="hidden" name="request_page" value="mngyatchtypimages" />
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
			<tr class="tabheading">
				<td width="5%">Sr#</td>
				<td width="20">&nbsp;</td>
				<td width="20">Yacht </td>
                <td width="30%">Image</td>
                <td width="20%">Agency</td>
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
                        <td>&nbsp; 
					  
					  </td>
						<td><?php 
					 // echo stripslashes($rs_limit->fields['yatch_name']);
					 
					 $qry_rooms = "SELECT * FROM ".$tblprefix."yatchtypes WHERE id=".$rs_limit->fields['car_yatch_id']; 
$rs_yachtes = $db->Execute($qry_rooms);
					  
					  echo stripslashes($rs_yachtes->fields['yatch_name']);

					  ?></td>
						
						<td valign="middle"><a href="<?php echo $rs_limit->fields['fileurl']; ?>">
						<img  src="<?php echo SURL; ?>classes/phpthumb/phpThumb.php?src=<?php echo $rs_limit->fields['fileurl']; ?>&w=50&h=40&zc=1" border="0"></a></td>
						<td valign="middle"><?php echo $rs_limit->fields['agn_name']; ?></td>
						<td valign="middle">
							<a href="admin.php?act=edit_yatchtype_images&amp;id=<?php echo base64_encode($rs_limit->fields['mf_id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;	
							<a href="admin.php?act=yatchtypesimages&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['mf_id']); ?>&amp;request_page=mngyatchtypimages" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
							<input type="hidden" name="act" value="yatchagencyimages">		
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
					<td colspan="14" class="errmsg"> No Yatch Media Image Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>
