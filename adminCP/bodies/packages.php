
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
	//var_dump($rs); exit;
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
$mode = "";
$maxRows = 40;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;
// getting packages record and showing it in the grid
 $qry_packages = "SELECT *
					FROM
					".$tblprefix."packages  
				   WHERE ".$tblprefix."packages.package_status = 1 LIMIT $startRow,$maxRows ";
$rs_packages = $db->Execute($qry_packages);
//var_dump($rs_packages); exit;
$count_add =  $rs_packages->RecordCount();
  $totalRows = $count_add; 
$totalPages = ceil($totalRows/$maxRows);

$rs_limit = $db->Execute($qry_packages);
$totalcountalpha =  $rs_limit->RecordCount();
?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Manage Packages
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">&nbsp;</td>
  	</tr>
    <tr>
    	<td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']);}
		if(!empty($_GET['okmsg'])){ echo base64_decode($_GET['okmsg']);}  ?> </td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">Total Menu Items: <?php echo $totalcountalpha ?></td>
	</tr>
	<tr class="tabheading">
		<td colspan="6" align="right">
		<a   href="javascript" onClick="jQuery('#controls').slideToggle('fast'); return false"  >
		<img src="<?php echo MYSURL?>graphics/add.png" border="0" title="Add New Package" />
		</a>
		</td>
	</tr>
	<tr>
	<td colspan="6">
 <div id="controls" class="add_subscriber" style="display:none;">
        <table width="100%" align="center"  cellpadding="1" cellspacing="1" border="0" class="table table-hover" >
        <tr>
        <td>
  		<b>  Add Package </b>
        </td>
        </tr>                    
        <tr>
        <td>
		<form name="managepackageform" id="managepackageform" action="admin.php" method="post"  enctype="multipart/form-data">
			<table  border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
				<tr>
					<td class="fieldheading">Package Title : </td>
					 <td >
					 <input style="width:42%;" name="package_title" class="fields" id="package_title" type="text" required="required"  />
					</td>
				</tr>
				   <tr>
                <td>&nbsp;
                
                </td>
                </tr>
				 <tr>
					<td class="fieldheading"> Package Type : </td>
					 <td>
                     <select name="package_type" id="package_type" required="required" onchange="javascript: disableprice(this.value)" style="width:42%;" >
                     <option value="daily">Daily</option>
                     <option value="weekly">Weekly</option>
                     <option value="monthly">Monthly</option>
                     <option value="annually">Annually</option>
                     <option value="forever">Forever</option>
                     <option value="free">Free</option>
                     
                     </select>
					 
                     </td>
				</tr>
                 
                   <tr>
                <td>&nbsp;
                
                </td>
                </tr>
               <tr>
					<td class="fieldheading"> Package Currency : </td>
					 <td>
                     <select name="package_currency" id="package_currency" style="width:42%;" >
                     <option value="1">$</option>
                     <option value="2">Rs</option>
                     
                     </select>
					 
                     </td>
				</tr>
                   <tr>
                <td>&nbsp;
                
                </td>
                </tr>
                <tr>
					<td class="fieldheading"> Package Price : </td>
					 <td>
					 <input type="number" name="package_price"  id="package_price" style="width:42%;"  />
                     </td>
				</tr>
                   <tr>
                <td>&nbsp;
                
                </td>
                </tr>
                <tr>
					<td class="fieldheading"> Package Description : </td>
					 <td>
					 <textarea name="package_description" id="package_description" required="required">
                     </textarea>
                     </td>
				</tr>
                   <tr>
                <td>&nbsp;
                
                </td>
                </tr>
                <tr>
					<td class="fieldheading"> Package Detail : </td>
					 <td>
					 
                     <textarea name="package_detail" id="package_detail" required="required" >
                     </textarea>
                     </td>
				</tr>
                 <tr>
                <td>&nbsp;
                
                </td>
                </tr>
                <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">
					<input style="margin:5px; width:100px; float:none; text-align:center; margin-left: 17%;" type="submit" name="Sbtadd_menu" id="Sbtadd_menu" value="Add Package" class="button" />
					<input type="hidden" name="mode" value="add" />
					<input type="hidden" name="act" value="packages">
					<input type="hidden" name="act2" value="packages">
					<input type="hidden" name="request_page" value="packages" />
					</td>
				</tr>
			
				
			</table>
	</form>
		</td>
		</tr>
		</table>
