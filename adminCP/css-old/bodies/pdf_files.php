<style>
/*
    Colorbox Core Style:
    The following CSS is consistent between example themes and should not be altered.
*/
#colorbox, #cboxOverlay, #cboxWrapper{position:absolute; top:0; left:0; z-index:9999; overflow:hidden;}
#cboxOverlay{position:fixed; width:100%; height:100%;}
#cboxMiddleLeft, #cboxBottomLeft{clear:left;}
#cboxContent{position:relative;}
#cboxLoadedContent{overflow:auto; -webkit-overflow-scrolling: touch;}
#cboxTitle{margin:0;}
#cboxLoadingOverlay, #cboxLoadingGraphic{position:absolute; top:0; left:0; width:100%; height:100%;}
#cboxPrevious, #cboxNext, #cboxClose, #cboxSlideshow{cursor:pointer;}
.cboxPhoto{float:left; margin:auto; border:0; display:block; max-width:none; -ms-interpolation-mode:bicubic;}
.cboxIframe{width:100%; height:100%; display:block; border:0;}
#colorbox, #cboxContent, #cboxLoadedContent{box-sizing:content-box; -moz-box-sizing:content-box; -webkit-box-sizing:content-box;}

/* 
    User Style:
    Change the following styles to modify the appearance of Colorbox.  They are
    ordered & tabbed in a way that represents the nesting of the generated HTML.
*/
#cboxOverlay{background:url(images/overlay.png) repeat 0 0;}
#colorbox{outline:0;}
    #cboxTopLeft{width:21px; height:21px; background:url(images/controls.png) no-repeat -101px 0;}
    #cboxTopRight{width:21px; height:21px; background:url(images/controls.png) no-repeat -130px 0;}
    #cboxBottomLeft{width:21px; height:21px; background:url(images/controls.png) no-repeat -101px -29px;}
    #cboxBottomRight{width:21px; height:21px; background:url(images/controls.png) no-repeat -130px -29px;}
    #cboxMiddleLeft{width:21px; background:url(images/controls.png) left top repeat-y;}
    #cboxMiddleRight{width:21px; background:url(images/controls.png) right top repeat-y;}
    #cboxTopCenter{height:21px; background:url(images/border.png) 0 0 repeat-x;}
    #cboxBottomCenter{height:21px; background:url(images/border.png) 0 -29px repeat-x;}
    #cboxContent{background:#fff; overflow:hidden;}
        .cboxIframe{background:#fff;}
        #cboxError{padding:50px; border:1px solid #ccc;}
        #cboxLoadedContent{margin-bottom:28px;}
        #cboxTitle{position:absolute; bottom:4px; left:0; text-align:center; width:100%; color:#949494;}
        #cboxCurrent{position:absolute; bottom:4px; left:58px; color:#949494;}
        #cboxLoadingOverlay{background:url(images/loading_background.png) no-repeat center center;}
        #cboxLoadingGraphic{background:url(images/loading.gif) no-repeat center center;}

        /* these elements are buttons, and may need to have additional styles reset to avoid unwanted base styles */
        #cboxPrevious, #cboxNext, #cboxSlideshow, #cboxClose {border:0; padding:0; margin:0; overflow:visible; width:auto; background:none; }
        
        /* avoid outlines on :active (mouseclick), but preserve outlines on :focus (tabbed navigating) */
        #cboxPrevious:active, #cboxNext:active, #cboxSlideshow:active, #cboxClose:active {outline:0;}

        #cboxSlideshow{position:absolute; bottom:4px; right:30px; color:#0092ef;}
        #cboxPrevious{position:absolute; bottom:0; left:0; background:url(images/controls.png) no-repeat -75px 0; width:25px; height:25px; text-indent:-9999px;}
        #cboxPrevious:hover{background-position:-75px -25px;}
        #cboxNext{position:absolute; bottom:0; left:27px; background:url(images/controls.png) no-repeat -50px 0; width:25px; height:25px; text-indent:-9999px;}
        #cboxNext:hover{background-position:-50px -25px;}
        #cboxClose{position:absolute; bottom:0; right:0; background:url(images/controls.png) no-repeat -25px 0; width:25px; height:25px; text-indent:-9999px;}
        #cboxClose:hover{background-position:-25px -25px;}

/*
  The following fixes a problem where IE7 and IE8 replace a PNG's alpha transparency with a black fill
  when an alpha filter (opacity change) is set on the element or ancestor element.  This style is not applied to or needed in IE9.
  See: http://jacklmoore.com/notes/ie-transparency-problems/
*/
.cboxIE #cboxTopLeft,
.cboxIE #cboxTopCenter,
.cboxIE #cboxTopRight,
.cboxIE #cboxBottomLeft,
.cboxIE #cboxBottomCenter,
.cboxIE #cboxBottomRight,
.cboxIE #cboxMiddleLeft,
.cboxIE #cboxMiddleRight {
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#00FFFFFF,endColorstr=#00FFFFFF);
}
</style>

<?php
//Query for the Property Name that will be dynamically populated 

$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
$rs = $db->Execute($sql);
$isrs = $rs->RecordCount();
	if($isrs == 0){
	echo 'No Admin account found!';
	exit;
	}

$maxRows = 40;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;


$qry_prop = "SELECT pr.id AS pid, pr.property_name 
             FROM ".$tblprefix."properties as pr  
             WHERE  pr.pm_type=0 
		      AND  pr.property_category<>24";
$rs_prop = $db->Execute($qry_prop);

