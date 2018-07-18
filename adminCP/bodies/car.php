<?php
$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();
if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}

$maxRows = 20;
$pageNum = $_GET['pageNum'];
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."car" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil — Round fractions up i.e echo ceil(4.3);    // 5
$vcar=$tblprefix."car";
//$category=$tblprefix."content_category";
$qry_limit = "SELECT cr.*, tbl_sup.supplier_name
					FROM ".$vcar." as cr  
		      INNER JOIN tbl_carsupplier as tbl_sup ON tbl_sup.id=cr.supplier_id  
					LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();


$qry_pm = "SELECT first_name,last_name,id FROM ".$tblprefix."users";  
$rs_pm = $db->Execute($qry_pm);

$qry_agency = "SELECT * FROM ".$tblprefix."agency"; 
$rs_agency= $db->Execute($qry_agency);


$qry_carsupplier = "SELECT * FROM ".$tblprefix."carsupplier" ;
$rs_carsupplier = $db->Execute($qry_carsupplier);

$qry_cat = "SELECT * FROM ".$tblprefix."car_categories" ;
$rs_cat = $db->Execute($qry_cat);
?>


<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
<tr>
  <td id="heading">Car</td>
</tr>
<tr>
  <td  align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?>
  </td>
</tr>
<tr>
  <td>
  <table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" class="txt">
    <tr class="tabheading">
      
      <td colspan="13" align="right">Total Car Found: <?php echo $totalcountalpha ?></td>
    </tr>
    <tr class="tabheading">
      <td colspan="13" align="right"></td>
      <td  align="right"><a href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"> <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /></a></td>
    </tr>
    <tr>
      <td colspan="13">
<div id="controls" <?php if($_SESSION['record_add_edit']=='Yes'){ ?> style="display:block;" <?php } ?> class="add_subscriber">
<form action="admin.php" enctype="multipart/form-data" method="post" name="testform" >
  <table width="98%" border="0" align="center" cellpadding="13" cellspacing="0" class="txt">
   <tr>
     <td width="30%"></td>
	 <td width="70%"></td>
   </tr>
   <tr>
    
	
	
	
	
			<tr>
			<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">			</td></tr>
			
			
			
			<tr>
		 	<td class="txt1">Car Agency*</td>
			<td>
			<select name="agency" class="fields"   id="agency" onchange="get_car_supplier('get_supplier', this.value, '<?php echo MYSURL."ajaxresponse/get_car_supplier.php"?>')">
			
			<option value="0">Select Car Agency</option>	
	<?php while(!$rs_agency->EOF){
				
				$is_cat_selected = '';
				if($rs_agency->fields['agn_id']==$id){
					$is_cat_selected = 'selected="selected"';
				}else{
					$is_cat_selected = '';
				}
?>
<option value="<?php echo $rs_agency->fields['agn_id'];?>" <?php echo $is_cat_selected; ?>><?php echo $rs_agency->fields['agn_name'] ;?></option>
	<?php $rs_agency->MoveNext();
	}
	
?>
</select>
			
		</td>
			</tr> 	
			
			
            <?php
			}else{?>
			<tr>
			<td class="txt1">Property Manager :<br/>[vlasnika objekta]:</td>
			<td>
			<select name="pm_id" class="fields"   id="pm_id" onchange="get_car_agency('get_agency', this.value, '<?php echo MYSURL."ajaxresponse/get_car_agency.php"?>')">
				<option value="0">Izaberite objekat</option>
				<?php 
				$rs_pm->MoveFirst();
			    while(!$rs_pm->EOF){
				?>
				<option value="<?php echo $rs_pm->fields['id'];?>"
				<?php
				if($rs_pm->fields['id']==$rs_limit->fields['pm_id']){
				echo 'selected="selected"';
				}
				?>><?php echo $rs_pm->fields['first_name']; echo '&nbsp;'; echo $rs_pm->fields['last_name'];?></option>
				<?php
				$rs_pm->MoveNext();
				}
				?>					
			</select>
				
			</td><td> </td><td> </td>
			</tr> 
			
			
			<tr>
		 	<td class="txt1">Car Agency*</td>
			<td>
			<div id="get_agency">
			<select name="agency" class="fields"   id="agency" onchange="get_car_supplier('get_supplier', this.value, '<?php echo MYSURL."ajaxresponse/get_car_supplier.php"?>')">
				<option value="0">Select Car Agency</option>
						
				</select>	
			</div>
			
			</td>
			</tr> 
		<?php } ?>
		<tr>
	        <td class="txt1">
  			
			Supplier Name
		   	</td>
			<td>
		<div id="get_supplier"> 	
		<select name="supplier_id" class="fields"   id="supplier_id" onchange="get_car_type('get_car', this.value, '<?php echo MYSURL."ajaxresponse/get_car_type.php"?>')">
			<option value="0">Supplier Name</option>
		</select>
		</div>	
		</td>
        </tr>
	

	
	<tr>
      <td>Car type*</td>
      <td><input type="text" name="car_type" class="fields" id="last_name" value="<?php echo $rs_limit->fields['last_name']; ?>" />
      </td>
    </tr>
    <tr>
      <td>Car Category*</td>
      <td><select name="category" class="fields"   id="category">
          <option value="0">Select Car Category</option>
          <?php 
			    while(!$rs_cat->EOF){
				?>
          <option value="<?php echo $rs_cat->fields['id'];?>"
				<?php
				/*if(isset($_SESSION["addproperty"]["first_name"]) and $_SESSION["addproperty"]["first_name"]==$rs_pm->fields['id']){                echo 'selected="selected"';
				}*/
				?>><?php echo $rs_cat->fields['car_category_name'];?></option>
          <?php
				$rs_cat->MoveNext();
				}
			?>
        </select>
      </td>
    </tr>
  
    <tr>
      <td>Produced*</td>
      <td width="200"><!--<input type="text" name="produced"  id="produced" />
        <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'testform',
                                        // input name
                                        'controlname': 'produced',
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
             </script>-->

	<select name="produced" class="fields"   id="produced">
          <option value="0">Select Car Produced Year</option>
          <?php 
			    for($j=1950;$j<=2050;$j++){
				
				 ?>
          <option value="<?php  
		  
		  echo $j;?>"
				<?php
				/*if(isset($_SESSION["addproperty"]["first_name"]) and $_SESSION["addproperty"]["first_name"]==$rs_pm->fields['id']){                echo 'selected="selected"';
				}*/
				?>><?php echo $j;?></option>
          <?php
				
				}
			?>
        </select>

	
	  </td>
    </tr>
	
	
    <tr>
      <td>Doors*</td>
      <td><input type="text" name="doors" class="fields" id="doors" value="" /></td>
    </tr>
    <tr>
      <td>passengers*</td>
      <td><input type="text" name="passengers" class="fields" id="passengers" value="" /></td>
    </tr>
    <tr>
      <td>Number of Cars*</td>
      <td><input type="text" name="num_of_car" class="fields" id="num_of_car" value="" /></td>
    </tr>
    <tr>
      <td>Minimum days for rent*</td>
      <td><input type="text" name="min_day_for_rent" class="fields" id="min_day_for_rent" value="" /></td>
    </tr>
    <tr>
      <td>Car Picture</td>
      <td><input  type="file" name="car_picture" class="fields" id="car_picture" value="<?php echo $rs_limit->fields['car_picture']; ?>" /></td>
    </tr>
	<tr>
    <td>&nbsp;</td>
      <td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Add Car" class="button" />
      </td>
    </tr>
    <tr>
    
      <td><input type="hidden" name="mode" value="add">
        <input type="hidden" name="act" value="car">
        <input type="hidden" name="act2" value="add_car">
        <input type="hidden" name="request_page" value="manage_car" />
      </td>
    </tr>
    
  </table>
