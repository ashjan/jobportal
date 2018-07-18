<?php
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
$maxRows = 50;

if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE '.$tblprefix.'yatmng_price.pm_id = '.$_SESSION[SESSNAME]['pm_id'].'';
}else{
	$module_pm_where = '';
}

if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;
			 $qry_faq = "SELECT 
							".$tblprefix."property_manager.first_name, 
							".$tblprefix."property_manager.last_name, 
							".$tblprefix."yatmng_price.id, 
							".$tblprefix."yatmng_price.start_date, 
							".$tblprefix."yatmng_price.end_date, 
							".$tblprefix."yatmng_price.day_weekflag, 
							".$tblprefix."yatmng_price.price,
							".$tblprefix."yatchagency.agn_name,
							".$tblprefix."yatchtypes.yatch_name as model							
							FROM
 							".$tblprefix."yatmng_price
  Inner Join ".$tblprefix."yatchagency ON ".$tblprefix."yatmng_price.agn_id = ".$tblprefix."yatchagency.agn_id
  Inner Join ".$tblprefix."yatchtypes ON ".$tblprefix."yatmng_price.yat_model = ".$tblprefix."yatchtypes.id
  Inner Join ".$tblprefix."property_manager ON ".$tblprefix."yatmng_price.pm_id = ".$tblprefix."property_manager.id 
  $module_pm_where ORDER BY ".$tblprefix."yatmng_price.id DESC";  
						
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

					$qry_limit = "SELECT 
							".$tblprefix."property_manager.first_name, 
							".$tblprefix."property_manager.last_name, 
							".$tblprefix."yatmng_price.id, 
							".$tblprefix."yatmng_price.start_date, 
							".$tblprefix."yatmng_price.end_date, 
							".$tblprefix."yatmng_price.day_weekflag, 
							".$tblprefix."yatmng_price.price, 
							".$tblprefix."yatchagency.agn_name,
							".$tblprefix."yatchtypes.yatch_name as model							
							FROM
 							".$tblprefix."yatmng_price
  Inner Join ".$tblprefix."yatchagency ON ".$tblprefix."yatmng_price.agn_id = ".$tblprefix."yatchagency.agn_id
  Inner Join ".$tblprefix."yatchtypes ON ".$tblprefix."yatmng_price.yat_model = ".$tblprefix."yatchtypes.id
  Inner Join ".$tblprefix."property_manager ON ".$tblprefix."yatmng_price.pm_id = ".$tblprefix."property_manager.id 
  $module_pm_where ORDER BY ".$tblprefix."yatmng_price.id DESC LIMIT ".$startRow.",".$maxRows;   

					
			
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();
//query for the room type drop down
$qry_region = "SELECT * FROM ".$tblprefix."rooms";
$rs_region = $db->Execute($qry_region);
$count_region =  $rs_region->RecordCount();
$totalRegions = $count_region;

//Query for the Property Manager that will be dynamically populated in the add and edit form
$qry_property_manag = "SELECT
                    ".$tblprefix."property_manager.id,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name 
					FROM
					".$tblprefix."property_manager"; 
					
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();
$property_qry = "SELECT agn_id,agn_name FROM ".$tblprefix."yatchagency WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].'';
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading">Yacht Rates Management</td>
  </tr>
  <tr>
    <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="5" align="right">Total Yacht Rates Found: <?php echo $totalcountalpha ?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="6" align="right">
      <a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  > <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> </a> </td>
  </tr>
  <tr>
    <td colspan="6"> <div id="controls" class="add_subscriber">
        <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		    <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
<?php	}else{ ?>
          <tr>
             <td>PM Name</td>
              <td>
			    <select name="first_name" id="first_name" class="fields" onchange="get_yacht_agency('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_yacht_agency.php"?>')">
					<option value="0">Select PM</option>
				 	<?php
						while(!$rs_property_manag->EOF){?>
					    <option value="<?php echo $rs_property_manag->fields['id'];?>"><?php echo $rs_property_manag->fields['first_name'].' '.$rs_property_manag->fields['last_name'];  ?></option>
						<?php
						$rs_property_manag->MoveNext();
						}?>		
				</select>
			  </td>
            </tr> 
			<?php }?>
			<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr>
             <td>Agency Name</td>
              <td>
			  <div id="agency_name"> 
			    <select name="agency" id="agency" class="fields" onchange="get_yacht_agency('agency_name', this.value, '<?php echo MYSURL."ajaxresponse/get_yacht_agency.php"?>')">
					<option value="0">Select Property</option>
					<?php  
					$rs_property->MoveFirst();
					while(!$rs_property->EOF){ ?>
 <option value="<?php echo $rs_property->fields['agn_id']; ?>"><?php echo $rs_property->fields['agn_name']; ?></option>
					<?php 
					$rs_property->MoveNext();
					} ?>
				</select>
			  </div>
			  </td>
           </tr>
