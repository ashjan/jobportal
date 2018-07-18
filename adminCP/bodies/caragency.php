<?php

$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();
if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}

$qry_terms = "SELECT description FROM ".$tblprefix."pagecontent WHERE page_type1='general-terms-and-conditions'";
$rs_terms = $db->Execute($qry_terms);

$maxRows = 20;
$pageNum = $_GET['pageNum'];
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."agency" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil — Round fractions up i.e echo ceil(4.3);    // 5
$vcar=$tblprefix."agency";
//$category=$tblprefix."content_category";
$qry_limit = "SELECT *
					FROM ".$vcar."
					LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

$qry_property_manag = "SELECT
                    tbl_users.id,
					tbl_users.first_name,
					tbl_users.last_name
					FROM
					tbl_users"; 
$rs_property_manag = $db->Execute($qry_property_manag);

?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Car Agency</td>
  	</tr>
  <tr><td colspan="7" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td></tr>
  <tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		<tr class="tabheading">
			  <td colspan="2">&nbsp; </td>
			  
			  <td width="9%" align="right"></td>
			  <td colspan="7" align="right">Total Agencies Found: <?php echo $totalcountalpha ?></td>
		  </tr>
		  <tr class="tabheading">
		<td colspan="7" align="right"><a href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false">
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /></a></td>
	</tr>
			<tr>
				<td colspan="7">
					<div id="controls" <?php if($_SESSION['record_add_edit']=='Yes'){ ?> style="display:block;" <?php } ?> class="add_subscriber">
                <form action="" enctype="multipart/form-data" method="post" name="testform" > 
					<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
					
					<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php
			}else{
			?>
					<tr>
					<td class="txt1">PM Name*</td>
					<td>
					<select name="first_name" class="fields" id="first_name">
				 	<option value="0">Select PM</option>
					<?php while(!$rs_property_manag->EOF){$is_manager_selected = '';
							/*if($rs_property_manag->fields['id']==$rs_content->fields['page_category']){
							   $is_manager_selected = 'selected="selected"';
							}*/
                     ?>
		  			<option value="<?php echo $rs_property_manag->fields['id'];?>" 
					<?php //echo $is_cat_selected; ?>><?php echo $rs_property_manag->fields['first_name'] ;?><?php echo '&nbsp;'; ?><?php echo $rs_property_manag->fields['last_name'] ;?>
					</option>
	                <?php $rs_property_manag->MoveNext();
					} ?>			
					</select>					
					</td>
				</tr>
				<?php } ?>
							<tr>
								<td>Agency Name*</td>
								<td><input type="text" name="agency_name" class="fields" id="agency_name" value="<?php echo $rs_limit->fields['first_name']; ?>" />						</td>
							</tr>        
							
							<tr>
								<td>Country*</td>
								<td>
								<input type="text" name="country" id="country" value="" class="fields" />								</td>
							</tr> 
							<tr>
								<td>City*</td>
								<td>
								<?php
									$qry_city = "SELECT * FROM ".$tblprefix."city" ;
									$rs_city = $db->Execute($qry_city);
								?>
								<select name="city" id="city" class="fields">
								<?php
								while(!$rs_city->EOF)
								{
								?>
								<option value="<?php echo $rs_city->fields['city_id'];?>"><?php echo $rs_city->fields['city_name'];?></option>
								<?php
									$rs_city->MoveNext();
								}
								?>
								</select>
								
								</td>
							</tr>
							 
							
							<tr>
								<td>Address*</td>
								<td>
								<textarea name="address" id="address"></textarea>
								</td>
							</tr> 
							
							<tr>
								<td>Post code*</td>
								<td>
								<input type="text" name="postcode" id="postcode" value="" class="fields" />
								</td>
							</tr> 
							
							<tr>
								<td>Phone number/fax*</td>
								<td>
								<input type="text" name="phonefax" id="phonefax" value="" class="fields" />
								</td>
							</tr> 
							
							<tr>
								<td>Phone mobile*</td>
								<td>
								<input type="text" name="mobile" id="mobile" value="" class="fields" />
								</td>
							</tr> 
							
							<tr>
								<td>E-mail*</td>
								<td>
								<input type="text" name="email" id="email" value="" class="fields" />
								</td>
							</tr> 
							
							<tr>
								<td>Latitude*</td>
								<td>
								<input type="text" name="latitude" id="latitude" value="" class="fields" />
								
								</td>
							</tr> 
							
							<tr>
								<td>Longitude*</td>
								<td>
								<input type="text" name="longitude" id="longitude" value="" class="fields" />
								</td>
							</tr> 
							
							<tr>
								<td>No.of Cars*</td>
								<td>
								<input type="text" name="yatchnumbr" id="yatchnumbr" value="" class="fields" />
								</td>
							</tr> 
							
							<tr>
								<td>Contact language</td>
								<td>
								<input type="text" name="cntactlang" id="cntactlang" value="" class="fields" />
								</td>
							</tr> 
							
							<tr>
								<td>Local bank Account</td>
								<td>
								<input type="text" name="bankaccount" id="bankaccount" value="" class="fields" />
								</td>
							</tr> 
							
							
							<tr>
								<td>Logo*</td>
								<td><input  type="file" name="car_picture" class="fields" id="car_picture" value="" /></td>
							</tr> 
							
							<tr>
								<td>Agency Type*</td>
								<td>
							<input name="agntype" type="radio" class="field_div" id="agntype" checked="checked" value="0" /> OFFLINE 
							<input name="agntype" type="radio" class="field_div" id="agntype" value="1" /> ONLINE
							</td>
							</tr>
							 
							 <tr>
								<td>Description</td>
								<td>
								<textarea name="descagn" id="descagn"></textarea>
								</td>
							</tr> 
		
				<tr>
								<td>Terms and Conditions*</td>
								<td><textarea name="trmcond" id="trmcond" class="smalltxtareas" rows="10" cols="35"></textarea></td>
							</tr>			
							
							
							
							
							
							
							
					   <tr>
					<td>&nbsp;</td>
					<td>
					<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Add Agency" class="button" />			</td>
				</tr>
					
			
					<tr>
						<td>&nbsp;</td>
						<td>
							<input type="hidden" name="mode" value="add">
							<input type="hidden" name="act" value="caragency">
							<input type="hidden" name="act2" value="caragency">
							<input type="hidden" name="request_page" value="manangecaragency" />						</td>
					</tr>
				
				
				<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
				</tr>
				</table>
