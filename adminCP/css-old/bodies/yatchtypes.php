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

$qry_faq = "SELECT pa.* FROM `".$tblprefix."yatchtypes` as pa "; 
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_manage = "SELECT * FROM ".$tblprefix."yatchagency";
$rs_property_manag = $db->Execute($qry_manage);


$qry_facility = "SELECT * FROM ".$tblprefix."yacht_facility"; 
$rs_facility = $db->Execute($qry_facility);
$totalcountalfacility =  $rs_facility->RecordCount();

    	 		$qry_limit = "SELECT pa.*,pc.yatch_category_name
				FROM ".$tblprefix."yatchtypes as pa
				INNER JOIN  ".$tblprefix."yatch_category as pc ON pc.id=pa.yatch_cat 
				LIMIT $startRow,$maxRows";
$rs_limit = $db->Execute($qry_limit);


$qry_yachttype="SELECT * FROM ".$tblprefix."yatchtypes LIMIT $startRow,$maxRows"; 
$rs_yachttype=  $db->Execute($qry_yachttype);
$totalcountalpha =  $rs_yachttype->RecordCount();
$qry_property_manag = "SELECT
                    tbl_property_manager.id,
					tbl_property_manager.first_name,
					tbl_property_manager.last_name
					FROM
					tbl_property_manager"; 
$rs_property_manag = $db->Execute($qry_property_manag);
$rs_property_manager = $db->Execute($qry_property_manag);

