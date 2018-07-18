// JavaScript Document
// THis files is used for searching of jobs in search corner



// this function is used to search jobs through ajax
function showrecord(a,b){
	// a parameter is for search title 
	// b parameter is location from where it is coming like relevance, time etc
	$('#data_dv').hide();
	$('#loader').show();
	if(a == ''){
		a = 'noparameterfortitle';
		}
	//alert(a);
	//alert(b);	
	var c	=	APPLICATION_URL+"welcome/custom_search/"+a+"/"+b;
	$.ajax({
			url: APPLICATION_URL+"welcome/custom_search/"+a+"/"+b,
			context: document.body,
			error: function(data, transport) { 
			//alert(c);
			alert("Sorry, the operation is failed.");
			
			
			 },
			success: function(data){
				
				$('#loader').hide();
				$('#ajax_data').html(data);
				if (b == 'relevance'){
					relevance_wise_search();

				}
				if (b == 'date'){
					date_wise_search();

				}
				if (b == 'lastday' || b == 'lastweek' || b == 'twoweek' || b == 'lastmonth' || b == 'anytime' ){
					
					resetalldatecolor();
					if(b == 'lastday'){
						$('#lastday').css({color:"#073E01",'text-decoration':'underline'});
						}
					else if(b == 'lastweek'){
						$('#lastweek').css({color:"#073E01",'text-decoration':'underline'});
						}
					else if(b == 'twoweek'){
						$('#twoweek').css({color:"#073E01",'text-decoration':'underline'});
						}
					else if(b == 'lastmonth'){
						$('#lastmonth').css({color:"#073E01",'text-decoration':'underline'});
						}
					else{
						$('#anytime').css({color:"#073E01",'text-decoration':'underline'});
						}	
				}
				
				if (b == 'part_time' || b == 'full_time' || b == 'all_times'){
					
					resetalljobtypecolor();
					if(b == 'part_time'){
						$('#part_time').css({color:"#073E01",'text-decoration':'underline'});
						}
					else if(b == 'full_time'){
						$('#full_time').css({color:"#073E01",'text-decoration':'underline'});
						}
						
				}
				
				if (b == 'carear_level_7' || b == 'carear_level_6' || b == 'carear_level_5' || b == 'carear_level_4' || b == 'carear_level_3' ){
					
					resetallcareercolor();
					if(b == 'carear_level_7'){
						$('#carear_level_7').css({color:"#073E01",'text-decoration':'underline'});
						}
					else if(b == 'carear_level_6'){
						$('#carear_level_6').css({color:"#073E01",'text-decoration':'underline'});
						}
					else if(b == 'carear_level_5'){
						$('#carear_level_5').css({color:"#073E01",'text-decoration':'underline'});
						}
					else if(b == 'carear_level_4'){
						$('#carear_level_4').css({color:"#073E01",'text-decoration':'underline'});
						}
					else if(b == 'carear_level_3'){
						$('#carear_level_3').css({color:"#073E01",'text-decoration':'underline'});
						}	
				}
			}
		});
	
	}
function resetalldatecolor(){
	
	$('#lastday').css({color:"#69696A",'text-decoration':'none'});
	$('#lastweek').css({color:"#69696A",'text-decoration':'none'});
	$('#twoweek').css({color:"#69696A",'text-decoration':'none'});
	$('#lastmonth').css({color:"#69696A",'text-decoration':'none'});
	$('#anytime').css({color:"#69696A",'text-decoration':'none'});
}

function resetalljobtypecolor(){
	$('#part_time').css({color:"#69696A",'text-decoration':'none'});
	$('#full_time').css({color:"#69696A",'text-decoration':'none'});
}
function resetallcareercolor(){
	$('#carear_level_3').css({color:"#69696A",'text-decoration':'none'});
	$('#carear_level_4').css({color:"#69696A",'text-decoration':'none'});
	$('#carear_level_5').css({color:"#69696A",'text-decoration':'none'});
	$('#carear_level_6').css({color:"#69696A",'text-decoration':'none'});
	$('#carear_level_7').css({color:"#69696A",'text-decoration':'none'});
}	



	
// this function is used to embed green dot in the relevenace title and embed blue dot in date title when user click on relevance wise search

function relevance_wise_search(){
	$('#Ellipse1_date').show();
	$('#Ellipse1copy_date').hide();
	$('#Ellipse1').hide();
	$('#Ellipse1copy').show();
}

// this function is used to embed green dot in the date title and embed blue dot in relevance title when user click on relevance wise search
function date_wise_search(){
	$('#Ellipse1_date').hide();
	$('#Ellipse1copy_date').show();
	$('#Ellipse1').show();
	$('#Ellipse1copy').hide();
}


function clear_search(){
	// a parameter is for search title 
	// b parameter is location from where it is coming like relevance, time etc
	$('#data_dv').hide();
	$('#loader').show();
	//a	=	encodeURIComponent(a);
	//alert(b);
	//alert('dasdasdas');
	$.ajax({
			//alert('dasdasdas');
			url: APPLICATION_URL+"welcome/clearsearchfilter",
			context: document.body,
			error: function(data, transport) { 
			//alert(url);
			alert("Sorry, the operation is failed."); },
			success: function(data){
				//document.getElementById('Ellipse1').innerHTML	=	blue_icon;
				//document.getElementById('Ellipse1copy').innerHTML	=	green_icon;
				//alert('dasdasdas');
				$('#loader').hide();
				//alert(data);
				$('#ajax_data').html(data);
				resetalldatecolor();
				resetallcareercolor();
				resetalljobtypecolor();
				
				
				
				
				
			}
		});	
	
	}
	
function showjobdescription(id){
	$('#dialog_job_print').dialog('open');
	showjob(id);
	return false;
}
$('#dialog_job_print').dialog({
	autoOpen: false,
	width:700,
	height:600,
	modal:true,
		
	buttons: {
		"Print": function() {
			window.print();
			},
		"Close": function() {
			$(this).dialog("close");
			},	
	}
});
function showjob(id){
	$.ajax({
			url: APPLICATION_URL+"welcome/showjobforprint/"+id,
			context: document.body,
			error: function(data, transport) { alert("Sorry, the operation is failed."); },
			success: function(data){
				//alert(data);
				$('#print_job').html(data);
			}
		});	
}

