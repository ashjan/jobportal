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
$id=base64_decode($_GET['id']);
$qry_limit = "SELECT * FROM ".$tblprefix."packages WHERE package_id=".$id;
$rs_limit = $db->Execute($qry_limit);

// Editor Loading //


?>

<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
 	<tr>
  		<td id="heading">Package Management Section</td>
 	</tr>
	<tr>
  		<td></td>
	</tr>
	<tr>
		<td>
	<form name="managepackageform" action="admin.php" method="post" enctype="multipart/form-data">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	  <tr>
                <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']);}
                if(!empty($_GET['okmsg'])){ echo base64_decode($_GET['okmsg']);}  ?> </td>
    </tr>
     
	<tr>
					<td class="fieldheading">Package Title : </td>
					 <td >
					 <input style="width:42%;" name="package_title" class="fields" id="package_title" type="text" required="required" value="<?php echo $rs_limit->fields['package_name'] ?>"  />
					</td>
				</tr>
				 <tr>
                <td>&nbsp;
                
                </td>
                </tr>
                
                	<tr>
					<td class="fieldheading">Package Type : </td>
					 <td >
					  <select style="width:42%;" name="package_type" id="package_type" onchange="javascript: disableprice(this.value)" required="required">
                     <?php if($rs_limit->fields['package_type'] == 'daily'){?>
                     <option value="daily" selected="selected">Daily</option>
                     <option value="weekly">Weekly</option>
                     <option value="monthly">Monthly</option>
                     <option value="annually">Annually</option>
                     <option value="forever">Forever</option>
                     <option value="free">Free</option>
                     <?php }
					 else if($rs_limit->fields['package_type'] == 'weekly'){?>
                     <option value="daily" >Daily</option>
                     <option value="weekly" selected="selected">Weekly</option>
                     <option value="monthly">Monthly</option>
                     <option value="annually">Annually</option>
                     <option value="forever">Forever</option>
                     <option value="free">Free</option>
                     <?php }
					  else if($rs_limit->fields['package_type'] == 'monthly'){?>
                     <option value="daily" >Daily</option>
                     <option value="weekly">Weekly</option>
                     <option value="monthly" selected="selected">Monthly</option>
                     <option value="annually">Annually</option>
                     <option value="forever">Forever</option>
                     <option value="free">Free</option>
                     <?php }
					 elseif($rs_limit->fields['package_type'] == 'annually'){?>
                     <option value="daily" >Daily</option>
                     <option value="weekly">Weekly</option>
                     <option value="monthly">Monthly</option>
                     <option value="annually" selected="selected">Annually</option>
                     <option value="forever">Forever</option>
                     <option value="free">Free</option>
                     <?php }elseif($rs_limit->fields['package_type'] == 'forever'){?>
                     <option value="daily" >Daily</option>
                     <option value="weekly">Weekly</option>
                     <option value="monthly">Monthly</option>
                     <option value="annually" >Annually</option>
                     <option value="forever" selected="selected">Forever</option>
                     <option value="free">Free</option>
					 <?php }elseif($rs_limit->fields['package_type'] == 'free'){?>
                     <option value="daily" >Daily</option>
                     <option value="weekly">Weekly</option>
                     <option value="monthly">Monthly</option>
                     <option value="annually" >Annually</option>
                     <option value="forever">Forever</option>
                     <option value="free" selected="selected">Free</option>
                     <?php } ?>
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
                     <select style="width:42%;" name="package_currency" id="package_currency">
                     <?php if($rs_limit->fields['package_currency'] == 1){?>
                     <option value="1" selected="selected">$</option>
                     <option value="2">Rs</option>
                     <?php }
					 else { ?>
                     <option value="1">$</option>
                     <option value="2" selected="selected">Rs</option>
                     <?php } ?> 
                     </select>
					 
                     </td>
				</tr>
                <tr>
                <td>&nbsp;
                
                </td>
                </tr>
                <tr>
					<td class="fieldheading" style="width:42%;"> Package Price : </td>
					 <td>
					 <input type="number" name="package_price" id="package_price" value="<?php echo $rs_limit->fields['package_price'] ?>"  />
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
                     <?php echo $rs_limit->fields['package_description'] ?>
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
                     <?php echo $rs_limit->fields['package_detail'] ?>
                     </textarea>
                     </td>
				</tr>		
		<tr>
         <tr>
                <td>&nbsp;
                
                </td>
                </tr>
	        <td>&nbsp;
			</td>
			<td>
			<input style="margin:5px; width:112px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Update Package" class="button"  />
			</td>
        </tr>
		</table>
			<input type="hidden" name="act" value="packages" />
			<input type="hidden" name="request_page" value="packages" />
			<input type="hidden" name="id" value="<?php echo base64_encode($rs_limit->fields['package_id']); ?>" />
			<input type="hidden" name="mode" value="update">
		</form>
		</td>
	</tr>
</table>
<script>
<?php if($rs_limit->fields['package_type'] == 'free') {?>
disableprice('<?php echo $rs_limit->fields['package_type']; ?>');
<?php } ?>
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