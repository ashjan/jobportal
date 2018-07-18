<?php
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

    $maxRows = 50;

    if (empty($_GET['pageNum'])){ $pageNum=0;}else{if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}}
    if ($pageNum == '') $pageNum = 0;
    $startRow        = $pageNum * $maxRows;

	$qry_gateway = "SELECT
					   ".$tblprefix."omba_gateway.id,
					   ".$tblprefix."omba_gateway.server_name,
					   ".$tblprefix."omba_gateway.server_path,
					   ".$tblprefix."omba_gateway.user_agent,
					   ".$tblprefix."omba_gateway.sender,
					   ".$tblprefix."omba_gateway.transaction_response,
					   ".$tblprefix."omba_gateway.channel,
					   ".$tblprefix."omba_gateway.transaction_mode,
					   ".$tblprefix."omba_gateway.user_password,
					   ".$tblprefix."omba_gateway.user_id,
					   ".$tblprefix."omba_gateway.identification_transactionid,
					   ".$tblprefix."omba_gateway.account_bank,
					   ".$tblprefix."omba_gateway.account_authorization,
					   ".$tblprefix."omba_gateway.payment_code,
					   ".$tblprefix."omba_gateway.contact_ip,
					   ".$tblprefix."omba_gateway.name_company,
					   ".$tblprefix."omba_gateway.response_url
				    FROM
					   ".$tblprefix."omba_gateway 
					   ";
			
					
					

   $rs_gateway = $db->Execute($qry_gateway);

   $count_add  = $rs_gateway->RecordCount();
   $totalRows  = $count_add;
   $totalPages = ceil($totalRows/$maxRows);

   $qry_limit  = "SELECT
					   ".$tblprefix."omba_gateway.id,
					   ".$tblprefix."omba_gateway.server_name,
					   ".$tblprefix."omba_gateway.server_path,
					   ".$tblprefix."omba_gateway.user_agent,
					   ".$tblprefix."omba_gateway.sender,
					   ".$tblprefix."omba_gateway.transaction_response,
					   ".$tblprefix."omba_gateway.channel,
					   ".$tblprefix."omba_gateway.transaction_mode,
                                           ".$tblprefix."omba_gateway.account_bank,
					   ".$tblprefix."omba_gateway.user_password,
					   ".$tblprefix."omba_gateway.user_id,
					   ".$tblprefix."omba_gateway.identification_transactionid,
					   ".$tblprefix."omba_gateway.account_authorization,
					   ".$tblprefix."omba_gateway.payment_code,
					   ".$tblprefix."omba_gateway.contact_ip,
					   ".$tblprefix."omba_gateway.name_company,
					   ".$tblprefix."omba_gateway.response_url 
				    FROM
					   ".$tblprefix."omba_gateway 
					WHERE    
					   ".$tblprefix."omba_gateway.id  = 1
					LIMIT 1 ";
  
   $rs_limit        = $db->Execute($qry_limit);
   $totalcountalpha = $rs_limit->RecordCount();
