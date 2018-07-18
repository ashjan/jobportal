<?php include("common_pages/internal_header.php");?>

<body>
		<div id="background">
        
        <?php 
        if($this->session->userdata['user_data']['u_type'] == 3)
        {
            include("common_pages/left_pannel_usr.php");
        }
        else 
        {
            include("common_pages/left_pannel.php");
        }
        ?>
        
	<div class="right_panel">
            
            <?php
            
            echo form_open('testimonials/add_testimonial');?>
            <h2>Post Your Testimonial</h2>
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
                
<!--            <div class="text">Title:</div>
                <div class="field"><input type="text" class="inpt_fld" name="title" id="title" required=""/></div>
                <div class="clearfix"></div>-->
                
                <div class="text">Testimonial:</div>
                <div class="field"><textarea name="testimonial" cols="50" rows="10"></textarea></div>
                <div class="clearfix"></div>
                
                
                <div class="text"></div>
                <div class="field"> <input type="submit" name="submit" value="Add Testimonial"/> </div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();
            ?>
	</div>

</div>
    
    
<?php include("common_pages/internal_footer.php");?>