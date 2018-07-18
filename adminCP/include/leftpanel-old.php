<table width="100%" border="0" cellspacing="0" cellpadding="2" class="txt">
	<?php
	if(is_array($_SESSION[SESSNAME]['pm_modules_list'])){
	   foreach($_SESSION[SESSNAME]['pm_modules_list'] as $groupname=>$menus){
			echo '<tr><td colspan="2" id="heading">'.$groupname.'</td></tr>';
	   foreach($menus as $key=>$menu){
	?> <tr><td colspan="2" height="35"><a href="<?php SURL?>admin.php?act=<?php echo $menu['module_act']?>"><?php echo $menu['module_name']?></a></td></tr>
    <?php
			}
		}
	
	}else{
		echo '<tr><td colspan="2" id="heading">Modules List</td></tr>';
		echo '<tr><td colspan="2" height="25">Invalid modules list</td></tr>';
	}
	?>
</table>