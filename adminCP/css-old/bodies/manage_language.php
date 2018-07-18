<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."language" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT * FROM ".$tblprefix."language LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Manage Languages
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">
	
    <tr>
        <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Languages Found: <?php echo $totalcountalpha ?></td>
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
        <table cellpadding="1" cellspacing="1" border="0" class="txt" >
        <tr>
	        <td>
  			Language Name
		   	</td>
			<td><input type="text" name="lan_name" class="fields" value="" /></td>
        </tr>                    
        <tr>
	        <td>
  			Language Code
		   	</td>
			<td><input type="text" name="lan_code" class="fields" value="" /></td>
        </tr>
		<tr>
	        <td>
  			Default Language
			</td>
			<td>
			<select name="default_lang" class="fields">
				<option value="1">Yes</option>
				<option value="0" selected="selected">No</option>
			</select>
			</td>
        </tr>
		<tr>
	        <td>
  			flag
		   	</td>
			<td>
			<input type="file" name="image" class="fields" />
			</td>
        </tr>
		<tr>
	        <td>&nbsp;
				
			</td>
			<td>
			<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Language" class="button" />
			</td>
        </tr>

		</table>
			<input type="hidden" name="act" value="manage_language" />
			<input type="hidden" name="request_page" value="language" />
			<input type="hidden" name="mode" value="add">

		</form>
</div>
		 </td>
		 </tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table-hover">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<th width="3%">Sr#</th>
                <th width="30%">Flag</th>
                <th width="30%">Language Name</th>
				<th width="10%">Code</th>
				<th width="16%">Default Language</th>
				<th width="11%">Options</th>
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
                        
					
						
						
						<td valign="middle"><img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo $rs_limit->fields['flag_full_path']; ?> &w=50&h=50&zc=1" border="0"  /> </td>
						<td valign="middle"><?php echo $rs_limit->fields['Lan_name']; ?></td>
						<td valign="middle"><?php echo $rs_limit->fields['Lan_code']; ?></td>
						<td align="center"> 
					  
					  <?php if($rs_limit->fields['Lan_default']==0){ ?>
					  <a href="admin.php?act=manage_language&amp;mode=change_default&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=language">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make Default" border="0" />
					  </a>
					  <?php }else{  ?>
                        <a href="#">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Make Default" border="0" />
						</a>
					  <?php } ?>
					  
					  
					   </td>
					   <td valign="middle" text align="center">
							<a href="admin.php?act=update_language&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?> &amp;request_page=categories_management"  ><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<!--<a href="admin.php?act=manage_language&amp;mode=delete&amp;id=<?php //echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=language" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php //MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>-->
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
					<td colspan="14" class="errmsg"> No Category Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
</div></div>
<?php //echo $where;?>
