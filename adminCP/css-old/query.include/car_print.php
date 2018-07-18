<?php
$my_qry=base64_decode($_POST['my_qry']);

    $rs = $db->Execute($my_qry);
	$isrs = $rs->RecordCount();
		if($isrs == 0){
		echo 'No Records Found!';
		}

?>
<style>

body{
	font-family:Arial, Helvetica, sans-serif; color:#333333; font-weight:normal;
}


.txt {
	FONT-SIZE: 9pt; COLOR:#222020;
     }
	 
.txtnew {
	FONT-SIZE: 10px; COLOR:#222020;
     }

.txtnewb {
	  FONT-SIZE: 9px;  COLOR:#222020 ;
     }
.txtnewbb {
	  FONT-SIZE: 9px; bgcolor: #green;  COLOR:#222020 ;
     }
	 
.txt1 {
    WIDTH:260px;FONT-SIZE: 9pt; COLOR:#222020;
}	 


.txt2 {
    WIDTH:260px;FONT-SIZE: 10pt; COLOR:#222020; FONT-WEIGHT:bold;
	}	 


.txt3 {
    WIDTH:180px;FONT-SIZE: 10pt; COLOR:#222020; FONT-WEIGHT:normal;
	}
	
	
.txt_bold{
  font-weight:bold;
}

	 
.txtnote {
	FONT-SIZE: 9pt; COLOR:#999999;
     }
.copyrights {
	FONT-SIZE: 9pt; COLOR: #C1C1C1; FONT-FAMILY: Tahoma, Verdana, Arial 
}
.button{
	padding:1; border:1px solid #333333; FONT-SIZE: 12px; /*WIDTH: 60px; */COLOR: #ffffff; TEXT-INDENT: 3px; FONT-FAMILY: MS Sans Serif;/* HEIGHT: 20px;*/ BACKGROUND-COLOR: #0099FF; text-align:center;
}
.smallfields {
	padding:1; border:1px solid #C8C8C8; FONT-SIZE: 11px; WIDTH: 150px; COLOR: #333333; TEXT-INDENT: 3px; FONT-FAMILY: MS Sans Serif; HEIGHT: 20px; BACKGROUND-COLOR: #FFFFFF; background-image:url('../graphics/fieldsbg.gif')
	}
	
.smallestfields {
	padding:1; border:1px solid #C8C8C8; FONT-SIZE: 11px; WIDTH: 60px; COLOR: #333333; TEXT-INDENT: 3px; FONT-FAMILY: MS Sans Serif; HEIGHT: 20px; BACKGROUND-COLOR: #FFFFFF; background-image:url('../graphics/fieldsbg.gif')
	}
.fields {
	padding:1; border:1px solid #5594B1; FONT-SIZE: 11px; WIDTH: 250px; COLOR: #333333; TEXT-INDENT: 3px; FONT-FAMILY: MS Sans Serif; HEIGHT: 20px; BACKGROUND-COLOR: #FFFFFF; background-image:url('../graphics/fieldsbg.gif'); background-position:top left;
}

.fields1 {
	padding:1; border:1px solid #5594B1; FONT-SIZE: 11px; WIDTH: 146px; COLOR: #333333; TEXT-INDENT: 3px; FONT-FAMILY: MS Sans Serif; HEIGHT: 20px; BACKGROUND-COLOR: #FFFFFF; background-image:url('../graphics/fieldsbg.gif'); background-position:top left;
}
.fields_small{
	padding:1; border:1px solid #5594B1; FONT-SIZE: 11px; WIDTH: 145px; COLOR: #333333; TEXT-INDENT: 3px; FONT-FAMILY: MS Sans Serif; HEIGHT: 20px; BACKGROUND-COLOR: #FFFFFF; background-image:url('../graphics/fieldsbg.gif'); background-position:top left;
}
.fields_checked{
	padding:1;  FONT-SIZE: 11px;  COLOR: #333333; TEXT-INDENT: 3px; FONT-FAMILY: MS Sans Serif; HEIGHT: 20px;  background-position:top left;
}

