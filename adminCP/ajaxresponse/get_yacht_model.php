<?php
include('root.php');
include($root.'include/file_include.php');

if(isset($_GET['id'])){
$id=$_GET['agn_id'];
$property_name=$_GET['property_id'];

$qry_ymodel = "SELECT * from ".$tblprefix."yachtmodel WHERE agn_id=".$id;  
$rs_ymodel = $db->Execute($qry_ymodel);
$totalcountalpha =  $rs_ymodel->RecordCount();

		?>
		<div id="yatchdiv">
<select name="agency_id" class="fields1" id="agency_id" onchange="">
<?php
if($totalcountalpha<=0){?>
<option value="0">No Model Found</option>
<?php
}else{?>
<option value="0">Select Model</option>	
	<?php while(!$rs_ymodel->EOF)
	{
	?>
<option value="<?php echo $rs_ymodel->fields['id'];?>"><?php echo $rs_ymodel->fields['model'] ;?></option>
	<?php $rs_ymodel->MoveNext();
	}
	}
    }
?>
</select>
</div>