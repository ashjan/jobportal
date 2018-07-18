
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

$newsid = base64_decode($_GET['newsid']);

$query_newsletter = "SELECT * FROM ".$tblprefix."email_conf WHERE id = '".$newsid ."' "; 
$rs_newsletter = $db->Execute($query_newsletter);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
  	<tr><td id="heading">Edit Email</td></tr>
  	<tr>
		<td>
	<form name="addnewsfrm" action="admin.php?act=manageletter" method="post" onsubmit="return validate_editnewsletter()">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			 	<tr>
					<td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>				</td>
				</tr>
			 	<tr>
			   		<td>&nbsp;</td>
			   		<td colspan="2" class="required_txt">* Required Fields</td>
	      		</tr>
				
				<tr>
					<td class="fieldheading">Subject :</td>
					<td><input name="newsletter_name" id="newsletter_name" type="text" class="fields" value="<?php echo stripslashes($rs_newsletter->fields['subject'])?>" /> * 
					</td>
				</tr>
				
				<tr>
					<td>Message Body:</td>
					<td>
						<textarea id="description" name="description" rows="25" cols="83">
							<?php echo stripslashes($rs_newsletter->fields['email_body'])?>
						</textarea>				
					</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" name="updateletterSbt" id="updateletterSbt" value="Update Template  " class="button"/>
						<input type="hidden" name="act" value="manageemail" />
						<input type="hidden" name="newsid" value="<?php echo $rs_newsletter->fields['id'];?>" />
						<input type="hidden" name="mode" value="send" />
						<input type="hidden" name="request_page" value="email_management" />			 
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
</table>

