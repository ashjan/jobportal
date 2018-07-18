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

$qry_faq = "SELECT * FROM ".$tblprefix."yatfacility_management" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);



$qry_limit = "SELECT yatpr.*,yat.yatch_name FROM `".$tblprefix."yatmng_price` as yatpr,`".$tblprefix."yatch` as yat WHERE yatpr.yat_model=yat.id";
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

$qry_yat = "SELECT * FROM ".$tblprefix."yatch" ;
$rs_yat = $db->Execute($qry_yat);

$qry_agncy = "SELECT * FROM ".$tblprefix."yatchagency" ;
$rs_agncy = $db->Execute($qry_agncy);
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Yacht Prices</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Number of Records Found: <?php echo $totalcountalpha ?></td>
	</tr>
	
	<tr>
	<td colspan="6">
 
		 </td>
		 </tr>
  <tr>
    <td> 
	
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
      <tr class="tabheading"> 
	   <td width="5%">Sr#</td>
	    <td width="15%">Yacht Model</td>
		<td width="15%">Starting Date</td>
       	<td width="15%">Ending Date</td>
        <td width="20%">Price</td>
		<td width="5%">Option</td>
		</tr>			<?php if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   } ?>
					<?php  while(!$rs_limit->EOF){ ?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
						<td valign="top"><?php echo $rs_limit->fields['yatch_name']; ?></td>
						<td valign="top"><?php echo stripslashes($rs_limit->fields['start_date']); ?></td>
					 	<td valign="top"><?php echo stripslashes($rs_limit->fields['end_date']);?></td>
					 	<td valign="top"><?php echo stripslashes($rs_limit->fields['price']);?></td>
					 	
						<td valign="top">
                <a href="admin.php?act=edit_yatprice&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
				<a href="admin.php?act=change_yatprices&amp;mode=del&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=mng_yatprice" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                        </td>
            </tr>
            <?php 
						$rs_limit->MoveNext();
						} 
						?>
          
        
      
      <input type="hidden" name="act" value="manage_pm_commission" />
      <input type="hidden" name="request_page" value="pm_commision_management" />
      <input type="hidden" name="mode" value="add">
  </form>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><input type="hidden" name="act" value="manageletter">
      <input type="hidden" name="mode" value="delete">
    </td>
  </tr>
</table>
	
		</td>
  </tr>
  
  <tr><td>
  <div id="properties_facilities">
  <?php
  if(isset($_POST['viewprices']) and $_POST['viewprices']=="1")
  {
  	echo "Coming Soon...";
	
	
  }
  ?>
	</div>
  </td></tr>
</table>