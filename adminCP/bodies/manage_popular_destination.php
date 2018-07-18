<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE pr.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' AND pr.pm_type=0';
}else{
	$module_pm_where = ' WHERE pr.pm_type=0 ';
}



$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;


  $qry_faq = "SELECT
			".$tblprefix."popular_destination.id,
			".$tblprefix."popular_destination.popular_destination_title,
			".$tblprefix."popular_destination.popular_destination_description,
			".$tblprefix."popular_destination.popular_destination_thumbnail,
			".$tblprefix."popular_destination.popular_destination_cat_id,
			".$tblprefix."popular_destination.popular_destination_slug,
			".$tblprefix."popular_dest_cat.popular_category_name,
			".$tblprefix."popular_dest_cat.popular_category_slug,
			".$tblprefix."popular_dest_cat.cat_orderdering
			FROM
			".$tblprefix."popular_destination
			Inner Join ".$tblprefix."popular_dest_cat ON ".$tblprefix."popular_destination.popular_destination_cat_id = ".$tblprefix."popular_dest_cat.id 
			";

$rs_faq = $db->Execute($qry_faq);
$totalcountalpha =  $rs_faq->RecordCount();
$totalRows = $totalcountalpha;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "
             SELECT
			".$tblprefix."popular_destination.id,
			".$tblprefix."popular_destination.popular_destination_title,
			".$tblprefix."popular_destination.popular_destination_description,
			".$tblprefix."popular_destination.popular_destination_thumbnail,
			".$tblprefix."popular_destination.popular_destination_cat_id,
			".$tblprefix."popular_destination.popular_destination_slug,
			".$tblprefix."popular_dest_cat.popular_category_name,
			".$tblprefix."popular_dest_cat.popular_category_slug,
			".$tblprefix."popular_dest_cat.cat_orderdering
			FROM
			".$tblprefix."popular_destination
			Inner Join ".$tblprefix."popular_dest_cat ON ".$tblprefix."popular_destination.popular_destination_cat_id = ".$tblprefix."popular_dest_cat.id  ";

$rs_limit = $db->Execute($qry_limit);


//loading popular destination categories

$qry_popular_des = "SELECT * FROM ".$tblprefix."popular_dest_cat";

$rs_popular_des = $db->Execute($qry_popular_des);
$totalcountpopulardestination =  $rs_popular_des->RecordCount();

// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE ALL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'";
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();

?>


<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Manage popular destination
</div></div>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">
	
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Popular Destination Found: <?php echo $totalcountalpha ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
		<a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  >
		<img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" />
		</a>
		</td>
	</tr>
	<tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber">
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
		<table>
		
				<!--<tr>
					<td class="txt1">Popular Destination Title</td>
					<td>
					<input type="text" name="popular_destination_title" class="fields" id="popular_destination_title" value="" />					
					</td>
				</tr>-->
				<!-- hs make changes here -->
				
				
				<tr>
					<td>
			     Title:(English) 			
				</td>
					<td >
