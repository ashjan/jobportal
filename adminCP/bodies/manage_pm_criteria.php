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


if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE pm_id = '.$_SESSION[SESSNAME]['pm_id'];
}else{
	$module_pm_where = ' ';
}


$qry_faq = "SELECT * FROM ".$tblprefix."property_facilities $module_pm_where " ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT * FROM ".$tblprefix."property_facilities $module_pm_where LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

//Dropdown for parent
$category_qry = "SELECT * FROM ".$tblprefix."users";
$rs_category = $db->Execute($category_qry);

//Dropdown for parent
$category_qry1 = "SELECT * FROM ".$tblprefix."users";
$rs_category1 = $db->Execute($category_qry1);

//Dropdown for parent
$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'];
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();

$qry_pm = "SELECT * FROM ".$tblprefix."users" ;

$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPM = $count_pm;

$qry_reviews = "SELECT * FROM ".$tblprefix."reviews ORDER BY id DESC LIMIT $startRow,$maxRows"; 
$rs_reviews = $db->Execute($qry_reviews);
$totalcountalphar =  $rs_reviews->RecordCount();

?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading">Manage Property Criteria</td>
  </tr>
  <tr>
    <td colspan="8" align="center" 
	<?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> >
	<?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?>
	</td>
  </tr>
  
    <tr class="tabheading">
    <td colspan="6" align="right">
	
	<a href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  > 
	  <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> 
	</a> 
	  </td>
  </tr>
  <tr>
    <td colspan="6">
	  <div id="controls" class="add_subscriber">
        <form name="managecontentfrm" action="admin.php" method="POST"  enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
		  
		  <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
		
			<tr>
				<td class="txt2">Select Property Type:</td>
					<td>
			
			<div id="property_id">
					<select name="property_id"class="fields" >
				 	<option value="0">Select Property Name</option>
					<?php  
					$rs_property->MoveFirst();
					while(!$rs_property->EOF){ ?>
 <option value="<?php echo $rs_property->fields['id']; ?>"><?php echo $rs_property->fields['property_name']; ?></option>
					<?php 
					$rs_property->MoveNext();
					} ?>
					</select>
					</div>
			
			</td>
			</tr>
			
            <?php
			}else{
			?>
			<tr>
	        <td style="border-left:1px solid #999999;">
  			Project Manager
		   	</td>
			<td style="border-right:1px solid #999999;">
			<select name="first_name" class="fields"   id="first_name" onchange="get_prop_name('property_ids', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name.php"?>')">
				<option value="0">Select Project Manager</option>
				<?php 
			    while(!$rs_pm->EOF){
				?>
				<option value="<?php echo $rs_pm->fields['id'];?>"
				<?php
				if(isset($_SESSION["addproperty"]["first_name"]) and $_SESSION["addproperty"]["first_name"]==$rs_pm->fields['id']){                echo 'selected="selected"';
				}
				?>><?php echo $rs_pm->fields['first_name']." ".$rs_pm->fields['last_name'];?></option>
				<?php
				$rs_pm->MoveNext();
				}
				?>					
			</select>					
			</td>
        </tr>
		<tr>
				<td class="txt2">Select Property Type:</td>
					<td>
					<div id="property_ids">
					<select name="property_id" class="fields" >
				 	<option value="0">Select Property Name</option>
					</select></div>					
					</td>
			</tr>	
		<?php
		}?>
		  
		  <tr>
				<td class="txt2">Select Property Criteria:</td>
					<td>
					
					  <?php 
				    	if($totalcountalphar >0){
						if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
						while(!$rs_reviews->EOF) {
			              ?>
            <tr valign="top"> <td valign="top">&nbsp; </td><td valign="top">
					 
 <input type="checkbox" value = "<?php echo $rs_reviews->fields['id']; ?>"  name="review[]"/>
             <?php echo $rs_reviews->fields['reviews_name']; ?>
			 
			 
			 </td>
			  <td>&nbsp;
   			  
			  </td>
            </tr>
			
            <?php 
						$rs_reviews->MoveNext();
						} 
						}
						?>
					
					</td> </tr>
		  
		  
					
					</form>				
					
		  <tr>
              <td>&nbsp;</td>
              <td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Criteria" class="button" />
              </td>
            </tr>
          </table>
          <input type="hidden" name="act" value="manage_pm_criteria" />
          <input type="hidden" name="request_page" value="pm_criteria_management" />
          <input type="hidden" name="mode" value="add"/>
        </form>
      </div></td>
  </tr>

    <tr>
	<td>
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>
				<td class="txt2">Select Property Manager:</td>
					<td>
					<form action="admin.php" name="uniqueness" method="post" enctype="multipart/form-data">
                    <?php
					if($_SESSION[SESSNAME]['pm_moduleid']!=2){
					?>
					<select name="pm_id" class="fields" id="pm_id" onchange="get_prop_name14('property_id', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name14.php"?>')">
				 	<option value="0">Izaberite vlasnika objekta</option>
					<?php
					$rs_category->MoveFirst();
					while(!$rs_category->EOF){
										?>
		  			<option value="<?php echo $rs_category->fields['id'];?>" ><?php echo $rs_category->fields['first_name']."  ".$rs_category->fields['last_name'];  ?></option>
					<?php
					$rs_category->MoveNext();
					}
					?>			
					</select>
					<div id="property_id">
					<select name="property_id"class="fields" >
				 	<option value="0">Select Property Name</option>
					</select>
					</div>
					<?php
					}else{
					?>
					<div id="property_id">
					<select name="property_id"class="fields" onchange="get_pm_criteria('properties_facilities', this.value, '<?php echo MYSURL."ajaxresponse/get_pm_criteria.php"?>','<?php echo $_SESSION[SESSNAME]['pm_id'];?>')" >
				 	<option value="0">Select Property Name</option>
					<?php  
					$rs_property->MoveFirst();
					while(!$rs_property->EOF){ ?>
 <option value="<?php echo $rs_property->fields['id']; ?>"><?php echo $rs_property->fields['property_name']; ?></option>
					<?php 
					$rs_property->MoveNext();
					} ?>
					</select>
					</div>
					</form>				
					<?php } ?>
					</td>
				</tr>
	</table>
	</td>
	</tr>

	<tr>
    <td> 
    <div id="properties_facilities">
	</div>
</td>
</tr>
</table>
           <?php
           /* if($_SESSION[SESSNAME]['pm_moduleid']==2){
			?>
            <script language="javascript">
	        get_facilities('properties_facilities', <?php echo $_SESSION[SESSNAME]['pm_id'];?>, '<?php echo MYSURL."ajaxresponse/get_facilities.php"?>');
			</script>
            <?php } */?>