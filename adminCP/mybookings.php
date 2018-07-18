<?php include('include/header.php'); ?>
       <div class="onerow"> 
		<div class="welcome_div_large">
			 <div class="frmmsgz" style="color:#FF0000;">
			<?php 
			      if(validation_errors() ){
						if(validation_errors()) echo validation_errors();
			     }
				  if(!empty($adminmsg)){echo $adminmsg;}
			?>
			</div>
			<div style="float:left;">
			<?php if(!empty($pagecontents[0])) { ?>
			<div class="welcome_hding onerow">
			<h3><?php echo $pagecontents[0]->page_title; ?> </h3>
			</div>
			<div class="botm_line"></div>
			<div class="onerow p_text_welcome">
			
			<?php echo $pagecontents[0]->description;
			?>
			</div>
			<?php 
			}?>
			</div>
        </div> 
      </div>  
<?php include('include/footer.php'); ?>