.fields_checked span{
	padding:1; border:1px solid #5594B1; FONT-SIZE: 11px; COLOR: #333333; TEXT-INDENT: 3px; FONT-FAMILY: MS Sans Serif; HEIGHT: 20px;   background-position:top left;

}


.txtareas {
	padding:1; border:1px solid #C8C8C8; FONT-SIZE: 13px; WIDTH: 550px; COLOR: #333333; TEXT-INDENT: 3px; FONT-FAMILY: MS Sans Serif; HEIGHT: 600px; BACKGROUND-COLOR: #FFFFFF; background-image:url('../graphics/fieldsbg.gif'); background-repeat:repeat-x; background-position:top left;
}
.smalltxtareas {
	padding:1; 
	border:1px solid #C8C8C8; 
	FONT-SIZE: 11px; COLOR: #333333; 
	TEXT-INDENT: 3px; 
	FONT-FAMILY: MS Sans Serif; 
	BACKGROUND-COLOR: #FFFFFF; background-image:url('../graphics/fieldsbg.gif'); 
	background-repeat:repeat-x; 
	background-position:top left;
	height:85px;
}
.dropfields {
	padding:1; border:1px solid #5594B1; FONT-SIZE: 12px; WIDTH: 250px; COLOR: #333333; TEXT-INDENT: 3px; FONT-FAMILY: MS Sans Serif; HEIGHT: 20px; BACKGROUND-COLOR: #FFFFFF;
}
.hidelink {
	FONT-SIZE: 9pt; COLOR: #C1C1C1; FONT-FAMILY: Tahoma, Verdana, Arial 
}
.bluestripwhitetext
{
 font-family:Arial, Helvetica, sans-serif; color:#FFFFFF; font-size:12pt;
 }
.bluestriptxt
{ 
font-family:Arial, Helvetica, sans-serif; color:#4E8DB7; font-size:10pt;
}
.emailheading
{ 
font-family:Arial, Helvetica, sans-serif; color:#01467C; font-size:10pt;
}
.redfont
{
color:#CC3300; font-weight:bold; font-size:13px;
}
.tabheading
{
font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold; color:#2D2D2D; 
}
.caltbl{
font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal; color:#787878; border:1px solid #E1EBF2; border-collapse:collapse;
}
.calheadermonthname{
font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#01467C; background:#DEDEDE;  
}
.caldaysname{
font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold; color:#4A76A6; padding:0px; background:#D7E4EA; 
}
.caldates{
font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal; color:#4A76A6;
}
.redcolorcal{
FONT-SIZE: 9pt; COLOR:#EC1111; FONT-FAMILY: sans-serif; font-weight:normal; padding:1 1 1 1; width:18px; height:16px; vertical-align:middle;
}
a{
font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-weight:normal; text-decoration:none; color:#0066CC; text-indent:5px;
}
a:hover{
font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-weight:normal; text-decoration:underline; color:#299DF7; text-indent:5px;
}
.divheadingred 
{
font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold; color:#ff0000; 
}
.divheadingblack 
{
font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold; color:#999999; 
}
#heading{
	background-image:url(../graphics/headingbg.gif); background-position:left top; background-repeat:repeat-x; height:25px;
	color:#FFFFFF; font-weight:bold; font-size:11px; text-indent:2px;
}
#mainpan{
	border:1px solid #FEDEDE; width:100%; background-image:url(../graphics/mainbg.gif); background-position:left top; background-repeat:repeat-x;
}

.okmsg{
	
	font-weight:bold;
	color:#0033FF;
	border: solid 1px #006600;
}
.errmsg{
	
	font-weight:bold;
	color:#FF0000;
	border: solid 1px #006600;
}

.smalldropfields {
	padding:1; border:1px solid #5594B1; FONT-SIZE: 12px; COLOR: #333333; FONT-FAMILY: MS Sans Serif; HEIGHT: 20px; BACKGROUND-COLOR: #FFFFFF;
}

.add_subscriber{
	/*background-color:#F0FFFF; border:0px none; display:none; width:100%;*/
	background-color: #E7DAE7;
	width:100%; 
	overflow: hidden;
	display:none;
}

