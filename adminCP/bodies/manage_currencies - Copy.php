<?php
$sql        = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs         = $db->Execute($sql);
$isrs       = $rs->RecordCount();
if($isrs == 0){
 echo 'No Admin account found!';
 exit;
}

$maxRows = 20;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') {$pageNum=0;}
$startRow = $pageNum * $maxRows;

$qry_currencies = "SELECT * FROM ".$tblprefix."currencies" ;
$rs_currencies  = $db->Execute($qry_currencies);
$count_add      = $rs_currencies->RecordCount();


$qry_currencies_data = "SELECT * FROM ".$tblprefix."currencies_data" ;
$rs_currencies_data  = $db->Execute($qry_currencies_data);


$totalRows       = $count_add;
$totalPages      = ceil($totalRows/$maxRows);

$qry_limit       = "SELECT * FROM ".$tblprefix."currencies ORDER BY countryname ASC LIMIT $startRow,$maxRows"; 
$rs_limit        = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();
?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
   Manage Currencies
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">
	
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
			  <td colspan="2">&nbsp; </td>
			  
			  <td width="9%" align="right"></td>
			  <td colspan="8" align="right">Total Employers Found:<?php echo $totalcountalpha ?><br/>
			  </td>
		  </tr>
	<tr class="tabheading">
		<td colspan="5" align="right">
		<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  >
		<img src="<?php   MYSURL?>graphics/add.png" border="0" title="Add New" />
		</a>
		</td>
	</tr>
	<tr>
	<td colspan="5">
 <div id="controls" class="add_subscriber">
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
        <table cellpadding="1" cellspacing="1" border="0" class="txt" >
        <tr>
	        <td class="fieldheading">
  			Country Name
		   	</td>
			<td >
			  <select id="countryname" class="fields" onchange="get_currency_name('get_currency', this.value, '<?php echo SURL ; ?>ajaxresponse/get_currency_name.php')" name="countryname" style="width:42%; margin-left: 30%;"> 
			  
			 <option value="0">Select country</option>
                <?php 
			 $rs_currencies_data->MoveFirst();
			 while(!$rs_currencies_data->EOF){
		     echo "<option value=".$rs_currencies_data->fields['id'].">".$rs_currencies_data->fields['countryname'].'</option>';
			 $rs_currencies_data->MoveNext();
				  }
				?>  
			</select>
			</td>
        </tr>
        <tr>
            <td>&nbsp;
            
            </td>
            </tr>                    
      <div id="get_currency">
      <tr>
	        <td class="fieldheading">  
		
			
  			Currency Code
			
            </td>
            <td>
				
			<select name="curr_name" id="curr_name" class="fields" style="width: 42%;
margin-left: 30%;" >
			    <option value="0" selected="selected">Select Currency Name</option>
                <?php 
				  $rs_currencies_data->MoveFirst();
				  while(!$rs_currencies_data->EOF){
echo "<option value=".$rs_currencies_data->fields['curr_name'].">".$rs_currencies_data->fields['curr_name'].'</option>';
				  $rs_currencies_data->MoveNext();
				  }
				?>  
			</select>
			</td>
			
			
			</tr>
            <tr>
            <td>&nbsp;
            
            </td>
            </tr>
            <tr>
            <td class="fieldheading">
            	
  			Iso Code
			</td>
            <td>
            
			<select name="curr_isocode" id="curr_isocode" class="fields" style="width: 42%;
margin-left: 30%;">
				<option value="0" selected="selected">Select Currency Code</option>
                <?php 
				  $rs_currencies_data->MoveFirst();
				  while(!$rs_currencies_data->EOF){
				  echo "<option value=".$rs_currencies_data->fields['curr_isocode'].">".$rs_currencies_data->fields['curr_isocode'].'</option>';
				  $rs_currencies_data->MoveNext();
				  }
				?>  
			</select>
           </td>
           </tr>
           </div>
            <tr>
            <td>&nbsp;
            
            </td>
            </tr>
		<tr>
	        <td>&nbsp;
				
			</td>
			<td>
			<input type="submit" name="submit" value="Insert Currency" class="button" style="width: 30%;
margin-left: 30%;"  />
			</td>
        </tr>

		</table>
			<input type="hidden" name="act" value="manage_currencies" />
			<input type="hidden" name="request_page" value="manage_currencies" />
			<input type="hidden" name="mode" value="add">

		</form>
</div>
		 </td>
		 </tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<th width="5%">Sr#</th>
                <th width="35%">Country Name</th>
                <th width="35%">Curency Name</th>
				<th width="20%">ISO Code </th>
				<th width="5%">Options</th>
		    </tr>
			<?php 
				if($totalcountalpha >0){
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
				    $j=1;
					while(!$rs_limit->EOF){
			?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="middle"><?php echo ++$i; ?></td>
                        <td valign="middle"><?php echo $rs_limit->fields['countryname']; ?></td>
						<td valign="middle"><?php echo $rs_limit->fields['curr_name']; ?></td>
						<td valign="middle"><?php echo $rs_limit->fields['curr_isocode']; ?></td>
						<td> 
					  
					  <?php if($rs_limit->fields['currency_status']==0){ ?>
					  <a href="admin.php?act=manage_currencies&amp;mode=change_default&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;pageNum=<?php echo $pageNum; ?>&amp;request_page=manage_currencies">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make Default Currency" border="0" />
					  </a>
					  <?php }else{  ?>
                        <a href="#">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Make Default Currency" border="0" />
						</a>
					  <?php } ?>
					  
					   <?php if($rs_limit->fields['currency_status']<>1){ ?>
					   <a href="admin.php?act=manage_currencies&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=manage_currencies" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a> 
					  <?php } ?>
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
							<input type="hidden" name="act" value="manage_currencies">		
							<input type="hidden" name="mode" value="delete">						
						</td>
					</tr>
					<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							<div id="txt" align="center"> Showing <?php 
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
							<a href="admin.php?act=<?php echo $_GET['act'];?>&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>" ><b>[Previous]</b></a>
							
							<?php }?>
							
							<?php
							///////////////////////////////
							
							if($pageNum>5){
							if($pageNum+5<$totalPages){	  
							$startPage=$pageNum-5;
							}else{ $startPage=($totalPages-10);  }
							}
							else $startPage=0;
							$count = $startPage;
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
					<td colspan="14" class="errmsg"> No Currency Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
</div></div>