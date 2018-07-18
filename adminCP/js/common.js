function ajaxq(ui_id, ajaxurl, data_to_send){
	
	document.getElementById(ui_id).innerHTML = '';
	var div = jQuery("#"+ui_id);
	//alert('dasdas');
	jQuery.ajax ({
		type: "POST",
		url: ajaxurl,
		data: data_to_send,
		cache: false,
		success: function(data)
		{
			//alert('dasddasdsadadadaa');
			//document.getElementById(ui_id).style.display = 'block';
			div.hide();
			div.html(data);
			div.show();
			//div.show();
		}
	});
}

//---------------------------Function to calculate system fee -------------------------------------
/*function calculate_system_fee(divid,ajaxurl){
	var name_element = document.getElementById('site_amount').value;
	ajaxq(divid, ajaxurl+name_element, data_to_send = '');
}
*/
//------------------- for Category and Sub category -------------------------------------------
function get_sub_cat(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- for Category and Sub category -------------------------------------------
function get_agency_model(div_id, agn_id, ajaxurl,pm_id){
ajaxq(div_id, ajaxurl+"?id="+agn_id+"&pm_id="+pm_id, data_to_send = '');
}


//------------------- for Category and Sub category -------------------------------------------
function get_car_name(div_id, supid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+supid, data_to_send = '');
}
//----------------------------------- End ----------------------------------------------------


//------------------- for get car equipment-------------------------------------------
function get_car_equipment(div_id, supid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+supid, data_to_send = '');
}
//----------------------------------- End ----------------------------------------------------

function get_yacht_agency(div_id, supid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+supid, data_to_send = '');
}


