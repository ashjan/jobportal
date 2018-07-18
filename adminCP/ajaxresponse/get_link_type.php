<?php
include('root.php');
include($root.'include/file_include.php');
echo 'here';die;
?>

<div id="get_link_type">
    <?php
    echo 'here';die;
    ?>                        
    <tr>
                                       <td class="fieldheading"> Menu Content : </td>
					<td>
					<?php 
					$qry_getcontent = "SELECT * FROM ".$tblprefix."pagecontent"; 
					$rs_getcontent = $db->Execute($qry_getcontent);
					$count_contents =  $rs_getcontent->RecordCount();
					$totalContents = $count_contents;
					?>
					 <select name="content_id" class="fields" id="content_id" >
					 <option value="0">Select Content Page</option>
					 <?php
					while(!$rs_getcontent->EOF){
					 echo '<option value="'.$rs_getcontent->fields['id'].'">'.$rs_getcontent->fields['page_title'].'</option>';
					 $rs_getcontent->MoveNext();
					 }
					 ?>
					 </select>
                                         </td>
				</tr>
</div>