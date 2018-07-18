<?php
//var_dump($this->session->userdata('user_data')['usr_id']); exit;
 ?>
<?php include("common_pages/internal_header.php");?>
 <script>
$(function() {
$( "#activation_date" ).datepicker({ dateFormat: 'yy-mm-dd' }).val();
});
</script>

<script language="JavaScript">
	function generateCC(){
		var cc_number = new Array(16);
		var cc_len = 16;
		var start = 0;
		var rand_number = Math.random();

		switch(document.perform.creditCardType.value)
        {
			case "Visa":
				cc_number[start++] = 4;
				break;
			case "Discover":
				cc_number[start++] = 6;
				cc_number[start++] = 0;
				cc_number[start++] = 1;
				cc_number[start++] = 1;
				break;
			case "MasterCard":
				cc_number[start++] = 5;
				cc_number[start++] = Math.floor(Math.random() * 5) + 1;
				break;
			case "Amex":
				cc_number[start++] = 3;
				cc_number[start++] = Math.round(Math.random()) ? 7 : 4 ;
				cc_len = 15;
				break;
        }

        for (var i = start; i < (cc_len - 1); i++) {
			cc_number[i] = Math.floor(Math.random() * 10);
        }

		var sum = 0;
		for (var j = 0; j < (cc_len - 1); j++) {
			var digit = cc_number[j];
			if ((j & 1) == (cc_len & 1)) digit *= 2;
			if (digit > 9) digit -= 9;
			sum += digit;
		}

		var check_digit = new Array(0, 9, 8, 7, 6, 5, 4, 3, 2, 1);
		cc_number[cc_len - 1] = check_digit[sum % 10];

		document.perform.creditCardNumber.value = "";
		for (var k = 0; k < cc_len; k++) {
			document.perform.creditCardNumber.value += cc_number[k];
		}
	}
</script>

		<div id="background">
        
        <?php 
        if($this->session->userdata['user_data']['u_type'] == 3)
        {
            include("common_pages/left_pannel_usr.php");
        }
        else 
        {
            ?> 
            
                    
                    <?php
            include("common_pages/left_pannel.php");
        }
        ?>
        
	<?php ///////////////////////////// PAYPAL CHECKOUT PROCESSING /////////////////////////////// ?>
    
    <?php
	
