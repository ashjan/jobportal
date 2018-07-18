<?php include 'login_popup.php'; ?>

<script>
    <?php if(isset($this->session->userdata['user_data']['usr_id'])){?>
    link_auto = '<?php echo base_url();?>jobs/auto_comp_data/';
        link_search = '<?php echo base_url();?>jobs/inner_search_data/';
    <?php }else{?>
            link_auto = '<?php echo base_url();?>welcome/auto_comp_data/';
        link_search = '<?php echo base_url();?>welcome/inner_search_data/';
        <?php }?>
     var options, a;
jQuery(function(){
	options = { serviceUrl:link_auto,
        minChars:1,
	delimiter: /(,|;)\s*/, // regex or character
	deferRequestBy: 0, //miliseconds //aditional parameters
	noCache: false};
    
	a = $('#autocomplete').autocomplete(options);
       
});
</script>


<div class="footer_outer">
<div class="footer">
     
     <div class="footer_container">
         <div class="footer_ttl">INFORMATION</div>
         <ul class="footer_lnks">
                               <?php 
	 if(count($widget1_menus_items)==0){
		}else{
		for($i=0; $i<count($widget1_menus_items);$i++){?>
                       <li>
                            <?php if($widget1_menus_items[$i]->content_id==$this->uri->segment(3) && $this->uri->segment(3)!=0){?> 
                    <a style="color:#137A63"  href="<?php echo base_url().'index.php/content/display/'.$widget1_menus_items[$i]->content_id; ?>" >
                               <?php echo $widget1_menus_items[$i]->menu_title; ?>
                    </a>
                    <?php }else{ ?>
                    <a  href="<?php echo base_url().'index.php/content/display/'.$widget1_menus_items[$i]->content_id; ?>" >
                           <?php echo $widget1_menus_items[$i]->menu_title; ?>
                    </a>
                    
                     <?php } ?>
                       
      <?php }
	  echo '<br>';
	  } ?>
           
           
         </ul>
     </div>
     
     <div class="footer_container">
        <div class="footer_ttl">SERVICES</div>
         <ul class="footer_lnks">
             <?php 
	 if(count($widget2_menus_items)==0){
		}else{
		for($i=0; $i<count($widget2_menus_items);$i++){?>
                        <li>
                <?php if($widget2_menus_items[$i]->content_id==$this->uri->segment(3) && $this->uri->segment(3)!=0){?> 
                <a style="color:#137A63" href="<?php echo base_url().'index.php/content/display/'.$widget2_menus_items[$i]->content_id; ?>" >
		<?php echo $widget2_menus_items[$i]->menu_title ; ?>                                
		</a>
                <?php }else{ ?>
                <a href="<?php echo base_url().'index.php/content/display/'.$widget2_menus_items[$i]->content_id; ?>" >
		<?php echo $widget2_menus_items[$i]->menu_title ; ?>                                
		</a>
                             <?php } ?>
                         </li>
      <?php }
	  echo '<br>';
	  } ?> 
             
             
             
         </ul>
     </div>
     
     
     <div class="footer_container spacer">
         <div class="footer_ttl">MY ACCOUNT</div>
         <ul class="footer_lnks">
             <?php	
             if(count($widget3_menus_items)==0){
		}else{
		for($i=0; $i<count($widget3_menus_items);$i++){?>
			<li>
                            <?php if($widget3_menus_items[$i]->content_id==$this->uri->segment(3) && $this->uri->segment(3)!=0){?> 
                            <a style="color:#137A63" href="<?php echo base_url().'index.php/content/display/'.$widget3_menus_items[$i]->content_id; ?>" >
                            <?php echo $widget3_menus_items[$i]->menu_title ; ?>                                
                            </a>
                            <?php }else{ ?>
                            <a href="<?php echo base_url().'index.php/content/display/'.$widget3_menus_items[$i]->content_id; ?>" >
                            <?php echo $widget3_menus_items[$i]->menu_title ; ?>                                
                            </a>
                            <?php } ?>
                        </li>
            <?php }
            echo '<br>';
            } ?>
          
          
          
         </ul>
     </div>
     
     <div class="footer_container last">
         <div class="footer_ttl">FOLLOW US</div>
         <ul class="footer_lnks">
             <li><a href="#"><div class="social_icon"><img  width="20px" height="20px" src="<?php echo base_url().'resources/images/images/twitter.png';?>"/></div>TWITTER</a></li>
             <li><a href="#"><div class="social_icon"><img  width="23px" height="20px" src="<?php echo base_url().'resources/images/images/facebook.png';?>"/></div>FACEBOOK</a></li>
             <li><a href="#"><div class="social_icon"><img  width="20px" height="20px" src="<?php echo base_url().'resources/images/images/rss.png';?>"/></div>RSS</a></li>
         </ul>
     </div>
     
     
     <div class="prop_txt">
     </div>
     
 
</div>

</div>
		</div>
 </body>
 
 
 <script type="text/javascript">APPLICATION_URL='<?php echo base_url();?>';</script>
 <script type="text/javascript" src="<?php echo base_url('')?>resources/js/popup.js"> </script>   
 </html>