<?php }else{ ?>
			<tr>
             <td>Agency Name</td>
              <td>
			  <div id="agency_name"> 
			    <select name="agency" id="agency" class="fields"  />
					<option value="0">Select Agency</option>
				</select>
				</div>
			  </td>
            </tr>
			<?php }?>
			
			<tr>
	        <td bgcolor="#3399FF">
  			Model Name
		   	</td>
			<td>
			
	<div id="room_type">
			<select name="model" class="dropfields" >
			  <option value="0">Select Model</option>
			</select>
    </div>
			</td>
        </tr>

        <!--Property name against PM name-->
        
		    
			
        
        <!--Property name against PM name End HERE-->
			 <tr>
			 <td >
			 <b> Rate</b>
			 </td></tr>
			 <tr  bgcolor="#CCCCCC">
          <td><b>Start Range</b> </td>
          <td><b>End Range</b> </td>
          <td><b>Rate</b></td>
        </tr>
       
	    <tr bgcolor="#CCCCCC">
         <td colspan="3">The date pickers and the ratio input allow you to set one price for a given date range. Chose a start and end date, input a price, and click the Set Rates button.</td>
        </tr>
		
			<tr>
			<td width="200">
			  <input type="text" name="standard_start_date"  id="standard_start_date" />
			  <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'standard_start_date',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
             </script>
			</td>
			
			 <td>
			 <input type="text" name="standard_end_date"  id="standard_end_date" />
			  <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'standard_end_date',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>
			 </td>
			
			  <td>
			  <input type="text" name="standard_rate_price"  id="standard_rate_price" />
			  </td>
			 </tr>
			 
			 <tr>
			 <td colspan="3">&nbsp;</td>
			 </tr>
			 
			 <!--<tr>
			 <td bgcolor="#3399FF">Berths</td>
			 <td>
			 <select name="berths_for_sale" class="fields"   id="berths_for_sale">
			<?php //for($i=1;$i<=25;$i++){ ?>
				<option value="<?php //echo $i; ?>"> <?php  //echo $i; ?></option>
			<?php //}?>
			</select>
			</td>
			<td>&nbsp;</td>
			 </tr>-->
			 <tr>
			 <td>Price</td>
			 <td>
			 <select name="price_style" id="price_style" onchange="price_availability('price_style','show_select')" class="fields">
			 <option value="0">Per day</option>
			 <option value="1">Per week</option>
			 </select>
			
			 </td>
			 </tr>
			   <tr>
		<td colspan="2" class="txt">
				<table border="0" cellpadding="2" cellspacing="1" width="84%" id="show_select" style="display:none;">
			       <tr>
				   <td width="30%" class="txt">Renting starts by</td>
                   <td width="32%" >
                 <select name="days_in_week" class="fields">
				<?php  for($i=1; $i<=7; $i++){?>
					<option value="<?php echo $i; ?>"  <?php if(!empty($_SESSION['add_sees']['children_age_beds'])){
					if($_SESSION['add_sees']['children_age_beds']==$i){ $sel='selected="selected"';}else{$sel='';} echo $sel;
					} ?> ><?php echo $i; ?></option>
					<?php } ?>
                 </select>				
                 </tr>
                 </table>
        </td>
        
		</tr>
			 <tr>
			 <td colspan="3">&nbsp;</td>
			 </tr>
		      
    <tr>
    <td colspan="3">
     <table width="100%" border="0" cellspacing="1" cellpadding="2" class="txt" >
		<tr>
          <td>&nbsp;</td>
        </tr>
	      <input type="hidden" name="act" value="manage_yatprice" />
		  <input type="hidden" name="request_page" value="mng_yatprice" />
          <input type="hidden" name="mode" value="add_price">
      </form>
    </tr>
      <tr> <td>&nbsp;</td>
  <td><input style="margin:5px; width:130px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert rates" class="button" /></td> 
  </tr> 
    </table>

	</td>
	</tr>
	
</table>
</div>
<table cellpadding="1" cellspacing="2" border="0" width="100%">
	
	
    <tr>
    <td colspan="3">
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
     <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
	
			<tr height="5%">
			<td colspan="5" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="2%">Sr#</td>
				<td width="15%">PM Name</td>
                <td width="15%">Agency Name</td>
                <td width="15%">Model Name</td>
				<td width="15%">Price</td>
				<td width="15%">Price Per</td>
				<td width="10%">Stating Date</td>
				<td width="10%">Ending Date</td>
				<td width="10%">Options</td>
		    </tr>
	<?php 
	$i = 0;
	if($totalcountalpha >0){
	if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
	while(!$rs_limit->EOF){?>
	
	<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
	<td colspan="11">
       <strong>Yacht Price Management</strong>
	</td>
	</tr>
	
	<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>

	<td valign="top"><?php echo $i+1; ?></td>
	<td valign="top"><?php  echo stripslashes($rs_limit->fields['first_name'].'  '.$rs_limit->fields['last_name']);?></td>
  
    <td valign="top"><?php  echo stripslashes($rs_limit->fields['agn_name']); ?></td>
    <td valign="top"><?php  echo stripslashes($rs_limit->fields['model']); ?></td>
    
	<td><?php echo stripslashes($rs_limit->fields['price']); ?></td>
	<td><?php   if($rs_limit->fields['day_weekflag']==0){
	echo "Day";
	}else{
	echo "Week";
	} ?></td>
	
	<td><?php echo stripslashes(date("m/d/Y",strtotime($rs_limit->fields['start_date']))); ?></td>
	<td><?php echo stripslashes(date("m/d/Y",strtotime($rs_limit->fields['end_date'])));  ?></td>
	<td><a href="admin.php?act=edit_yachtprice&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>">
		<img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=manage_yatprice&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=mng_yatprice" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
	</td>
	</tr>
	
	
	<?php $i=$i+1; ?>
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
					<td colspan="13" class="errmsg"> No Yacht Rate Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
	
  </table>
  </td>
  </tr>
</table>
<?php
// code for when click on edit button toggle window will open , actually that is use for insertin category 
if(isset($_GET['cateid'])){
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