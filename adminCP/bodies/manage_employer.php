<?php

$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1' ";
$rs = $db->Execute($sql);


    $isrs = $rs->RecordCount();

if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}


if(isset($_GET['sortby']))
	{
		if(isset($_GET['orderby'])){
			if($_GET['orderby']=='DESC'){
				$orderby='DESC';
				
			}
			elseif($_GET['orderby']=='ASC'){
				$orderby='ASC';
			}
		}
		else{
			$orderby='ASC';
			$sortby='id';
			}
		//$orderbypag=$_GET['orderby'];
		//$sortby=$_GET['sortby'];
	}
	else
	{
		$orderbypag='ASC';
		$orderby='ASC';
		$sortby='id';
	}	


$maxRows = 20;

if (empty($_GET['pageNum'])){ $pageNum=0;}else{if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}}
$startRow = $pageNum * $maxRows;
//Total pagination
$users=$tblprefix."users";
$qry_faq = "SELECT usr.*,
			comp.`company_id` as cmp_id,
			comp.`company_name`,
			comp.`featured`,
			comp.`logo`
			FROM ".$users." usr
			left JOIN
			`tbl_companyy` comp
			ON
			usr.company_id=comp.company_id
			WHERE usr.user_type=4
			ORDER BY usr.".$sortby." ".$orderby." ";
//echo $qry_faq; exit;
$rs_faq = $db->Execute($qry_faq);

if($rs_faq)
{
    $count_add =  $rs_faq->RecordCount();
}
else
{
    $count_add = 0;
}
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil � Round fractions up i.e echo ceil(4.3);    // 5
$users=$tblprefix."users";
			//page limit pagination		
     $qry_limit = "SELECT usr.*,
			comp.`company_id` as cmp_id,
			comp.`company_name`,
			comp.`featured`,
			comp.`logo`
			FROM ".$users." usr
			left JOIN
			`tbl_companyy` comp
			ON
			usr.company_id=comp.company_id
			WHERE usr.user_type=4
			ORDER BY usr.".$sortby." ".$orderby."  
					LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
if($rs_limit)
{
    $totalcountalpha =  $rs_limit->RecordCount();
}
else
{
    $totalcountalpha = 0;
}
//echo "<pre>";print_r($rs_limit); exit;
?>

<?php

if($orderby == 'ASC'){
    $orderby    =   'DESC';
}else{
    $orderby    =   'ASC';
} ?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
   Employers
