<?php
//$newsletter_qry = "SELECT * FROM ".$tblprefix."newsletter";
	//			$rs_newsletter = $db->Execute($newsletter_qry);


if(isset($_POST['send_mail'])){
	if($_POST['sendreport']){
		$sendreport = "yes";
	}else{
		$sendreport = "no";
	}
	$_SESSION['field'] = $_POST;
	if($_SESSION['security_code'] == $_POST['code']){
			$_SESSION['justsentemails'] = array();
			$_SESSION['justsentemails'] = "";
			$_SESSION['recipients'] = array();
			$_SESSION['recipients'] = "";
			$reportrecipients = array();
			$reportrecipients = "";
			$_SESSION['showreport'] = "yes";
			$_SESSION['newemails'] = 0;
			$_SESSION['sentemails'] = 0;
			$_SESSION['invalidemails'] = 0;
			$_SESSION['email2limit'] = 1;
			
			if(strpos($_SESSION['field']['recipients'], ",")===false){
				//Single email
				///echo "Hello control 222222222222222e";exit;
			  $_SESSION['recipients'][] = $_SESSION['field']['recipients']; 
			}else{
			//////echo "Hello control 3333333333is her888e";exit;
				$_SESSION['recipients'] = explode(",", $_SESSION['field']['recipients']);
			}
			$totalemails = count($_SESSION['recipients'])-1;
			
			$_SESSION['field']['newsletter'] = $_REQUEST['letterid'];
			
			$newsletter_qry = "SELECT * FROM ".$tblprefix."newsletter where id = '".$_SESSION['field']['newsletter']."'";
			$rs_newsletter = $db->Execute($newsletter_qry);

			$body = $rs_newsletter->fields['letter_description'];
	?>
			
			<div id="resultscompleted" style="display:block; margin: 0 auto; overflow:hidden; border:1px solid #CCCCCC; color:#CC0000; font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal; padding:5px; width:600px; margin-bottom:2px; background-color:#E6E6E6"></div>
			<div id="resultsprintpanel" style="display:block; margin: 0 auto; border:1px solid #E2E2E2; color:#333333; font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal; padding:5px; width:600px; height:auto;">
				<h1>Process Started: (<small>sit back and relax</small>)</h1>
			</div>
			<script src="js/display.js"></script>
			<script src="js/request.js"></script>
			<script language="javascript">
			function update(result, ui_id){
				var div = $(ui_id);
				if (result.status==Http.Status.OK)
				div.innerHTML += result.responseText;
				else
				div.innerHTML = "An error occurred (" + result.status.toString() + ").";
			}
			function update_report(result, ui_id){
				var div = $(ui_id);
				if (result.status==Http.Status.OK)
				div.innerHTML += "Report Sent<br><a href='javascript:history.go(-1)'>Click here to go back</a>";
				else
				div.innerHTML = "Reporting error occurred (" + result.status.toString() + ").";
			}
			function get_ajaxnewsletter_response(cache_method, ui_id, emailid){
				Http.get({
				url: "newsletter_requested.php?emailid="+emailid,
				callback: update,
				cache: cache_method
				}, [ui_id]);
			}
			function get_ajaxreport_response(cache_method, ui_id, sendreport){
				Http.get({
				url: "sendreport.php?sendreport="+sendreport,
				callback: update_report,
				cache: cache_method
				}, [ui_id]);
			}
			var timeperiod = <?php echo $_SESSION['field']['timeperiod']?>;
			var sendreport_request = '<?php echo $sendreport?>';
			var limitloop = 0;
			var limitloop_printer = 1;
			var totalemails_endcheck = <?php echo $totalemails?>;
			var endlimit = <?php echo $totalemails*$_SESSION['field']['timeperiod'];?>;
				document.getElementById("resultscompleted").innerHTML = "Total Processing emails: (<?php echo $totalemails+1;?>)";
				document.getElementById("resultscompleted").innerHTML += "<br><div style='display:block; width:100px; overflow:hidden; float:left;'>Processing email #: (</div><div id='emailprocessprinter' style='float:left; display:block; overflow:hidden; width:20px; margin-left:8px;'></div>)";
				function openit(){
					if(limitloop > totalemails_endcheck){
						if(limitloop < totalemails_endcheck){
							document.getElementById("resultscompleted").innerHTML += "<h2>Free users are only allowed to send 10 emails at a time</h2>";
						}
						document.getElementById("resultscompleted").innerHTML += "<h2>Newsletter process completed....</h2>";
						clearTimeout(t);
						if(sendreport_request=="yes"){
							document.getElementById("resultscompleted").innerHTML += "<h2>Report is OFF</h2><br><a href='admin.php?act=managenewsletter'>Click here to go back</a>";
						}else{
							document.getElementById("resultscompleted").innerHTML += "<br><a href='admin.php?act=managenewsletter'>Click here to go back</a>";
						}
						return;
					}else{
						document.getElementById("emailprocessprinter").innerHTML = limitloop_printer;
						get_ajaxnewsletter_response(Http.Cache.GetNoCache, 'resultsprintpanel', limitloop);
					}
				limitloop_printer++;
				limitloop++;
				t = setTimeout("openit()",timeperiod);
				return false;
				}
				openit();
				
				
				
				
			</script>
			<?php
			exit;
		
	}else{
		$msg=base64_encode("Invalid security code");
		?>
		<script language="javascript">window.location="admin.php?act=managenewsletter&msg=<?php echo $msg?>"</script>
		<?php
		exit;
	}
}
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
    
	
	$group_selected=$_GET['selct'];
	
	$maxRows = 50;
	if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
	if ($pageNum == '') $pageNum=0;
	$startRow = $pageNum * $maxRows;

 if($group_selected==1){
    $group_name=$_POST['group'];
	if($group_name=='all_subscribers'){
		$qry_faq = "SELECT * FROM ".$tblprefix."newletter_subscriber WHERE status = '1'" ;
		$rs_faq = $db->Execute($qry_faq);
		$count_add =  $rs_faq->RecordCount();
		$totalRows = $count_add;
		$totalPages = ceil($totalRows/$maxRows);
		
		$qry_limit = "SELECT * FROM ".$tblprefix."newletter_subscriber WHERE status = '1' LIMIT $startRow,$maxRows"; 
		$rs_limit = $db->Execute($qry_limit);
		$totalcountalpha =  $rs_limit->RecordCount();
		$i=1 ;
		
		$qrysub = mysql_query("SELECT * FROM ".$tblprefix."newletter_subscriber WHERE status = '1' ");
		while($res_sub = mysql_fetch_array($qrysub)){
				 if($res_sub['sub_email'] != ""){
					 if($i == 1){
						$to .= $res_sub['sub_email'] ;
					 }else{
						$to .= ','.$res_sub['sub_email'] ;
					 }
			   }
			$i++;
		}
	
	}elseif($group_name=='existing_pms'){
		$qry_faq = "SELECT email_address FROM ".$tblprefix."property_manager WHERE pm_status=1 ORDER BY first_name ASC" ;
		$rs_faq = $db->Execute($qry_faq);
		$count_add =  $rs_faq->RecordCount();
		$totalRows = $count_add;
		$totalPages = ceil($totalRows/$maxRows);
		$qry_limit = "SELECT email_address FROM ".$tblprefix."property_manager WHERE pm_status=1 ORDER BY first_name ASC LIMIT $startRow,$maxRows"; 
		$rs_limit = $db->Execute($qry_limit);
		$totalcountalpha =  $rs_limit->RecordCount();
		$i=1 ;
		$qrysub=mysql_query("SELECT email_address FROM ".$tblprefix."property_manager WHERE pm_status=1 ORDER BY first_name ASC");
		while($res_sub=mysql_fetch_array($qrysub)){
				 if($res_sub['email_address'] != ""){
					 if($i == 1){
						$to .= $res_sub['email_address'];
					 }else{
						$to .= ','.$res_sub['email_address'] ;
					 }
			   }
			$i++;
		}
	
	}elseif($group_name=='top_pms'){
 		$qry_faq = "SELECT pm_email FROM ".$tblprefix."top_offer_program WHERE offer_status = '1' AND emailsnt_flag = 1 LIMIT 0 , 10 ";  
		$rs_faq = $db->Execute($qry_faq);
		$count_add =  $rs_faq->RecordCount();
		$totalRows = $count_add;
		$totalPages = ceil($totalRows/$maxRows);
		
		$qry_limit = "SELECT pm_email FROM ".$tblprefix."top_offer_program WHERE offer_status = '1' AND emailsnt_flag = 1 LIMIT 0 , 10 ";   
		$rs_limit = $db->Execute($qry_limit);
		$totalcountalpha =  $rs_limit->RecordCount();
		$i=1 ;
		$qrysub = mysql_query("SELECT pm_email FROM ".$tblprefix."top_offer_program WHERE offer_status = '1' AND emailsnt_flag = 1 LIMIT 0 , 10 ");
		while($res_sub = mysql_fetch_array($qrysub)){
				 if($res_sub['pm_email'] != ""){
					 if($i == 1){
						$to .= $res_sub['pm_email'] ;
					 }else{
						$to .= ','.$res_sub['pm_email'] ;
					 }
			   }
			$i++;
		}
	
	}elseif($group_name=='all_customers'){
		$qry_faq = "SELECT customer_email FROM ".$tblprefix."customer" ; 
		$rs_faq = $db->Execute($qry_faq);
		$count_add =  $rs_faq->RecordCount();
		$totalRows = $count_add;
		$totalPages = ceil($totalRows/$maxRows);
		
	$qry_limit = "SELECT customer_email FROM ".$tblprefix."customer LIMIT $startRow,$maxRows"; 
		$rs_limit = $db->Execute($qry_limit);
		$totalcountalpha =  $rs_limit->RecordCount();
		$i=1 ;
		$qrysub = mysql_query("SELECT customer_email FROM ".$tblprefix."customer");
		while($res_sub = mysql_fetch_array($qrysub)){
				 if($res_sub['customer_email'] != ""){
					 if($i == 1){
						$to .= $res_sub['customer_email'] ;
					 }else{
						$to .= ','.$res_sub['customer_email'] ;
					 }
			   }
			$i++;
		}
	
	
	}else{
	 	$qry_faq = "SELECT * FROM ".$tblprefix."newletter_subscriber WHERE status = '1'" ;
		$rs_faq = $db->Execute($qry_faq);
		$count_add =  $rs_faq->RecordCount();
		$totalRows = $count_add;
		$totalPages = ceil($totalRows/$maxRows);
		
		$qry_limit = "SELECT * FROM ".$tblprefix."newletter_subscriber WHERE status = '1' LIMIT $startRow,$maxRows"; 
		$rs_limit = $db->Execute($qry_limit);
		$totalcountalpha =  $rs_limit->RecordCount();
		$i=1 ;
		$qrysub = mysql_query("SELECT * FROM ".$tblprefix."newletter_subscriber WHERE status = '1' ");
		while($res_sub = mysql_fetch_array($qrysub)){
				 if($res_sub['sub_email'] != ""){
					 if($i == 1){
						$to .= $res_sub['sub_email'] ;
					 }else{
						$to .= ','.$res_sub['sub_email'] ;
					 }
			   }
			$i++;
		}
	}	
}