//------------------- for Category and Sub category -------------------------------------------
function get_fac_name(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- for Car Facilities-------------------------------------------
function get_car_fac_name(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- for Car supplier-------------------------------------------
function get_yachtsuppliers(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//------------------- for Category and Sub category -------------------------------------------
function get_prop_name(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//------------------- for Category and Sub category -------------------------------------------
function get_prop_name_0(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//------------------- for Category and Sub category -------------------------------------------
function get_prop_name2(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- for Category and Sub category -------------------------------------------
function get_prop_name11(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- for Category and Sub category -------------------------------------------
function get_prop_name14(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//------------------- for Category and Sub category -------------------------------------------
function get_prop_name15(div_id, catid, ajaxurl){
	
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}


//------------------- for Category and Sub category -------------------------------------------
function get_prop_name16(div_id, catid, ajaxurl){
   ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}


//------------------- for Category and Sub category -------------------------------------------
function get_prop_name12(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- for Category and Sub category -------------------------------------------
function get_prop_name19(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- for Category and Sub category -------------------------------------------
function get_prop_name9(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

function get_pm_criteria(div_id, prop_id, ajaxurl,pm_id){
ajaxq(div_id, ajaxurl+"?prop_id="+prop_id+"&pm_id="+pm_id, data_to_send = '');
}

function get_agency_name(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
function get_agency_name1(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

function get_car_agency(div_id, pmid, ajaxurl){
	
    ajaxq(div_id, ajaxurl+"?pmid="+pmid, data_to_send = '');
}

function get_car_supplier(div_id, agn_id, ajaxurl){
    ajaxq(div_id, ajaxurl+"?agn_id="+agn_id, data_to_send = '');
}

function get_car_type1(div_id, get_car, ajaxurl){
    ajaxq(div_id, ajaxurl+"?agn_id="+get_car, data_to_send = '');
}


function get_car_type(div_id, sup_id, agn_id, ajaxurl){
	ajaxq(div_id, ajaxurl+"?sup_id="+sup_id, data_to_send = '');
}

function get_caragency_name(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

function get_supplier(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

function get_carsupplier(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

function get_yatches(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

function get_cars(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//------------------- for Category and Sub category -------------------------------------------
function get_prop_name5(div_id, catid, ajaxurl){
	//alert(div_id+' = '+catid+' = '+ajaxurl);
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- for Category and Sub category -------------------------------------------
function get_prop_name6(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//-------------for Category and sub category
function get_prop_name10(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//-------------for Category and sub category
function get_prop_name13(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- for PROP Name category -------------------------------------------
function get_prop_name1(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}



//------------------- for PROP Name category -------------------------------------------
function get_prop_name8(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}




//------------------- for Car Facilities -------------------------------------------
function get_car_facility(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- for PROP Name category -------------------------------------------
function get_agency_name(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//------------------- for PROP Name category -------------------------------------------
function get_prop_name3(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}




//------------------- for PROP Name category -------------------------------------------
function get_prop_name20(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}



function get_proprty_type(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- for Currency Country -------------------------------------------

function get_currency_name(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');

}


//------------------- for Category and Sub category -------------------------------------------
function get_accommadation(div_id, catid, ajaxurl){
if(catid=='24'){
	document.getElementById('stardiv').style.display = 'block';
}else{
	document.getElementById('stardiv').style.display = 'none';
}
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');

}

//------------------- for Category and Sub category -------------------------------------------
function get_facilities(div_id, catid, ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
	document.getElementById('display_selected').style.display = 'none';
}
function get_facilities_offline(div_id, catid, ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
	document.getElementById('display_selected').style.display = 'none';
}

//------------------- for Category and Sub category -------------------------------------------
function get_yacht_model(div_id, catid, ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- for Category and Sub category -------------------------------------------
function get_business_subtype(div_id, catid, ajaxurl){
	
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}


//------------------- for Category and Sub category -------------------------------------------
function get_businesssubtype(div_id, catid, ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}



//------------------- for Category and Sub category -------------------------------------------
function get_room_facilities(div_id, catid, ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
function get_room_facilities1(div_id, catid, ajaxurl,roomid){
	ajaxq(div_id, ajaxurl+"?id="+catid+"&roomid="+roomid, data_to_send = '');
}



//------------------- for Room type and Sub category -------------------------------------------
function get_room_type(div_id, catid, ajaxurl){
	
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}


//------------------- Media Manager online function for Room type and Sub category -------------------
function get_room_type_0(div_id, room_id, ajaxurl){
	
	ajaxq(div_id, ajaxurl+"?id="+room_id, data_to_send = '');
}
//------------------- Media Manager offline function for Room type and Sub category -------------------
function get_room_type_1(div_id, room_id, ajaxurl){
	
	ajaxq(div_id, ajaxurl+"?id="+room_id, data_to_send = '');
}
//------------------- Media Manager function for Room type and Sub category -------------------
function get_room_type1(div_id, catid, ajaxurl){
	
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}


//------------------- for Room weekoffer -------------------------------------------
function get_room_weekoffer(div_id, catid, ajaxurl){
	
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//------------------- for Room type and Sub category -------------------------------------------
function get_room_type10(div_id, catid, ajaxurl){
	
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}


//------------------- for Room type and Sub category -------------------------------------------
function get_room_type14(div_id, catid, ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}





//------------------- for Room type and Sub category -------------------------------------------
function get_room_type2(div_id, catid, ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//------------for Room type category and Sub Category
function get_room_type4(div_id, catid, ajaxurl,pm_id){
	ajaxq(div_id, ajaxurl+"?id="+catid+"&pm_id="+pm_id, data_to_send = '');
}
//------------for Room type category and Sub Category
function get_room_type5(div_id, catid, ajaxurl,pm_id){
	ajaxq(div_id, ajaxurl+"?id="+catid+"&pm_id="+pm_id, data_to_send = '');
}
//------------------- for Category and Sub category -------------------------------------------
function get_rates_overview(div_id, catid, ajaxurl){
	
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//------------------- for Category and Sub category -------------------------------------------
function get_rates_overview1(div_id, catid, ajaxurl,pm_id){
	alert(ajaxurl+"?id="+catid+"&pm_id="+pm_id);
	ajaxq(div_id, ajaxurl+"?id="+catid+"&pm_id="+pm_id, data_to_send = '');
	document.getElementById('newroomvalues').style.display='none';
}
//------------------- for Category and Sub category -------------------------------------------
function get_rates_overview2(div_id, catid, ajaxurl,pm_id){
	
	ajaxq(div_id, ajaxurl+"?id="+catid+"&pm_id="+pm_id, data_to_send = '');
	document.getElementById('newroomvalues').style.display='none';
}
//------------------- for Category and Sub category -------------------------------------------
function get_advance_rates_overview(div_id, catid, ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//------------------- for Category and Sub category -------------------------------------------
function get_yacht_facilities(div_id, catid, ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//---------------------------for Property Name
function get_propertyname(div_id, catid, ajaxurl){
	ajaxq(div_id,ajaxurl+"?id="+catid, data_to_send = '');
	}


//------------------- for Search content of a category -------------------------------------------
function search_content(div_id, propertymanagerid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+propertymanagerid, data_to_send = '');
}

//---------- Set no of rooms for a specific date ---------------------------------------------
function set_property_room_value(div_id,ajaxurl){
	    var style=document.getElementById('propertyroom').style.display;
	    
	    
	    document.getElementById('propertyroom').style.display='none';
	    
	    var rooms = document.getElementById('value_of_rooms').value;
		var pm_id = document.getElementById('value_pm_id').value;
		var property_id = document.getElementById('value_room_id').value;
		var date = document.getElementById('value_day').value;
		var room_type_id=document.getElementById('room_type_id').value;
		ajaxq(div_id,ajaxurl+"?rooms="+rooms+"&pm_id="+pm_id+"&property_id="+property_id+"&date="+date+"&room_type_id="+room_type_id,data_to_send="");
	

}
//---------- Set no of rooms for a specific date ---------------------------------------------
function set_property_room_value1(div_id,ajaxurl){
	    var style=document.getElementById('propertyroom').style.display;
	    
	    
	    document.getElementById('propertyroom').style.display='none';
	    
	    var rooms = document.getElementById('value_of_rooms1').value;
		var pm_id = document.getElementById('value_pm_id1').value;
		var property_id = document.getElementById('value_room_id1').value;
		var date = document.getElementById('value_day_id1').value;
		var room_type_id=document.getElementById('room_type_id').value;
		ajaxq(div_id,ajaxurl+"?rooms="+rooms+"&pm_id="+pm_id+"&property_id="+property_id+"&date="+date+"&room_type_id="+room_type_id,data_to_send="");
}


function set_property_room_value2(div_id,ajaxurl){
	    var style=document.getElementById('propertyroom').style.display;
	    
	    
	    document.getElementById('propertyroom').style.display='none';
	    
	    var rooms = document.getElementById('value_of_rooms').value;
		var pm_id = document.getElementById('value_pm_id').value;
		var property_id = document.getElementById('value_room_id').value;
		var day = document.getElementById('value_day').value;
		var room_type_id=document.getElementById('room_type_id').value;
		ajaxq(div_id,ajaxurl+"?rooms="+rooms+"&pm_id="+pm_id+"&property_id="+property_id+"&date="+day+"&room_type_id="+room_type_id,data_to_send="");
	

}
//--------------------------------------------- End ------------------------------------------

function page_type(value){	
	var value2='';
	var value1='';
	var value3='';
	 if(value=='content_type'){
	  value2= "page_title";
	  value3= "page_description";
	  value1="content_type";
	  }else if(value=="category_type"){
	  value2= "category_title";
  	  value1= "category_type";
	  }else if(value=="event_type"){
	  value2= "page_title";
	  value3= "page_description";
  	  value1= "event_type";
	  }else if(value=="popular_destination"){
	  value2= "page_title";
	  value3= "popular_destination_description";
  	  value1= "popular_destination";
	  }else if(value=="feature_type"){
	  value2= "feature_title";
	  value3= "feature_description";
  	  value1= "feature_type";
	  }else if(value=="facility_type"){
	  value2= "facility_title";
	  value3= "facility_description";
  	  value1= "facility_type";
	  }else if(value=="cate_type"){
	  value2= "cate_title";
	  value3= "cate_description";
  	  value1= "cate_type";
	  }else if(value=="property_type"){
	  value2= "property_title";
	  value3= "property_description";
  	  value1= "property_type";
	  }else if(value=="landmark_type"){
	  value2= "landmark_title";
	  value3= "landmark_description";
  	  value1= "landmark_type";
	  }else if(value=="menu_footer_type"){
	  value2= "menu_title";
	  value3= "menu_description";
  	  value1= "menu_footer_type";
	  }else if(value=="feature_type"){
	  value2= "menu_title";
	  value3= "feature_description";
  	  value1= "feature_type";
	  }
	  
	  var myValue=new Array();
	  myValue.length=0;
	  myValue=Array(value2,value3);
	  document.getElementById('field_name').value='';
	  document.getElementById('field_name').innerHTML = "";
	
	var select = document.getElementById("field_name");

	for(index in myValue) {
	    select.options[select.options.length] = new Option(myValue[index], myValue[index]);
	}
	  
      document.getElementById('page_type').value=value1;
	}

//--------------------------------------------- End ------------------------------------------

function page_type_edit(value,value4){	
	var value2='';
	var value1='';
	var value3='';
	 if(value=='content_type'){
	  value2= "page_title";
	  value3= "page_description";
	  value1="content_type";
	  }else if(value=="category_type"){
	  value2= "category_title";
  	  value1= "category_type";
	  }else if(value=="event_type"){
	  value2= "page_title";
	  value3= "page_description";
  	  value1= "event_type";
	  }else if(value=="popular_destination"){
	  value2= "page_title";
	  value3= "popular_destination_description";
  	  value1= "popular_destination";
	  }else if(value=="feature_type"){
	  value2= "feature_title";
	  value3= "feature_description";
  	  value1= "feature_type";
	  }else if(value=="facility_type"){
	  value2= "facility_title";
	  value3= "facility_description";
  	  value1= "facility_type";
	  }else if(value=="cate_type"){
	  value2= "cate_title";
	  value3= "cate_description";
  	  value1= "cate_type";
	  }else if(value=="property_type"){
	  value2= "property_title";
	  value3= "property_description";
  	  value1= "property_type";
	  }else if(value=="landmark_type"){
	  value2= "landmark_title";
	  value3= "landmark_description";
  	  value1= "landmark_type";
	  }else if(value=="menu_footer_type"){
	  value2= "menu_title";
	  value3= "menu_description";
  	  value1= "menu_footer_type";
	  }else if(value=="feature_type"){
	  value2= "menu_title";
	  value3= "feature_description";
  	  value1= "feature_type";
	  }
	  
	  var myValue=new Array();
	  myValue.length=0;
	  myValue=Array(value2,value3);
	  document.getElementById('field_name').value='';
	  document.getElementById('field_name').innerHTML = "";
	
	var select = document.getElementById("field_name");

	for(index in myValue) {
		/*if(myValue[index]!=value4){
		selectObject.selectedIndex=index;
		select.options[select.options.length.options.selectedIndex] = new Option(myValue[index], myValue[index]);
		}else{}*/
	    select.options[select.options.length] = new Option(myValue[index], myValue[index]);
		
	}
	  
      document.getElementById('page_type').value=value1;
	}


//--------------------------------------------- End ------------------------------------------



function removeCityImagesElement(divNum) {
  
  var d = document.getElementById('dynamicInput');
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
  
	var numi = document.getElementById('theValue');
	var num = document.getElementById("theValue").value;
	numi.value = num-1;  
  
} // removeUplaodFileElement()	
function addImage() {
	var ni = document.getElementById('dynamicInput');
	var numi = document.getElementById('theValue');
	var num = (document.getElementById("theValue").value -1)+ 2;
	numi.value = num;
	var divIdName = "my"+num+"Div";
	var newdiv = document.createElement('div');
	newdiv.setAttribute("id",divIdName);
newdiv.innerHTML = '<div class="clear"></div><div id='+divIdName+'><div class="image_div_title">image</div><div class="image_div_title_text"><input type="file" name="image['+num+']" id="image['+num+']" /><a href="javascript:;"style="text-decoration:none;font-weight:bold" onclick=removeCityImagesElement("'+divIdName+'") >[Remove]</a></div><div class="clear"></div>';		
ni.appendChild(newdiv);

} // addUploadFileEvent()	

function changeValue(selectid,id){
	var val=$('#'+selectid).val();
	if(val==0){
	$('#'+id).hide('slow', function() {
     });
	}else{
		$('#'+id).show('fast', function() {
	   });
	}
}

function price_availability(selectid,id){
	
	var val=$('#'+selectid).val();
	
	if(val==0){
	$('#'+id).hide('slow', function() {
     });
	}else{
		$('#'+id).show('fast', function() {
	   });
	}
}

function footer_menu_position(act, mode, request_page, id, changevalue){
	window.location="admin.php?act="+act+"&mode="+mode+"&request_page="+request_page+"&id="+id+"&changevalue="+changevalue;
	return false;
}
function event_open_video_opts(valuestr){

	if(valuestr=="1"){
		document.getElementById("video_panel_url").style.display="block";
		document.getElementById("video_panel_upload").style.display="none";
	}else if(valuestr=="0"){
		document.getElementById("video_panel_url").style.display="none";
		document.getElementById("video_panel_upload").style.display="block";
	}else{
		return false;
	}
}


function get_weekdays(isprflag)
{

	if(isprflag=="1")
	{
		document.getElementById("weekdays").style.display="block";
	}
	else
	{
		return false;
	}
}


function open_text_box(pm_id,property_room_id,no_of_rooms,day,property_id,rate_id){
	     
	   
		var style=document.getElementById('propertyroom').style.display;
	    document.getElementById('value_property_id').value=property_id;
	    document.getElementById('textbox').style.display='block';
		document.getElementById('value_of_rooms').value=no_of_rooms;
		document.getElementById('value_pm_id').value=pm_id;
		document.getElementById('value_room_id').value=property_room_id;
		document.getElementById('value_day').value=day;
		document.getElementById('value_rate_id').value =rate_id;
		
		
}
function open_text_box1(pm_id,property_room_id,no_of_rooms,day){
	     
	    
	    document.getElementById('textbox1').style.display='block';
		document.getElementById('value_of_rooms1').value=no_of_rooms;
		document.getElementById('value_pm_id1').value=pm_id;
		document.getElementById('value_room_id1').value=property_room_id;
		document.getElementById('value_day_id1').value=day;
				
}
function open_text_box2(pm_id,property_room_id,no_of_rooms,day,month,year){
	     
	    var date=month+'/'+day+'/'+year;
		var style=document.getElementById('propertyroom').style.display;
	    
	    document.getElementById('textbox').style.display='block';
		document.getElementById('value_of_rooms').value=no_of_rooms;
		document.getElementById('value_pm_id').value=pm_id;
		document.getElementById('value_room_id').value=property_room_id;
		document.getElementById('value_date_id').value=date;
		
}
function open_text_box3(pm_id,property_room_id,no_of_rooms,day,month,year){
	     
	    var date=month+'/'+day+'/'+year;
		var style=document.getElementById('propertyroom').style.display;
	    
	    document.getElementById('textbox1').style.display='block';
		document.getElementById('value_of_rooms1').value=no_of_rooms;
		document.getElementById('value_pm_id1').value=pm_id;
		document.getElementById('value_room_id1').value=property_room_id;
		document.getElementById('value_date_id1').value=date;
		
}
function getproperty(divid,ajaxurl,counter_skills){
	ajaxurl=ajaxurl+'/'+counter_skills;
	ajaxq(divid, ajaxurl, data_to_send = '');
}
function is_checked()
{
	value = document.getElementById('credit_card_accepted').value;
	checked = document.getElementById('credit_card_accepted').checked;
	if(value==0 && checked==true){
		document.getElementById('credit_card').style.display='none';
	}else {
		document.getElementById('credit_card').style.display='block';
	}
}



function toggle(div_id) {
	var el = document.getElementById(div_id);
	if ( el.style.display == 'none' ) {	el.style.display = 'block';}
	else {el.style.display = 'none';}
}
function blanket_size(popUpDivVar) {


	if (typeof window.innerWidth != 'undefined') {
		viewportheight = window.innerHeight;
	} else {
		viewportheight = document.documentElement.clientHeight;
	}
	if ((viewportheight > document.body.parentNode.scrollHeight) && (viewportheight > document.body.parentNode.clientHeight)) {
		blanket_height = viewportheight;
	} else {
		if (document.body.parentNode.clientHeight > document.body.parentNode.scrollHeight) {
			blanket_height = document.body.parentNode.clientHeight;
		} else {
			blanket_height = document.body.parentNode.scrollHeight;
		}
	}
	var blanket = document.getElementById('blanket');
	blanket.style.height = blanket_height + 'px';
	var popUpDiv = document.getElementById(popUpDivVar);
	popUpDiv_height=200/2-275; /*  150 is half popups height*/
	popUpDiv.style.top = popUpDiv_height + 'px';
}
function window_pos(popUpDivVar) {
	if (typeof window.innerWidth != 'undefined') {
		viewportwidth = window.innerHeight;
	} else {
		viewportwidth = document.documentElement.clientHeight;
	}
	if ((viewportwidth > document.body.parentNode.scrollWidth) && (viewportwidth > document.body.parentNode.clientWidth)) {
		window_width = viewportwidth;
	} else {
		if (document.body.parentNode.clientWidth > document.body.parentNode.scrollWidth) {
			window_width = document.body.parentNode.clientWidth;
		} else {
			window_width = document.body.parentNode.scrollWidth;
		}
	}
	var popUpDiv = document.getElementById(popUpDivVar);
	window_width=550/2-275;
	popUpDiv.style.left = window_width + 'px';
}



function popup(windowname) {
	blanket_size(windowname);
	window_pos(windowname);
	toggle('blanket');
	toggle(windowname);		
}

function show_terms(){
	var terms= document.getElementById('terms').style.display;
	if(terms=='block'){
	   document.getElementById('terms').style.display = 'none';	
	}else{
	   document.getElementById('terms').style.display = 'block';
	}
}

function show_terms1(){
	var terms1= document.getElementById('terms1').style.display;
	if(terms1=='block'){
	   document.getElementById('terms1').style.display = 'none';	
	}else{
	   document.getElementById('terms1').style.display = 'block';
	}
}

function close_terms(){
	document.getElementById('terms').style.display = 'none';
}
//show div
function show_div(div,selectBox){
		document.getElementById(div).style.display ='block';
		var getSelectedIndex = document.managecontentfrm.selectBox.selectedIndex;
	    //var getSelectedOptionText = document.managecontentfrm.selectBox[getSelectedIndex].text;
	    alert(getSelectedIndex);
}


//------------------- PDF  files for Non-accommodation properties  -------------
function get_prop_pdf(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//---------------------------   ASHFAQ  	------------------------------


// get_prop_name_weekoffer
function get_prop_name_weekoffer(div_id, catid,  ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

// get_prop_name22
function get_prop_name22(div_id, catid,  ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}


// get_rates
function get_rates(div_id, catid, propid, pm_id, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid+"&propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}
//---------------------------- VAT and TAX Charges offline  --------------------------------------

function get_prop_vat_nam1(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//---------------------------- VAT and TAX Charges   --------------------------------------

function get_prop_vat_nam(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

function get_edit_prop_name(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

// get_rates
function get_rates_vat_tax(div_id, propid, pm_id, ajaxurl){
ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_rates_vat_tax
function get_rates_vat_tax1(div_id, propid, pm_id, ajaxurl){
ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

//---------------------------------------------------------------------------------------
// get_rates1
function get_rates1(div_id, catid, propid, pm_id, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid+"&propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_rooms
function get_rooms(div_id, propid, pm_id, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_rooms1
function get_rooms1(div_id, propid, pm_id, ajaxurl){

ajaxq(div_id, ajaxurl+"?id="+propid+"&pm_id="+pm_id, data_to_send = '');
}
// get_prop_name23
function get_prop_name23(div_id, catid,  ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}


// get_prop_name24
function get_prop_name24(div_id, catid,  ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}


// get_prop_name25
function get_prop_name25(div_id, catid,  ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}


// get_prop_name27
function get_prop_name27(div_id, catid,  ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
// get_prop_name_image
function get_prop_name_image(div_id, catid,  ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

// get_prop_name_image1
function get_prop_name_image1(div_id, catid,  ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

// get_prop_media_nam_image
function get_prop_media_nam_image(div_id, catid,  ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

// get_rooms_pm_image
function get_room_pm1(div_id, propid, pm_id, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_rooms_pm
function get_room_pm(div_id, propid, pm_id, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+propid+"&pm_id="+pm_id, data_to_send = '');
}


// get_rates_room
function get_rate_room(div_id, rooms_id1, propid, pm_id, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+rooms_id1+"&propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}


// get_rates_room_images
function get_rate_room1(div_id, catid, propid, pm_id, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid+"&propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_prop_video
function get_prop_video(div_id, catid,  ajaxurl){
	//alert(div_id+' = '+catid+' = '+ajaxurl);
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

// get_prop_video1
function get_prop_video1(div_id, catid,  ajaxurl){
	//alert(div_id+' = '+catid+' = '+ajaxurl);
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

// get_rooms_pm_videos
function get_room_pm_vidoes(div_id, propid, pm_id, ajaxurl){
	//alert(div_id+' = '+propid+' = '+ajaxurl +' = '+pm_id);
ajaxq(div_id, ajaxurl+"?id="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_rooms_pm_videos
function get_room_pm_vidoes1(div_id, propid, pm_id, ajaxurl){
	//alert(div_id+' = '+propid+' = '+ajaxurl +' = '+pm_id);
ajaxq(div_id, ajaxurl+"?id="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_rates_room_videos
function get_rates_room_videos(div_id, catid, propid, pm_id, ajaxurl){
	//alert(div_id+' = '+propid+' = '+ajaxurl +' = '+pm_id+'='+catid);
    ajaxq(div_id, ajaxurl+"?id="+catid+"&propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_rates_room_videos
function get_rates_room_videos1(div_id, catid, propid, pm_id, ajaxurl){
	//alert(div_id+' = '+propid+' = '+ajaxurl +' = '+pm_id+'='+catid);
    ajaxq(div_id, ajaxurl+"?id="+catid+"&propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_prop_topoffer
function get_prop_topoffer(div_id, catid,  ajaxurl){
	//alert('div_id ='+div_id+' :: catid ='+catid+' :: ajaxurl '+ajaxurl);
    ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

// get_prop_topoffer
function get_prop_topoffer1(div_id, catid,  ajaxurl){
	//alert('div_id ='+div_id+' :: catid ='+catid+' :: ajaxurl '+ajaxurl);
    ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

// get_rates

function get_topoffer(div_id, propid, pm_id, ajaxurl){
	
    ajaxq(div_id, ajaxurl+"?pm_id="+pm_id+"&propid="+propid, data_to_send = '');
}

function get_topoffer1(div_id, propid, pm_id, ajaxurl){
	
    ajaxq(div_id, ajaxurl+"?pm_id="+pm_id+"&propid="+propid, data_to_send = '');
}
//-------------------------  VAT and TAX Charges online  -------------------------
// get_vat_and_tax
 function get_vat_and_tax(div_id, catid,  ajaxurl){
	//alert('div_id ='+div_id+' :: catid ='+catid+' :: ajaxurl '+ajaxurl);
    ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

function get_vat_tax(div_id, propid, pm_id, ajaxurl){
	   //alert(div_id+'='+ propid+'='+pm_id+'='+ajaxurl);
	    ajaxq(div_id, ajaxurl+"?pm_id="+pm_id+"&propid="+propid, data_to_send = '');
}

//-------------------------  VAT and TAX Charges offline  -------------------------
 function get_vat_and_tax1(div_id, catid,  ajaxurl){
	    ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}


function get_vat_tax1(div_id, propid, pm_id, ajaxurl){
	  	    ajaxq(div_id, ajaxurl+"?pm_id="+pm_id+"&propid="+propid, data_to_send = '');
}

// get_prop_room
function get_prop_room(div_id, catid,  ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

// get_rooms_managment
function get_room_manag(div_id, propid, pm_id, ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+propid+"&pm_id="+pm_id, data_to_send = '');

}

// get_rates_room_manag
function get_rates_room_manag(div_id, catid, propid, pm_id, ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+catid+"&propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_prop_room_managment
function get_prop_room1(div_id, catid,  ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
// get_rooms_managment1
function get_room_manag1(div_id, propid, pm_id, ajaxurl){
    ajaxq(div_id, ajaxurl+"?id="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_rates_room_manag1
function get_rates_room_manag1(div_id, catid, propid, pm_id, ajaxurl){
	     ajaxq(div_id, ajaxurl+"?id="+catid+"&propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_prop_change_request
function get_prop_change_request(div_id, catid,  ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}


// get_change_request
function get_change_request(div_id, propid, pm_id, ajaxurl){
	ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

/////////////////////////////// Online Property policy /////////////////////////////////

// get_prop_property
function get_prop_property(div_id, propid,  ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+propid, data_to_send = '');
}


// get_prop_property_policy
function get_prop_property_policy(div_id, propid, pm_id, ajaxurl){
	ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_manage_property_policy
function get_manage_property_policy(div_id, rooms_id1, propid, pm_id, ajaxurl){	
		ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id+"&rooms_id1="+rooms_id1, data_to_send = '');
}

/////////////////////////////// offline Property policy1 /////////////////////////////////

// get_prop_property
function get_prop_property1(div_id, propid,  ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+propid, data_to_send = '');
}

// get_prop_property_policy
function get_prop_property_policy1(div_id, propid, pm_id, ajaxurl){
	ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_manage_property_policy
function get_manage_property_policy1(div_id, rooms_id1, propid, pm_id, ajaxurl){	
		ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id+"&rooms_id1="+rooms_id1, data_to_send = '');
}

//-------------------------  WAQAS ------------------------------------

//-------------------------  offline invoice  -------------------------

// get Properties for offline_invoice
function get_property_offline_invoice(div_id, pm_id,  ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+pm_id, data_to_send = '');
}

// get_offline_invoice
function get_offline_invoice(div_id, propid, pm_id, ajaxurl){
	ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

//------------------------- online invoice -----------------------------

// get Properties for online_invoice
function get_property_online_invoice(div_id, pm_id,  ajaxurl){	
	ajaxq(div_id, ajaxurl+"?id="+pm_id, data_to_send = '');
}

// get_online_invoice
function get_online_invoice(div_id, propid, pm_id, ajaxurl){
	ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}
//------------------------- Discount Management -------------------------

function get_prop_dis_name(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

// get_prop_discount
function get_prop_discount(div_id, propid,  ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+propid, data_to_send = '');
}

// get_prop_room_discount
function get_prop_room_discount(div_id, propid, pm_id, ajaxurl){
	ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_discount_management
function get_discount_management(div_id,rooms_id1, propid, pm_id,  ajaxurl){	
	ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id+"&rooms_id1="+rooms_id1, data_to_send = '');
}

//---------------------- Online Bedding Types -------------------------

function get_add_prop_name_0(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//
function get_edit_bed_prop_nam(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

// get_prop_bedding
function get_prop_bedding(div_id, propid,  ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+propid, data_to_send = '');
}

// get_prop_bedding_types
function get_prop_bedding_types(div_id, propid, pm_id, ajaxurl){
	ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_manage_bedding
function get_manage_bedding(div_id, rooms_id1, propid, pm_id, ajaxurl){	
		ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id+"&rooms_id1="+rooms_id1, data_to_send = '');
}

//------------------------- offline Bedding Types  ------------------------

function get_edit_prop_nam_0(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//
function get_add_prop_name_1(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

// get_prop_bedding1
function get_prop_bedding1(div_id, propid,  ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+propid, data_to_send = '');
}

// get_prop_bedding_types1
function get_prop_bedding_types1(div_id, propid, pm_id, ajaxurl){
	ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

// get_manage_bedding1
function get_manage_bedding1(div_id, rooms_id1, propid, pm_id, ajaxurl){	
		ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id+"&rooms_id1="+rooms_id1, data_to_send = '');
}

//------------------------- Manage Minimum Stay -------------------------

// get_prop_minimu_stay
function get_prop_minimu_stay(div_id, propid,  ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+propid, data_to_send = '');
}

// get_prop_room_minimu_stay
function get_prop_room_minimu_stay(div_id, propid, pm_id, ajaxurl){
	ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id, data_to_send = '');
	
}

// get_manage_minimu_stay
function get_manage_minimu_stay(div_id, rooms_id1, propid, pm_id, ajaxurl){	
		ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id+"&rooms_id1="+rooms_id1, data_to_send = '');
}

//------------------------- Manage Property Commision  -----------------------

function get_prop_com_add(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

// get_prop_comm
function get_prop_comm(div_id, propid,  ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+propid, data_to_send = '');
}

// get_prop_commssion
function get_prop_commssion(div_id, propid, pm_id, ajaxurl){
	ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

//-------------------------  Report management  ------------------------
// get_prop_repo_mang
function get_prop_repo_mang(div_id, pm_id,  ajaxurl){	
	ajaxq(div_id, ajaxurl+"?id="+pm_id, data_to_send = '');
}

// get_report_mang
function get_report_mang(div_id, propid, pm_id, ajaxurl){
	ajaxq(div_id, ajaxurl+"?propid="+propid+"&pm_id="+pm_id, data_to_send = '');
}

//------------------- add form function Room management --------------------
function get_prop_room_nam(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- Edit form function Room management --------------------
function get_edit_room_prop_name(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}


//------------------- Edit form function Room management --------------
function get_edit_policy_pro_nam(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- Edit form function Room management --------------
function get_ad_pol_pro_nam(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- for Category and Sub category -------------------

function get_prop_name_edit(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- Add Vat text prop name offline ------------------

function get_prp_vat_edit(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
//------------------- Add Vat TAX prop name offline -------------------
function get_prp_vat_edit_on(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- for Category and Sub category ------------------
function get_prop_nam_fac_add(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- Minimum Stay edit property function  ------------
function get_prop_nam_edit(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- Rate Management Property Name  -------------------

// get_prop_name_rate
function get_prop_name_rate(div_id, catid,  ajaxurl){
	
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------ room facility management offline pm for add-----------------

function get_prop_name_facility(div_id, catid, ajaxurl){
	//alert(div_id+' = '+catid+' = '+ajaxurl);
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//-------------------  room facility management  ---------------------
function get_room_facility_offline(div_id, catid, ajaxurl){
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- Media image Edit PM Online ----------------------
function get_media_pn_online(div_id, catid, ajaxurl){
ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

//------------------- Media Manager function for Room type -------------
function get_room_media(div_id, catid, ajaxurl){
	
	ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}

function get_users_type_filter(div_id, catid, ajaxurl){
    ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
function get_user_status_filter(div_id, catid, ajaxurl){
	//alert(catid);
    ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
function get_company_status_filter(div_id, catid, ajaxurl){
	//alert(catid);
    ajaxq(div_id, ajaxurl+"?id="+catid, data_to_send = '');
}
