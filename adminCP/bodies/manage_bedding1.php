<?php
	 
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}

$maxRows = 50;


if($_SESSION[SESSNAME]['pm_moduleid']==2){
	$module_pm_where = ' WHERE  '.$tblprefix.'bedding.pm_id = '.$_SESSION[SESSNAME]['pm_id'].' 
								AND '.$tblprefix.'properties.pm_type=0 
								AND '.$tblprefix.'properties.property_category=24';
}else{
	$module_pm_where = ' WHERE '.$tblprefix.'properties.pm_type=0 
								AND '.$tblprefix.'properties.property_category=24';
}



if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
if ($pageNum == '') $pageNum=0;
$startRow = $pageNum * $maxRows;

	$qry_faq = "SELECT
					".$tblprefix."rooms.room_type,
					".$tblprefix."rooms.id,
					".$tblprefix."bedding.room_id,
					".$tblprefix."bedding.property_id,
					".$tblprefix."bedding.pm_id,
					".$tblprefix."bedding.id,
					".$tblprefix."bedding.bedding_type_name,
					".$tblprefix."bedding.number_beds,
					".$tblprefix."bedding.extra_beds,
					".$tblprefix."bedding.dimensions_width,
					".$tblprefix."bedding.dimensions_length,
					".$tblprefix."properties.property_name,
					".$tblprefix."users.first_name,
					".$tblprefix."users.last_name
					FROM
					".$tblprefix."bedding
					Inner Join ".$tblprefix."rooms ON ".$tblprefix."bedding.room_id = ".$tblprefix."rooms.id 
					Inner Join ".$tblprefix."properties ON ".$tblprefix."bedding.property_id= ".$tblprefix."properties.id 
					Inner Join ".$tblprefix."users ON ".$tblprefix."bedding.pm_id = ".$tblprefix."users.id
					 $module_pm_where 
					";
			
					
					

$rs_faq = $db->Execute($qry_faq);
$count_add =  $rs_faq->RecordCount();
$totalRows = $count_add;
$totalPages = ceil($totalRows/$maxRows);

$qry_limit = "SELECT
					".$tblprefix."rooms.room_type,
					".$tblprefix."rooms.id,
					".$tblprefix."bedding.room_id,
					".$tblprefix."bedding.property_id,
					".$tblprefix."bedding.pm_id,
					".$tblprefix."bedding.extra_beds,
					".$tblprefix."bedding.id,
					".$tblprefix."bedding.bedding_type_name,
					".$tblprefix."bedding.number_beds,
					".$tblprefix."bedding.dimensions_width,
					".$tblprefix."bedding.dimensions_length,
					".$tblprefix."properties.property_name,
					".$tblprefix."users.first_name,
					".$tblprefix."users.last_name
					FROM
					".$tblprefix."bedding 
					Inner Join ".$tblprefix."rooms ON ".$tblprefix."bedding.room_id = ".$tblprefix."rooms.id 
					Inner Join ".$tblprefix."properties ON ".$tblprefix."bedding.property_id= ".$tblprefix."properties.id 
					Inner Join ".$tblprefix."users ON ".$tblprefix."bedding.pm_id = ".$tblprefix."users.id  $module_pm_where ORDER BY ".$tblprefix."bedding.id DESC
					LIMIT $startRow,$maxRows"; 
$rs_limit = $db->Execute($qry_limit);
$totalcountalpha =  $rs_limit->RecordCount();

//List down all Rooms
$qry_region = "SELECT * FROM ".$tblprefix."rooms" ;
$rs_region = $db->Execute($qry_region);
$count_region =  $rs_region->RecordCount();
$totalRegions = $count_region;


//List down all PMs
$qry_pm =  "SELECT ".$tblprefix."users.*,
   				   ".$tblprefix."properties.property_name ,
				   ".$tblprefix."properties.pm_type ,
				   ".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."users 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."users.id
						 WHERE ".$tblprefix."properties.pm_type =0 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id";