</form>   
            </div>
				</td>
			</tr>		

		    <tr height="5%">
			  <td colspan="5" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="10%">Sr#</td>
				<td width="15%">PM Name</td>
				<td width="15%">Agency Name</td>
				<td width="20%">Country</td>
				<td width="20%">City</td>
				
				<td width="20%">Logo</td>
				<td width="10%">Options<br/>[Opcije]</td>
		    </tr>
			<?php 
				if($totalcountalpha >0){
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
					while(!$rs_limit->EOF){?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
						    <td width="3%" valign="top"><?php $qry_agn = "SELECT first_name , last_name FROM 
					  ".$tblprefix."users where id=".$rs_limit->fields['pm_id']; 
					   $rs_agn= $db->Execute($qry_agn);
					   echo $rs_agn->fields['first_name']; echo '&nbsp;'; echo $rs_agn->fields['last_name'];
					   ?>
  </td>
					  <td width="3%" valign="top"><?php echo stripslashes($rs_limit->fields['agn_name']); ?></td>
					  <td width="3%" valign="top"><?php echo stripslashes($rs_limit->fields['country']); ?></td>
					  <td width="3%" valign="top">
					  <?php
							$qry_cityy = "SELECT * FROM ".$tblprefix."city where city_id='".$rs_limit->fields['city']."'" ;
							$rs_cityy = $db->Execute($qry_cityy);
					 		echo stripslashes($rs_cityy->fields['city_name']); ?>
					  </td>
					  
					<td> <!-- <td width="3%" valign="top"><?php //echo stripslashes($rs_limit->fields['agency_picture']); ?>--> <img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL."graphics/agency_logos/".$rs_limit->fields['agncy_logo'];?>&w=50&h=40&zc=1" border="0" />
					  </td>
					   <!-- <img src="<?php //MYSURL ?>graphics/agency_upload/<?php //echo $rs_limit->fields['agency_picture']; ?>" width="100" height="50" /></td>-->
						
						<td >
						<a href="admin.php?act=editcaragency&amp;id=<?php echo base64_encode($rs_limit->fields['agn_id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=caragency&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['agn_id']); ?>&amp;request_page=manangecaragency" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                        		
		   </td>
					</tr>
					
			<?php $rs_limit->MoveNext();
			}?>
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
					<td colspan="13" class="errmsg"> No Agency Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
	</td>
  </tr>
</table><?php //echo $where;?>


<?php
// code for when click on edit button toggle window will open , actually that is use for insertin category 
if(isset($_GET['cateid']))
{
?>
	<script type="text/javascript">
		function openeditarea()
		{
			jQuery('#controls').slideToggle('fast'); 
			return false;
		}
		openeditarea();
	</script>
<?php 
}
?>
