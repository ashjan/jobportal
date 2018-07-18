<?php
    $sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
	if($_SESSION[SESSNAME]['pm_moduleid']==2){
		$module_pm_where = ' WHERE '.$tblprefix.'rooms.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' AND '.$tblprefix."properties.pm_type=1";
	}else{
		$module_pm_where = ' WHERE '.$tblprefix."properties.pm_type=1";
	}

$maxRows = 20;
$pageNum = $_GET['pageNum'];
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."change_request" ; 
$rs_faq = $db->Execute($qry_faq);

$totalcountalpha = $rs_faq ->RecordCount();

$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil � Round fractions up i.e echo ceil(4.3);    // 5


//List down all Properties
$qry_properties = "SELECT * FROM ".$tblprefix."property_manager WHERE id=".$rs_faq->fields['pm_id'];
$rs_properties = $db->Execute($qry_properties);
$count_prop =  $rs_properties->RecordCount();
$totalprop = $count_prop;


//List down all PMs
$qry_pm = "SELECT * FROM ".$tblprefix."property_manager WHERE id=".$rs_faq->fields['pm_id'];
$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPm = $count_pm;

//Dropdown for parent
$category_qry = "SELECT * FROM ".$tblprefix."property_manager WHERE id=".$rs_faq->fields['pm_id'];
$rs_category = $db->Execute($category_qry);
?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Manage Change Request
</div></div>
 <table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">
	
  <tr><td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td></tr>
  

  <form  name="mngcontentform" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
    <tr>
    <td colspan="2">
       
            <tr>
            
              
                    <?php
										 
					//Dropdown for parent
					
				     $category_qry = "SELECT ".$tblprefix."property_manager.*,".$tblprefix."properties.property_name FROM ".$tblprefix."property_manager 
					 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
					 group by pm_id
					  ";
				   
					$rs_category = $db->Execute($category_qry); 
					
					
					?>
            
				<td width="20%" class="tabheading">Select Property Manager:</td>
				<td width="60%" align="center">
                <select name="pm_id" class="fields" id="pm_id" onchange="get_prop_change_request('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_change_request.php"?>')">
					<option value="0">Izaberite vlasnika objekta</option>
				 	<?php
						while(!$rs_category->EOF){?>
					    <option value="<?php echo $rs_category->fields['id'];?>"><?php echo $rs_category->fields['first_name'].' '.$rs_category->fields['last_name'];  ?></option>
						<?php
						$rs_category->MoveNext();
						}?>		
				</select><br />
                </td>
             </tr>
            
            <tr>
				<td width="20%" class="tabheading">Select Property </td>
				<td width="60%" align="center">
                <div id="property_id1">
			   
			    <select name="property_id" id="property_id" class="fields"  />
					<option value="0">Izaberite objekat</option>
				</select>
				
				</div>
                </td>
		    </tr>
                        
	</td>
  
 
</form>
 </table>

<div id="get_change_requests"></div>
</div></div>
<?php
// code for when click on edit button toggle window will open , actually that is use for inserting category 
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