$rs_pm = $db->Execute($qry_pm);
$count_pm =  $rs_pm->RecordCount();
$totalPm = $count_pm;



//List down all Properties
$qry_properties = "SELECT * FROM ".$tblprefix."properties where pm_type=0 AND ".$tblprefix."properties.property_category=24";
$rs_properties = $db->Execute($qry_properties);
$count_prop =  $rs_properties->RecordCount();
$totalprop = $count_prop;

$property_qry = "SELECT id,property_name FROM ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id'].' 
				AND pm_type=0 
				AND '.$tblprefix.'properties.property_category=24';
$rs_property = $db->Execute($property_qry);
$totalproperties =  $rs_property->RecordCount();



?>
<script>
function ShowConversionResult(getid,resultid){
widthincm=$("#"+getid).val();
widthinIN=widthincm *0.4 ;
widthinIN = Math.round(widthinIN,2);
widthinIN = widthinIN + 'in';
$("#"+resultid).html(widthinIN);
}
</script>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt">
  <tr>
    <td id="heading" colspan="2">Property Bedding Types Management&nbsp;[Upravljanje tipovima kreveta u objektu]</td>
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
    <td colspan="6">
	<div id="controls" class="add_subscriber">
        <form name="managecontentfrm" action="admin.php" method="post" onSubmit="return validate_contant()" enctype="multipart/form-data">
          <table cellpadding="1" cellspacing="1" border="0" class="txt" >
         <?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>
		    <tr><td style="border-left:1px solid #999999;" colspan="2">
            <input type="hidden" name="pm_id" value="<?php echo $_SESSION[SESSNAME]['pm_id'];?>">
            </td></tr>
