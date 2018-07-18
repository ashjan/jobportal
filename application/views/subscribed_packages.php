<?php
//var_dump($this->session->userdata('user_data')['usr_id']); exit;
 ?>
<?php include("common_pages/internal_header.php");?>



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
        

   
    
    
    
     
    <div class="right_panel">
    		<?php if(!empty($package_details)){
			 ?>
    		<h2 style="margin-left: 3%;"> Package Detail </h2>
            <?php foreach($package_details as $package_detail)
			 { ?>
            <div class="pricing_container" style="margin-top: 3%;">
            <div style="width: 100%; height: 410px !important;">
                                <div class="price_title"> <?php echo $package_detail->package_name; ?></div>
                                <div class="price"><?php if($package_detail->package_currency == 1){echo '$';} elseif($package_detail->package_currency == 2) {echo 'Rs';}
								echo $package_detail->package_price; ?><div><?php echo " / ".$package_detail->package_type; ?></div> </div>
                                <div class="price_duration"> <p><?php echo $package_detail->package_description; ?></p></div>
                                <div class="price_desc"> <p><?php echo $package_detail->package_detail ;?></p></div>							</div>
                                <div class="add_cart"> Subscribtion date: <strong> <?php echo $package_detail->subscription_date; ?> </strong></div>
                                <div class="add_cart"> Activation date: <strong> <?php echo $package_detail->activation_date; ?> </strong></div>
                                
                                <div class="add_cart"> Expiry date:  <strong> <?php echo $package_detail->expiry_date; ?> </strong></div>
                                
                                <div class="add_cart"> Status: <strong> <?php if($package_detail->status == 0){echo 'Pending Approve';} elseif($package_detail->status == 1) {echo 'Active';} elseif($package_detail->status == 2) {echo 'Request Rejected';} elseif($package_detail->status == 3) {echo 'Expired';} elseif($package_detail->status == 4) {echo 'Disabled';}   
								 ?> </strong></div>
                            </div>
            

	<?php } }else {echo "You dont have any subscribed package"; } ?>
	</div>
	
</div>


<?php include("common_pages/internal_footer.php");?>
