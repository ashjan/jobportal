
<script type='text/javascript' src="<?php echo MYSURL?>tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>

<?php 
        $sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
$mode = '';
$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."resume ORDER BY id ASC " ; 
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

echo $qry_limit = "SELECT 
              resume.*,
              cont.Country as cnt_name,
              stat.Region,
              city.name as city_name,
              comp.company_name
              FROM 
              ".$tblprefix."resume rsm
              LEFT JOIN
              ".$tblprefix."countries cont
              ON
              rsm.country = cont.CountryId
              LEFT JOIN
              ".$tblprefix."state stat
              ON
              stat.RegionId = rsm.state 
              LEFT JOIN
              ".$tblprefix."city city
              ON
              city.id = rsm.city
              LEFT JOIN
              ".$tblprefix."company comp
              ON
              comp.company_id = rsm.company
              ORDER BY 
              rsm.id ASC
              LIMIT $startRow,$maxRows"; die;
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();
?>
<table width="100%"  class="table table-hover" cellspacing="2" cellpadding="2" class="txt">	
    <tr class="tabheading">
        <td>
            Manage Jobs
        </td>
    </tr> 
    <tr class="tabheading">
            <td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
            </td> 
    </tr>
    <tr class="tabheading">
            <td colspan="2" align="right">Total Number Of Jobs Found: <?php echo $totalcountalpha ?>
            </td>
	</tr>

	
  <tr>
 <form name="ordering_menu" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data"> 
	<td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table">

			<tr class="tabheading">
				<td width="10%">
					<table class="txt" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="10%">Jobs Order
						<input type="submit" title="Save Ordering" name="sbt_ordering" value="" class="save_icon" />
						</td>
					</tr>
					</table>
				</td>
                <th width="10px">Job Title</th>
                <th width="10px">Company</th>
                <th width="10px">Country</th>
                <th width="10px">state</th>
                <th width="10px">city</th>
		<th width="10%">Options</th>
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
					    <td valign="top">
					<?php if($rs_limit->fields['job_id']==24){ ?>
 <input size="3" style="text-align:center; width:50px; background:#FFFFDD; border:#0000FF 1px solid;" name="menu_order[<?php echo $rs_limit->fields['job_id']; ?>]" id="menu_order[<?php echo $rs_limit->fields['job_id']; ?>]" type="text" value="0"/>
 					<?php }else{ ?>
					<input size="3" style="text-align:center; width:50px; background:#FFFFDD; border:#0000FF 1px solid;" name="menu_order[<?php echo $rs_limit->fields['job_id']; ?>];" id="menu_order[<?php echo $rs_limit->fields['job_id']; ?>]" type="text" value="<?php echo $rs_limit->fields['job_orderdering'];?>"/>
				<?php	} ?>
					</td>
                        <td width="10px"><?php echo $rs_limit->fields['job_title']; ?></td>
                        <td width="10px"><?php echo $rs_limit->fields['company_name']; ?></td>
                        <td width="10px"><?php echo $rs_limit->fields['cnt_name']; ?></td>
                        <td width="10px"><?php echo $rs_limit->fields['Region']; ?></td>
                        <td width="10px"><?php echo $rs_limit->fields['city_name']; ?></td>
			<td valign="top" width="10px">
                            <a href="admin.php?act=update_property&amp;id=<?php echo base64_encode($rs_limit->fields['job_id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
                            <a href="admin.php?act=manage_property&amp;mode=del_category&amp;id=<?php echo base64_encode($rs_limit->fields['job_id']); ?>&amp;request_page=property_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                            <a href="javascript:;" onClick="jQuery('#controls_<?php echo $rs_limit->fields['job_id']; ?>').slideToggle('fast'); return false"  ><img src="<?php MYSURL?>graphics/data.gif" border="0" title="Open Details" /></a>
                            <a href="javascript:;" onClick="jQuery('#control_preference_<?php echo $rs_limit->fields['job_id']; ?>').slideToggle('fast'); return false"  ><img src="<?php MYSURL?>graphics/contents.gif" border="0" title="Open Details" /></a>
                        <!-- code for job preferences starts -->
                        <?php
                           $qry_preference = "SELECT * FROM ".$tblprefix."preference WHERE job_id=".$rs_limit->fields['job_id'];
                            $rs_preference = $db->Execute($qry_preference);
                        ?>
                        <!-- code for job preferences ends   -->
                        </td>
					</tr>
	<style>
	#controls_<?php echo $rs_limit->fields['job_id']; ?>{
	display:none;
	}
        #control_preference_<?php echo $rs_limit->fields['job_id']; ?>{
	display:none;
	}
        </style>
	 <tr>
             
	 <td colspan="8">
	 <div id="controls_<?php echo $rs_limit->fields['job_id']; ?>" style="display: none;">
	 <?php echo $rs_limit->fields['job_description']; ?> 
         </div>
	 </td>
	 
         </tr>
         <tr>
             
	 <td colspan="8">
	 <div id="control_preference_<?php echo $rs_limit->fields['job_id']; ?>" style="display: none;">
	 <?php 
            //echo $rs_preference->fields['preference_title'].'<br>';
            //echo $rs_preference->fields['preference_description'];
         ?> 
             <form action="admin.php" enctype="multipart/form-data" method="post" name="testform" > 
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			<tr>
				<td>
                                    Preference Title
                                </td>
                        </tr>
                        
                      
                        
                        <tr>
				<td>
                                    <input type="text" name="preference_title" class="fields" id="preference_title" value="<?php echo $rs_preference->fields['preference_title']; ?>" />						
                                </td>
			</tr>  
                        
                        <tr><td>&nbsp;</td></tr>
                        
                        <tr>
        			<td>
                                    Preference Description
                                </td>
                        <tr>
				
                         
			<tr>
        							
                                <td>
                                        <textarea id="description_<?php echo $rs_limit->fields['job_id']?>" name="preference_description" rows="15" cols="100">
						<?php echo stripslashes($rs_preference->fields['preference_description'])?>
                                        </textarea>
                                </td>
			</tr> 
                        
                        <tr><td>&nbsp;</td></tr>
                                                
			<tr>
				<td>
                                    <input style="margin:5px; width:110px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Submit" class="button" />			
                                </td>
			</tr>
					
			
					<tr>
						<td>&nbsp;</td>
						<td>
							<input type="hidden" name="mode" value="add">
							<input type="hidden" name="job_id" value="<?php echo base64_encode($rs_limit->fields['job_id']);?>">
							<input type="hidden" name="act" value="jobs_listing">
<!--							<input type="hidden" name="act2" value="filter_price">-->
							<input type="hidden" name="request_page" value="manage_preference"/>						
                                                </td>
					</tr>
				
				
				<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
				</tr>
				</table>
                             </form>  
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
							<!-- END: Pagination Code -->						</td>
					</tr>
			
			<?php
				}else{

			?>
				<tr>
					<td colspan="14" class="errmsg"> No Property type Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
	</td>
	    <input type="hidden" name="mode" value="order_menu">
		<input type="hidden" name="act" value="manage_property">
<!--		<input type="hidden" name="id" value="<?php echo base64_encode($id); ?>">-->
		<input type="hidden" name="request_page" value="property_management" />
		</form>
		
  </tr>
</table>