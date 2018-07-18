<?php
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

$maxRows = 20;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_menu = "SELECT
                    ".$tblprefix."menu.id,
					".$tblprefix."menu.menu_order,
					".$tblprefix."menu.menu_title,
					".$tblprefix."menu.menu_link,
					".$tblprefix."menu.parent,
					".$tblprefix."menu.menu_status,
					".$tblprefix."pagecontent.page_title
					FROM
					".$tblprefix."menu  
					LEFT Join ".$tblprefix."pagecontent ON ".$tblprefix."menu.content_id = ".$tblprefix."pagecontent.id where page_type=2 ";
					

$rs_menu = $db->Execute($qry_menu);
$count_add =  $rs_menu->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT
					".$tblprefix."menu.id,
					".$tblprefix."menu.menu_order,
					".$tblprefix."menu.menu_title,
					".$tblprefix."menu.menu_link,
					".$tblprefix."menu.parent,
					".$tblprefix."menu.menu_status,
					".$tblprefix."pagecontent.page_title
					FROM
					".$tblprefix."menu  
					LEFT Join ".$tblprefix."pagecontent ON ".$tblprefix."menu.content_id = ".$tblprefix."pagecontent.id where page_type=2
					
					ORDER BY ".$tblprefix."menu.menu_order ASC LIMIT $startRow,$maxRows "; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();


// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE AL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();



?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Menu Items</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Menu Items: <?php echo $totalcountalpha ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
		<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New Menu Item" />
		</a>
		</td>
	</tr>
	<tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber">
        <table width="100%" align="center"  cellpadding="1" cellspacing="1" border="0" >
        <tr>
        <td>
  		<b>  Add Menu Item  </b>
        </td>
        </tr>                    
        <tr>
        <td>
		<form name="managemenuesfrm" id="managemenuesfrm" action="admin.php" method="post" onSubmit="return validate_managemenues()" enctype="multipart/form-data">
			<table width="450" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
				<tr>
					<td class="fieldheading">Menu Title : </td>
					 <td >
					 <input width="300" size="40" name="menu_title" class="fields" id="menu_title" type="text"  class="tex" />
					</td>
				</tr>
                <tr>
					<td class="fieldheading"> Menu Content : </td>
					 <td>
					<?php 
					$qry_getcontent = "SELECT * FROM ".$tblprefix."pagecontent";
					$rs_getcontent = $db->Execute($qry_getcontent);
					$count_contents =  $rs_getcontent->RecordCount();
					$totalContents = $count_contents;
					?>
					 <select name="content_id" class="fields" id="content_id" >
					 <option value="0">Select Content Page</option>
					 <?php
					while(!$rs_getcontent->EOF){
					 echo '<option value="'.$rs_getcontent->fields['id'].'">'.$rs_getcontent->fields['page_title'].'</option>';
					 $rs_getcontent->MoveNext();
					 }
					 ?>
					 </select>
                     </td>
				</tr>
               <tr>
					<td class="fieldheading">Parent :</td>
					 <td>
					<?php 
					$qry_getmenues = "SELECT * FROM ".$tblprefix."menu";
					$rs_getmenues = $db->Execute($qry_getmenues);
					$count_menues =  $rs_getmenues->RecordCount();
					$totalMenues = $count_menues;
					?>
					<select name="parent" class="fields" id="parent" >
					<option value="0">Select Parent Menu</option>
					<?php
					while(!$rs_getmenues->EOF){
					 echo '<option value="'.$rs_getmenues->fields['id'].'">'.$rs_getmenues->fields['menu_title'].'</option>';
					 $rs_getmenues->MoveNext();
					 }
					?>
					</select>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">
					<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="Sbtadd_menu" id="Sbtadd_menu" value="Add Menu Item" class="button" />
					<input type="hidden" name="mode" value="add" />
					<input type="hidden" name="act" value="noncomercialmenus">
					<input type="hidden" name="act2" value="noncomercialmenus">
					<input type="hidden" name="request_page" value="manange_noncommercial_menus" />
					</td>
				</tr>
			</table>
	</form>
		</td>
		</tr>
		</table>
</div>
		 </td>
		 </tr>
  <tr>
    <td>
		<form name="list_order" id="list_order" method="post" enctype="multipart/form-data" action="admin.php?act=manange_noncommercial_menus" >
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="7%"><table cellpadding="0" cellspacing="0"><tr class="tabheading"><td>Menu Order</td><td>
				<input type="submit" title="Save Ordering" name="sbt_ordering" value="" class="save_icon" />
				</td></tr></table></td>
                <td width="30%">Menu Title</td>
				<td width="35%">Menu Content</td>
				<td width="12%">Parents</td>
				<td width="12%">Menu Status</td>
				<td width="11%">Options</td>
		    </tr>
			<?php if($totalcountalpha >0){ 
			if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }       
					while(!$rs_limit->EOF){  ?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
					<td valign="top">
					<input size="3" style="text-align:center; width:50px; background:#FFFFDD; border:#0000FF 1px solid;" name="menu_order[<?php echo $rs_limit->fields['id']; ?>]" id="menu_order[<?php echo $rs_limit->fields['id']; ?>]" type="text" value="<?php echo $rs_limit->fields['menu_order'];?>"/>
					</td>
                    <td valign="top"><?php  echo $rs_limit->fields['menu_title']; ?></td>
					<td valign="top"><?php echo $rs_limit->fields['page_title']; ?></td>
					<td><?php 
						if($rs_limit->fields['parent']==0){
							echo 'N/A';
						}else{
							$qry_parent = "SELECT menu_title FROM ".$tblprefix."menu WHERE id=".$rs_limit->fields['parent']; 
							$rs_parent = $db->Execute($qry_parent);
							if($rs_parent->RecordCount()>0){ 
							echo $rs_parent->fields['menu_title'];
							}else{ echo "N/A"; 
							}
						}
						?></td>
						<!--Status code here-->
						<td> 
					  <?php if($rs_limit->fields['menu_status']==0){ 
					  ?>
					  <a href="admin.php?act=noncommercialmenus&amp;m_status=1&amp;mode=change_default&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=manange_noncommercial_menus">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make Default" border="0" />
					  </a>
					  <?php }else{ 
					   ?>
                        <a href="admin.php?act=noncommercialmenus&amp;m_status=0&amp;mode=change_default&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=manange_noncommercial_menus">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Make Default" border="0" />
						</a>
					  <?php } ?>
					   </td>
						<!--Status code upto here-->
						<td valign="top">
							<a href="admin.php?act=edit_noncommercial_menus&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?> &amp;"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit Menu Item" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=noncommercialmenus&amp;mode=del_menu&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=manange_noncommercial_menus" onClick="return confirm('Are you sure you want to Delete this menu Item?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
						 <a href="admin.php?act=<?php echo $_GET['act']; ?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Menu Item Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
		            <input type="hidden" name="mode" value="change_ordering" />
					<input type="hidden" name="act" value="noncommercialmenus">
					<input type="hidden" name="request_page" value="manange_noncommercial_menus" />
		</form>
		
			</td>
  </tr>
</table>