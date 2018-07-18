// JavaScript Document

						
	var showobj;
	function makeRequest(url,obj)
	{
		showobj=obj;
		var http_request = false;
			    if (window.XMLHttpRequest) { // Mozilla, Safari, ...
	
    	        http_request = new XMLHttpRequest();
	
    	        if (http_request.overrideMimeType) {
	
    	            http_request.overrideMimeType('text/xml');
        	    }

        	} else if (window.ActiveXObject) { // IE
	
    	        try {
	
    	            http_request = new ActiveXObject("Msxml2.XMLHTTP");
	
    	        } catch (e) {
	
    	            try {
	
    	                http_request = new ActiveXObject("Microsoft.XMLHTTP");
	
    	            } catch (e) {}

        	    }
	
    	    }
	
			if (!http_request) {
        	    alert('Giving up :( Cannot create an XMLHTTP instance');
            	return false;
	        }

    	    http_request.onreadystatechange = function() { alertContents(http_request); };

			if(navigator.appName == "Microsoft Internet Explorer"){
				 http_request.open('POST', url, true);
			 }else{
				 http_request.open('GET', url, true);
			 }
	        http_request.send(null);
    	}

	function alertContents(http_request) {
    	    if (http_request.readyState == 4) {
	
    	        if (http_request.status == 200) {
        	        document.getElementById(showobj).innerHTML =  http_request.responseText;
            	} else {
	                alert('There was a problem with the request.');
    	        }
        	}
			else{
				document.getElementById(showobj).innerHTML =  '';//loading image
			}
	
}
