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

$qry_preview = "SELECT 
                ".$tblprefix."car.id, 
				".$tblprefix."car.car_type, 
				".$tblprefix."car.car_picture, 
				".$tblprefix."car.car_slug, 
				".$tblprefix."agency.agn_name, 
				".$tblprefix."agency.country, 
				".$tblprefix."agency.town, 
				".$tblprefix."agency.agncy_logo, 
				".$tblprefix."car_standard_rates.standard_start_date, 
				".$tblprefix."car_standard_rates.standard_rate_price, 
				".$tblprefix."car_standard_rates.passengers, 
				".$tblprefix."car_standard_rates.doors, 
				".$tblprefix."car_standard_rates.conditioner, 
				".$tblprefix."car_standard_rates.small_suitcase, 
				".$tblprefix."car_standard_rates.large_suitcase, 
				".$tblprefix."car_standard_rates.standard_end_date 
				FROM ".$tblprefix."car 
				LEFT JOIN ".$tblprefix."car_standard_rates ON ".$tblprefix."car.id = ".$tblprefix."car_standard_rates.car_id 
				LEFT JOIN ".$tblprefix."agency ON ".$tblprefix."car.agency = ".$tblprefix."agency.agn_id limit 0, 10"; 
$rs_preview = $db->Execute($qry_preview);
$totalcountalpha =  $rs_preview->RecordCount(); 
?>


<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
<tr>
  <td id="heading">Car Preview</td>
</tr>
<tr>
  <td  align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
  </td>
</tr>
<tr>
  <td>
  <table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" class="txt">
    <tr class="tabheading">
      <td colspan="13" align="right">Total Car Preview Found: <?php echo $totalcountalpha ?></td>
    </tr>
<?php 
				if($totalcountalpha >0){
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
					while(!$rs_preview->EOF){?>
<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
  <td valign="top"><?php echo ++$i; ?></td>
  
  <td valign="top">
        <div class="mid_right_car_search">
        <div class="onerow">
 <div class="onerow">        
 <div class="spa_hding"><?php echo $rs_preview->fields['car_type'];?></div>
 </div>
		<div class="onerow margin_10_tick">
         <div class="p_text widht_p" style="width:165px;">
		 <img  src="<?php echo MYSURL; ?>graphics/car_upload/<?php echo $rs_preview->fields['car_picture']; ?>" title="  Car Image " alt="No image " width="160" height="160" border="0"/>
		 </div>
		 <div style="float:left; width:auto;"> 
		  <div class="mid_text_cars">Quantity of days: <?php echo $rs_preview->fields['min_day_for_rent'];?></div>
		  <div class="mid_text_cars">Class code: MCMR</div>
		  <div class="mid_text_cars">Stack-in of passengers: <?php echo $rs_preview->fields['passengers']; ?></div>
		  <div class="mid_text_cars">Stack-in of doors: <?php echo  $rs_preview->fields['doors']; ?></div>
		  <div class="mid_text_cars">Transmission: Machanics</div>
		  <div class="mid_text_cars">Conditioner: Yes</div>
		  <div class="mid_text_cars">Stack-in of big suitcases: <?php echo $rs_preview->fields['	category']; ?></div>
		  <div class="mid_text_cars">Stack-in of small suitcases: <?php echo $rs_preview->fields['car_picture']; ?></div>
		  </div>
        </div>
		<div class="onerow" style="text-align:left; float:left; height:25px; font-size:13px; font-weight:bold; color:#666666; margin-top:5px;">
		<div style="float:left; width:100%;">
		<div style="float: left; margin-left: 25px; width: 200px;">
		<a href="#post" id="tandc" onclick="popup('terms')">View rental T & C's</a>
		</div>
		<div style="float: left; margin-left: 50px; width: 180px;">
		<a class="mid_link_cars" rel="facebox[.bolder]" href="http://dev.evsoft.pk/montenegro/app_montenegro/views/popup.php">
		What is included?
		</a>     
		</div>
		</div>
	   <div id="blanket" style="display:none; position:relative; opacity:1;">
	   <div id="terms" style="display:none; width:380px; opacity:1;">
		<a style="float:left; width:100%; text-align:right; font-family:Arial, Helvetica, sans-serif; font-weight:bold;padding-right:10px; padding-top:5px;  font-size:14px; color:#0099FF;" href="#pos1" onclick="popup('terms')">Close</a>
		</div>
	 </div>
        </div>
        </div>
		</div>
  </td>
  <td >&nbsp; </td>
</tr>
<?php   $rs_preview->MoveNext(); 
		 } ?> 
		 <?php 
		 } else{
		 ?> 
         <div class="car_searh">
             <td colspan="13" class="errmsg"> No CAR PREVIEW FOUND</td>
        </div>
         <?php
		 	}
		 ?>
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
