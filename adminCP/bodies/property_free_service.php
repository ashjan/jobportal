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

$qry_faq = "SELECT * FROM ".$tblprefix."property_free_services" ;

$rs_faq = $db->Execute($qry_faq);
if($rs_faq)
{
    $count_add =  $rs_faq->RecordCount();
}
else {
    $count_add =  "";
}

$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT * FROM ".$tblprefix."property_free_services LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);

if($rs_faq)
{
    $totalcountalpha =  $rs_limit->RecordCount();
}
else {
    $totalcountalpha =  "";
}

//  G  E T        A L L     T H E     L A N G U A G E          F I E L D S  
$language_query = "SELECT * FROM  ".$tblprefix."language   
						    WHERE ".$tblprefix."language.id<>4";
$rs_language    = $db->Execute($language_query);
$totallanguage  = $rs_language->RecordCount();						   

//  G  E T       A L L    T H E     T R A N S L A T E D      F I E L D S  LANGUAGE CONTENTS
$language_content_query = "SELECT 
                           ".$tblprefix."language_contents.id,
						   ".$tblprefix."language_contents.language_id,
                           ".$tblprefix."language_contents.page_id,
                           ".$tblprefix."language_contents.field_name,
                           ".$tblprefix."language_contents.translation_text,
                           ".$tblprefix."language_contents.translated_text,
                           ".$tblprefix."language_contents.fld_type
                           FROM  ".$tblprefix."language_contents   
						   WHERE ".$tblprefix."language_contents.fld_type='free_services' 
						   AND   ".$tblprefix."language_contents.field_name='service_name'";
$rs_language_content = $db->Execute($language_content_query);
$totallanguagecontent =  $rs_language_content->RecordCount();
?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Manage Free Property Services
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">
	
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Number Services Found: <?php echo $totalcountalpha ?></td>
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
    <table cellpadding="1" cellspacing="1" border="0" class="table" >				
				<tr>
				<td class="txt1">Service (English)</td>
				<td>
				<input type="text" name="service_name" class="fields"  id="service_name" value=""  />
 				</td> 
				</tr>
			   <?php while(!$rs_language->EOF){ ?>	
				<tr>
				<td class="txt1">Service (<?php echo $rs_language->fields('Lan_name'); ?>)</td>
				<td>
				<input type="text" name="service_name_<?php echo $rs_language->fields('id'); ?>" class="fields"  id="service_name_<?php echo $rs_language->fields('id'); ?>" value=""  />
 				</td> 
				</tr>
				<?php 
				 $rs_language->MoveNext();
				} 
				?>
</table>				
</div>

<div class="border_div_categories"  align="center">				
		<table cellpadding="1" cellspacing="1" border="0" >
		<tr>
		<td><input style="margin:5px; width:150px; float:none; text-align:center;" name="addsubscribeSbt" id="addsubscribeSbt" type="submit" value="Add Service" class="button" />
		</td>
		</tr>
		</table>
</div>

		<input type="hidden" name="mode" value="add">
		<input type="hidden" name="act" value="property_free_service">
		<input type="hidden" name="act2" value="property_free_service">
		<input type="hidden" name="request_page" value="freeppt_management" />
</form> 

  </div>  
  </td>
  </tr>     
  </table>
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
				<th width="40%">Sr#</th>
                <th width="50%">Service</th>
				<th width="5%">Options</th>
		    </tr>
			
		<?php 
		if($totalcountalpha >0){
		if($pageNum==0){$i=0;}else{$i = ($pageNum*$maxRows);}
			   while(!$rs_limit->EOF){

			   $qry_mon = "SELECT 
                           ".$tblprefix."language_contents.id,
						   ".$tblprefix."language_contents.language_id,
                           ".$tblprefix."language_contents.page_id,
                           ".$tblprefix."language_contents.field_name,
                           ".$tblprefix."language_contents.translation_text,
                           ".$tblprefix."language_contents.translated_text,
                           ".$tblprefix."language_contents.fld_type
                            FROM  ".$tblprefix."language_contents   
						    WHERE ".$tblprefix."language_contents.fld_type='free_services'   
						    AND   ".$tblprefix."language_contents.field_name='service_name_7'  
							AND   ".$tblprefix."language_contents.language_id='7' 
						    AND   ".$tblprefix."language_contents.page_id='".$rs_limit->fields['id']."'";

			   $rs_language_mon = $db->Execute($qry_mon);
			   
			   
               $totallanguagecontent_mon = $rs_language_mon->RecordCount();
			   $mon_value = "";
			   if($totallanguagecontent_mon>0){
			   $rs_language_mon->MoveFirst();
			     while(!$rs_language_mon->EOF){
			      $mon_value = $rs_language_mon->fields['translated_text'];
				  $rs_language_mon->MoveNext(); 
				 }
			   }
			   if($mon_value == NULL or $mon_value == ""){$mon_value = $rs_limit->fields['service_name'];}
		       ?>
					    <tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
                        <td valign="top"><?php echo $mon_value; ?></td>						
						<td valign="top">
							<a href="admin.php?act=update_ppt_freeservice&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=property_free_service&amp;mode=del_service&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=freeppt_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
					<td colspan="14" class="errmsg"> No Service Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
</div></div>