<?php

	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}


if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE pmc.pm_id = '.$_SESSION[SESSNAME]['pm_id'];
}else{
	$module_pm_where = ' ';
}


$maxRows = 100;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

$qry_com = "SELECT pmc.*,pm.id as pm_idd,pm.first_name,pm.last_name FROM `".$tblprefix."property_manager_commission` as pmc INNER JOIN tbl_property_manager as pm ON pm.id=pmc.pm_id  $module_pm_where  ";

$rs_qry_com = $db->Execute($qry_com);
$count_add =  $rs_qry_com->RecordCount();

$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT pmc.*,pm.id as pm_idd ,pm.first_name,pm.last_name,pt.property_name FROM `".$tblprefix."property_manager_commission` as pmc INNER JOIN tbl_property_manager as pm ON pm.id=pmc.pm_id INNER JOIN tbl_properties as pt ON pt.id=pmc.pt_id $module_pm_where ";
 
$rs_limit = $db->Execute($qry_limit);

$qry_property_manag ="SELECT ".$tblprefix."property_manager.*,
   				   	  ".$tblprefix."properties.property_name ,
				      ".$tblprefix."properties.pm_type ,
				      ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."property_manager 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id"; 
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountalpha =  $rs_limit->RecordCount();



//Dropdown for parent
$property_qry = "SELECT id,property_name,property_category FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' 
					AND pm_type=1
					AND '.$tblprefix.'properties.property_category=24';
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();

?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading" colspan="2">Manage Property Commision&nbsp;&nbsp;[Podešavanje provizije objekta]</td>
  </tr>
  <tr>
    <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
  </tr>
  <tr class="tabheading">
    	<td colspan="5" align="right">Total Number of Commision Found: <?php echo $totalcountalpha ?></td>
	</tr>
  <tr class="tabheading">
    <td colspan="6" align="right">
      <a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  > <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> </a> </td>
  </tr>
  
  <tr>
    <td colspan="6"><div id="controls" class="add_subscriber">
        <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
		  
		 
		<!-- <tr>
					<td class="txt1">Property Manager Name</td>
					<td>
					<select name="first_name" class="fields" id="first_name" onchange="get_prop_name('property_name', this.value, '<?php //echo MYSURL."ajaxresponse/get_prop_name.php"?>')">
				 	<option value="">Izaberite vlasnika objekta</option>
					<?php //while(!$rs_property_manag->EOF){$is_manager_selected = '';
							/*if($rs_property_manag->fields['id']==$rs_content->fields['page_category']){
							   $is_manager_selected = 'selected="selected"';
							}*/
                     ?>
		  			<option value="<?php //echo $rs_property_manag->fields['id'];?>" 
					<?php /*
					if($rs_property_manag->fields['id'] == $_SESSION["addpcommision"]["first_name"])
					{
						echo 'selected="selected"';
					}
					*/ ?> >
					 <?php //echo $rs_property_manag->fields['first_name']; ?>
					</option>
					
	                <?php //$rs_property_manag->MoveNext();
					//} ?>			
					</select>					
					</td>
				</tr>
		 -->
		 
		 
<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		    <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="first_name" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
<?php	}else{ ?>
		  <tr>
             <td>PM Name</td>
              <td>
			    <select name="first_name" id="first_name"  class="fields" onchange="get_prop_com_add('property_name', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_com_add.php"?>')">
					<option value="0">Izaberite vlasnika objekta</option>
				 	<?php
						while(!$rs_property_manag->EOF){?>
<option value="<?php echo $rs_property_manag->fields['id'];?>"><?php echo $rs_property_manag->fields['first_name'].' '.$rs_property_manag->fields['last_name'];  ?></option>
				<?php
					$rs_property_manag->MoveNext();
						}?>		
				</select>
			  </td>
            </tr>
<?php  } ?>
			
		<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr>
             <td>Property Name</td>
              <td>
			  <div id="property_name"> 
			    <select name="property_name" id="property_name" class="fields" />
					<option value="0">Izaberite objekat</option>
					<?php  
					$rs_property->MoveFirst();
					while(!$rs_property->EOF){ ?>
 <option value="<?php echo $rs_property->fields['id']; ?>"><?php echo $rs_property->fields['property_name']; ?></option>
					<?php 
					$rs_property->MoveNext();
					} ?>
				</select>
			  </div>
			  </td>
           </tr>