$qry_yatchcat = "SELECT * FROM ".$tblprefix."yatch_category"; 
$rs_yatchcat = $db->Execute($qry_yatchcat);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Yatch General Specification</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Yachts Found: <?php echo $totalcountalpha ?></td>
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
			<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" id="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>"> </td></tr>
		
		
		
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
				 	<option value="0">Select Yatch Manager</option>
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
							<option value="0">First Select PM</option>
						</select>
					</div>
					
					</td>
				</tr>
				<?php } ?>
				
		
        <tr>
		<td>
  			Destination
		   	</td>
			<td>
			<input type="text" name="destination" class="fields" id="destination" />
			</td>
        </tr>
        
        		
		<tr>
		<td>
  			Yatch Model
		   	</td>
			<td>
			<input type="text" name="yatch_name" class="fields" id="yatch_name" />
			</td>
        </tr>     
        
        <!--This is the new fileds -->
        <tr>
		<td>
  			Number Yatch
		   	</td>
			<td>
			<input type="text" name="number_yachts" class="fields" id="number_yachts" />
			</td>
        </tr>
        <!--Number yatch field is ended here-->
        
                       
		
		<tr>
		<td>
  			Yatch Category
		   	</td>
			<td>
			<select name="yatcat" id="yatcat" class="fields">
            <option value="0">Select Yatch Category</option>
			<?php while(!$rs_yatchcat->EOF)
				{
                     ?>
		  			<option value="<?php echo $rs_yatchcat->fields['id'];?>">
					<?php echo $rs_yatchcat->fields['yatch_category_name'] ;?>
					</option>
	                <?php $rs_yatchcat->MoveNext();
				} ?>	
			</select>
			</td>
        </tr>                    
		
		<tr>
				<td class="txt1">Built Year</td>
				<td>
				<input name="built_year" id="built_year" value="" type="text" class="fields"  maxlength="30" />
				</td> 
		</tr>
		
		<tr>
		<td class="txt1">Yatch Length</td>
		<td>
		<input name="yatch_length" id="yatch_length" value="" type="text" class="fields"  maxlength="30" /> m(meter)
	    </td> 
		</tr>
		
		
		<tr>
				<td class="txt1">Yatch Beam</td>
				<td>
				<input name="yatch_beam" id="yatch_beam" value="" type="text" class="fields"  maxlength="30" /> m(meter)
				
				</td> 
		</tr><tr>
				<td class="txt1">Yatch Draft</td>
				<td>
				<input name="yatch_draft" id="yatch_draft" value="" type="text" class="fields"  maxlength="30" /> m(meter)
				
				</td> 
		</tr>
		<tr>
				<td class="txt1">Yatch Engine</td>
				<td>
				<input name="yatch_engine" id="yatch_engine" value="" type="text" class="fields"  maxlength="30" />
				
				</td> 
		</tr>
		<tr>
				<td class="txt1">Yatch Fuel Tank</td>
				<td>
				<input name="yatch_fuel_tank" id="yatch_fuel_tank" value="" type="text" class="fields"  maxlength="30" />  L(Liter) 
				
				</td> 
		</tr>
		
		<tr>
				<td class="txt1">Cabins</td>
				<td>
				<input name="cabins" id="cabins" value="" type="text" class="fields"  maxlength="30" />
				
				</td> 
		</tr>
		
		<tr>
				<td class="txt1">Yatch Water Tank</td>
				<td>
				<input name="water_tank" id="water_tank" value="" type="text" class="fields"  maxlength="30" />  L(Liter) 
				
				</td> 
		</tr>
		<tr>
				<td class="txt1">Yatch Berthsk</td>
				<td>
				<input name="yathch_berths" id="yathch_berths" value="" type="text" class="fields"  maxlength="30" />
				
				</td> 
		</tr>
		<tr>
				<td class="txt1">Yatch Seats</td>
				<td>
				<input name="yatch_seats" id="yatch_seats" value="" type="text" class="fields"  maxlength="30" />
				
				</td> 
		</tr><tr>
				<td class="txt1">Yatch Additional Berth</td>
				<td>
				<input name="yatch_additional_berth" id="yatch_additional_berth" value="" type="text" class="fields"  maxlength="30" />
				
				</td> 
		</tr><tr>
				<td class="txt1">Yatch wc</td>
				<td>
				<input name="yatch_wc" id="yatch_wc" value="" type="text" class="fields"  maxlength="30" />
				
				</td> 
		</tr>
		
		<tr>
				<td class="txt1">Yatch Showers</td>
				<td>
				<input name="yatch_showers" id="yatch_showers" value="" type="text" class="fields"  maxlength="30" />
				
				</td> 
		</tr>
        
        
        <tr>
				<td class="txt1">Yatch Picture</td>
				<td>
				<input name="yatch_picture" id="yatch_picture" value="" type="file" class="fields" />
				
				</td> 
		</tr>
        
        
        
        
		<tr><tr>
				<td class="txt1">Yatch Navigation Electronic</td>
				<td>
				<textarea name="yatch_navigation_electronic" id="yatch_navigation_electronic" style="width: 224px; height: 145px;"></textarea>
				
				
				</td> 
		</tr><tr>
				<td class="txt1">Sail And Deck</td>
				<td>
				<textarea name="sailanddeck" id="sailanddeck" style="width: 224px; height: 145px;" ></textarea>				
				</td> 
		</tr>
        <!--<tr>
				<td class="txt1">Yatch Week Day</td>
				<td>
				<input name="yatch_week_day" id="yatch_week_day" value="" type="text" size="35"  maxlength="30" />
				
				</td> 
		</tr>-->
		
		<tr>
				<td class="txt1">Yatch Comfort</td>
				<td>
				<textarea name="yatch_comfort" style="width: 224px; height: 145px;" id="yatch_comfort"></textarea>
							
				</td> 
		</tr>
		
		<tr>
				<td class="txt1">Yatch Other</td>
				<td>
				<textarea name="yatch_other" style="width: 224px; height: 145px;" id="yatch_other"></textarea>
				
				</td> 
		</tr>
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Yatch" class="button" />
			</td>
        </tr>

		</table>
			<input type="hidden" name="act" value="<?=$_GET['act']?>" />
			<input type="hidden" name="request_page" value="yatchtypes_mangagemnet" />
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
				<td width="3%">Sr#</td>
                <td width="40%">Yacht Model </td> 
              	<td width="10%">Yacht Model </td> 
				<td width="40%">Number Yacht</td>
				<td width="7%">Options</td>
		    </tr>
			<?php 
				if($totalcountalpha >0){
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
					while(!$rs_yachttype->EOF){
			?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="middle"><?php echo ++$i; ?></td>
                        <td valign="middle">
						<?php 
					echo 	$rs_yachttype->fields['yatch_name']; 
						?>
					</td>
                    
                    
					<td valign="middle"><?php 
										$cat = $rs_yachttype->fields['yatch_agency'];
										$qry_ycaht_cat = "SELECT * FROM ".$tblprefix."yatchagency WHERE agn_id=".$cat;
										$rs_ycaht_cat = $db->Execute($qry_ycaht_cat); 
										?>
					<?php echo $rs_ycaht_cat->fields['agn_name'];  ?>
					</td>
                    <td valign="middle">
						<?php 
					echo 	$rs_yachttype->fields['number_yachts']; 
						?>
					</td>		
				    <td valign="middle">
							<a href="admin.php?act=edityatchtypes&amp;id=<?php echo base64_encode($rs_yachttype->fields['id']);?> &amp;request_page=yatchtypes_mangagemnet"  ><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=<?=$_GET['act']?>&amp;mode=delete&amp;id=<?php echo base64_encode($rs_yachttype->fields['id']); ?>&amp;request_page=yatchtypes_mangagemnet" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                    </td>
					</tr>
			<?php 
						$rs_yachttype->MoveNext();
					}
			?>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="hidden" name="act" value="<?=$_GET['act']?>">		
							<input type="hidden" name="mode" value="delete">
							<input type="hidden" name="request_page" value="yatchtypes_mangagemnet">
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
					<td colspan="14" class="errmsg"> No Yacht Type Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