</div></div>
<form action="admin.php" enctype="multipart/form-data" method="post" name="add_category">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	
  <tr><td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']); }?></td></tr>
  <!--<tr>
    <td >
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table table-hover">-->
		<tr class="tabheading">
			  <td colspan="2">&nbsp; </td>
			  
			  <td width="9%" align="right"></td>
			  <td colspan="8" align="right">Total Employers Found:<?php echo $totalcountalpha ?><br/>
			  </td>
		  </tr>
		 <tr class="tabheading">
          <td colspan="1">&nbsp;
         
          </td>
          <td colspan="4">
          Status: <select name "status" id="status" onchange="get_company_status_filter('filter_results', this.value, '<?php echo SURL?>ajaxresponse/get_company_status_filter.php')">
		  <option value="">ALL</option>
		  <option value="1">Enable</option>
		  <option value="0">Disable</option>
		  </select>
          </td>
		  </tr>
          <tr>
          <td>&nbsp;
          
          </td>
          </tr>
		  <tr>
    <td colspan="8">
		<div id="filter_results">
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table table-hover">
		  
			<tr class="tabheading">
				<td width="5%">Sr#</td>
                <td width="15%"><img src="images/ascending.gif" title="ascending" /><a href="admin.php?act=manage_employer&amp;orderby=<?php echo $orderby; ?>&amp;sortby=<?php echo "first_name"; ?>"><b style="color:#000">First Name;</b></a></td>
                <td width="15%"><img src="images/ascending.gif" title="ascending" /><a href="admin.php?act=manage_employer&amp;sortby=<?php echo "last_name"; ?>"><b style="color:#000">Last Name;
                </b></a></td>
                <td> Company Name</td>
				<td width="20%">Email Address</td>
                <td width="20%"><img src="images/ascending.gif" title="ascending" /><a href="admin.php?act=manage_employer&amp;sortby=<?php echo "town"; ?>"><b style="color:#000">Town<br/>&nbsp;&nbsp;&nbsp;&nbsp;
                </b></a></td>
				<td witth="15%">Phone Number</td>
                                <td width="10%">Options</td>
                                <td width="5">Details</td>
                                <td> Featured </td>
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
					<td  valign="top"><?php echo stripslashes($rs_limit->fields['first_name']); ?></td>
					<td valign="top"><?php echo stripslashes($rs_limit->fields['last_name']); ?></td>
                                        <td valign="top"> <?php echo stripslashes($rs_limit->fields['company_name']); ?> </td>
					<td valign="top"><?php echo stripslashes($rs_limit->fields['email_address']); ?></td>
					
			<td valign="top"><?php echo stripslashes($rs_limit->fields['town']); ?></td>
			<td valign="top"><?php echo stripslashes($rs_limit->fields['phone_number']); ?></td>
			<td>
			<?php if($rs_limit->fields['pm_status']==0){ 
			?>
			<a href="admin.php?act=manage_employer&amp;m_status=0&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=employer_manager">
			  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make Default" border="0" />
			</a>
			<?php }else{		  	
			?>
                        <a href="admin.php?act=manage_employer&amp;m_status=1&amp;mode=change_pmstatus&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=employer_manager">
			<img src="<?php MYSURL?>graphics/activate.gif" title="Make Default" border="0" />
			</a>
					  <?php } ?>
			<a href="admin.php?act=edit_manage_employer&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>">	<img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;				
			<a href="admin.php?act=manage_employer&amp;mode=delpage&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=employer_manager" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
							
		   </td>
                   
                   
                   <td>
                   <?php if($rs_limit->fields['company_id'] != 0){ ?>
                        <a href="javascript:" onClick="javascript: jQuery('#controls_<?php echo $rs_limit->fields['id']; ?>').slideToggle('fast'); return false"  ><img src="<?php MYSURL?>graphics/contents.gif" border="0" title="Open Details" /></a>				
                   <?php } else {?>
                   &nbsp;
                   <?php } ?>
                   </td>
                   
                    
                   <td>
						<?php if($rs_limit->fields['featured']==0){ 
					  ?>
					  <a href="admin.php?act=manage_employer&amp;featured=0&amp;mode=change_featured&amp;id=<?php echo base64_encode($rs_limit->fields['cmp_id']); ?>&amp;request_page=employer_manager">
					  <img src="<?php MYSURL?>graphics/deactivate.gif" title="Make Default" border="0" />
					  </a>
					  <?php }else{ 
					  	?>
                        <a href="admin.php?act=manage_employer&amp;featured=1&amp;mode=change_featured&amp;id=<?php echo base64_encode($rs_limit->fields['cmp_id']); ?>&amp;request_page=employer_manager">
					  <img src="<?php MYSURL?>graphics/activate.gif" title="Make Default" border="0" />
						</a>
					  <?php } ?>
						
							
		   </td>
					</tr>
   <?php if($rs_limit->fields['company_id'] != 0){ ?>            
                                        
                                <style>
	#controls_<?php echo $rs_limit->fields['id']; ?>{
	display:none;
	}
        