<?php }else{ ?>
			<tr>
             <td>Property Name</td>
              <td>
			  <div id="property_name"> 
			    <select name="property_name" id="property_name" class="fields" />
					<option value="0">Izaberite objekat</option>
				</select>
			  </div>
			  </td>
            </tr>
<?php  } ?>			
			
		 
		 
		  
           
			  
		   <td> Starting Date <br/>[Početni datum]</td>
			  <?php // $from_date=  date("y/m/d",strtotime($from_date)); ?>
			  <td width="200"><input  style="width:100px;" class="fields" type="text" name="from_date"  id="from_date" value="<?php 
			  
			  $start_date=date("m/d/Y");
			  echo $start_date; ?>" />
			  
			  <script language="JavaScript">
                                    
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'from_date'
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>
			  
			  </td>
            </tr>
			
			<tr>
              <td> Ending Date<br/>[Krajnji datum] </td>
			  <?php // $to_date=  date("y/m/d",strtotime($to_date)); ?>
			  <td width="200"><input class="fields"  style="width:100px;" type="text" name="to_date"  id="to_date" value="<?php 
			  $today = date("m/d/Y");
			 
			  $tomorrow = strtotime(date("m/d/Y", strtotime($today)) . " +1 day");
			 // $to_date = date("m/d/Y",strtotime($tomorrow));
			  echo date("m/d/Y",$tomorrow);?>" />
			  
			  <script language="JavaScript">
                                    var o_cal = new tcal ({
                                        // form name
                                        'formname': 'managecontentfrm',
                                        // input name
                                        'controlname': 'to_date'
                                    });
                                    
                                    // individual template parameters can be modified via the calendar variable
                                    o_cal.a_tpl.yearscroll = false;
                                    o_cal.a_tpl.weekstart = 1;
									</script>
			  
			  </td>
            </tr>
			
			<tr>
              <td> Commision <br/>[Provizija]</td>
			  <?php
			  if(isset($_SESSION["addpcommision"]["commission"]))
			  {
			  		 $comm = $_SESSION["addpcommision"]["commission"];
			  }
			  else
			  {
			  		 $comm = "";
			  }
			  ?>
              <td><input type="text" name="commission" class="fields1" id="commission" value="<?php echo $comm;?>" /></td>
            </tr>
			
			 <tr>
              <td>&nbsp;</td>
              <td><input style="margin:5px; width:108px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Dodaj proviziju" class="button" />
              </td>
            </tr>
          </table>
          <input type="hidden" name="act" value="manage_pm_commission" />
          <input type="hidden" name="request_page" value="pm_commision_management" />
          <input type="hidden" name="mode" value="add">
        </form>
      </div>
      </td>
  </tr>
<form name="mngcontentform" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
	<tr>
    <td colspan="2"> 
    	<?php  if($_SESSION[SESSNAME]['pm_moduleid']!=2){ ?>       
        <tr>                
        <?php                                 
        //Dropdown List    
         $offline_qry = "SELECT ".$tblprefix."property_manager.*,".$tblprefix."properties.property_name ,".$tblprefix."properties.pm_type ,".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."property_manager 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id";           
         $rs_offline = $db->Execute($offline_qry);           
        ?>
        
            <td width="30%" class="tabheading">Select PMs</td>             
            <td width="70%" align="center">
            <select name="pm_id" class="fields" id="pm_id" onchange="get_prop_comm('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_comm.php"?>')">
            
                <option value="0">Vlasnik objekta</option>
                <?php
                    while(!$rs_offline->EOF){?>
                    <option value="<?php echo $rs_offline->fields['id'];?>"><?php echo $rs_offline->fields['first_name'].' '.$rs_offline->fields['last_name'];  ?></option>
                    
                    <?php
                    $rs_offline->MoveNext();
                    }?>	
                    	
            </select><br />
            </td>
         </tr>
          
        <?php  }else{	        
			$qry_content = "SELECT * FROM  ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." AND property_category=24";
			$rs_content = $db->Execute($qry_content);
			$count_add =  $rs_content->RecordCount();
		?>
        <tr>
            <td width="30%" class="tabheading">Select Property<br/>[Izaberite objekat]</td>
            <td width="70%" align="center">
            <div id="property_id1">		
                <select name="property_id" class="fields" id="property_id" onChange="get_prop_commssion('get_prop_commssion',this.value,<?php echo $_SESSION[SESSNAME]['pm_id'];?>,'<?php echo MYSURL."ajaxresponse/get_prop_commssion.php"?>')">
                <?php
                if($count_add<=0){?>
                <option value="0">Izaberite objekat</option>
                <?php
                }else{?>
                <option value="0">Izaberite objekat</option>	
                    <?php while(!$rs_content->EOF){
                ?>
                <option value="<?php echo $rs_content->fields['id'];?>"><?php echo $rs_content->fields['property_name'] ;?></option>
                    <?php $rs_content->MoveNext();
                    }
                    }
                ?>
                </select>	
			</div>
            </td>
        </tr>  
        <?php } ?>  
       
		<?php if($_SESSION[SESSNAME]['pm_moduleid']!=2){ ?> 
        
        <tr>
            <td width="30%" class="tabheading">Select Property<br/>[Izaberite objekat]</td>
            <td width="70%" align="center">
            <div id="property_id1">           
                <select name="property_id" id="property_id" class="fields"  />
                    <option value="0">Izaberite objekat</option>
                </select>            
            </div>
            </td>
        </tr>     
                           
 		<?php } ?> 
        
	</form>	
	</td>
	
  </tr>
  
	<tr>
       <td colspan="6">
			<div id="get_prop_commssion"></div>
      </td>
  </tr>
  
  
  </form>
</table>
<?php //echo $where;?>

<?php
if($_SESSION[SESSNAME]['pm_moduleid']==2){
?>
<script language="javascript">
	get_facilities('properties_facilities', <?php echo $_SESSION[SESSNAME]['pm_id'];?>, '<?php echo MYSURL."ajaxresponse/get_facilities.php"?>');
</script>
<?php
}
?>
