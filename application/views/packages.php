<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php include 'common_pages/headers.php';?>
<br />
<br />

<div class="pricing" style="background-color:#FFF;">
 <?php if(!empty($packagesArray)){
	 				$count_package	=	1;
						foreach($packagesArray as $item) {
								
								 ?>
                            
                            <div class="pricing_container" style="margin-bottom:4%;">
                            	<div style="width: 100%; height: 420px !important;">
                                <div class="price_title" <?php if($item->package_currency == ''){?> style="background-color:#F3C;" <?php } ?> > <?php echo $item->package_name; ?></div>
                                <div class="price"> <?php if($item->package_currency == 1){echo '$';} elseif($item->package_currency == 2) {echo 'Rs';} 
								echo $item->package_price; ?><div><?php echo " / ".$item->package_type; ?></div> </div>
                                <div class="price_duration"> <?php echo $item->package_description; ?></div>
                                <div class="price_desc"> <?php echo $item->package_detail; ?></div>
                                </div>
                                <div class="add_cart"> <a href="<?php echo base_url('jobs/getpackagedetail/'.$item->package_id); ?>" target='_top' rel='nofollow' class='signin last_nav' title="login"> 
                                <?php if($item->package_currency == ''){ ?>
                                <img src="<?php echo base_url().'resources/images/images/add_cart_p.png';?>"/>
                                <?php }else { ?>
                                <img src="<?php echo base_url().'resources/images/images/add_cart.png';?>"/>
                                 <?php } ?>
                                 </a></div>
                            </div>
                            <?php 
							
							} 
							}  ?>
 
 </div>
      
 <?php  include 'common_pages/footers.php';  ?>