?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    OMBA Payment Gateway
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">
    
    <tr>
    <td  colspan="2">
	<br/><br/><center>
	<h3>OMBA Payment-Gateway Configurations.</h3></center><br/><br/> </td>
    </tr>
  
    <tr>
    <td colspan="2" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']); } ?>
	</td>
   </tr>
   
    <tr>
    <td colspan="2">
	<form name="frm_omba_paymentgateway" id="frm_omba_paymentgateway" method="post">
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">       
	<?php while(!$rs_limit->EOF){  
					$server_name                  = $rs_limit->fields['server_name'];
					$server_path                  = $rs_limit->fields['server_path'];
					$user_agent                   = $rs_limit->fields['user_agent'];
					$sender                       = $rs_limit->fields['sender']; 
					$transaction_response         = $rs_limit->fields['transaction_response'];
					$channel                      = $rs_limit->fields['channel'];
					$transaction_mode             = $rs_limit->fields['transaction_mode'];
					$user_password                = $rs_limit->fields['user_password'];
					$user_id                      = $rs_limit->fields['user_id'];
					$identification_transactionid = $rs_limit->fields['identification_transactionid'];
					$account_bank                 = $rs_limit->fields['account_bank'];
					$account_authorization        = $rs_limit->fields['account_authorization'];
					$payment_code                 = $rs_limit->fields['payment_code'];
					$contact_ip                   = $rs_limit->fields['contact_ip'];
					$name_company                 = $rs_limit->fields['name_company'];
					$response_url                 = $rs_limit->fields['response_url'];
	?>
		<tr> 
            <td width="30%" class="tabheading">Server Name</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="server_name" id= "server_name" value="<?php echo $server_name; ?>"/>
            </td>
        </tr>
		
		<tr> 
            <td width="30%" class="tabheading">Server Path</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="server_path" id= "server_path" value="<?php echo $server_path; ?>"/>
            </td>
        </tr>
		
		
		<tr> 
            <td width="30%" class="tabheading">User Agent</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="user_agent" id= "user_agent" value="<?php echo $user_agent; ?>"/>
            </td>
        </tr>
		
		
		<tr> 
            <td width="30%" class="tabheading">Sender</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="sender" id= "sender" value="<?php echo $sender; ?>"/>
            </td>
        </tr>
		
	
		
		<tr> 
            <td width="30%" class="tabheading">Transaction Response</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="transaction_response" id= "transaction_response" value="<?php echo $transaction_response; ?>"/>
            </td>
        </tr>
		
		<tr> 
            <td width="30%" class="tabheading">Transaction Channel</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="channel" id= "channel" value="<?php echo $channel; ?>"/>
            </td>
        </tr>
		
		
		
		<tr> 
            <td width="30%" class="tabheading">Transaction Mode</td>
            <td width="70%" align="center">
<input style="width:460px;" maxlength="120" type="text" name="transaction_mode" id= "transaction_mode" value="<?php echo $transaction_mode; ?>"/>
            </td>
        </tr>
		
		<tr> 
            <td width="30%" class="tabheading">User Password</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="user_password" id= "user_password" value="<?php echo $user_password; ?>"/>
            </td>
        </tr>
		
		
		<tr> 
            <td width="30%" class="tabheading">User ID</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="user_id" id= "user_id" value="<?php echo $user_id; ?>"/>
            </td>
        </tr>
		
		
		<tr> 
            <td width="30%" class="tabheading">Identification Transaction ID</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="identification_transactionid" id= "identification_transactionid" value="<?php echo $identification_transactionid; ?>"/>
            </td>
        </tr>
		
		
		<tr> 
            <td width="30%" class="tabheading">Account Bank</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="account_bank" id= "account_bank" value="<?php echo $account_bank; ?>"/>
            </td>
        </tr>
		
		
		<tr> 
            <td width="30%" class="tabheading">Account Authorization</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="account_authorization" id= "account_authorization" value="<?php echo $account_authorization; ?>"/>
            </td>
        </tr>
		
		<tr> 
            <td width="30%" class="tabheading">Payment Code</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="payment_code" id= "payment_code" value="<?php echo $payment_code; ?>"/>
            </td>
        </tr>
		
		
		
		<tr> 
            <td width="30%" class="tabheading">Contact IP</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="contact_ip" id= "contact_ip" value="<?php echo $contact_ip; ?>"/>
            </td>
        </tr>
		
		
		<tr> 
            <td width="30%" class="tabheading">Name Company</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="name_company" id= "name_company" value="<?php echo $name_company; ?>"/>
            </td>
        </tr>
		
		
		<tr> 
            <td width="30%" class="tabheading">Response URL</td>
            <td width="70%" align="center">
		     <input style="width:460px;" maxlength="120" type="text" name="response_url" id= "response_url" value="<?php echo $response_url; ?>"/>
            </td>
        </tr>
		
		
		<tr> 
            <td width="30%" class="tabheading"></td>
            <td width="70%" align="center">
		     <input  type="submit" value="Save Changes"  class="button" />
            </td>
        </tr>
	    <?php 
	          $rs_limit->MoveNext();
	      } 
	    ?>
	</table>
	      <input type="hidden" name="act"          value="omba_payment" />
          <input type="hidden" name="request_page" value="omba_payment" />
          <input type="hidden" name="mode"         value="edit"         />
	</form>
	</td>
    </tr>
</table>
</div></div>