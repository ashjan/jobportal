<?php
    $sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}


if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE  '.$tblprefix.'property_minimum_stay.pm_id = '.$_SESSION[SESSNAME]['pm_id'].'								 
							AND '.$tblprefix.'properties.pm_type=1	AND '.$tblprefix.'properties.property_category=24';
}else{
	$module_pm_where = ' WHERE '.$tblprefix.'properties.pm_type=1 
								AND '.$tblprefix.'properties.property_category=24';
}	

$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;
$qry_faq = "SELECT
					".$tblprefix."rooms.room_type,
					".$tblprefix."property_minimum_stay.rate_type,
					".$tblprefix."property_minimum_stay.night_stay,
					".$tblprefix."property_minimum_stay.id,
					".$tblprefix."property_minimum_stay.room_id,
					".$tblprefix."rooms.id,
					".$tblprefix."properties.property_name,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name
					FROM
					".$tblprefix."property_minimum_stay 
	Inner Join ".$tblprefix."rooms ON ".$tblprefix."property_minimum_stay.room_id = ".$tblprefix."rooms.id 
	Inner Join ".$tblprefix."properties ON ".$tblprefix."property_minimum_stay.property_id= ".$tblprefix."properties.id  
	Inner Join ".$tblprefix."property_manager ON ".$tblprefix."property_minimum_stay.pm_id = ".$tblprefix."property_manager.id
	 $module_pm_where 
	";
												
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT
					".$tblprefix."rooms.room_type,
					".$tblprefix."property_minimum_stay.property_id,
					".$tblprefix."property_minimum_stay.pm_id,
					".$tblprefix."property_minimum_stay.rate_type,
					".$tblprefix."property_minimum_stay.night_stay,
					".$tblprefix."property_minimum_stay.id as mstayid,
					".$tblprefix."property_minimum_stay.room_id,
					".$tblprefix."rooms.id as rid,
					".$tblprefix."properties.property_name,
					".$tblprefix."property_manager.first_name,
					".$tblprefix."property_manager.last_name
					FROM
					".$tblprefix."property_minimum_stay
					Inner Join ".$tblprefix."rooms ON ".$tblprefix."property_minimum_stay.room_id = ".$tblprefix."rooms.id
					Inner Join ".$tblprefix."properties ON ".$tblprefix."property_minimum_stay.property_id= ".$tblprefix."properties.id 
					Inner Join ".$tblprefix."property_manager ON ".$tblprefix."property_minimum_stay.pm_id = ".$tblprefix."property_manager.id $module_pm_where ORDER BY ".$tblprefix."property_minimum_stay.id DESC
					LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();



//Query for the Property Manager that will be dynamically populated in the add and edit form
$qry_property_manag = "SELECT
                    ".$tblprefix."rooms.id,
					".$tblprefix."rooms.room_type
					FROM
					".$tblprefix."rooms"; 
$rs_property_manag = $db->Execute($qry_property_manag);
$totalcountpropertymanag =  $rs_property_manag->RecordCount();

//List down all PMs
$qry_pm = "SELECT ".$tblprefix."property_manager.*,
		  ".$tblprefix."properties.property_name ,
		  ".$tblprefix."properties.pm_type ,
		  ".$tblprefix."properties.property_category 
			 FROM ".$tblprefix."property_manager 
			 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
			 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
			 GROUP BY ".$tblprefix."properties.pm_id"; 
$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPm = $count_pm;

//List down all Properties
$qry_properties = "SELECT * FROM ".$tblprefix."properties where pm_type=1 AND ".$tblprefix."properties.property_category=24";
$rs_properties = $db->Execute($qry_properties);
$count_prop =  $rs_properties->RecordCount();
$totalprop = $count_prop;

$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' AND pm_type=1 AND '.$tblprefix.'properties.property_category=24';
$rs_prop = $db->Execute($property_qry);
$totalproperties =  $rs_prop->RecordCount();
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading" colspan="2">Property Room Minimum Stay &nbsp;[Ograničenje za minimalan boravak u objektu]</td>
  </tr>
  <tr>
    <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="5" align="right">Total Rooms Found: <?php echo $totalcountalpha ?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="6" align="right">
      <a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"  > <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> </a> </td>
  </tr>
  <tr>
    <td colspan="6"><div id="controls" class="add_subscriber">
        <form name="managecontentfrm" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
          <?php } else {?>
          <tr>
	        <td>
  			Property Manager
		   	</td>
			<td>
			<select name="pm_id" class="fields"   id="pm_id" onchange="get_prop_name15('property_id', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_name15.php"?>')">
				<option value="0">Izaberite vlasnika objekta</option>
				<?php 
   	while(!$rs_pm->EOF){
	echo '<option value="'.$rs_pm->fields['id'].'">'.$rs_pm->fields['first_name'].'  '.$rs_pm->fields['last_name'].'</option>';
	$rs_pm->MoveNext();
					}
				?>					
			</select>					
			</td>
        </tr>
        <?php }?>
        <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
        <tr>
	        <td>
  			Property Name
		   	</td>
			<td>
