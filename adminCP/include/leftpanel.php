<div class="col-md-2 bootstrap-admin-col-left">
                    <ul class="nav navbar-collapse collapse bootstrap-admin-navbar-side">
                       <?php
	if(is_array($_SESSION[SESSNAME]['pm_modules_list'])){
	   foreach($_SESSION[SESSNAME]['pm_modules_list'] as $groupname=>$menus){
			echo '<li id="heading">'.$groupname.'</li>';
	   foreach($menus as $key=>$menu){
	?>
                        <li>
                            <a href="<?php SURL?>admin.php?act=<?php echo $menu['module_act']?>"><i class="glyphicon glyphicon-chevron-right"></i><?php echo $menu['module_name']?></a>
                        </li>
                        <?php
           }
           }
        }
                        ?>

                    </ul>
                </div>