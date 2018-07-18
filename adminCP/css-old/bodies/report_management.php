<?php
	$sql = "SELECT * FROM ".$tblprefix."admin WHERE id='1'";
	$rs = $db->Execute($sql);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Admin account found!';
		exit;
		}
		

  $qry_properties = "SELECT 
                   prop_booking.id,
                   prop_booking.pm_id,
				   prop_booking.user_id,
				   prop_booking.property_id,
				   prop_booking.room_id,
				   prop_booking.pincode,
				   prop_booking.check_indate,
				   prop_booking.check_outdate,
				   prop_booking.guests,
				   prop_booking.transaction_date,
				   prop.id,
				   prop.property_category,
				   prop.property_name,
				   prop.pm_type,
				   prop.short_description,
				   prop.contact_language,
				   prop.property_thumbnail,
				   prop.total_number_rooms,
				   pm.first_name,
				   pm.last_name,
				   pm.email_address,
				   pm.phone_number,
				   pm.pm_status
				   FROM ".$tblprefix."properties as prop  
				   INNER JOIN ".$tblprefix."property_booking as prop_booking ON prop.properties_slug=prop_booking.property_id 
				   INNER JOIN ".$tblprefix."property_manager as pm ON pm.id=prop_booking.pm_id
				   GROUP BY
				   prop.property_code ";  
		
		//  WHERE prop.pm_type=1"; 
        $rs_properties = $db->Execute($qry_properties);
        $totalinvoices =  $rs_properties->RecordCount();  
		
	//query for total price	
	   $qry_total_price = "SELECT 
				   SUM(prop_booking.price) as total_prices 
                   FROM ".$tblprefix."property_booking as prop_booking 
				   INNER JOIN ".$tblprefix."properties as prop ON prop.properties_slug=prop_booking.property_id 
				   INNER JOIN ".$tblprefix."property_manager as pm ON pm.id=prop_booking.pm_id LIMIT 1";
		//  WHERE prop.pm_type=1"; 
        $rs_total_price = $db->Execute($qry_total_price);
        $totalprices =  $rs_total_price->RecordCount();
		
		
		
		$maxRows = 18;
		if (empty($_GET['pageNum'])){ $pageNum=0;}else{$pageNum = $_GET['pageNum'];}
		if ($pageNum == '') $pageNum=0;
		$startRow = $pageNum * $maxRows;
		$totalRows = $totalinvoices;
		$totalPages = ceil($totalRows/$maxRows);
		$qry_letter_head = "SELECT * FROM ".$tblprefix."montenegro_letter_head "; 
		$rs_letter_head = $db->Execute($qry_letter_head);
		$totalcountletterhead =  $rs_letter_head->RecordCount();
		?>
<div class="row">
<div class="panel panel-default bootstrap-admin-no-table-panel">
<div class="panel-heading">
<div class="text-muted bootstrap-admin-box-title">
    Manage online  Reports
</div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="table">

	
    
    <tr>
    <td colspan="8" align="center" <?php if(!empty($_GET['okmsg'])){ echo 'class="okmsg"'; }else{ echo 'class="errmsg"';} ?> ><?php if(!empty($_GET['errmsg'])){ echo base64_decode($_GET['errmsg']).base64_decode($_GET['okmsg']);}?></td>
    </tr>
    
 	<tr class="tabheading">
    	<td colspan="2" align="right">Total Invoices Found: <?php echo $totalinvoices; ?></td>
	</tr>
    
  
	<form  name="mngcontentform" action="admin.php" method="post" onsubmit="return validate_contant()" enctype="multipart/form-data">
    <tr>
    <td colspan="2">  
    	<?php  if($_SESSION[SESSNAME]['pm_moduleid']!=2){ ?>     
        <tr>                
        <?php                                 
        //Dropdown List    
         $offline_qry = "SELECT ".$tblprefix."property_manager.*,".$tblprefix."properties.property_name 
						 FROM ".$tblprefix."property_manager 
						 inner Join ".$tblprefix."properties ON ".$tblprefix."properties.pm_id = ".$tblprefix."property_manager.id
						 WHERE ".$tblprefix."properties.pm_type =1 
						 group by pm_id";            
         $rs_offline = $db->Execute($offline_qry);           
        ?>
        
            <td width="30%" class="tabheading">Select PMs </td>
            <td width="70%" align="center">
            <select name="pm_id" class="fields" id="pm_id" onchange="get_prop_repo_mang('property_id1', this.value, '<?php echo MYSURL."ajaxresponse/get_prop_repo_mang.php"?>')">
            
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
			$qry_content = "SELECT * FROM  ".$tblprefix."properties WHERE pm_id=".$_SESSION[SESSNAME]['pm_id']." AND property_category=24";
			$rs_content = $db->Execute($qry_content);
			$count_add =  $rs_content->RecordCount();
		?>
        <tr>
            <td width="30%" class="tabheading">Select Property</td>
            <td width="70%" align="center">
            <div id="property_id1">		
       			<select name="property_id" class="fields" id="property_id" onChange="get_report_mang('get_report_mang',this.value,<?php echo $_SESSION[SESSNAME]['pm_id'];?>,'<?php echo MYSURL."ajaxresponse/get_report_mang.php"?>')">
        <?php
        if($count_add<=0){?>
        <option value="0">Izaberite vlasnika</option>
        <?php
        }else{?>
        <option value="0">Izaberite vlasnika</option>	
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
            <td width="30%" class="tabheading">Select Property</td>
            <td width="70%" align="center">
            <div id="property_id1">           
                <select name="property_id" id="property_id" class="fields"  />
                    <option value="0">Izaberite vlasnika</option>
                </select>            
            </div>
            </td>
        </tr>
      
       <?php } ?>
      
                             
	</td>
  
 
	</form>
 </table>
<div id="get_report_mang"></div> 
</div></div>
<?php //echo $where;?>
