<!DOCTYPE html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php include 'common_pages/headers.php';?>
    <div class="welcome_div_large onerow">  
    <div class="onerow"> 
	 <?php
		if(!empty($pagecontents[0])) { ?>
			<div class="onerow">
                            <h1><?php echo $pagecontents[0]->page_title; ?> </h1>
			</div>
			<div class="botm_line"></div>
			<div class="onerow p_text_welcome">
                            <p><?php echo str_replace('../',base_url(),$pagecontents[0]->description);?></p>
			</div>
			<?php 
			}?>
    </div>  </div>
    </div>
 <?php  include 'common_pages/footers.php';  ?>