</style>                        
			<tr>
				<td colspan="10">
				<div  id="controls_<?php echo $rs_limit->fields['id']; ?>">		
				<table cellpadding="2" border="1" bordercolor="#666666" bgcolor="#E7DAE7">
				<tr class="txt tabheading">
                                    <td width="5%"><b>Name</b></td>
				<td width="5%"><b>Email Address</b></td>
				<td width="5%"><b>Business Email</b></td>
				<td width="5%"><b>Town</b></td>
				<td  width="5%"><b>Phone Number</b></td>
				<td width="5%"><b>Country</b></td>
				<td width="5%"><b>state</b></td>
				<td width="5%"><b>city</b></td>
			    </tr>
				<tr class="txt">
				<td valign="top"><?php echo $rs_limit->fields['company_name']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['email_address']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['business_email']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['town']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['phone_number']; ?></td>
				<td valign="top"><?php 
                                $qry_country = "SELECT tbl_countries.Country FROM tbl_countries 
								JOIN tbl_companyy ON tbl_countries.CountryId = tbl_companyy.country  
								WHERE tbl_companyy.company_id =".$rs_limit->fields['company_id']." ";
                                //echo $qry_country;
								$rs_country = $db->Execute($qry_country);
								echo $rs_country->fields['Country']; ?></td>
				<td valign="top"><?php 
                                $qry_state = "SELECT tbl_state.Region FROM tbl_state 
								JOIN tbl_companyy ON tbl_state.RegionID = tbl_companyy.state  
								WHERE tbl_companyy.company_id =".$rs_limit->fields['company_id']." ";
                                $rs_state = $db->Execute($qry_state);
                                echo $rs_state->fields['Region']; 
                                //echo $rs_limit->fields['state']; ?></td>
				<td valign="top"><?php
                                $qry_city = "SELECT tbl_city.name FROM tbl_city 
								JOIN tbl_companyy ON tbl_city.id = tbl_companyy.city  
								WHERE tbl_companyy.company_id =".$rs_limit->fields['company_id']." ";
                                $rs_city = $db->Execute($qry_city);
                                echo $rs_city->fields['name']; 
                                
                                
                                
                                //echo $rs_limit->fields['city']; ?></td>
				</tr>
				<tr class="txt tabheading" >
				
				<td width="5%"><b>Profile Picture</b></td>
				<td width="5%"><b>Resume</b></td>
				<td width="5%"><b>User Status</b></td>
				<td width="5%"><b>User Type</b></td>
				<td width="5%"><b>face book id</b></td>
				<td width="5%"><b>Consultant Check</b></td>
				<td width="5%"><b>company id</b></td>
				<td width="5%"><b>privilage status</b></td>
				
				</tr>
				<tr class="txt">
				
				<td valign="top"><?php //echo '&nbsp;&nbsp;';echo $rs_limit->fields['profile_pic']; ?>
                
                                <img border="0" title="Make Default" src="<?php MYSURL?>../uploads/profile_images/thumb/<?php echo $rs_limit->fields['logo']; ?>">
                                </td>
				<td valign="top"><?php echo '&nbsp;&nbsp;'; echo $rs_limit->fields['resume']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['pm_status']; ?></td>
                <td valign="top">
                    <?php 
                        if($rs_limit->fields['user_type']==1) 
                            { 
                            echo "Admin";
                            }
						elseif($rs_limit->fields['user_type']==2)
							{
								echo "HR";
							}
						elseif($rs_limit->fields['user_type']==3)
							{
							echo "Applicant";
							}
						elseif($rs_limit->fields['user_type']==4)
							{
							echo "Employer";
							}
                ?>
                </td>
				<td valign="top"><?php echo $rs_limit->fields['fb_id']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['consultant_check']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['company_id']; ?></td>
				<td valign="top"><?php echo $rs_limit->fields['privilage_status']; ?></td>
                                </tr>
				</table>	
				</div>
	          </td>
					</tr>
                    <?php }  ?>		
			<?php $rs_limit->MoveNext();
			}?>
<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							
							<div id="txt" align="center"> Showing <?php 
							
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;sortby=<?php echo $sortby; ?>" ><b>[Previous]</b></a>
							
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
							<a id="<?php echo '0' ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>&amp;sortby=<?php echo $sortby; ?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a>
							&nbsp; <?php } 		
							
							
							for ($i=$startPage; $i< $count; $i=$i+1){
							if ($i!=$pageNum){
							?>
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $i; ?>&amp;sortby=<?php echo $sortby; ?>"><?php echo $i+1; ?></a>
							<?php 
							}else{
							echo ("<b class=txt>[". ($i + 1) ."]</b>");
							}
							} 
							?>
							
							<?php
							
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;sortby=<?php echo $sortby; ?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							
							?>
							<?php 
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;sortby=<?php echo $sortby; ?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			<?php
				}else{
			?>
				<tr>
					<td colspan="13" class="errmsg"> No Employer Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
		</div>
	</td>
  </tr>
</table><?php //echo $where;?>
</form>
</div>


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