</form>
 </div>
</td>
</tr>
<tr height="5%">
  <td colspan="13" ></td>
</tr>
<tr class="tabheading">
  <td width="5%">Sr#</td>
  <td width="5%">Property Manager</td>
  <td width="5%">Car Agency</td>
  <td width="3%">Car type</td>
  <td width="3%">Car Supplier</td>
  <td width="5%">Car Category</td>
  <td width="5%">produced</td>
  <td width="5%">doors</td>
  <td width="5%">passengers</td>
  <td width="5%">number of cars</td>
  <td width="5%">minimum Days for Rent</td>
  <td width="5%">Car Picture</td>
  <td width="5%">Options<br/>[Opcije]</td>
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


 <td width="3%" valign="top"><?php $qry_agn = "SELECT first_name , last_name FROM 
					  ".$tblprefix."users where id=".$rs_limit->fields['pm_id']; 
					   $rs_agn= $db->Execute($qry_agn);
					   echo $rs_agn->fields['first_name']; echo '&nbsp;'; echo $rs_agn->fields['last_name'];
					   ?>
  </td>



  <td width="3%" valign="top"><?php $qry_agn = "SELECT agn_name FROM 
					  ".$tblprefix."agency where agn_id=".$rs_limit->fields['agency']; 
					   $rs_agn= $db->Execute($qry_agn);
					   echo $rs_agn->fields['agn_name'];
					   ?>
  </td>
  <td width="3%" valign="top"><?php echo stripslashes($rs_limit->fields['car_type']); ?></td>
   <td width="3%" valign="top"><?php echo stripslashes($rs_limit->fields['supplier_name']); ?></td>
  <td width="3%" valign="top"><?php  $qry_categ = "SELECT car_category_name FROM 
					  ".$tblprefix."car_categories where id=".$rs_limit->fields['category'];  
					   $rs_categ= $db->Execute($qry_categ);
					   echo $rs_categ->fields['car_category_name'];
					   ?></td>
  <td width="2%" valign="top"><?php echo stripslashes($rs_limit->fields['produced']); ?></td>
  <td width="2%" valign="top"><?php echo stripslashes($rs_limit->fields['doors']); ?></td>
  <td width="2%" valign="top"><?php echo stripslashes($rs_limit->fields['passengers']); ?></td>
  <td width="2%" valign="top"><?php echo stripslashes($rs_limit->fields['num_of_car']); ?></td>
  <td width="2%" valign="top"><?php echo stripslashes($rs_limit->fields['min_day_for_rent']); ?></td>
  <td> <!-- <td width="3%" valign="top"><?php //echo stripslashes($rs_limit->fields['car_picture']); ?>--> <img src="<?php echo MYSURL ; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL."graphics/car_upload/".$rs_limit->fields['car_picture'];?>&w=50&h=40&zc=1" border="0" />
					  </td>
  
  <td ><a href="admin.php?act=edit_car&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?>"> <img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp; <a href="admin.php?act=car&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=manage_car" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a> </td>
</tr>
<?php $rs_limit->MoveNext();
			}?>
<tr>
  <td colspan="13"><!-- START: Pagination Code -->
    <div class="txt">
      <div id="txt" align="center"> Showing
        <?php 
							
							echo ($startRow + 1) ?>
        to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />
        Pages ::
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
        <a id="<?php echo '0' ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a> &nbsp;
        <?php } 		
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
  <td colspan="13" class="errmsg"> No CAR Found</td>
</tr>
<?php
				}// end if($totalcount > 0)
?>
</table>
</td>
</tr>
</table>

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
