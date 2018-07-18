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

$qry_faq = "SELECT * FROM ".$tblprefix."golofr_badge where id='1'" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT * FROM ".$tblprefix."golofr_badge where id='1'"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Manage Badge Image
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">
	
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	
	
	<tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber">
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
        <table cellpadding="1" cellspacing="1" border="0" class="txt" >
                            
        <tr>
	        <td>
  			Badge Image
		   	</td>
			<td><input type="file" name="landmark_icon" class="fields" /></td>
        </tr>
		
		<tr>
	        <td>&nbsp;
				
			</td>
			<td>
<input style="margin:5px; width:200px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Image" class="button" />
			</td>
        </tr>

		</table>
			<input type="hidden" name="act" value="goldofr_badge" />
			<input type="hidden" name="request_page" value="landmark_type_management" />
			<input type="hidden" name="mode" value="addbadgegold">
			<input type="hidden" name="badgeid" value="<?php echo $rs_limit->fields['id']; ?>" />
			<input type="hidden" name="landmark_icon_old" value="<?php echo $rs_limit->fields['badge_path']; ?>" />

		</form>
</div>
		 </td>
		 </tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table table-hover">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<th width="20%">Sr#</th>
                
                <th width="55%">Badge Image</th>
				<th width="10%">Options</th>
		    </tr>
			<?php 
				if($totalcountalpha >0){
				
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
				
				
			?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="middle"><?php echo ++$i; ?></td>
                        
					
						
						<td valign="middle">
<!--<img src="<?php //echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=graphics/landmark_type_uploads/<?php //echo $rs_limit->fields['landmark_icon']; ?> &w=50&h=50&zc=1" border="0"/> -->

<img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL; ?>graphics/thumbnail_upload/<?php echo $rs_limit->fields['badge_path']; ?>&w=60&h=70&zc=1" border="0"/>

</td>
						
	   <td valign="middle" text align="center">
		<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" />
		</a>
	
							
                       </td>
					</tr>
			<?php 
						
			?>
					<tr>
						<td>&nbsp;</td>
					</tr>
					
					
			
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Badge Image Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
</div></div>
<?php //echo $where;?>
