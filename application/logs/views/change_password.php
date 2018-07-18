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
            <?php echo form_open('profile/change_password');?>
            <h2>Change Password</h2>
            <div class="message"><?php echo $this->session->flashdata('msg');
            echo validation_errors();?></div>
                
                <div class="text">Old Password:</div>
                <div class="field"><input type="password" name="pass" id="pass" required=""/></div>
                <div class="clearfix"></div>
                
                <div class="text">New Password:</div>
                <div class="field"><input type="password" name="new_pass" id="new_pass" required=""/></div>
                <div class="clearfix"></div>
                
                <div class="text">Confirm Password:</div>
                <div class="field"><input type="password" name="conf_pass" id="conf_pass" required=""/></div>
                <div class="clearfix"></div>
            
                
                <div class="text"></div>
                <div class="field"><input type="submit" name="submit" value="Change Password"/></div>
                <div class="clearfix"></div>
                
                
                <?php echo form_close();?>
	</div>

</div>


<?php include("common_pages/internal_footer.php");?>
<script>
    
</script>