$qry_prop_manager = "SELECT pm.*,pr.id AS pid, pr.property_name 
             FROM ".$tblprefix."property_manager as pm   
			 INNER JOIN ".$tblprefix."properties as pr ON   pr.pm_id= pm.id 
             WHERE pr.property_category<>24
			 GROUP BY pm.id"
			 ;
$rs_prop_manager = $db->Execute($qry_prop_manager);


$qry = "SELECT * FROM ".$tblprefix."pdf_files";
$rs = $db->Execute($qry);
$count_add =  $rs->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);
$qry_limit = "SELECT pdf.id, pdf.file_name,prop.property_name ,prop.id AS prop_id  
 			  FROM `".$tblprefix."pdf_files` as pdf 
			  LEFT JOIN tbl_properties as prop  
			  ON prop.id=pdf.`property_id` 
			   LIMIT $startRow,$maxRows";

$rs_pdf = $db->Execute($qry_limit);
$totalcountalpha =  $rs_pdf->RecordCount();
?>

<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Manage PDF
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">
	
    <tr>
        <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
 	<tr class="tabheading">
    	<td colspan="5" align="right">All PDF Documents : <?php echo $totalcountalpha ?></td>
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
 <div id="controls" class="add_subscriber" style="display:none;">
	<form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
		<table>
            <tr>
                <td class="txt1">Select PM</td>
				<td>
                <select name="property_manager" class="fields" id="property_manager" onchange="get_prop_pdf('property_id', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name_pdf.php"?>')">
                    <option value="">Izaberite vlasnika objekta</option>
                    <?php 
                        $rs_prop_manager->MoveFirst();
                        while(!$rs_prop_manager->EOF){
                        echo '<option value="'.$rs_prop_manager->fields['id'].'">'.$rs_prop_manager->fields['first_name'].' '.$rs_prop_manager->fields['last_name'].'</option>';
                        $rs_prop_manager->MoveNext();
                    }
                    ?>  
                </select>					
            </td>
            </tr>
			<tr>
                <td class="txt1">Property Name</td>
				<td>
                <div id="property_id">
				<select name="property_name" class="fields" id="property_name">
                    <option value="">--Select Object--</option>
                    <?php 
                        $rs_prop->MoveFirst();
                        while(!$rs_prop->EOF){
                        echo "<option value=".$rs_prop->fields['pid'].">".$rs_prop->fields['property_name'].'</option>';
                        $rs_prop->MoveNext();
                    }
                    ?>  
                </select>
				</div>					
            </td>
        </tr>                
        <tr>
                    
		  <td class="txt1">Pdf Upload</td>
		  <td><input type="file" name="userfile" id="userfile" class="fields" /></td>
		  </tr>
        <tr><td></td>
		<td></td></tr>
		<tr><td></td>
		<td>
        <input style="margin:5px; width:170px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Upload PDF" class="button" />
		<input type="hidden" name="act" value="pdf_files" />
		<input type="hidden" name="theValue" id="theValue" value="0" />
                <input type="hidden" name="id" value="<?php echo base64_encode($id); ?>" />
		<input type="hidden" name="request_page" value="pdf_upload" />
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
				<th width="10%">PDF File Name</th>
                <th width="10%">Property Name</th>				
				<th width="7%" style="text-align: center">Options</th>
		    </tr>
			<?php 
				if($totalcountalpha >0){
				if($pageNum==0)
				   {
				     $i=0;
				   }else{
				     $i = ($pageNum*$maxRows);
				   }
				    $rs_pdf->MoveFirst();
					while(!$rs_pdf->EOF){
			?>
					<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="middle"><?php echo ++$i; ?></td>
						 <td valign="middle">
                                                     
<a class='iframe' href="" onclick="javascript:resumepre('<?php echo MYSURL.'pdf_file/'.$rs_pdf->fields['file_name'];?>')" data-toggle="modal" data-target="#myModal"><?php
  
$info =pathinfo($rs_pdf->fields['file_name']); 
if($info['extension']=='pdf')
    echo '<img src="'.MYSURL.'graphics/pdf-red.png" width="16" height="20">&nbsp;';
else
     echo '<img src="'.MYSURL.'graphics/Word-icon.png" width="16" height="20">&nbsp;';
 echo $rs_pdf->fields['file_name']; ?></a>
						 </td>
					   <td valign="middle"><?php echo $rs_pdf->fields['property_name']; ?></td>
					   <td valign="middle" text align="center">
							<a href="admin.php?act=edit_pdf_files&amp;id=<?php echo base64_encode($rs_pdf->fields['id']);?>"><img src="<?php MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=pdf_files&amp;mode=delete&amp;id=<?php echo base64_encode($rs_pdf->fields['id']); ?>&amp;request_page=pdf_upload" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                       </td>
					</tr>
			<?php 
						$rs_pdf->MoveNext();
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
							</div>
							</div>	
							<!-- END: Pagination Code -->						
							</td>
					</tr>
			
			<?php
				}else{
			?>
				<tr>
					<td colspan="14" class="errmsg"> No Fix List Found</td>
				</tr>
			<?php
				}// end if($totalcount > 0)
                             
			?>
		</table>	</td>
  </tr>
 
</table>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Resume Preview</h4>
                </div>
                <div class="modal-body" id="modallink">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
<div id="get_rates_images">

</div>
    <script>
   
function resumepre(resumename){
   
    $('#modallink').html('<a class="docview" href="'+resumename+'">'+resumename+'</a>');
     $('a.docview').gdocsViewer();
}
    </script>
<?php //echo $where;?>