</div>
		 </td>
		 </tr>
  <tr>

    <td>
		<form name="list_order" id="list_order" method="post" enctype="multipart/form-data" action="admin.php?act=managemenues" >
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table table-hover" >
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				
                <td width="12">Package Title</td>
				<td width="10">Package Type</td>
				<td width="30">Package Price</td>
                <td width="30">Package Description</td>
                <td width="30">Package Detail</td>
				<!--<td width="15">Main Menu</td>
				<td width="15%">Menu Status</td>-->
				<td width="10%">Options</td>
		    </tr>
			<?php if($totalcountalpha >0){ 
			if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   
				   }       
					while(!$rs_limit->EOF){  ?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
					
                    <td valign="top"><?php  echo $rs_limit->fields['package_name']; ?></td>
                    <td valign="top"><?php  echo ucwords($rs_limit->fields['package_type']); ?></td>
                    <td valign="top"><?php if($rs_limit->fields['package_currency'] == 1){ echo "$";
						} elseif($rs_limit->fields['package_currency'] == 2) {echo "Rs";}  echo $rs_limit->fields['package_price']; ?></td>
					<td valign="top"><?php echo $rs_limit->fields['package_description']; ?></td>
                    <td valign="top"><?php  echo $rs_limit->fields['package_detail']; ?></td>
					<td valign="top">
							<a href="admin.php?act=editpackage&amp;id=<?php echo base64_encode($rs_limit->fields['package_id']);?> &amp;"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit Package Item" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=packages&amp;mode=del_package&amp;id=<?php echo base64_encode($rs_limit->fields['package_id']); ?>&amp;request_page=packages" onClick="return confirm('Are you sure you want to Delete this menu Item?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
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
							if($showDot==1){ echo "..."; }
							if($pageNum+6<$totalPages)	{	?> 
							<a id="<?php echo $totalPages-1 ?>" href="admin.php?act=<?=$_GET['act']?>&amp;pageNum=<?php echo $totalPages-1;?>&amp;condition=<?php echo base64_encode($where);?>" > <?php echo "<b>[Last]</b>"; ?></a>				    
							<?php }
							if ($pageNum < $totalPages - 1){
							?>
						 <a href="admin.php?act=<?php echo $_GET['act']; ?>&amp;pageNum=<?php echo min($totalPages, $pageNum + 1);?>&amp;condition=<?php echo base64_encode($where);?>&amp;search=<?php echo $_GET['search'];?>"><b>[Next]</b> </a>
							<?php } ?>
							</div>
							</div>	
							<!-- END: Pagination Code -->						</td>
					</tr>
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Package Item Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
			?>
		</table>
		            
					<input type="hidden" name="act" value="packages">
					<input type="hidden" name="request_page" value="packages" />
		</form>
	</td>
  </tr>
  
  
  
</table>
</div>

<br />

<script>
function disableprice(id){
	if(id == 'free'){
		$("#package_currency").attr("disabled", "disabled"); 
		$("#package_price").attr("disabled", "disabled");
		$("#package_currency").css("background-color", "gainsboro");
		$("#package_price").css("background-color", "gainsboro");
		
	}
	else {
		$("#package_currency").removeAttr("disabled"); 
		$("#package_price").removeAttr("disabled"); 
		$("#package_currency").css("background-color", "white");
		$("#package_price").css("background-color", "white");
	}
	}
</script>