if(isset($_POST['send'])){
	
	
	?>
      <script language="javascript">
	    /* window.location("<?php //echo 'admin.php?act=managenewsletter&amp;selct=1&amp;id='.$_POST["group"];?>");*/
		location.href="<?php echo 'http://sunnymontenegro.com/adminCP/admin.php?act=managenewsletter&selct=1&id='.$_POST['group'];?>";

	  </script>
    <?php 
	//header("location:admin.php?act=managenewsletter&amp;selct=1&amp;id=".$_POST['group']);
	//exit;
}


?>


<script language="javascript">
	var test = new Array();

	function passfunc(id){
			makeRequest('getletter.php?lid='+id, 'get_letter');
	}
	
</script>
<?php  
    
	 if(empty($group_selected)){
?>
<!--<form name="NewsLetterFrm" method="post" enctype="multipart/form-data" action="admin.php?act=managenewsletter&amp;selct=1">-->
<form name="NewsLetterFrm" method="post" enctype="multipart/form-data" action="" >
<table align="center" width="100%" cellspacing="0" cellpadding="5" border="0" class="txt">	
    <tbody><tr>
     <?php 
		  $qry_news = "SELECT * FROM ".$tblprefix."newsletter_groups";
		  $res_news = $db->Execute($qry_news);
	    
	 ?>
    <td align="left" width="167">Select Group :*</td>
    <td> 
	 <select class="smalldropfields" id="group" name="group">
        <option value="">Select Group</option>
        <?php
		while(!$res_news->EOF){
		?>
        <option value="<?php echo $res_news->fields['id'];?>"><?php echo html_entity_decode($res_news->fields['group_name_des']);?></option>
    	<?php
		$res_news->MoveNext();
		}
		?>
    </select>
	</td>
  </tr>
  	<tr>
		<td></td>
		<td>
			<input type="hidden" value="managenewsletter" name="act">
			<input type="submit" class="button" value=" Select Group " name="send">
		</td>
		</tr>
				</tbody>
</table>
</form>	
<?php }elseif($group_selected==1){ ?>
<form action="admin.php?act=managenewsletter" enctype="multipart/form-data" method="post" name="NewsLetterFrm" onsubmit="return validatenewsletteremail()">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
	<tr>
    	<td id="heading">Manage Newsletter Subscribe Email </td>
  	</tr>
  <tr><td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td></tr>
  <tr class="tabheading">
    <td colspan="8" align="right"></td>
  </tr>
  <tr>
  <tr>
    <td>
		<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
			<?php
			//	if($group_name=='all_subscribers'){
				$newsletter_qry = "SELECT * FROM ".$tblprefix."newsletter ORDER BY id ASC ";
				$rs_newsletter = $db->Execute($newsletter_qry);
			//	}elseif($group_name=='existing_pms'){
			//	$newsletter_qry = "SELECT email_address FROM ".$tblprefix."tbl_property_manager WHERE pm_status=1 ORDER BY first_name ASC";
			//	$rs_newsletter = $db->Execute($newsletter_qry);
			//	}elseif($group_name=='top_pms'){
				
			//	}elseif($group_name=='all_customers'){
				
		//		}else{
		//		$newsletter_qry = "SELECT * FROM ".$tblprefix."newsletter ORDER BY id ASC ";
		//		$rs_newsletter = $db->Execute($newsletter_qry);
		//		}
			?>
			  <tr>
    <td width="167" align="left">Select Newsletter :*</td>
    <td width="1019"><select name="news_letter" id="news_letter" class="smalldropfields" onchange="get_val(this.value);">
					 <option value="">Select Letter</option>
      				<?php while(!$rs_newsletter->EOF){ ?>
     <option value="<?php echo $rs_newsletter->fields['id']; ?>"  ><?php echo $rs_newsletter->fields['letter_name']; ?></option>
      				<?php $rs_newsletter->MoveNext();
			 		}//end while
					?>
    </select></td>
  </tr>
  <tr>
    <td align="left">Subject: *</td>
    <td><input type="text" name="subject" id="subject" class="fields"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><span style="display:block; float:left; margin-left:140px;">
    
    <?php 
	
	  	  //$qry_news = "SELECT a.id , b.sub_email FROM ".$tblprefix."newsletter_groups as a, ".$tblprefix."newletter_subscriber as b where b.id IN (a.subscriber_list)"; 
		  
		/*$qry_news = "SELECT a.id, b.sub_email
		FROM newsletter_groups
INNER JOIN newletter_subscriber
ON a.id = renewals.memberid";
		  
		echo "<pre>";
		print_r($res = mysql_query($qry_news)); 
		echo "</pre>";*/
		$qry_news = "SELECT subscriber_list FROM ".$tblprefix."newsletter_groups where id=".$_REQUEST['id'] ;
		$group_news = $db->Execute($qry_news);
		$subscriber_list = $group_news->fields['subscriber_list'];
		
		$qry_group = "SELECT * FROM ".$tblprefix."newletter_subscriber where id IN ($subscriber_list)";
		$group_new = $db->Execute($qry_group);
		$totalsubscribers =  $group_new->RecordCount();
		$sub_emails_arr= array();
		 
		 while(!$group_new->EOF){ 
     		$sub_emails_arr[] = $group_new->fields['sub_email'] ; 
      		$group_new->MoveNext();
		}//end while
			
				
	?>
    
    <textarea name="recipients" id="recipients" class="bigfield"><?php echo implode(',',$sub_emails_arr); ?> </textarea>
      <!--<textarea name="recipients" id="recipients" class="bigfield"><?php //echo $to; ?> </textarea>-->
    </span></td>
  </tr>
  <tr>
    <td align="left">Set Time Period:</td>
    <td>
	<select name="timeperiod">
      <option value="5000">5 Sec</option>
      <option value="10000" selected="selected">10 Sec</option>
      <option value="15000">15 Sec</option>
      <option value="20000">20 Sec</option>
      <option value="25000">25 Sec</option>
      <option value="30000">30 Sec</option>
      <option value="35000">35 Sec</option>
      <option value="40000">40 Sec</option>
      <option value="45000">45 Sec</option>
      <option value="50000">50 Sec</option>
      <option value="55000">55 Sec</option>
      <option value="60000">1 Min</option>
      <option value="90000">1.5 Min</option>
      <option value="120000">2 Min</option>
    </select></td>
  </tr>
  <tr>
    <td align="left">Security Code:</td>
    <td><img src="<?php echo MYSURL?>captchacode/CaptchaSecurityImages.php?width=150&height=30&character=8" style="border: 1px dotted #808080" /></td>
  </tr>
  <tr>
    <td align="left">Verify code:</td>
    <td><input name="code" type="text" class="smallfields" id="code" value=""></td>
  </tr>
  <tr>
    <td></td>
	<td><input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="send_mail" id="send_mail" value="Send Email" class="button" />
		<input type="hidden" name="letterid" id="letterid" value="" />
		</td>
  </tr>
		</table>	</td>
  </tr>
</table>
<?php //echo $where;?>
</form>
<?php } ?>

<script language="javascript">
	function get_val(id){
	
		document.getElementById("letterid").value = id;
	
	}		

</script>