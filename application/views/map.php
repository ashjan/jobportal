<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php include 'common_pages/internal_header.php';?>


<body>
		<div id="background">
	
                    <div class="left_pannel">
                        <img width="256px" height="500px" src="<?php echo base_url();?>resources/images/ad_vr2.jpg"/>
                    </div>

	<div class="right_panel">




<div class="map">
                                <?php if (isset($job_detail) and $job_detail != '' ){ ?>
                                <iframe width="640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php echo $job_detail->name ; ?>&output=embed"></iframe>
                            </div>
                            <?php } else { ?>
                                <iframe width="640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php echo "Software Technology Park, Service Rd N, Islamabad, Pakistan"; ?>&output=embed"></iframe>
                            <?php } ?>
            
        </div>
                </div>
                    
                            
                         <?php include 'common_pages/internal_footer.php';?>