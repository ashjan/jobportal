<?php
$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();
if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}

$maxRows = 20;
if(isset($_GET['pageNum']))
{
    $pageNum = $_GET['pageNum'];
}
 else {
$pageNum = '';    
}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."footer_banner" ;  
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil � Round fractions up i.e echo ceil(4.3);    // 5

$qry_limit = "SELECT * FROM ".$tblprefix."footer_banner"." ORDER BY image_ordering ASC"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

$qry_pm = "SELECT id,first_name,last_name FROM ".$tblprefix."property_manager" ;
$rs_pm = $db->Execute($qry_pm);

?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Footer Banner Images
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	
    <tr>
        <td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(isset($_GET['errmsg'])){echo base64_decode($_GET['errmsg']); } elseif(isset ($_GET['okmsg'])){ echo base64_decode($_GET['okmsg']); }?></td>
    </tr>
 	<tr class="tabheading">
    	 <td colspan="13" align="right">Total Footer Banner Found: <?php echo $totalcountalpha ?></td>
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
  <table cellpadding="1" cellspacing="1" border="0" width="100%" >
  <tr>
  <td colspan="2">
 <div style="width:100%; float:none; " align="center"> 
  
 <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
<div class="border_div_categories"  align="center" >
<table cellpadding="1" cellspacing="1" border="0" >				
				
				<tr>
	        <td colspan="2"  style="text-align:left; font-weight:bold;" class="txt">
  			HR <br/>[Kategorije ]
		   	</td>
        </tr>
        <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
            <?php } else {?>
		<tr>
		<td class="txt" width="35%">HR Manager:</td>
		<td width="65%">
		<select name="first_name" class="fields" id="first_name"  onchange="get_prop_name3('property_name', this.value, '<?php echo MYSURL.							  		"ajaxresponse/get_prop_name3.php"?>')">
		<option value="0">Izaberite vlasnika objekta</option>
		<?php 
    	while(!$rs_pm->EOF){?>
		<option value="<?php echo $rs_pm->fields['id']; ?>" <?php if(!empty($_SESSION['add_sees']['first_name'])){
		if($_SESSION['add_sees']['first_name']==$rs_pm->fields['id']){
		echo "selected='selected'";
		}
		}?>
		 ><?php echo $rs_pm->fields['first_name']." ".$rs_pm->fields['last_name'];?></option>
		<?php 
		$rs_pm->MoveNext();
		}
		?>	
</select>				
            </td>
				</tr>
				<?php }?>
				<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
				<tr>
				<td class="txt">HR Name:</td>
				<td>
				<select name="property_name" class="fields"   id="property_name">
						<option value="0">izaberite vlasnika</option>
						<?php 
						$qry_prop = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' AND pm_type=1';
						$rs_prop = $db->Execute($qry_prop);
						$count_prop =  $rs_prop->RecordCount();
						$totalprop = $count_prop;
						$rs_prop->MoveFirst();
						while(!$rs_prop->EOF){
						?>
						<option value="<?php echo $rs_prop->fields['id'];?>" <?php if($_SESSION['add_sees']['property_name']==					 						$rs_prop->fields[id]){ $sel='selected="selected"'; }else{$sel='';} echo $sel;?>><?php echo $rs_prop->	  		 						fields['property_name']; ?></option>
						<?php
						$rs_prop->MoveNext();
						} 
						 ?>
						</select>
				</td>
				</tr>
				<?php } else {?>
				<tr>
					<td class="txt">HR Name</td>
					<td>               
			            <div id="property_name"> 
						<select name="property_id" class="fields"   id="property_id">
						<option value="0">izaberite vlasnika </option>
						<?php if (!empty($_SESSION['add_sees']['property_name'])){
						$qry_prop = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION['add_sees']['first_name'];
                        $rs_prop = $db->Execute($qry_prop);
						$count_prop =  $rs_prop->RecordCount();
						$totalprop = $count_prop;
						$rs_prop->MoveFirst();
						while(!$rs_prop->EOF){
						?>
						<option value="<?php echo $rs_prop->fields['id'];?>" <?php if($_SESSION['add_sees']['property_name']==$rs_prop->fields[id]){ $sel='selected="selected"'; }else{$sel='';} echo $sel;?>><?php echo $rs_prop->fields['property_name']; ?></option>
						<?php
						$rs_prop->MoveNext();
						} 
						} ?>
						</select>
						</div> 				
				    </td>
				</tr>
				<?php } ?>
				
				
				<tr>
      <td class="txt">Image Title</td>
      <td><input type="text" name="image_title" class="fields" id="image_title" value="" />
      </td>
    </tr>
				
				<tr>
      <td class="txt">Price</td>
      <td><input type="text" name="price" class="fields" id="price" value="" />
      </td>
    </tr>
	
	
    <tr>
      <td class="txt">Image Status</td>
      <td><select name="image_status" class="fields"   id="image_status">
          <option value="0">Disable</option>
          <option value="1">Enable</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="txt">Image Ordering</td>
      <td><input type="text" name="image_ordering" class="fields" id="image_ordering" value="" /></td>
    </tr>
    
    
    
    <tr>
      <td class="txt">Footer Images</td>
      <td><input  type="file" name="image_name" class="fields" id="image_name" value="" /></td>
    </tr>
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:196px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Add Footer Image" class="button" />
		</td>
		</tr>
		</table>
