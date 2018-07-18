<script language="javascript">
function validate_category()
{
//alert("hi");
var catename=document.add_category.catename.value;
if(catename=="")
{
alert("please ener category name");
document.add_category.catename.focus();
return false;
}
else
return true;
}
</script>
<?php
$maxRows = 20;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."resume_views" ; 
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil � Round fractions up i.e echo ceil(4.3);    // 5


$resume_views=$tblprefix."resume_views";
$users=$tblprefix."users";
$resume=$tblprefix."resume";

$qry_limit = "SELECT 
					tbl_resume_views.*,
					p_manager.first_name, 
					p_manager.last_name  
					FROM tbl_resume_views 
					LEFT JOIN tbl_users as p_manager ON tbl_resume_views.candidate_id = p_manager.id LIMIT 0,20";

$rs_limit = $db->Execute($qry_limit);

if($rs_limit)
{
    $totalcountalpha =  $rs_limit->RecordCount();
}
else
{
    $totalcountalpha = 0;
}

$qry_pm = "SELECT first_name,last_name,id FROM ".$tblprefix."users where type=4";  
$rs_pm = $db->Execute($qry_pm);

// for editing category

$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();

if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}

// GET Content Title list to be search 
$tbl_resume=$tblprefix."resume";
$qry_search_resume="SELECT id FROM ".$tbl_resume;
$rs_search_resume = $db->Execute($qry_search_resume);
$totalcountalpha1 = $rs_search_resume->RecordCount();





//Edit Query
$is_edit_form = false;
if(isset($_REQUEST['pagid'])){
	$is_edit_form = true;
	$categoryid = base64_decode($_GET['cateid']);// send frm edit section
	$update_query_category = "SELECT * FROM ".$tblprefix."resume_views WHERE id = '".$_REQUEST['pagid']."' "; 
	$rs_update_category = $db->Execute($update_query_category);
	$row_update_category = $rs_update_category->GetRows();
}




?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Manage Content Pages
</div></div>
<form action="admin.php" enctype="multipart/form-data" method="post" name="add_category">

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">
	
  <tr><td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']); }?></td></tr>
  <tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table table-hover">
		<tr class="tabheading">
			  <td colspan="2">&nbsp; </td>
			  
			  <td colspan="5" width="15%" align="right">Total Resume Views Found: <?php echo $totalcountalpha ?></td>
		  </tr>
		  <tr height="5%">
		  <td colspan="5" >
		  <div id="content_listing" class="content_listing">
		  </div>
		  <div id="contents" class="contents">
		  </td>
		  </tr>
			<tr class="tabheading">
				<th width="5%">Sr#</th>
				<th width="30%">Candidate Name<br/></th>
				<th width="20%">Resume Views</th>
				<th width="20%">Resume Limit Flag</th>
				<th width="20%">Resume View Limit</th>
				<th width="55%">Options</th>
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
		<td  valign="top"><?php echo $rs_limit->fields['first_name']; ?><?php echo '&nbsp;'; ?>
		<?php echo $rs_limit->fields['last_name']; ?></td>
		<td  valign="top"><?php  echo stripslashes($rs_limit->fields['no_of_views']); ?></td>
                <td  valign="top"><?php  if($rs_limit->fields['limit_flag']==1){echo 'Yes';}else{echo 'No';} ?></td>
		
                
                <td  valign="top"><?php  echo stripslashes($rs_limit->fields['view_limit']); ?></td>
		<td>
	<a href="admin.php?act=edit_resume_views&pageid=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>
	&nbsp;&nbsp;				
   <!--<a href="admin.php?act=contentpage&amp;mode=delpage&amp;pageid=<?php //echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=content_management" onClick="return confirm('Are you sure you want to Delete?')">
	<img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>-->
   <!--<a class="tabheading" href="javascript:;" onClick="jQuery('#controls_<?php //echo $rs_limit->fields['id']; ?>').slideToggle('fast'); return false">
   <img src="<?php //MYSURL?>graphics/data.gif" width="15" height="18" border="0" title=" Click here to view the Answer " /></a>-->			
		</td>
		</tr>
<tr class="tabheading">
          <td colspan="5">
          <div id="controls_<?php echo $rs_limit->fields['id']; ?>" class="add_subscriber txt" >
           <table cellpadding="5" cellspacing="5" border="0" >
               <tr>
                    <td width="50%" class="txt">
                       <?php //echo $rs_limit->fields['sitegdt']; ?>
                    </td>
               </tr>                    
               
		   <tr>
                    <td width="50%" class="txt">
                       <?php //echo $rs_limit->fields['property_page']; ?>
                    </td>
            </tr>  
			 <tr>
                    <td width="50%" class="txt">
                       <?php //echo $rs_limit->fields['news']; ?>
                    </td>
            </tr>   
			</table>   
			</div>
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
					<td colspan="13" class="errmsg"> No Content Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
		</div>
	</td>
  </tr>
</table>
</form>
</div></div>