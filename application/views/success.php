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
        
	<?php ///////////////////////////// PAYPAL CHECKOUT PROCESSING /////////////////////////////// ?>
    
    <?php
	

			
	 ?>
     
     <?php //////////////////////////// END PAYPAL PRO CHECKOUT /////////////////// //////////////// ?>
     
    <div class="right_panel">
    		
    		<h2> Success </h2>
            Your Transaction is completed successfully
          
            
            
            
            
           
           
	</div>
	
</div>


<?php include("common_pages/internal_footer.php");?>