<div id="property_id"> 			
<select name="property_id" class="fields" onchange="get_room_type2('room_ids', this.value, '<?php echo MYSURL."ajaxresponse/get_Room_type7.php"?>')"   >
	<option value="0">Izaberite objekat</option>
		<?php 
     	while(!$rs_prop->EOF){
		echo '<option value="'.$rs_prop->fields['id'].'">'.$rs_prop->fields['property_name'].'</option>';
		$rs_prop->MoveNext();
		}
		?>					
 </select>				
</div>	
</td>
        </tr><b></b>
        <?php }else {?>
        <tr>
        <td>
        Property Name
        </td>
        <td>
        <div id="property_id"> 			
        <select name="property_id" class="fields"   >
        <option value="0">Izaberite objekat</option>       			
        </select>				
        </div>	
        </td>
        </tr>
			<?php }?>
			<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
			<tr>
             <td>Izaberite sobu</td>
             <td>
              
			    <div id="room_ids">
				<select name="room_id" class="fields">
					<option value="0">Sve sobe</option>
                </select>
             </div>
             </td>       
			</tr>
			<?php } else {?>
		    <tr>
             <td>Izaberite sobu</td>
              <td>
			    <div id="room_id">
				<select name="room_id" class="fields">
					<option value="0">Sve sobe</option>
				 	<?php
						while(!$rs_property_manag->EOF){?>
<option value="<?php echo $rs_property_manag->fields['id'];?>"><?php echo $rs_property_manag->fields['room_type'];?></option>
						<?php
						$rs_property_manag->MoveNext();
						}?>		
				</select>
				</div>
			  </td>
            </tr>	
			<?php }?>
			
            <tr>
			  <td> Rate Type<br/>[Vrsta cijene] </td>
              <td>
			    <select name="rate_type"  id="rate_type" class="fields" >
                	<option value="">Izaberite cijenu</option>
					<option value="1" selected="selected">Osnovna cijena</option>
				 	<!--<option value="2">Advance Rates</option>
                    <option value="3">All Rates</option>-->
				</select>
			  </td>
            </tr>
			
			<tr>
              <td> Nights Minimum Stay <br/>[Minimalan broj noćenja]</td>
              <td><select name="night_stay" id="night_stay" class="fields">
					<option value="">Izaberite minimalan broj noćenja</option>
					<?php
						for($i=1; $i<=40; $i++){
							echo "<option value=\"".$i."\">".$i."</option>";
						}
					?>
				</select>   
			  </td>
            </tr>
			
            <tr>
              <td>&nbsp;</td>
              <td><input style="margin:2px; width:274px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Dodaj minimalan broj noćenja" class="button" />
              </td>
            </tr>
          </table>
          <input type="hidden" name="act" value="manage_minimu_stay" />
          <input type="hidden" name="request_page" value="minimum_stay_management" />
          <input type="hidden" name="mode" value="add">
        </form>
      </div>
	 
  			</tr>
  
  <tr>
    <td colspan="6">
    <form  name="mngcontentform" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
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
            <select name="pm_id" class="fields" id="pm_id" onchange="get_prop_minimu_stay('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_minimu_stay.php"?>')">
            
                <option value="0">Izaberite vlasnika objekta</option>
                <?php
                    while(!$rs_offline->EOF){?>
                    <option value="<?php echo $rs_offline->fields['id'];?>"><?php echo $rs_offline->fields['first_name'].' '.$rs_offline->fields['last_name'];?></option>
                    
                    <?php
                    $rs_offline->MoveNext();
                    }?>	
                    	
            </select><br />
            </td>
         </tr>
          
        <?php  }else{	        
			$qry_content = "SELECT * FROM  ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." AND  property_category=24 AND  pm_type=1 ";
			$rs_content = $db->Execute($qry_content);
			$count_add =  $rs_content->RecordCount();
		?>
        <tr>
            <td width="30%" class="tabheading">Select Property<br/>[Izaberite objekat]</td>
            <td width="70%" align="center">
            <div id="property_id1">		
       			<select name="property_id" class="fields" id="property_id" onChange="get_prop_room_minimu_stay('rooms_id1',this.value,<?php echo $_SESSION[SESSNAME]['pm_id'];?>, '<?php echo MYSURL."ajaxresponse/get_prop_room_minimu_stay.php"?>')">
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
        <tr>
				<td width="20%" class="tabheading">Select Room Name<br/>[Izaberite sobu]</td>
				<td width="60%" align="center">
                <div id="rooms_id1">
			    <select name="room_id" id="room_id" class="fields"  />
					<option value="0">Izaberite sobu</option>
				</select>
				</div>
                </td>
		    </tr>
        
	</form>	
	</td>
	
  </tr>
  
  <tr>
   <td colspan="6">
   <div id="get_manage_minimu_stay">
            
   </div>
  </td>
  </tr>
  
</table>
<?php
// code for when click on edit button toggle window will open , actually that is use for insertin category 
if(isset($_GET['cateid']))
{
?>
	<script type="text/javascript">
		function openeditarea()
		{
			jQuery('#controls').slideToggle('fast'); 
			return false;
		}
		openeditarea();
	</script>
<?php 
}
?>
