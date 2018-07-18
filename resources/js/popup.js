// JavaScript Document
function showpopup(package_id){
	jQuery('#dialog_product_view').dialog('open');
	 var pack_id		=	package_id;
	jQuery.ajax({
	  	url: APPLICATION_URL+"welcome/showpopup/"+pack_id,
	  	context: document.body,
	  	error: function(data, transport) { 
			alert("No Response from the Server, Please click ok and try again.");
	  	},
	  	success: function(data){
			//alert(data);
			//document.getElementById('product_div').innerHTML = data;
			//jQuery('#product_diva').css("display","block");
			jQuery('#product_diva').html(data);
			
		}
	});
	return false;
}

jQuery('#dialog_product_view').dialog({
	autoOpen: false,
	width:800,
	height:550,
	modal:true,
		
	buttons: {
		"CLOSE": function() {
			jQuery(this).dialog("close");
			},
	}
});
