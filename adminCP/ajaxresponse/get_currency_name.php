<?php
include('root.php');
include($root.'include/file_includes.php');
    $id = $_GET['id'];
    //$maxRows = 20;
	//echo "this is just a test and would no be count in future"; exit;

$qry_currencies_data = "SELECT * FROM ".$tblprefix."currencies_data WHERE id=".$id;
$rs_currencies_data = $db->Execute($qry_currencies_data);
$count_add =  $rs_currencies_data->RecordCount();
?>
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