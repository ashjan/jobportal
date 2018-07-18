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
	$module_pm_where = ' WHERE  '.$tblprefix.'bedding.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' AND '.$tblprefix.'properties.pm_type=0';
}else{
	$module_pm_where = 'WHERE '.$tblprefix."properties.pm_type=0";
}



if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

	$qry_faq = "SELECT
					".$tblprefix."rooms.room_type,
					".$tblprefix."rooms.id,
					".$tblprefix."bedding.room_id,
					".$tblprefix."bedding.property_id,
					".$tblprefix."bedding.pm_id,
					".$tblprefix."bedding.id,
					".$tblprefix."bedding.bedding_type_name,
					".$tblprefix."bedding.number_beds,
					".$tblprefix."bedding.extra_beds,
					".$tblprefix."bedding.dimensions_width,
					".$tblprefix."bedding.dimensions_length,
					".$tblprefix."properties.property_name,
					".$tblprefix."users.first_name,
					".$tblprefix."users.last_name
					FROM
					".$tblprefix."bedding
					Inner Join ".$tblprefix."rooms ON ".$tblprefix."bedding.room_id = ".$tblprefix."rooms.id 
					Inner Join ".$tblprefix."properties ON ".$tblprefix."bedding.property_id= ".$tblprefix."properties.id 
					Inner Join ".$tblprefix."users ON ".$tblprefix."bedding.pm_id = ".$tblprefix."users.id
					 $module_pm_where 
					";
			
					
					

$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT
					".$tblprefix."rooms.room_type,
					".$tblprefix."rooms.id,
					".$tblprefix."bedding.room_id,
					".$tblprefix."bedding.property_id,
					".$tblprefix."bedding.pm_id,
					".$tblprefix."bedding.extra_beds,
					".$tblprefix."bedding.id,
					".$tblprefix."bedding.bedding_type_name,
					".$tblprefix."bedding.number_beds,
					".$tblprefix."bedding.dimensions_width,
					".$tblprefix."bedding.dimensions_length,
					".$tblprefix."properties.property_name,
					".$tblprefix."users.first_name,
					".$tblprefix."users.last_name
					FROM
					".$tblprefix."bedding 
					Inner Join ".$tblprefix."rooms ON ".$tblprefix."bedding.room_id = ".$tblprefix."rooms.id 
					Inner Join ".$tblprefix."properties ON ".$tblprefix."bedding.property_id= ".$tblprefix."properties.id 
					Inner Join ".$tblprefix."users ON ".$tblprefix."bedding.pm_id = ".$tblprefix."users.id  $module_pm_where ORDER BY ".$tblprefix."bedding.id DESC
					LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

//List down all Rooms
$qry_region = "SELECT * FROM ".$tblprefix."rooms" ;
$rs_region = $db->Execute($qry_region);
$count_region =  $rs_region->RecordCount();
$totalRegions = $count_region;


//List down all PMs
$qry_pm = "SELECT * FROM ".$tblprefix."users" ;
$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPm = $count_pm;



//List down all Properties
$qry_properties = "SELECT * FROM ".$tblprefix."properties" ;
$rs_properties = $db->Execute($qry_properties);
$count_prop =  $rs_properties->RecordCount();
$totalprop = $count_prop;

$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' AND pm_type=0';
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();



?>
<script>
function ShowConversionResult(getid,resultid){
widthincm=$("#"+getid).val();
widthinIN=widthincm *0.4 ;
widthinIN = Math.round(widthinIN,2);
widthinIN = widthinIN + 'in';
$("#"+resultid).html(widthinIN);
}
</script>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading">Property Bedding Types Management</td>
  </tr>
  <tr>
    <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="5" align="right">Total Rooms Found: <?php echo $totalcountalpha ?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="6" align="right"><!--		<a   href="<?php //MYSURL?>admin.php?act=add_categories"   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  ><img src="<?php //MYSURL?>graphics/add.png" border="0" title="Add Country" /></a>-->
      <a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  > <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> </a> </td>
  </tr>
  <tr>
    <td colspan="6"><div id="controls" class="add_subscriber">
        <form name="managecontentfrm" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
         <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		    <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