.subscriber_txt{
	cursor:pointer; font-style:normal;
	font-family:Arial, Helvetica, sans-serif;
	font-weight:bold;
	font-size:12px;
	/*color:#E7DAE7; */
	text-decoration:none;
	overflow: hidden;
}

.bigfield{
	width:460px;
	height:150px;
	color:#0099CC;
}
.add_subscriber{
	background-color:#E7DAE7;
  	display:none;
  	overflow-x:hidden;
  	overflow-y:hidden;
  	width:100%;
}
.image_div_title{
margin:5px 0px 0px 10px ;
width:100px;
float:left;
}
.image_div_title_text{
margin:5px 0px 0px 0px ;
 width:300px;
 float:left;
}

.clear{
clear:both;
}


#page_parent{
 width:356px;
}


.border_div_categories{
  /*
  border:#666666 1px solid; margin-top:20px; 
  float:left; width:732px; 
  */
  padding:5px;
}




.field_comments{
  float:left; 
  color:#999999; 
  font-size:12px;
  width:700px;
}


.field_comments{
  float:left; 
  font-size:12px;
  width:700px;
  color:#000000;
  font-size:11px;
}


.save_icon{
    background-image:url(../graphics/save_icon.png);
	background-position:top;
    border: 0 none;
    height: 25px;
    width: 25px;
	cursor:pointer;
} 
.field2 {
	padding:1; border:1px solid #5594B1; FONT-SIZE: 11px; WIDTH: 100px; COLOR: #333333; TEXT-INDENT: 3px; FONT-FAMILY: MS Sans Serif; HEIGHT: 20px; BACKGROUND-COLOR: #FFFFFF; background-image:url('../graphics/fieldsbg.gif'); background-position:top left;
}
.outer_rates {
float:left;
border: 1px solid;
}

.inner_div {
float:left;
padding:0px;
border:1px solid;
width:167px;
font-size:12px;
font-weight:bold;

}

.single_div{
padding:5px;
margin-left:0px;
border:1px solid;
height:13px;
}

.value_div{
  float:left;
  width:35px;
  /*border-left:1px dotted #999999;*/
  border-right:1px dotted #999999;
}


.value_div_epmty{
  float:left;
  width:20px;
  /*border-left:1px dotted #999999;*/
  border-right:1px dotted #999999;
}
.overview_heading{
  font-size:10px;
  font-weight:bold;
}

.overview_heading1{
  font-size:9px;

}

.single_div_17
{
 	padding:5px;
	margin-left:0px;
	border:1px solid;
	height:17px;
}

.value_div_bold_large{
  font-size:14px;
  font-weight:bold;
  float:left;
}
.month_style{
width:99%;
font-size:15px;
border:0;
background-color:grey;
color:#FFFFFF;
text-align:center;
}


.p_text{
 float:left;
 width:160px;
 height:160px;
 border:none;
}

.p_text img{
 float:left;
  width:160px;
 height:160px;
 border:none;
}

.onerow{
 float:left;
 width:100%;
}


.spa_hding{
    color: #072B5D;
    float: left;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 18px;
    font-weight: bold;
    height: auto;
    text-shadow: 1px 1px 1px #FFFFFF;
    width: auto;

}


.mid_link_cars{
 color: #666666;
    float: left;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 14px;
    font-style: normal;
    text-align: left;
    text-decoration: underline;
}

a.mid_link_cars:hover
{
	font-family:Arial, Helvetica, sans-serif;
	float:left; 
	text-align:left;
	font-size:14px;
	font-style:normal;
	color: #666666;
	text-decoration:none;
}

#tandc{
    color: #005CC0;
    font-size: 13px;
    text-decoration: none;
}
</style>

<div style=" float:left; width:100%;">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
        <tr height="5%">
        <td colspan="8">
        <img src="<?php echo MYSURL;?>graphics/logo.png" alt="logo" />
        	
        </td>
        </tr>

		    <tr height="5%">
			  <td colspan="8" style="text-align:right"><a href="javascript:void(0)" title="Print" onclick="window.print()" rel="nofollow" style="color:#003366; ">| Print |</a>
			  <a href="javascript:history.go(-1)" title="Go Back to the Yacht Report"  rel="nofollow" style="color:#003366; ">| Back |</a></td>
		    </tr>
