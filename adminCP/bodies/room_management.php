<?php
    $sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
	if(!empty($_GET['p'])){$post=explode(",",base64_decode($_GET['p']));}
	if($_SESSION[SESSNAME]['pm_moduleid']==2){
		$module_pm_where = ' WHERE '.$tblprefix.'rooms.pm_id = '.$_SESSION[SESSNAME]['pm_id'].'
							 AND '.$tblprefix.'properties.pm_type=1
							 AND '.$tblprefix.'properties.property_category=24';
	}else{
		$module_pm_where =' WHERE '.$tblprefix.'properties.pm_type=1 
							AND '.$tblprefix.'properties.property_category=24';
	}

		
		
$maxRows = 50;
if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

  $qry_faq = "SELECT  ".$tblprefix."rooms.*,
                    ".$tblprefix."properties.property_name,
			        ".$tblprefix."users.first_name,
			        ".$tblprefix."users.last_name 
               FROM ".$tblprefix."rooms 
	Inner Join ".$tblprefix."properties ON ".$tblprefix."rooms.property_id= ".$tblprefix."properties.id  
	Inner Join ".$tblprefix."users ON ".$tblprefix."rooms.pm_id = ".$tblprefix."users.id 
	$module_pm_where
	";
			
$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT  ".$tblprefix."rooms.*,
                    ".$tblprefix."properties.property_name,
			        ".$tblprefix."users.first_name,
			        ".$tblprefix."users.last_name 
    FROM ".$tblprefix."rooms  
	Inner Join ".$tblprefix."properties ON ".$tblprefix."rooms.property_id= ".$tblprefix."properties.id  
	Inner Join ".$tblprefix."users ON ".$tblprefix."rooms.pm_id = ".$tblprefix."users.id 
	 $module_pm_where 
	LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();



//List down all Properties
$qry_properties = "SELECT * FROM ".$tblprefix."properties";
$rs_properties = $db->Execute($qry_properties);
$count_prop =  $rs_properties->RecordCount();
$totalprop = $count_prop;


//List down all PMs
$qry_pm =" SELECT ".$tblprefix."users.*,
   				   	  ".$tblprefix."properties.property_name ,
				      ".$tblprefix."properties.pm_type ,
				      ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."users 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."users.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id";
$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPm = $count_pm;



//List down all Properties
$qry_properties = "SELECT * FROM ".$tblprefix."properties 
					WHERE ".$tblprefix."properties.pm_type=1 
					AND ".$tblprefix."properties.property_category=24" ;
$rs_properties = $db->Execute($qry_properties);
$count_prop =  $rs_properties->RecordCount();
$totalprop = $count_prop;


//Dropdown for parent
$category_qry = "SELECT ".$tblprefix."users.*,
   				   	  ".$tblprefix."properties.property_name ,
				      ".$tblprefix."properties.pm_type ,
				      ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."users 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."users.id
						 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id"; 
$rs_category = $db->Execute($category_qry);