<?php	}else{ ?> 
		  <tr>
	        <td>
  			Property Manager
		   	</td>
			<td>
			<select name="pm_id" class="fields"   id="pm_id" onchange="get_prop_name('property_id', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name_0.php"?>')">
				<option value="0">Izaberite vlasnika objekta</option>
				<?php 
   	while(!$rs_pm->EOF){
	echo '<option value="'.$rs_pm->fields['id'].'">'.$rs_pm->fields['first_name'].'  '.$rs_pm->fields['last_name'].'</option>';
	$rs_pm->MoveNext();
					}
				?>					
			</select>					

			</td>
        </tr>
		 <?php }?> 
		<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr>
             <td>Property Name</td>
              <td>
			  <div id="property_name"> 
			    <select name="property_id" id="property_id" class="fields" onchange="get_room_type2('room_ids', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type6.php"?>')">
					<option value="0">Select Property</option>
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
<?php }else{ ?>  
		  <tr>
	        <td>
  			Property Name
		   	</td>
			<td>
		<div id="property_id"> 			
		<select name="property_id" class="fields"   id="property_id">
			<option value="0">Select Property</option>
		</select>				
		 </div>	
</td>
        </tr>
        <?php }?>
		  
		<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>  
		  <tr>
	        <td>
  			Room/Property Type
		   	</td>
			<td>

			
	<div id="room_ids">
			<select name="room_ids" class="dropfields" >
			  <option value="0">Select Room</option>
			</select>
      </div>
			
							
			</td>
        </tr>
        <?php } else {?>
		  
		  <!--Room Start from here -->
          <tr>
	        <td>
  			Room Type
		   	</td>
			<td>
			<div id="room_id">
			<select name="room_id" class="fields">
				<option value="0">Select room type</option>
				<?php 
			     	while(!$rs_region->EOF){
					echo '<option value="'.$rs_region->fields['id'].'">'.$rs_region->fields['room_type'].'</option>';
					$rs_region->MoveNext();
					}
				?>					
			</select>					
            </div>
			</td>
        </tr>
        <?php }?>
        <!--Room upto here -->
           <tr><td>Bedding Type Name</td>
		   <td><input type="text" name="bedding_type_name" class="fields" id="bedding_type_name" ></td>
		   <td></td>
		   </tr>
		   
		   <tr><td>Number Of Beds</td>
		   <td><input type="text" name="number_beds" class="fields" id="number_beds" ></td>
		   <td></td>
		   </tr>
		   
		   <tr><td>Extra Beds</td>
		   <td><input type="text" name="extra_beds" class="fields" id="extra_beds" ></td>
		   <td></td>
		   </tr>
		    
			 <tr><td>Dimensions Width</td>
		   <td><input type="text" name="dimensions_width" class="smallfields" id="dimensions_width" onblur="ShowConversionResult('dimensions_width','conversion_result_width');"  >cm</td>
		   <td>
		   <div id="conversion_result_width" style="width:30px; float:right; text-align:left; border:1px solid #000000;">
		   </div>
		   </td>
		   </tr>
		   
		   <tr><td>Dimensions Length</td>
		   <td><input type="text" name="dimensions_length" class="smallfields" id="dimensions_length"  onblur="ShowConversionResult('dimensions_length','conversion_result_length');" >cm</td>
		    <td>
		   <div id="conversion_result_length" style="width:30px; float:right; text-align:left; border:1px solid #000000; ">
		   </div>
		   </td>
		   </tr>
			 		  
			  <tr>
              <td>&nbsp;</td>
              <td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Facility" class="button" />
              </td>
            </tr>
          </table>
          <input type="hidden" name="act" value="manage_bedding1" />
          <input type="hidden" name="request_page" value="bedding_management1" />
          <input type="hidden" name="mode" value="add">
        </form>
      </div></td>
  </tr>
  <form name="mngcontentform" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
    <tr>
    
	<td>
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
     <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			<tr height="5%">
			<td colspan="5" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="3%">Sr#</td>
                <td width="15%">Room Type</td>
				<td width="15%">PM</td>
				<td width="15%">Property</td>
				<td width="15%">Bedding Type Name</td>
				<td width="15%">Number Of Beds</td>
				<td width="15%">Extra Beds</td>
				<td width="15%">Width</td>
				<td width="15%">Length</td>
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
					while(!$rs_limit->EOF){?>
		 <tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
		 <td valign="top"><?php echo ++$i; ?></td>
         <td  valign="top"><?php  echo stripslashes($rs_limit->fields['room_type']); ?></td>
		 <td  valign="top"><?php  echo $rs_limit->fields['first_name'].'  '.$rs_limit->fields['last_name']; ?></td>
		 <td  valign="top"><?php  echo $rs_limit->fields['property_name']; ?></td>
		 <td  valign="top"><?php  echo stripslashes($rs_limit->fields['bedding_type_name']); ?></td>
		 <td><?php echo "No of beds in room" . "&nbsp;&nbsp;" . $rs_limit->fields['number_beds']; ?></td>
		 <td  valign="top"><?php  echo $rs_limit->fields['extra_beds']; ?></td>
		 <td><table width="100%" class="txt"><tr><td width="50%"><?php echo stripslashes($rs_limit->fields['dimensions_width'])."&nbsp;&nbsp;"."cm"; ?></td>&nbsp;&nbsp;&nbsp;<td width="50%"><?php echo stripslashes($rs_limit->fields['dimensions_width'])*0.4."&nbsp;&nbsp;"."In"; ?></td></tr></table></td>
		 <td><table width="100%" class="txt"><tr><td width="50%"><?php echo stripslashes($rs_limit->fields['dimensions_length'])."&nbsp;&nbsp;"."cm"; ?></td>&nbsp;&nbsp;&nbsp; <td width="50%"><?php echo stripslashes($rs_limit->fields['dimensions_length'])*0.4."&nbsp;&nbsp;"."In"; ?></td></tr></table></td>
		<td>
						<a href="admin.php?act=edit_bedding1&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>">	<img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=manage_bedding1&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=bedding_management1" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
					<td colspan="13" class="errmsg"> No Room Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
	</td>
  </table>
</form>

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
