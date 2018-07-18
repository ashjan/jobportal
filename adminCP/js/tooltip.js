// Extended Tooltip Javascript
// copyright 9th August 2002, 3rd July 2005
// by Stephen Chapman, Felgall Pty Ltd

// permission is granted to use this javascript provided that the below code is not altered
var DH = 0;
var an = 0;
var al = 0;
var ai = 0;
if (document.getElementById) {
    ai = 1;
    DH = 1;
} else {
    if (document.all) {
        al = 1;
        DH = 1;
    } else {
        browserVersion = parseInt(navigator.appVersion);
        if ((navigator.appName.indexOf('Netscape') != -1) && (browserVersion == 4)) {
            an = 1;
            DH = 1;
        }
    }
}
function fd(oi, wS) {
    if (ai) return wS ? document.getElementById(oi).style : document.getElementById(oi);
    if (al) return wS ? document.all[oi].style : document.all[oi];
    if (an) return document.layers[oi];
}

function pw() {
    return window.innerWidth != null ? window.innerWidth : document.body.clientWidth != null ? document.body.clientWidth : null;
}

function mouseX(evt) {
    if (evt.pageX) return evt.pageX;
    else if (evt.clientX) return evt.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
    else return null;
}

function mouseY(evt) {
    if (evt.pageY) return evt.pageY;
    else if (evt.clientY) return evt.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
    else return null;
}


function popUp(evt, oi,rate,pm_id,room_id,date_s,property_id,rates_id,rooms,standard_rate_id) {
	
	document.getElementById('change_standard_rate_id').value = standard_rate_id;
	document.getElementById('change_rate').value = rate;
	document.getElementById('change_pm').value = pm_id;
	document.getElementById('change_room_id').value = room_id;
	document.getElementById('change_date').value = date_s;
	document.getElementById('change_property_id').value = property_id;
	document.getElementById('change_rates_id').value = rates_id;
	document.getElementById('change_rates_rooms').value = rooms
	document.getElementById('change_rate_start_date').value = date_s;
	
	
    if (DH) {
        var wp = pw();
        ds = fd(oi, 1);
        dm = fd(oi, 0);
        st = ds.visibility;
        if (dm.offsetWidth) ew = dm.offsetWidth;
        else if (dm.clip.width) ew = dm.clip.width;
        if (st == "visible" || st == "show") {
            ds.visibility = "hidden";
        } else {
            tv = mouseY(evt) + 20;
            lv = mouseX(evt) - (ew / 4);
            if (lv < 2) lv = 2;
            else if (lv + ew > wp) lv -= ew / 2;
            if (!an) {
                lv += 'px';
                tv += 'px';
            }
            ds.left = lv;
            ds.top = tv;
            ds.visibility = "visible";
        }
    }
}

function popUp1(evt, oi,pm_id,room_type_id,date_s,property_id,rate_id,rooms) {
	
	
	document.getElementById('change_rooms_id').value = rooms;
	document.getElementById('change_pm_id').value = pm_id;
	document.getElementById('change_room_type_id').value =room_type_id;
	document.getElementById('change_properties_id').value = property_id;
	document.getElementById('change_rate_id').value = rate_id;
	document.getElementById('change_room_start_date').value = date_s;
	
	
    if (DH) {
        var wp = pw();
        ds = fd(oi, 1);
        dm = fd(oi, 0);
        st = ds.visibility;
        if (dm.offsetWidth) ew = dm.offsetWidth;
        else if (dm.clip.width) ew = dm.clip.width;
        if (st == "visible" || st == "show") {
            ds.visibility = "hidden";
        } else {
            tv = mouseY(evt) + 20;
            lv = mouseX(evt) - (ew / 4);
            if (lv < 2) lv = 2;
            else if (lv + ew > wp) lv -= ew / 2;
            if (!an) {
                lv += 'px';
                tv += 'px';
            }
            ds.left = lv;
            ds.top = tv;
            ds.visibility = "visible";
        }
    }
}