</table >
</div>
<div style=" float:left; width:100%;">			

	
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="txt">
		    <tr height="5%">
			  <td colspan="8" ></td>
		    </tr>
			<tr class="tabheading">
				<td width="2%">Sr#</td>
                <td width="9%">Booking Number</td>
                <td width="9%">Booked by</td>
                <td width="9%">Customer Name</td>
                <td width="5%">Pick Up</td>
                <td width="5%">Drop Off</td>
                <td width="9%">yacht Days</td>
                <td width="7%">Commission % </td>
                <td width="5%">Results</td>
                <td width="9%">Orignal Amount &euro;</td>
                <td width="9%">Final Amount &euro;</td>
                <td width="9%">Commission Amount &euro;</td>
                <td width="9%">Notes</td>
                <!--<td width="10%">Options</td>-->
		    </tr>
			<?php
while(!$rs->EOF){
?>
			<tr <?php if($i%2==0){ ?> bgcolor="#E7DAE7"  <?php }else{ echo 'bgcolor="#FFFFFF"'; }?>>
						<td valign="top"><?php echo ++$i; ?></td>
                        <td valign="top"><?php echo $rs_limit->fields['bk_no_car']?></td>						
                        <td valign="top"><?php echo ucwords($rs_limit->fields['customer_name'])." ".ucwords($rs_limit->fields['customer_last_name']); ?></td>
                        <td valign="top"><?php echo ucwords($rs_limit->fields['customer_name'])." ".ucwords($rs_limit->fields['customer_last_name']); ?></td>											
                        <td valign="top"><?php echo date("F j Y",strtotime($rs_limit->fields['car_bk_stdare'])); ?></td>											
                        <td valign="top"><?php echo date("F j Y",strtotime($rs_limit->fields['car_bk_endate'])); ?></td>						
                        <td valign="top"><?php 
						$date1 = strtotime($rs_limit->fields['car_bk_stdare']);
						$date2 = strtotime($rs_limit->fields['car_bk_endate']);
						// Calculate the differences, they should be 43 & 11353
						echo count_days( $date1, $date2 );
						 ?></td>						
                        <td valign="top"><?php echo number_format($rs_limit->fields['commission'],2);
						        $sum_commission[]=$rs_limit->fields['commission'];
						 ?>%</td>											
                        <td valign="top"><?php //echo $rs_limit->fields['commission']; ?></td>	<!--here i will past the Result Code-->				
                        <td valign="top"><?php echo number_format($rs_limit->fields['rent'],2);
						$rent[]= $rs_limit->fields['rent'];//array
						 ?>&euro;</td>			
                        <td valign="top"><?php
						  $comm=(float) $rs_limit->fields['commission']/100;
						  $final=(float) ($comm*$rs_limit->fields['rent']);
						  $final_amount=$final+$rs_limit->fields['rent'];
						  echo number_format($final_amount,2);
						  $final_amount_i[]= $final_amount;//array
						  
						?>&euro;</td>	
                        <td valign="top"><?php
						  $comm=(float)$rs_limit->fields['commission']/100;
						  $comm=$comm*$rs_limit->fields['rent'];
						  echo number_format($comm,2);
						  $comm_i[] = $comm;//array
						?>&euro;</td>		
                        <td valign="top"></td>						
                         <td valign="top">&nbsp;</td><!--Note will come here-->			
						
						<!--<td valign="top">
							<a href="admin.php?act=editregion&amp;id=<?php //echo base64_encode($rs_limit->fields['id']);?>"><img src="<?php //MYSURL?>graphics/edit.gif" border="0" title="Edit" /></a>&nbsp;&nbsp;
							<a href="admin.php?act=manage_region&amp;mode=del_region&amp;id=<?php //echo base64_encode($rs_limit->fields['id']); ?>&amp;request_page=region_management" onClick="return confirm('Are you sure you want to Delete?')"><img src="<?php //MYSURL?>graphics/delete.gif" title="Delete" border="0" /></a>
                       </td>-->
					</tr>
			
<?php  $rs->MoveNext(); 
} ?>
</table>
</div>

<?php
exit();
?>