?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading" colspan="2">Room Management &nbsp; [Upravljanje sobama]</td>
  </tr>
  <tr>
    <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?>
	<?php 
	if(isset($_GET['errmsg'])){
	
	} 
	?>
	</td>
  </tr>
  <tr class="tabheading">
    <td colspan="5" align="right">Total Rooms Found: <?php echo $totalcountalpha ?></td>
  </tr>
  <tr class="tabheading">
    <td colspan="6" align="right">
      <a   href="javascript:;" onClick="jQuery('#controls').slideToggle('fast'); return false"> 
	  <img src="<?php MYSURL?>graphics/add.png" border="0" title="Add New" /> </a> 
	  </td>
  </tr>
  <tr>
    <td colspan="6"><div id="controls" class="add_subscriber">
        <form action="admin.php" method="post" enctype="multipart/form-data" id="managemenufrm" name="managemenufrm">
    <table cellpadding="1" cellspacing="1" border="0" class="txt" >
   		  
		  <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
            <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
		  <?php } else {?>
		<tr>
				    <td>Select Property Manager::</td>
					<td>
				<select name="pm_id" class="fields"   id="pm_id" onchange="get_prop_room_nam('property_id', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_room_nam.php"?>')">
				<option  value="0">Izaberite vlasnika objekta</option>
				<?php 
   	while(!$rs_pm->EOF){
	if(isset($post[0])){if($post[0]==$rs_pm->fields['id']){$sel='selected="selected"';}else{$sel='';}}
	echo '<option '.$sel.' value="'.$rs_pm->fields['id'].'">'.$rs_pm->fields['first_name'].'  '.$rs_pm->fields['last_name'];'</option>';
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
  			Property Name<br/>[Naziv nekretnine]
		 	</td>
		    <td>
    <div id="property_id"> 			
    <select name="property_id" class="fields"   id="property_id">
	<option value="0">Izaberite objekat</option>
		<?php 
		$qry_property = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." AND pm_type=1 AND 
		property_category=24";
		                $rs_property = $db->Execute($qry_property);
						$count_property =  $rs_property->RecordCount();
						$totalproperty = $count_property;
						$rs_property->MoveFirst();
						while(!$rs_property->EOF){
						if(isset($post[1])){if($post[1]==$rs_property->fields['id']){$sel='selected="selected"';}else{$sel='';}}
		?>
						<option value="<?php echo $rs_property->fields['id'];?>"> <?php echo $rs_property->fields['property_name']; ?></option>
		<?php
						$rs_property->MoveNext();
						} 
		?>				
   </select>				
   </div>	
</td>
        </tr>
		  <?php } else {?>
		  <tr>
	        <td>
  			Property Name<br/>[Naziv nekretnine]
		   	</td>
			<td>
<div id="property_id"> 	
<?php if(isset($post)){?>
<select name="property_id" class="fields"   id="property_id">
	<option value="0">Izaberite objekat</option>
	<?php 
		$qry_property = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$post[0]." AND pm_type=1 AND 
		property_category=24";
		                $rs_property = $db->Execute($qry_property);
						$count_property =  $rs_property->RecordCount();
						$totalproperty = $count_property;
						$rs_property->MoveFirst();
		while(!$rs_property->EOF){
		if(isset($post[1])){if($post[1]==$rs_property->fields['id']){$sel='selected="selected"';}else{$sel='';}}
		?>
		<option <?php echo $sel; ?> value="<?php echo $rs_property->fields['id'];?>"> <?php echo $rs_property->fields['property_name']; ?></option>
		<?php   $rs_property->MoveNext();
				} 
		?>				
</select>				
<?php }else{ ?>
 <select name="property_id" class="fields"   id="property_id"> 
    <option value="0">Izaberite objekat</option>
 </select>					
<?php } ?>

</div>	
</td>
</tr>
<?php }?>
    <tr><td>Room Type<br/>[Vrsta sobe]</td>
	<td><br/><br/><br/><br/>
    <input type="text" name="room_type"     class="fields" id="room_type"     value="<?php if(!empty($post[2])){echo $post[2];}?>" /><br/><br/>
	<input type="text" name="room_type_rus" class="fields" id="room_type_rus" value="" /><br/><br/>
	<input type="text" name="room_type_mon" class="fields" id="room_type_mon" value="" /><br/><br/><br/><br/>
	</td>
	</tr>
   <tr><td>Number Resources Available<br/>[Broj raspolo&#382;ivih soba]</td>
			   <td>
			   <input type="text" name="number_resources_available" value="<?php if(!empty($post[3])){ echo $post[3];} ?>" />
				</td>
             </tr>
			 
			 <tr><td>Max Persons Per Resources<br/>[Maksimalan broj gostiju po sobi]</td>
			   <td><select class="fields"  name="max_persons_per_resource" id="<?php echo $rs_limit->fields['id']; ?>">
				   <option value="1">1 osoba</option>
			 	   <option value="2">2 osoba</option>
				   <option value="3">3 osoba</option>
				   <option value="4">4 osoba</option>
				   <option value="5">5 osoba</option>
				   <option value="6">6 osoba</option>
				   <option value="7">7 osoba</option>
				   <option value="8">8 osoba</option>
				   <option value="9">9 osoba</option>
				   <option value="10">10 osoba</option>
				</select></td>
             </tr>
			<tr>
			<td>Meter Square (Room Dimension)<br/>[Dimenzije sobe]</td>
			<td>
			<input type="text" name="meter_square" class="smallfields" id="meter_square" />
			</td>
			</tr>
			
	
			 <tr>
              <td>&nbsp;</td>
              <td><!--<input style="margin:5px; width:100px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Room" class="button" />-->
              <a href="javascript:" style="margin:5px; width:112px; float:none; text-align:center;" name="submit" id="submit" class="button" onclick="add_room_manag()">Add Room</a>
              </td>
            </tr>
          </table>
          <input type="hidden" name="act"          value="room_management"        />
          <input type="hidden" name="request_page" value="manage_room_management" />
          <input type="hidden" name="mode"         value="add"                    />
        </form>
      </div></td>
  </tr>
  <form  name="mngcontentform" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
    <tr>
    <td>
			<?php if($_SESSION[SESSNAME]['pm_moduleid']!=2){ ?>  
            <tr>
			<?php
				//Dropdown for parent
				$category_qry = "SELECT ".$tblprefix."users.*,".$tblprefix."properties.property_name ,".$tblprefix."properties.pm_type ,".$tblprefix."properties.property_category 
								 FROM ".$tblprefix."users 
								 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."users.id
								 WHERE ".$tblprefix."properties.pm_type =1 AND ".$tblprefix."properties.property_category =24  
								 GROUP BY ".$tblprefix."properties.pm_id";  
				$rs_category = $db->Execute($category_qry); 
            ?>
				<td width="20%" class="tabheading">Select Property Manager::</td>
				<td width="60%" align="center">
                <select name="pm_id" class="fields" id="pm_id" onchange="get_prop_room('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_room_mang.php"?>')">
					<option value="0">Izaberite vlasnika objekta</option>
				 	<?php
						while(!$rs_category->EOF){?>
					    <option value="<?php echo $rs_category->fields['id'];?>"><?php echo $rs_category->fields['first_name'].' '.$rs_category->fields['last_name'];  ?></option>
						<?php
						$rs_category->MoveNext();
						}?>		
				</select><br />
                </td>
             </tr>
			<?php  }else{	        
				$qry_content = "SELECT * FROM  ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']."
								AND pm_type=1
								AND property_category=24";
				$rs_content = $db->Execute($qry_content);
				$count_add =  $rs_content->RecordCount();
            ?>
            <tr>
                <td width="30%" class="tabheading">Select Property<br/>[Izaberite objekat]</td>
                <td width="70%" align="center">
                <div id="property_id1">		
                    <select name="property_id" class="fields" id="property_id" onChange="get_room_manag('rooms_id1', this.value,<?php echo $_SESSION[SESSNAME]['pm_id'];?>, '<?php echo MYSURL."ajaxresponse/get_rooms_manag.php"?>')">
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
				<td width="20%" class="tabheading">Select Property<br/>[Izaberite objekat]</td>
				<td width="60%" align="center">
                <div id="property_id1">
			   
			    <select name="property_id" id="property_id" class="fields"  />
					<option value="0">Izaberite objekat]</option>
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
	</td>
  </tr>
</form>
 </table>

<div id="get_rates_videos"></div>
<?php
// code for when click on edit button toggle window will open , actually that is use for insertin category 
if(isset($_GET['cateid'])){
?>
	<script type="text/javascript">
		function openeditarea()
		{
			jQuery('#controls').slideToggle('fast'); 
			return false;
		}
		openeditarea();
	</script>
<?php } ?>
<script type="text/javascript">

function add_room_manag(){ 
    var validation_flag= true;
	with (document.managemenufrm){ 		
		
		if(pm_id.value=="0"){
			alert("Please Enter Property Manager");
			pm_id.focus();
			validation_flag= false;
		}
		
		if(property_id.value=="0"){
			alert("Please Enter Property Name");
			property_id.focus();
			validation_flag= false;
		}	
		
		if(room_type.value==""){
			alert("Please Enter Room Type");
			room_type.focus();
			validation_flag= false;
			
		}
		
		if(number_resources_available.value==""){
			alert("Please Enter Number Resources");
			number_resources_available.focus();
			validation_flag= false;
			
		}		
		
		if(meter_square.value==""){
			alert("Please Enter Square Meter value");
			meter_square.focus();
			validation_flag= false;
		}		
	}
		if(validation_flag==true){
			   document.getElementById('managemenufrm').submit();
			}
		return validation_flag;
}// END
</script>