<?php	}else{ ?> 
		  <tr>
	        <td>
  			Property Manager
		   	</td>
			<td>
			<select name="pm_id" class="fields"   id="pm_id" onchange="get_add_prop_name_1('property_id', this.value, '<?php echo MYSURL."ajaxresponse/get_add_prop_name_1.php"?>')">
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
             <td>Property Name</td>
              <td>
			  <div id="property_name"> 
			    <select name="property_id" id="property_id" class="fields" onchange="get_room_type2('room_ids', this.value, '<?php echo MYSURL."ajaxresponse/get_room_type6.php"?>')">
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
	        <td>
  			Property Name
		   	</td>
			<td>
		<div id="property_id"> 			
		<select name="property_id" class="fields"   id="property_id">
			<option value="0">Izaberite objekat</option>
		</select>				
		 </div>	
</td>
        </tr>
        <?php }?>
		  
		<?php if($_SESSION[SESSNAME]['pm_moduleid']==2){?>  
		  <tr>
	        <td>
  			Room/Property Type<br/>[Vrsta sobe]
		   	</td>
			<td>

			
	<div id="room_ids">
			<select name="room_ids" class="dropfields" >
			  <option value="0">Izaberite sobu</option>
			</select>
      </div>
			
							
			</td>
        </tr>
        <?php } else {?>
		  
		  <!--Room Start from here -->
          <tr>
	        <td>
  			Room Type<br/>[Vrsta sobe]
		   	</td>
			<td>
			<div id="room_id">
			<select name="room_id" class="fields">
				<option value="0">Izaberite sobu Tip </option>
				<?php 
			     	while(!$rs_region->EOF){
					echo '<option value="'.$rs_region->fields['id'].'">'.$rs_region->fields['room_type'].'</option>';
					$rs_region->MoveNext();
					}
				?>					
			</select>					
            </div>
			</td>
        </tr>
        <?php }?>
        <!--Room upto here -->
           <tr><td>
		   Bedding Type Name &nbsp; [Vrsta kreveta]<br/><br/>
		   (Ruski)                                 <br/><br/>
		   (Crnogorski)                
		   </td>
		   <td><br/><br/><br/><br/>
	<input type="text" name="bedding_type_name"     class="fields" id="bedding_type_name"     value="" /><br/><br/>
	<input type="text" name="bedding_type_name_rus" class="fields" id="bedding_type_name_rus" value="" /><br/><br/>
	<input type="text" name="bedding_type_name_mon" class="fields" id="bedding_type_name_mon" value="" /><br/><br/><br/><br/>
		   </td>
		   <td></td>
		   </tr>
		   
		   <tr><td>Number Of Beds<br/>[Broj le&#382;ajeva]</td>
		   <td><input type="text" name="number_beds" class="fields" id="number_beds" ></td>
		   <td></td>
		   </tr>
		   
		   <tr><td>Extra Beds<br/>[Dodatni kreveti]</td>
		   <td><input type="text" name="extra_beds" class="fields" id="extra_beds" ></td>
		   <td></td>
		   </tr>
		    
			 <tr><td>Dimensions Width<br/>[Širina kreveta]</td>
		   <td><input type="text" name="dimensions_width" class="smallfields" id="dimensions_width" onblur="ShowConversionResult('dimensions_width','conversion_result_width');"  >cm</td>
		   <td>
		   <div id="conversion_result_width" style="width:30px; float:right; text-align:left; border:1px solid #000000;">
		   </div>
		   </td>
		   </tr>
		   
		   <tr><td>Dimensions Length<br/>[Du&#382;ina kreveta]</td>
		   <td><input type="text" name="dimensions_length" class="smallfields" id="dimensions_length"  onblur="ShowConversionResult('dimensions_length','conversion_result_length');" >cm</td>
		    <td>
		   <div id="conversion_result_length" style="width:30px; float:right; text-align:left; border:1px solid #000000; ">
		   </div>
		   </td>
		   </tr>
			 		  
			  <tr>
              <td>&nbsp;</td>
              <td><input style="margin:5px; width:174px; float:none; text-align:center;" type="submit" name="submit" id="submit" value="Insert Bedding &nbsp;[Dodaj krevet]" class="button" />
              </td>
            </tr>
          </table>
          <input type="hidden" name="act"          value="manage_bedding1" />
          <input type="hidden" name="request_page" value="bedding_management1" />
          <input type="hidden" name="mode"         value="add" />
        </form>
      </div></td>
  </tr>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
   <tr>
    <td colspan="6">
    <form  name="mngcontentform" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
    <tr>
    <td>
    	<?php if($_SESSION[SESSNAME]['pm_moduleid']!=2){ ?>       
        <tr>                
        <?php                                 
        //Dropdown List    
       $offline_qry = "SELECT ".$tblprefix."users.*,".$tblprefix."properties.property_name ,".$tblprefix."properties.pm_type ,".$tblprefix."properties.property_category 
						 FROM ".$tblprefix."users 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."users.id
						 WHERE ".$tblprefix."properties.pm_type =0 AND ".$tblprefix."properties.property_category =24  
						 GROUP BY ".$tblprefix."properties.pm_id";            
         $rs_offline = $db->Execute($offline_qry);           
        ?>
        
            <td width="30%" class="tabheading">Select Property Manager:<br/>[sIzaberite vlasnika objekta]:</td>
            <td width="70%" align="center">
            <select name="pm_id" class="fields" id="pm_id" onchange="get_prop_bedding1('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_bedding1.php"?>')">
            
                <option value="0">Izaberite vlasnika objekta</option>
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
         
		$qry_content = "SELECT * FROM  ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." 
						AND  pm_type=0 
						AND  property_category=24 ";
		$rs_content = $db->Execute($qry_content);
		$count_add =  $rs_content->RecordCount();
		
		?>
        <tr>
            <td width="30%" class="tabheading">Select Property<br/>[Izaberite objekat]</td>
            <td width="70%" align="center">
            <div id="property_id1">		
           		<select name="property_id" class="fields" id="property_id" onChange="get_prop_bedding_types1('rooms_id1',this.value,<?php echo $_SESSION[SESSNAME]['pm_id'];?>, '<?php echo MYSURL."ajaxresponse/get_prop_bedding_types1.php"?>')">
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
   <div id="get_prop_bedding_types1">
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
