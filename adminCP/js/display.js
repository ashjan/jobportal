// Don't pass in anything other than strings or nodes.
function $(o) {
	if (typeof(o) == "string")
		return document.getElementById(o)
	else
		return o;
}

DOM = {
	// Remove all the children of the given node
	nuke: function(id){
		var o=$(id); if (!o) return;
		while(0 < o.childNodes.length)
			o.removeChild(o.childNodes[0]);
	},
	
	before: function(id, node, nodeType){
		var o=$(id); if (!o) return;
		if (typeof(node) == "string"){
			var newNode = document.createElement(nodeType || "div")
			newNode.innerHTML = node
			node = newNode
		}
		o.parentNode.insertBefore(node, o)
	},
	
	after: function(id, node, nodeType){
		var o=$(id); if (!o) return;
		if (typeof(node) == "string"){
			var newNode = document.createElement(nodeType || "div")
			newNode.innerHTML = node
			node = newNode
		}
		o.parentNode.insertBefore(node, o.nextSibling)
	},
	
	// Sets the visibility of the given node
	set_visible: function(id,visible){
		if (visible) Display.show(id); else Display.hide(id)
	},
	
	// Hides the given node by setting CSS display: none
	hide: function(id){Display.show(id, "none")},
	// Displays the given node by clearing the CSS display property
	// This resets display: to the default value for that element type
	show: function(id, style){
		var o=$(id); if (!o) return;
		o.style.display = style || "";
	},
		
	// Toggle the visibility of the given node
	toggle: function(id){
		var o=$(id); if (!o) return;
		(o.style.display == "none") ? Display.show(o) : Display.hide(o)
	},
	
	// Enables the given node (useful for form elements.)
	enable: function(id){
		var o=$(id); if (!o) return;
		o.disabled="";
	},
		
	// Disables the given node (useful for form elements.)
	disable: function(id){
		var o=$(id); if (!o) return;
		o.disabled="disabled";
	},
	
	background: function(id, color){
		var o=$(id); if (!o) return;
		o.style.background=color
	}
}
