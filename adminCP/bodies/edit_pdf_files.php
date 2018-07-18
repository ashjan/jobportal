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
$qry = "SELECT * FROM ".$tblprefix."properties  
        WHERE   pm_type=0 
		AND  property_category<>24";
 
$rs = $db->Execute($qry);
$count_add =  $rs->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);
$totalcountalpha =  $rs->RecordCount();


$id=base64_decode($_GET['id']);

$qry_property_name  = "SELECT * 
                       FROM ".$tblprefix."properties 
					   WHERE  pm_type=0 
		               AND  property_category<>24";
$rs_property_name = $db->Execute($qry_property_name);



$qry_prop_manager = "SELECT pm.*,pr.id AS pid, pr.property_name 
             FROM ".$tblprefix."users as pm   
			 INNER JOIN ".$tblprefix."properties as pr ON   pr.pm_id= pm.id 
             WHERE pr.property_category<>24 
			 GROUP BY pm.id"
			 ;
$rs_prop_manager = $db->Execute($qry_prop_manager);





$qry_limit = "SELECT pdf.file_name,pdf.property_id,prop.property_name  
		   		FROM `tbl_pdf_files` as pdf 
		   		LEFT JOIN tbl_properties as prop  
		   		ON prop.id=pdf.`property_id` WHERE pdf.id=$id ";

$rs_limit = $db->Execute($qry_limit);	

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Edit PDF &nbsp; [Izmjeni] </td>
 	</tr>
 	<tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
	<tr>
		<td>
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_content()"  enctype="multipart/form-data">
		<div class="border_div_categories"  align="center" >
		<table cellpadding="1" cellspacing="1" border="0" >	
		<tr>
		<td class="txt1">Propery Name<br/>[vlasnika objekta]</td>
		<td>
	    <select name="users" class="fields" id="users" onchange="get_prop_pdf('property_id', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name_pdf.php"?>')">
    	<option value="">Izaberite vlasnika objekta</option>
	    <?php 
    	$rs_prop_manager->MoveFirst();
	    while(!$rs_prop_manager->EOF){
		?>
	    <option value="<?php echo $rs_prop_manager->fields['id']; ?>"
    	<?php  if($rs_prop_manager->fields['pid']== $rs_limit->fields['property_id'] ){echo 'selected="selected"';}?>>
	    <?php echo $rs_prop_manager->fields['first_name'].' '.$rs_prop_manager->fields['last_name']; ?>
		</option>
	    <?php 
    	    $rs_prop_manager->MoveNext();
	     }
    	?>  
	    </select>							
	</td>
	</tr>
			
			
	<tr>
	<td class="txt1">Propery Name</td>
	<td>
    <div id="property_id">
	<select name="property_name" class="fields" id="property_name">
        <option value="">Izaberite vlasnika</option>
       		 <?php while(!$rs_property_name->EOF){ ?>	
        <option  value="<?php echo $rs_property_name->fields['id'];?>" 
			<?php
             if($rs_property_name->fields['id']== $rs_limit->fields['property_id'] ){
                echo 'selected="selected"';
             }
             ?>>
         	<?php echo $rs_property_name->fields['property_name'];?>
        </option>
        	<?php $rs_property_name->MoveNext(); } //WHILE END ?>			
    </select>
	</div>					
			</td>
			</tr>			
			<tr>			
		</tr>	
		<tr>
        	<td class="txt1">Pdf Upload<br/>[Dodavanje PDF fajla]</td>
			<td>
			<input type="file" name="userfile" class="fields"  />
			</td>           
        </tr>
		<tr>
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:170px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update PDF &nbsp;[uspješno Pdf]" class="button" />
			</td>
        </tr>
</table>				
</div>
		<tr>
            <td>&nbsp;</td>
            <td>				
            <input type="hidden" name="mode" value="update">
            <input type="hidden" name="act" value="pdf_files">   
			 <input type="hidden" name="request_page" value="pdf_upload">           
            <input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
            <input type="hidden" name="old_pdf" value="<?php echo $rs_limit->fields['file_name']; ?>" />
			</td>
		</tr>
		</form> 
		</td>
	</tr>
</table>