<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
$maxRows = 500;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}

if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;


//$qry_faq = "SELECT * FROM ".$tblprefix."language_contents" ;
$contents=$tblprefix."language_contents";
$language=$tblprefix."language";

$qry_faq = "SELECT
				".$language.".Lan_name,
				".$contents.".page_id,
				".$contents.".id,
				".$contents.".field_name,
				".$contents.".translated_text,
				".$contents.".fld_type
				FROM
				".$contents."
				LEFT Join ".$language." ON ".$language.".id =".$contents.".language_id";

$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);
 $qry_limit = "SELECT
				".$language.".Lan_name,
				".$contents.".page_id,
				".$contents.".id,
				".$contents.".field_name,
				".$contents.".translated_text,
				".$contents.".fld_type
				FROM
				".$contents."
				LEFT Join ".$language." ON ".$language.".id =".$contents.".language_id
				LIMIT $startRow,$maxRows"; 


				
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

/*		
       while(!$rs_limit->EOF){
			if(strlen($rs_limit->fields['translated_text'])>0){
			echo 'empty<br>';
			}
			 echo $rs_limit->fields['translated_text']."<br>";
			$rs_limit->MoveNext();
		}
die;
*/


if(isset($_POST['field_name'])){
     $field_name = $_POST['field_name'];
	 $type = $_POST['type'];
	 $language = $_POST['language'];
	 $where =array();
	 $where[] =" WHERE ";
	 if(!empty($field_name) and $field_name!=NULL){
	 $where[] = $tblprefix."language_contents.field_name LIKE'%".$field_name."%'";
	 }
	
	 if((!empty($field_name) and $field_name!=NULL) and (!empty($type) and $type!=NULL)){
	 $whereor=" OR ";
	 }else{
	 $whereor=" ";
	 }
	 if(!empty($type) and $type!=NULL){
	 $where[] = $whereor.$tblprefix."language_contents.fld_type LIKE '%".$type."%'";
	 }
	 
	 if( (!empty($type) and $type!=NULL) and (!empty($language) and $language!=NULL)  ){
	 $whereor=" OR ";
	 }else{
	 $whereor=" ";
	 }
	 
	 
	 if(!empty($language) and $language!=NULL){
	 $where[] = $whereor.$tblprefix."language.lan_name LIKE '%".$language."%'";
	 }
	  
}
if(isset($where))
{
  if(count($where)<2){
   $where='';
  }else{
   $where=implode(" ",$where); 
  }
}
else
{
    $where = '';
}
  $qry_cont_search = "SELECT ".$tblprefix."language_contents.language_id,".$tblprefix."language_contents.page_id,
".$tblprefix."language_contents.field_name,
".$tblprefix."language_contents.translation_text,
".$tblprefix."language_contents.translated_text,
".$tblprefix."language_contents.fld_type,
".$tblprefix."language.id,".$tblprefix."language.lan_name  FROM
			".$tblprefix."language_contents 
				LEFT Join ".$tblprefix."language  ON ".$tblprefix."language.id = ".$tblprefix."language_contents.language_id
				".$where ; 

  $rs_cont_search = $db->Execute($qry_cont_search);
			
  $count_adds =  $rs_cont_search->RecordCount();
  $totalRow = $count_adds;
  $totalPage = ceil($totalRow/$maxRows);
 $qry_limits = "SELECT ".$tblprefix."language_contents.language_id,".$tblprefix."language_contents.page_id,
".$tblprefix."language_contents.field_name,
".$tblprefix."language_contents.translation_text,
".$tblprefix."language_contents.translated_text,
".$tblprefix."language_contents.fld_type,
".$tblprefix."language.id,".$tblprefix."language.lan_name  FROM
			".$tblprefix."language_contents 
				LEFT Join ".$tblprefix."language  ON ".$tblprefix."language.id = ".$tblprefix."language_contents.language_id
				".$where."
				LIMIT $startRow,$maxRows";
				$rs_limits = $db->Execute($qry_limits);
  $totalcountbeta =  $rs_limits->RecordCount();	
				
				
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">

	<tr>
    	<td id="heading">Manage Languages</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Languages Found: <?php echo $totalcountalpha ?></td>
	</tr>
<!--............................................ Search ........................................-->
	<tr><td>
	<form name="testform" action="admin.php?act=lang_cont_managment" method="post">
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
	
	<tr>
	<td colspan="6" align="left" class="tabheading" valign="baseline" style="border:#999999 solid 1px;">
		field name:
         
                <input style="width:100px;" class="fields" type="text" name="field_name"  id="field_name" value="<?php if(isset($_POST['field_name'])){ echo $_POST['field_name'];} ?>" /></td> <td colspan="6" align="left" class="tabheading" valign="baseline" style="border:#999999 solid 1px;">
		
		Type:
       
                <input style="width:100px;" class="fields" type="text" name="type"  id="type" value="<?php if(isset($_POST['type'])){echo $_POST['type'];}  ?>" /></td>
		<td colspan="6" align="left" class="tabheading" valign="baseline" style="border:#999999 solid 1px;">
		Language:
       
                <input style="width:100px;" class="fields" type="text" name="language"  id="language" value="<?php if(isset($_POST['language'])){echo $_POST['language'];}  ?>" /></td>
		</td> <td colspan="6" align="left" class="tabheading" valign="baseline" style="border:#999999 solid 1px;">
		<input type="hidden" name="act" value="lang_cont_managment"/>
		&nbsp;&nbsp;<input type="submit" name="sort" value="Search" class="button" />
        <!--<input type="submit" name="sort" value="Search" class="button" />-->
	  
	</td>
	</tr>
	
	</table>
	</form>		
	</td>
	</tr>
