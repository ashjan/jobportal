<?php
$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();

if($isrs == 0){
	echo 'No Admin account found!';
	exit;
}

$maxRows = 50;
$pageNum = $_GET['pageNum'];
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

 $qry_faq = "SELECT * FROM ".$tblprefix."site_news" ; 

$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);//ceil — Round fractions up i.e echo ceil(4.3);    // 5

$site_news=$tblprefix."site_news";
$qry_limit ="SELECT * FROM ".$tblprefix."site_news ORDER BY id DESC LIMIT ".$startRow.",".$maxRows ; 
		
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

// LOAD ALL THE LANGUAGES ADDED BY ADMIN EXCEPT ENGLISH AS IT WILL BE AL READY HERE 
$language_qry = "SELECT id,Lan_name,Lan_code,flag_name,flag_full_path,Lan_default FROM ".$tblprefix."language WHERE Lan_code<>'ENG'"; 
$rs_language = $db->Execute($language_qry);
$totallanguages =  $rs_language->RecordCount();
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading">Manage NEWS &nbsp; &nbsp;[Upravljanje novostima]</td>
  </tr>
  <tr>
    <td colspan="8" align="center" <?php if(isset($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);?></td>
  </tr>
  <tr class="tabheading">
    	<td colspan="5" align="right">Total Number of News Found: <?php echo $totalcountalpha ?></td>
	</tr>
  <tr class="tabheading">
    <td colspan="6" align="right">
      <a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  > <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> </a> </td>
  </tr>
    <td colspan="6"> <div id="controls" class="add_subscriber">
        <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
		  
		 <tr>
				<td class="txt2">
			     <!--Page Title:-->		
				</td>
					<td>&nbsp;
							
                  </td>
		 </tr>
		 <tr>
				<td>
			      News Title:<br/>[Naslov novosti]		
				</td>
					<td >
<input style="width:250px;" name="news_page_title" id="news_page_title" class="fields" type="text" value="<?php echo stripslashes($rs_content->fields['news_page_title']);?>" />					
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
					AND field_name='gdt_title' 
					AND fld_type='gdt_type'";
					$rs_lang_text = $db->Execute($language_qry);
					$totallang_flds =  $rs_lang_text->RecordCount();
					if($totallang_flds > 0){
						$value = $rs_lang_text->fields['translated_text'];
					}else{$value='';
					}
				}else{$value='';
				}
				
			/*echo '<tr>
			<td class="txt1">('.$rs_language->fields['Lan_name'].') </td>
			<td>
			<input style="width:250px;" class="fields" name="news_page_title_'.$rs_language->fields['id'].'" id="news_page_title_'.$rs_language->fields['id'].'" value="'.stripslashes($value).'" type="text" size="55"  maxlength="100" />
			</td>
			</tr>';*/
			$rs_language->MoveNext();
			} // while(!$rs_language->EOF)
          } // END if($totallanguages>0 
?>
            </tr>
					<tr>
						<td>NEWS Flag:<br/>[Tip novosti]	</td>
						<td>
                        	<select name="news_flag" id="news_flag" >
                            	<option value="1">On line</option>
                                <option value="0">Off line</option>
                            </select>
                        </td>
			</tr>
			<tr>
						<td class="txt"> NEWS Description:<br/>[Opis novosti]</td>
			</tr>
				  <tr>
                    <td>
                    Description: 	<br/>[Opis]:	
                    </td>
                <td >
<input style="width:250px;" name="news_description" id="news_description" class="fields" type="text" value="<?php echo stripslashes($rs_content->fields['news_description']);?>" />			
              </td>
            </tr>
            <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
			<td>
						
<?php           if($totallanguages>0){ 
				$rs_language->MoveFirst();
				while(!$rs_language->EOF){
 // Get the currently selected translated text if exist in language content table 
                $language_id=$rs_language->fields['id'];
				$id=$rs_content->fields['id'];    
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
				AND field_name='news_description' 
				AND fld_type='newsdescription_type'";
			$rs_lang_text = $db->Execute($language_qry);
			$totallang_flds =  $rs_language->RecordCount();
			if($totallang_flds>0){
		    $value=$rs_lang_text->fields['translated_text'];
			}else{$value='';
			}
			$rs_language->MoveNext();
					} // END  while(!$rs_language->EOF)
                } // END if($totallanguages>0 	
				
?>			</td>
			</tr>
			<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
			</tr>
			<tr>
						<td>&nbsp;</td>
						<td>
				<input style="margin:5px; width:176px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Events &nbsp;[Dodaj dogadaj]" class="button" />
				<input type="hidden" name="created_date" value="<?php echo strtotime(date("m/d/Y")); ?>">
				<input type="hidden" name="act" value="manage_news">
				<input type="hidden" name="request_page" value="news_management" />
				<input type="hidden" name="mode" value="add">
						</td>
					</tr>
			<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
			</tr>
			</table>
	</form>
		</td>
	</tr>
  <form name="mngcontentform"  action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
    <tr>
    
    <td>
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
      <tr height="5%">
        <td colspan="8" ></td>
      </tr>
      <tr class="tabheading"> 
	            <td width="5%">Sr#</td>
				<td width="35%">Page Title</td>
                <td width="20%">NEWS Status<br/>[Opis]</td>
				<td width="25%">Created Dates<br/>[Datum kreiranja]</td>
				<td width="15%">Options</td>
	  </tr>
				<?php 
				if($totalcountalpha >0){
				if($pageNum==0){$i=0;}else{$i=($pageNum*$maxRows);}
					while(!$rs_limit->EOF){?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
					  
					  <td  valign="top"><?php echo ++$i; ?></td>
					  <td valign="top"><?php echo stripslashes($rs_limit->fields['news_page_title']); ?></td>
                 <?php if($rs_limit->fields['news_flag']==1){
						?>
                        <td  valign="top" style="color:#0033FF;">Online NEWS</td>
                        <?php
							}else{
						?>
						<td  valign="top" style="color:#FF0000;">Offline NEWS</td>
						<?php
							}?>
					  <td  valign="top" style="color:#FF0000;"><?php echo date("m/d/Y",strtotime($rs_limit->fields['created_date'])); ?></td>
					  <td valign="top">
                <?php $flag= $rs_limit->fields['id']-1; ?>
				<a href="admin.php?act=edit_news&pageid=<?php echo base64_encode($rs_limit->fields['id']);?>&dgt_flag=<?php echo $flag;?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0"  title="Edit" /></a>&nbsp;&nbsp;
				<a href="admin.php?act=manage_news&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=news_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>				
                        </td>
            </tr>
            <?php 
						$rs_limit->MoveNext();
						} 
						}
						?>
						<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							<div id="txt" align="center"> Showing <?php 
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRows) ?> of <?php echo $totalRows ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>" ><b>[Previous]</b></a>
							<?php }
							///////////////////////////////
							if($pageNum>5){
							if($pageNum+5<$totalPages){	  
							$startPage=$pageNum-5;
							}else{ $startPage=($totalPages-10);  }
							}else $startPage=0;
							$count= $startPage;
							if($count+11<$totalPages){
							if($pageNum==0)$count= $count+10;else { $count = $count+11;}
							$showDot=1;
							}else{ $count=$totalPages;
							$showDot =0;
							}
							if($pageNum>6){	?>
							<a id="<?php echo '0'; ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo '0';?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[First]</b>"; ?></a>
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
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							
							?>
							<?php 
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
</table>
</td>
</tr>
</table>