</div>
<tr>
    
      <td><input type="hidden" name="mode" value="add">
        <input type="hidden" name="act" value="footer_banner">
        <input type="hidden" name="act2" value="footer_banner">
        <input type="hidden" name="request_page" value="mng_footer_banner" />
      </td>
    </tr>
</form> 

  </div>  
  </td>
  </tr>     
  </table>
</div>
		 </td>
		 </tr>
  <tr>
 <form name="ordering_menu" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data"> 
	<td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="15%">
					<table class="txt" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="20%">Image Order
						<input type="submit" title="Save Ordering" name="sbt_ordering" value="" class="save_icon" />
						</td>
					</tr>
					</table>
				</td>
                <th width="15%">HR Manager</th>
				<th width="15%">HR</th>
				<th width="15%">image status</th>
				<th width="15%">Price</th>
				<th width="15%">status</th>
				<th width="15%">footer images</th>
				<th width="10%">Options</td>
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
					    <td valign="top">
					<input size="3" style="text-align:center; width:50px; background:#FFFFDD; border:#0000FF 1px solid;" name="menu_order[<?php echo $rs_limit->fields['id']; ?>];" id="menu_order[<?php echo $rs_limit->fields['id']; ?>]" type="text" value="<?php echo $rs_limit->fields['image_ordering'];?>"/>
			
					</td>    
										                   
 
  <td width="2%" valign="top"><?php $qry_pmname = "SELECT id,first_name,last_name FROM ".$tblprefix."property_manager WHERE id =".$rs_limit->fields['pm_id']; 
  $rs_pmname = $db->Execute($qry_pmname);
 echo stripslashes($rs_pmname->fields['first_name']); echo '&nbsp;';
 echo stripslashes($rs_pmname->fields['last_name']);
 
  ?></td>
  <td width="2%" valign="top"><?php
  $qry_pmname = "SELECT * FROM ".$tblprefix."properties WHERE id =".$rs_limit->fields['property_id']; 
  $rs_pmname = $db->Execute($qry_pmname);
  
  
   echo stripslashes($rs_pmname->fields['property_name']); ?></td>
                       
  <td width="2%" valign="top"><?php echo stripslashes($rs_limit->fields['image_title']); ?></td>
  <td width="2%" valign="top"><?php echo stripslashes($rs_limit->fields['price']); ?></td>
  <td width="2%" valign="top"><?php if($rs_limit->fields['image_status']==0){ 
					  ?>
					  <a href="admin.php?act=footer_banner&amp;m_status=0&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=mng_footer_banner">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make Default" border="0" />
					  </a>
					  <?php }else{ 
					  	
					   ?>
                        <a href="admin.php?act=footer_banner&amp;m_status=1&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=mng_footer_banner">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Make Default" border="0" />
						</a>
					  <?php } ?></td>
    
  <td> <!-- <td width="3%" valign="top"><?php //echo stripslashes($rs_limit->fields['car_picture']); ?>--> <img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL."media/slider/footer_images/".$rs_limit->fields['image_name'];?>&w=50&h=40&zc=1" border="0" />
					  </td>
  
  <td ><a href="admin.php?act=edit_footer_banner&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"> <img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp; <a href="admin.php?act=footer_banner&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=mng_footer_banner" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a> </td>
</tr>
<?php $rs_limit->MoveNext();
			}?>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
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
					 <td colspan="13" class="errmsg"> No Footer Image Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
	</td>
	    <input type="hidden" name="mode" value="order_menu">
		<input type="hidden" name="act" value="footer_banner">
<!--		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">-->
		<input type="hidden" name="request_page" value="mng_footer_banner" />
		</form>		
  </tr>
</table>
</div></div>
<?php //echo $where;?>