<!--............................................ End of Search .................................-->
    <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="3%">Sr#</td>
                <td width="17%">field name</td>
                <td width="10%">Type</td>
				<td width="10%">Language</td>
				<td width="50%">Translated text</td>
				<td width="10%">Options</td>
		    </tr>
			<?php
			if($totalcountbeta >0){
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
				
				   if($pageNum==0){
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   }
				   
					while(!$rs_cont_search->EOF){
					
			?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="middle"><?php echo ++$i; ?></td>
                        <td valign="middle"><?php echo $rs_cont_search->fields['field_name']; ?></td>
						<td valign="middle"><?php echo $rs_cont_search->fields['fld_type']; ?></td>
						<td valign="middle"><?php echo $rs_cont_search->fields['lan_name']; ?></td>
						<td valign="middle"><?php echo substr($rs_cont_search->fields['translated_text'],0,50);?></td>

						<td valign="middle">
							<a href="admin.php?act=edit_lang_cont_managment&amp;id=<?php echo base64_encode($rs_cont_search->fields['id']);?> &amp;type=<?php echo base64_encode($rs_cont_search->fields['fld_type']); ?>"  ><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=lang_cont_managment&amp;mode=delete&amp;id=<?php echo base64_encode($rs_cont_search->fields['id']); ?>&amp;request_page=language_content" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                            <a class="tabheading" href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_cont_search->fields['id']; ?>').slideToggle('fast'); return false"><img src="<?php MYSURL?>graphics/data.gif" width="15" height="18" border="0" title=" Click here to view the Answer " /></a>							
                       </td>
					</tr>
<tr class="tabheading">
          <td colspan="7">
          <div id="controls_<?php echo $rs_cont_search->fields['id']; ?>" class="add_subscriber txt" >
           <table cellpadding="5" cellspacing="5" border="0" >
                <tr>
                    <td width="50%" class="txt">
                       <?php echo $rs_cont_search->fields['translated_text']; ?>
                    </td>
               </tr>                    
           </table>                     
          </div>
          </td>
      </tr>					
			<?php 
						$rs_cont_search->MoveNext();
					}
			?>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="hidden" name="act" value="lang_cont_managment">		
							<input type="hidden" name="mode" value="delete">
						</td>
					</tr>
					<tr>
						<td colspan="11">
							<!-- START: Pagination Code -->
							<div class="txt">
							
							<div id="txt" align="center"> Showing <?php 
							
							echo ($startRow + 1) ?> to <?php echo min($startRow + $maxRows, $totalRow) ?> of <?php echo $totalRow ?> &nbsp; Record(s)&nbsp;&nbsp;<br />Pages :: 
							<?php if ($pageNum  > 0) {?>
							
							<a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo max(0, $pageNum - 1)?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search']; ?>" ><b>[Previous]</b></a>
							
							<?php }?>
							
							<?php
							///////////////////////////////
							
							if($pageNum>5){
							if($pageNum+5<$totalPage){	  
							$startPage=$pageNum-5;
							}else{ $startPage=($totalPage-10);  }
							}
							else $startPage=0;
							$count= $startPage;
							if($count+11<$totalPage){
							if($pageNum==0)
							$count= $count+10;
							else { $count= $count+11;}
							$showDot=1;
							}
							else { $count=$totalPage;
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
							if($pageNum+6<$totalPage)	{	?> 
							<a id="<?php echo $totalPage-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPage-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							
							?>
							<?php 
							if ($pageNum < $totalPage - 1){
							?>
						 <a href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo min($totalPage, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						
						</td>
					</tr>
			<?php 
				}elseif($totalcountalpha >0){
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }
				
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
                        <td valign="middle"><?php echo $rs_limit->fields['field_name']; ?></td>
						<td valign="middle"><?php echo $rs_limit->fields['fld_type']; ?></td>
						<td valign="middle"><?php echo $rs_limit->fields['Lan_name']; ?></td>
						<td valign="middle"><?php echo substr($rs_limit->fields['translated_text'],0,50);?></td>

						<td valign="middle">
							<a href="admin.php?act=edit_lang_cont_managment&amp;id=<?php echo base64_encode($rs_limit->fields['id']);?> &amp;type=<?php echo base64_encode($rs_limit->fields['fld_type']); ?>"  ><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=lang_cont_managment&amp;mode=delete&amp;id=<?php echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=language_content" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                            <a class="tabheading" href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_limit->fields['id']; ?>').slideToggle('fast'); return false"><img src="<?php MYSURL?>graphics/data.gif" width="15" height="18" border="0" title=" Click here to view the Answer " /></a>							
                       </td>
					</tr>
<tr class="tabheading">
          <td colspan="7">
          <div id="controls_<?php echo $rs_limit->fields['id']; ?>" class="add_subscriber txt" >
           <table cellpadding="5" cellspacing="5" border="0" >
                <tr>
                    <td width="50%" class="txt">
                       <?php echo $rs_limit->fields['translated_text']; ?>
                    </td>
               </tr>                    
           </table>                     
          </div>
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
							<input type="hidden" name="act" value="lang_cont_managment">		
							<input type="hidden" name="mode" value="delete">
						</td>
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
					<td colspan="14" class="errmsg"> No Language Content Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>	
		</td>
  </tr>
</table>
<?php //echo $where;?>
