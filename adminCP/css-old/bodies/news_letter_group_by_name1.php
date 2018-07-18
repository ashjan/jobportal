<script>
function newsform()
{
	document.news_subscribe_form.submit();
}
</script>
<?php
	
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_faq = "SELECT * FROM ".$tblprefix."newsletter" ;
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT * FROM ".$tblprefix."newsletter LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

?>

<!--<form action="admin.php" enctype="multipart/form-data" method="post" name="delete_form" >-->
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Newsletter </td>
  	</tr>
	<tr class="tabheading" align="right">
		<td colspan="10">
			<a href="admin.php?act=addletter"><img src="<?php MYSURL?>graphics/add.png" border="0" title="Add News Letter" /></a>		</td>
	</tr>
  <tr><td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td></tr>
  
 
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			
			<tr>
                <td  valign="top">
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
               
                <tr class="tabheading">
                    <td width="3%">Sr#</td>
                    <td width="50%">Group Name</td>
                    <td>Subscriber Emails</td>
                </tr>
                
          <?php    
             $qry_news = "SELECT *	FROM tbl_newsletter_groups";
				    $rs_news = $db->Execute($qry_news);
				?>
               
               
                    <?php if(isset($_POST) && !empty($_POST))
					{
						$send_newsletter = $_POST['send_newsletter'];
						
						$qry_newsletter = "SELECT sub_email FROM tbl_newletter_subscriber  where id IN ($send_newsletter)";
				        $res_newsletter = $db->Execute($qry_newsletter);
					    while(!$res_newsletter->EOF){
						
					?>
                     <tr bgcolor="#E7DAE7">
                         <td> <?php echo $rs_news->fields['id'];?>  </td>
                        <td><?php echo $rs_news->fields['group_name_des'];?>  </td>
                        <td><?php echo $res_newsletter->fields['sub_email'];?> </td>
                     </tr> 
					<?php
					$res_newsletter->MoveNext();
					 }
					}
					?>
					 
                   
                </table>
                </td>
                <td valign="top">
                <form name="news_subscribe_form" id="news_subscribe_form" action="" method="post" >
				<?php		
					$qry_news = "SELECT *	FROM tbl_newsletter_groups";
				    $rs_news = $db->Execute($qry_news);
					 while(!$rs_news->EOF){
				?>
                    <input type="checkbox" value="<?php echo $rs_news->fields['subscriber_list'];?> " name="send_newsletter" id="send_newsletter" onclick="return newsform();"  /><?php echo html_entity_decode($rs_news->fields['group_name_des']); ?><br/>
                <?php  $rs_news->MoveNext();
				}
				?>	
                </form>
                </td>
            </tr>
		</table>	
    </td>
  </tr>
</table>
<?php //echo $where;?>
<!--</form>-->