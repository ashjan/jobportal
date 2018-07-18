<?php
#####################################
#// media images starts here
#####################################
$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();
$mode = '';
if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}

$tbl_users = 'tbl_users';

$maxRows = 20;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
$startRow = $pageNum * $maxRows;

 $qry_faq = "SELECT id,first_name,last_name,profile_pic FROM $tbl_users where user_type=4" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil � Round fractions up i.e echo ceil(4.3);    // 5

$qry_limit ="SELECT id,first_name,last_name,profile_pic FROM $tbl_users where user_type=4" ; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();
?>




<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Images</td>
  	</tr>
    <tr>
        <td colspan="8" align="center" <?php if(isset($_GET['msg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(isset($_GET['errmsg']) && isset($_GET['msg'])){echo base64_decode($_GET['errmsg']).base64_decode($_GET['msg']);}?></td>
  </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Images Found: <?php echo $totalcountalpha ?></td>
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
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">

            
				<tr>
					<td class="txt1">User Name</td>
					<td>
					
					<select name="id" class="fields" id="id">
					<option value="0">Employer Name</option>		
					<?php 
					$rs_limit->MoveFirst();
					while(!$rs_limit->EOF){ ?>
                                             <option value="<?php echo $rs_limit->fields['id']; ?>"><?php echo $rs_limit->fields['first_name'].'&nbsp;'.$rs_limit->fields['last_name']; ?></option>
					<?php 
					$rs_limit->MoveNext();
					} ?>
						</select>
					
					</td>
				</tr>
				

		<tr>
                    <td>Image</td>
                    <td><input type="file" name="image[]" class="fields" /></td>
		</tr>
                <tr>
                    <td></td>
                    <td></td></tr>
		<tr>
                    <td></td>
                    <td><input style="margin:5px; width:162px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Upload Image" class="button" />
                    <input type="hidden" name="act" value="mediaimages" />
                    <input type="hidden" name="theValue" id="theValue" value="0" />
                    <input type="hidden" name="id" value="<?php if(isset($id)){ echo base64_encode($id); } ?>" />
                    <input type="hidden" name="request_page" value="media_upload" />
                    <input type="hidden" name="mode" value="add">
                    </td>
		</tr>
		</table>
		</form>
</div>
		 </td>
		 </tr>
                 
                  <form name="mngcontentform" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
    <tr>
    
    <td>
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
      <tr class="tabheading"> 
	  
	    <td width="5%">Sr#</td>
				<td width="20%">Name</td>
				<td width="75%">Picture</td>
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
                                        $rs_limit->MoveFirst();
					while(!$rs_limit->EOF){?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
					  
					  <td valign="top"><?php echo ++$i; ?></td>
					  <td width="3%" valign="top"><?php echo $rs_limit->fields['first_name'].'&nbsp;'.$rs_limit->fields['last_name'] ; ?></td>
						
						<td valign="middle">
						<?php
						if(!empty($rs_limit->fields['profile_pic'])){
						$image_name =$rs_limit->fields['profile_pic'];
						}else{
						$image_name ="noimg.jpg";
						}
						?>
						<img  width="78px" height="78px" src="<?php echo BASE_URL."uploads/profile_images/".$image_name.""; ?>"/>  
                                                
                                                </td>
                                        

						<td valign="middle">
							<a href="admin.php?act=editmediaimages&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;	
							<a href="admin.php?act=mediaimages&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=media_upload" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                       </td>
            </tr>
            <?php 
						$rs_limit->MoveNext();
						} 
						
						}
						
						
						
						?>
						
						<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							
							<div id="txt" align="center"> Showing <?php 
							
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
                                                        <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo max(0, $pageNum - 1)?><?php if(isset($_GET['search'])){ ?>&amp;search=<?php echo $_GET['search']; ?> <?php } ?>" ><b>[Previous]</b></a>
							
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
							else { $count = $count+11;}
							$showDot=1;
							}
							else { $count=$totalPages;
							$showDot =0;
							}
							if($pageNum>6)	
							{	?>
							<a id="<?php echo '0'; ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>" > <?php echo "<b>[First]</b>"; ?></a>
							&nbsp; <?php } 		
							
							
							for ($i=$startPage; $i< $count; $i=$i+1){
							if ($i!=$pageNum){
							?>
                                                        <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $i; ?><?php if(isset($_GET['search'])){ ?>&amp;search=<?php echo $_GET['search']; ?> <?php } ?>"><?php echo $i+1; ?></a>
							<?php 
							}else{
							echo ("<b class=txt>[". ($i + 1) ."]</b>");
							}
							} 
							?>
							
							<?php
							
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?><?php if(isset($_GET['search'])){ ?>&amp;search=<?php echo $_GET['search']; ?> <?php } ?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							
							?>
							<?php 
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?><?php if(isset($_GET['search'])){ ?>&amp;search=<?php echo $_GET['search']; ?> <?php } ?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			<!--<?php
				//}else{
			?>
				<tr>
					<td colspan="13" class="errmsg"> No Property Manager Found</td>
				</tr>
			<?php
				//}// end if($totalcount > 0)
			?>-->
						
						

  
</table>
</td>
</tr>
</table>
                 
                 
                 
  