if(isset($_POST['submit'])){
	$errors = 0;
	
	
	
	$creditCardType 	= $_POST['creditCardType'];
	$creditCardNumber	= $_POST['creditCardNumber'];
	$cvv2Number			= $_POST['cvv2Number'];
	$expDateMonth 		= $_POST['expDateMonth'];
	$activation_date 	= $_POST['activation_date'];


	if($creditCardNumber == ''){
		$errors = $errors+1;
		echo '<span class="error_string">Please Enter Credit Card Number.</span><br />';
	}
	
	if($cvv2Number == ''){
		$errors = $errors+1;
		echo '<span class="error_string">Please Enter Credit Card Verification Number.</span><br />';
	}
	
	if($activation_date == ''){
		$activation_date = date('Y-m-d');
		}
	
	
	
	
	if($errors == 0){
		
	require_once("paypal_pro.inc.php");
            
			$company_info->first_name;
			$firstName =urlencode( $company_info->first_name);
            $lastName =urlencode( $company_info->last_name);
            $creditCardType =urlencode( $_POST['creditCardType']);
            $creditCardNumber = urlencode($_POST['creditCardNumber']);
            $expDateMonth =urlencode( $_POST['expDateMonth']);
            $padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
            $expDateYear =urlencode( $_POST['expDateYear']);
            $cvv2Number = urlencode($_POST['cvv2Number']);
            $address1 = urlencode($company_info->address);
            //$address2 = urlencode($_POST['address2']);
            $city = urlencode($company_info->city);
            $state =urlencode( $company_info->state);
            //$zip = urlencode($company_info->first_name);
            $amount = urlencode($package_detail->package_price);
            $currencyCode="USD";
            $paymentAction = urlencode("Sale");
            //if($_POST['recurring'] == 1)
            if(false) // For Recurring
            {
                $profileStartDate = urlencode(date('Y-m-d h:i:s'));
                $billingPeriod = urlencode($_POST['billingPeriod']);// or "Day", "Week", "SemiMonth", "Year"
                $billingFreq = urlencode($_POST['billingFreq']);// combination of this and billingPeriod must be at most a year
                $initAmt = $amount;
                $failedInitAmtAction = urlencode("ContinueOnFailure");
                $desc = urlencode("Recurring $".$amount);
                $autoBillAmt = urlencode("AddToNextBilling");
                $profileReference = urlencode("Anonymous");
                $methodToCall = 'CreateRecurringPaymentsProfile';
                $nvpRecurring ='&BILLINGPERIOD='.$billingPeriod.'&BILLINGFREQUENCY='.$billingFreq.'&PROFILESTARTDATE='.$profileStartDate.'&INITAMT='.$initAmt.'&FAILEDINITAMTACTION='.$failedInitAmtAction.'&DESC='.$desc.'&AUTOBILLAMT='.$autoBillAmt.'&PROFILEREFERENCE='.$profileReference;
            }
            else
            {
                $nvpRecurring = '';
                $methodToCall = 'doDirectPayment';
            }
            
            
            
            $nvpstr='&PAYMENTACTION='.$paymentAction.'&AMT='.$amount.'&CREDITCARDTYPE='.$creditCardType.'&ACCT='.$creditCardNumber.'&EXPDATE='.         $padDateMonth.$expDateYear.'&CVV2='.$cvv2Number.'&FIRSTNAME='.$firstName.'&LASTNAME='.$lastName.'&STREET='.$address1.'&CITY='.$city.'&STATE='.$state.'&ZIP=44000&COUNTRYCODE=US&CURRENCYCODE='.$currencyCode.$nvpRecurring;
			//var_dump($nvpstr); exit;
            
            
            $paypalPro = new paypal_pro('sdk-three_api1.sdk.com', 'QFZCWN5HZM8VBG7Q', 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI', '192.168.115.22', '3128', TRUE, FALSE );
            $resArray = $paypalPro->hash_call($methodToCall,$nvpstr);
			//var_dump($resArray); exit;
            $ack = strtoupper($resArray["ACK"]);
			
			 if($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING")
            {
             	if($package_detail->package_currency == 1){$p_price = '$';} elseif($package_detail->package_currency == 2) {$p_price = 'Rs';} 
				$p_price 		.= $package_detail->package_price;
				if($p_price == ''){
					$p_price	=	'FREE';
					}
				if($package_detail->package_type == 'daily'){
					$expiry_date	 =	date('Y-m-d', strtotime($activation_date."+1 day"));
					}
				elseif($package_detail->package_type == 'weekly'){
					$expiry_date	 =	date('Y-m-d', strtotime($activation_date."+1 week"));
					}
				elseif($package_detail->package_type == 'monthly'){
					$expiry_date	 =	date('Y-m-d', strtotime($activation_date."+1 month"));
					}
				elseif($package_detail->package_type == 'annually'){
					$expiry_date	 =	date('Y-m-d', strtotime($activation_date."+1 year"));
					}			
				$dataArray = array(							
						'package_id'     	=>  $package_detail->package_id,
						'company_id'     	=>  $company_info->company_id,
						'emp_id'     		=>  $company_info->emp_id,
						'amount'     		=>  $p_price,
						'subscription_date' =>  date('Y-m-d'),
						'transaction_id' 	=>	$resArray['TRANSACTIONID'],
						'status'     		=>  0,
						'payment_status'	=>  1,
						'expiry_date'		=>	$expiry_date,
						'activation_date'	=>	$activation_date,
					);
				   //var_dump($dataArray); exit;   
				 $this->m_common->insert_data('tbl_subscribed_packages',$dataArray);
				 
				 $subscribed_packageid		=	$this->m_common->getmaximumsubscribtionid();
				 $_SESSION['message']	=	"success";
					
					
					// email forwarded to admin
					// get admin email template
					$this->load->library('email');
					$config['protocol'] = 'sendmail';
					$config['mailpath'] = '/usr/sbin/sendmail';
					$config['charset'] = 'iso-8859-1';
					$config['mailtype'] = 'html';
					
					$this->email->initialize($config);
					
					
					$admin_record		=	$this->m_common->view_specific('id',1,'tbl_admin');
					$email_template_for_admin		=	$this->m_common->view_specific('id','14','tbl_email_conf');
					
					//email text initializing
					$fromemail		=	$company_info->email_address;
					$toEmail		=	$admin_record->notifyemail;
					$subject		=	ucwords($email_template_for_admin->subject);
					$message		=	$email_template_for_admin->email_body;
					
					// email forwarded to admin
					
					
					$this->email->from($fromemail);
					$this->email->to($toEmail);
					$this->email->subject($subject);
					$this->email->message($message);
					
					@$this->email->send();
					//echo $this->email->print_debugger(); exit;
					
					
					
					// sending mail to client
				 
				 	// get admin data
					
					//get email templates
					$email_template_for_client		=	$this->m_common->view_specific('id','11','tbl_email_conf');
					
					//email text initializing
					$fromemail		=	$admin_record->notifyemail;
					$toEmail		=	$company_info->email_address;
					$subject		=	ucwords($email_template_for_client->subject);
					$message		=	$email_template_for_client->email_body;
					
					// email forwarded to the clinet
					
					
					$this->email->from($fromemail);
					$this->email->to($toEmail);
					$this->email->subject($subject);
					$this->email->message($message);
					
					@$this->email->send();
					$name		=	$company_info->first_name." ".$company_info->last_name;	
					$message	=	str_replace("%displayname%",$name , $message);
					$message	=	str_replace("%package%",$package_detail->package_name , $message);
					//$message	=	str_replace("%package_type%",$package_detail->package_type , $message);
					$message	=	str_replace("%package_price%",$p_price , $message);
					$message	=	str_replace("%activation_date%",$activation_date , $message);
					$message	=	str_replace("%expiry_date%",$expiry_date , $message);
					
					// send notification to user in the site account
					
					$dataArray = array(							
						'sender_id'     	=>  0,
						'receiver_id'     	=>  $company_info->emp_id,
						'message'     		=>  $message,
						'sp_id'				=>  $subscribed_packageid->maximum,
						'notification_type' =>  'confirmation',
						'issue_date' 		=>	date('Y-m-d'),
						'status'     		=>  0
						
						
				   );   
				 $this->m_common->insert_data('tbl_notification',$dataArray);
					
				 header( "Location: ".base_url()."jobs/subscribedpackage" );    
				
                
            }
            else
            {
			 echo '<tr>';
                    echo '<td colspan="2" style="font-weight:bold;color:red;" align="center">Error! Please make sure that you provide all information correctly.</td>';
                echo '</tr>';	
				
				
				
		
            }
	}
	else{
		echo $errors;
		}
} //  end of if isset post submit
			
	 ?>
     
     <?php //////////////////////////// END PAYPAL PRO CHECKOUT /////////////////// //////////////// ?>
     
    <div class="right_panel">
    		
    		<h2> Package Detail </h2>
            <div class="text">Title:   </div>
            <div class="field"> <strong><?php echo $package_detail->package_name; ?> </strong> </div> 
            <div class="clearfix"></div>
            
            <div class="text">Description:   </div>
            <div class="field"> <strong><?php echo $package_detail->package_description; ?> </strong> </div> 
            <div class="clearfix"></div>
            
            <div class="text">Detail:   </div>
            <div class="field"> <strong><?php echo $package_detail->package_detail; ?> </strong> </div> 
            <div class="clearfix"></div>
            <form method="POST" name="package_payment" id="package_payment" action="" >
            <div class="text">Activation date</div>
            <div class="field">
            <input type="date" style="width: auto;" name="activation_date" id="activation_date" class="inpt_fld">
			</div> 
            <div class="clearfix"></div>
          	
            
            
            
            
            <h2>Payment</h2>
            
            <div class="text">Card Type </div>
            <div class="field">
            
            <select name="creditCardType" onchange="javascript:generateCC(); return false;" class="inpt_fld" style="width: auto;"  >
				<option value="Visa">Visa</option>
				<option value="MasterCard">MasterCard</option>
				<option value="Discover">Discover</option>
				<option value="Amex">American Express</option>
			</select>
            </div>
            <div class="clearfix"></div>
            
            <div class="text">Card Number </div>
            <div class="field">
            <input class="inpt_fld" type="text" name="creditCardNumber" id="creditCardNumber" maxlength="20" style="width: auto;"/>
            </div> 
            <div class="clearfix"></div>
            
              <div class="text">CVC </div>
            <div class="field">
            <input class="inpt_fld" type="text" name="cvv2Number" id="cvv2Number" style="width: auto;"/>
            </div> 
            <div class="clearfix"></div>
            <div class="text">Expiry Date </div>
            <div class="field">
            <select name="expDateMonth" class="inpt_fld" style="width: auto;">
				<option value="1" <?php if(isset($expDateMonth)){ echo 'selected="selected"';}?>>01</option>
				<option value="2">02</option>
				<option value="3">03</option>
				<option value="4">04</option>
				<option value="5">05</option>
				<option value="6">06</option>
				<option value="7">07</option>
				<option value="8">08</option>
				<option value="9">09</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
			</select>
			<select name="expDateYear" class="inpt_fld" style="width:auto;">
				<option value="2005" <?php if(isset($expDateYear)){ echo 'selected="selected"';}?>>2005</option>
				<option value="2006">2006</option>
				<option value="2007">2007</option>
				<option value="2008">2008</option>
				<option value="2009">2009</option>
				<option value="2010">2010</option>
				<option value="2011">2011</option>
				<option value="2012">2012</option>
				<option value="2013">2013</option>
				<option value="2014">2014</option>
				<option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
			</select>
            </div> 
            <div class="clearfix"></div>
            <div class="text">Amount </div>
            <div class="field">
            <input style="width: auto;" type="text" disabled="disabled" class="inpt_fld" value="<?php if($package_detail->package_currency == 1){echo '$';} elseif($package_detail->package_currency == 2) {echo 'Rs';} 
								echo $package_detail->package_price; ?>" />
            </div> 
            <div class="clearfix"></div>
            
            <div class="text">&nbsp; </div>
            <div class="field"><input name="submit" value="Pay" type="submit"></div>
            <input type="hidden" name="amount" value="<?php echo $package_detail->package_price ?>" />
            </form>
    <div class="clearfix"></div>
    <?php if(!empty($otherpackages)){
		foreach($otherpackages as $item){ ?>        
    <div class="pricing_container" style="margin-bottom:4%;">
                            	<div style="width: 100%; height: 420px !important;">
                                <div class="price_title" <?php if($item->package_currency == ''){?> style="background-color:#F3C;" <?php } ?>> <?php echo $item->package_name; ?></div>
                                <div class="price"> <?php if($item->package_currency == 1){echo '$';} elseif($item->package_currency == 2) {echo 'Rs';} 
								echo $item->package_price; ?><div><?php echo " / ".ucwords($item->package_type); ?></div> </div>
                                <div class="price_duration"> <?php echo $item->package_description; ?></div>
                                <div class="price_desc"> <?php echo $item->package_detail; ?></div>
                                </div>
                                <div class="add_cart"> <a href="<?php echo base_url('jobs/getpackagedetail/'.$item->package_id); ?>" target='_top' rel='nofollow' class='signin last_nav' title="login"><?php if($item->package_currency == ''){ ?>
                                <img src="<?php echo base_url().'resources/images/images/add_cart_p.png';?>"/>
                                <?php }else { ?>
                                <img src="<?php echo base_url().'resources/images/images/add_cart.png';?>"/>
                                 <?php } ?> </a></div>
                            </div>
     <?php } } ?>       
           
	</div>
	
</div>


<?php include("common_pages/internal_footer.php");?>
<script>
$(document).ready(function() {
    $("#creditCardNumber").keydown(function(event) {
    	// Allow only backspace and delete
    	if ( event.keyCode == 8 ) {
    		// let it happen, don't do anything
    	}
    	else {
    		// Ensure that it is a number and stop the keypress
    		if (event.keyCode < 48 || event.keyCode > 57 ) {
    			event.preventDefault();	
    		}	
    	}
    });
});


</script>