<input style="width:250px;" name="page_title" id="page_title" class="fields" type="text" value="" />					
                  </td>
				</tr>
                
                
                
                <?php 
				if($totallanguages>0){ 
				$rs_language->MoveFirst();
				while(!$rs_language->EOF){
                // Get the currently selected translated text if exist in language content table 
                $language_id=$rs_language->fields['id'];
				
				if($mode == "update"){
					
					$id = $pageid;
					
					$language_qry = "SELECT id,
					language_id,
					page_id,
					field_name,
					translation_text,
					translated_text,
					fld_type 
					FROM 
					".$tblprefix."language_contents 
					WHERE   
					language_id=".$language_id." 
					AND page_id='".$id."'  
					AND field_name='page_title' 
					AND fld_type='popular_destination'"
					;   

					$rs_lang_text = $db->Execute($language_qry);
					$totallang_flds =  $rs_lang_text->RecordCount();
					if($totallang_flds > 0){
						$value = $rs_lang_text->fields['translated_text'];
					}else{
						$value='';
					}
				}else{
					$value='';
				}
				
			echo '<tr>
			<td class="txt1">Title:('.$rs_language->fields['Lan_name'].') </td>
			<td>
			<input style="width:250px;" class="fields" name="page_title_'.$rs_language->fields['id'].'" id="page_title_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text" size="55"  maxlength="100" />
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // while(!$rs_language->EOF)
                } // END if($totallanguages>0 
?>
				
				
					<tr>
						<td>Description:(English)</td>
					
						<td>
							<textarea id="short_descriptions" name="short_descriptions" rows="25" cols="80"></textarea>					
							</td>
					</tr>
                    
                    <tr>
					
				<td>
						
<?php           if($totallanguages>0){ 
				$rs_language->MoveFirst();
				while(!$rs_language->EOF){
 // Get the currently selected translated text if exist in language content table 
                $language_id=$rs_language->fields['id'];
				$id=$rs_limit->fields['id'];    
				$language_qry = "SELECT id,
				language_id,
				page_id,
				field_name,
				translation_text,
				translated_text,
				fld_type 
				FROM 
				".$tblprefix."language_contents 
				WHERE   
				language_id=".$language_id." 
				AND page_id=".$id." 
				AND field_name='short_descriptions' 
				AND fld_type='popular_destination'"
				;  
			$rs_lang_text = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			if($totallang_flds>0){
		    $value=$rs_lang_text->fields['translated_text'];
			}else{
			$value='';
			}
			echo '<tr>
			<td class="txt1">Description:('.$rs_language->fields['Lan_name'].') </td>
			<td>
			<textarea id="short_descriptions_'.$rs_language->fields['id'].'" name="short_descriptions_'.$rs_language->fields['id'].'" rows="25" cols="80">'.stripslashes($value).'</textarea>
			</td>
			</tr>';
			$rs_language->MoveNext();
					} // END  while(!$rs_language->EOF)
                } // END if($totallanguages>0 	
				
?>					</td>
				</tr>
				<!-- hs make changes here -->
				<tr>
					<td class="txt1">&nbsp;</td></tr>
				
				<tr>
					<td class="txt1">Popular Destination Category</td>
					<td>
					
						<select name="popular_destination_cat_id" class="fields" id="popular_destination_cat_id">
							<option value="0">Select Popular Destination</option>
                            <?php
							while(!$rs_popular_des->EOF){
							?>
                            <option value="<?php echo $rs_popular_des->fields['id']; ?>"><?php echo $rs_popular_des->fields['popular_category_name']; ?></option>
                            <?php
								$rs_popular_des->MoveNext();
								}
							?>
						</select>
					
					</td>
				</tr>
				
                
    		
				
		<tr>
        <td>Popular Destination Image</td>
		<td><input type="file" name="popular_destination_thumbnail" class="fields" /></td>
		</tr>
        <tr><td></td>
		<td></td></tr>
		<tr><td></td>
		<td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Upload Image" class="button" />
		<input type="hidden" name="act" value="manage_popular_destination" />
		<input type="hidden" name="theValue" id="theValue" value="0" />
        <input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="request_page" value="popular_destination_management" />
		<input type="hidden" name="mode" value="add">
		</td>
		</tr>
		</table>
		</form>
</div>
		 </td>
		 </tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table table-hover">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<th width="5%">Sr#</th>
				<th width="25">Popular Destination Title</th>
				<th width="25">Popular Destination Description</th>
				<th width="65">Popular Destination Category</th>
                <th width="20%">Popular Destination Image</th>
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
					while(!$rs_limit->EOF){
			?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="middle"><?php echo ++$i; ?></td>
                        <td> 
					  <?php echo $rs_limit->fields['popular_destination_title']; ?>
					  </td>
						<td><?php 
					  echo stripslashes($rs_limit->fields['popular_destination_description']);
					  ?></td>
						<td><?php echo $rs_limit->fields['popular_category_name'];?></td>
						<td valign="middle"><a href="<?php echo $rs_limit->fields['popular_destination_thumbnail']; ?>">
						<img  src="<?php echo SURL; ?>classes/phpthumb/phpThumb.php?src=<?php echo MYSURL."media/images/".$rs_limit->fields['popular_destination_thumbnail']; ?>&w=50&h=40&zc=1" border="0"></a>
						</td>
						
						<td valign="middle">
							<a href="admin.php?act=edit_popular_destination&pageid=<?php echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;	
							<a href="admin.php?act=manage_popular_destination&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=popular_destination_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
							<input type="hidden" name="act" value="manageletter">		
							<input type="hidden" name="mode" value="delete">						</td>
					</tr>
					<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							<div id="txt" align="center"> Showing <?php 
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
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
							<?php } 
							?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Media Image Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	</td>
  </tr>
</table>
</div></div>
<?php //echo $where;?>
