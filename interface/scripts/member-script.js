function validateAndSendMemberForm(formId) {
	
	var form = document.getElementById(formId);
	
	var member_phone_input = form.getElementsByTagName('input')[0];
	var member_mobile_input = form.getElementsByTagName('input')[1];
	var regex = /^[+]?[0-9]{0,4}[/\.-\s]*([(][/\.-\s]*[0-9]{1,4}[/\.-\s]*[)])?[-\s\./0-9]*$/g;
	// Matching numbers that may contain zero or one + followed by zero to four digit number, followed by zero
	// or more slashes, dots, minuses or spaces followed by combination of one bracket, zero or more slashes,
	// dots, minuses or spaces, with one to four digits, and with zero or more slashes, dots, minuses and spaces 
	// and one closed bracket. Mentoned combination might appear zero or one time, and it is followed by zero or
	// more minuses, spaces, dots or slashes and numbers. Regex will not work for partially matched numbers but 
	// only for fully matched number. Matching is done with march(regex) function. Match all instances of the 
	// regex pattern in a string.
			
	if(member_phone_input.value.trim().length == 0){
		member_phone_input.value = '';
		member_phone_input.nextElementSibling.innerHTML = 'Member phone number is empty!';
	}
	else{
		member_phone_input.nextElementSibling.innerHTML = '';
		if(!new RegExp(regex).test(member_phone_input.value.trim())){
			member_phone_input.value = '';
			member_phone_input.nextElementSibling.innerHTML = 'Not valid phone number!';
		}
	}
	if(member_mobile_input.value.trim().length == 0){
		member_mobile_input.value = '';
		member_mobile_input.nextElementSibling.innerHTML = 'Member mobile number is empty!';
	}
	else{
		member_mobile_input.nextElementSibling.innerHTML = '';
		if(!new RegExp(regex).test(member_mobile_input.value.trim())){
			member_mobile_input.value = '';
			member_mobile_input.nextElementSibling.innerHTML = 'Not valid phone number!';
		}
	}
	if(member_phone_input.nextElementSibling.innerHTML.length == 0 && member_mobile_input.nextElementSibling.innerHTML.length == 0){
		var user_select = form.getElementsByTagName('select')[0];
		var options_length = user_select.options.length;
		if(options_length > 0){
			sendMemberData(formId);
		}
		else{
			alert("No more new users are available at this time!");
		}
	}
}

function sendMemberData(formId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var form = document.getElementById(formId);
	
	var member_phone_input = form.getElementsByTagName('input')[0];
	var member_mobile_input = form.getElementsByTagName('input')[1];
	var user_select = form.getElementsByTagName('select')[0];
	var user_id = user_select.options[user_select.selectedIndex].value;
	var address_select = form.getElementsByTagName('select')[1];
	var address_id = address_select.options[address_select.selectedIndex].value;	
	var member_notes = form.getElementsByTagName('textarea')[0];
	
	var params = 'member-phone-input='+member_phone_input.value+'&member-mobile-input='+member_mobile_input.value+'&id-user='+user_id+"&id-address="+address_id+"&notes="+member_notes.value;	
		
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var new_table = getElement("table",this.responseText);
			var old_table = document.getElementById("table");
			document.getElementById("datagrid").replaceChild(new_table,old_table);
			var new_nav_span = getElement("table-nums",this.responseText).firstChild;
			var old_nav_span = document.getElementById("table-nums").firstChild;
			document.getElementById("table-nums").replaceChild(new_nav_span,old_nav_span);
			var message = getElement("message",this.responseText).innerHTML;
			member_phone_input.value = '';
			member_mobile_input.value = '';
			member_notes.value = '';
			user_select.remove(user_select.selectedIndex); 
			user_select.selectedIndex = 0;
			address_select.selectedIndex = 0;
			alert(message);
		}
	};
	
	xhttp.open('POST', 'membership-management.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params); 
	
}

function sendUpdatedMemberData(formId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var form = document.getElementById(formId);
	
	var member_id_input = form.getElementsByTagName('input')[0];
	var member_phone_input = form.getElementsByTagName('input')[1];
	var member_mobile_input = form.getElementsByTagName('input')[2];
	var member_to_input = form.getElementsByTagName('input')[3];
	var address_select = form.getElementsByTagName('select')[0];
	var address_id = address_select.options[address_select.selectedIndex].value;	
	var member_notes = form.getElementsByTagName('textarea')[0];
	
	var params = 'id-member='+member_id_input.value+'&member-phone-input='+member_phone_input.value+'&member-mobile-input='+member_mobile_input.value+'&member-to='+member_to_input.value+"&id-address="+address_id+"&notes="+member_notes.value;
		
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var new_table = getElement("table",this.responseText);
			var old_table = document.getElementById("table");
			document.getElementById("datagrid").replaceChild(new_table,old_table);
			var new_nav_span = getElement("table-nums",this.responseText).firstChild;
			var old_nav_span = document.getElementById("table-nums").firstChild;
			document.getElementById("table-nums").replaceChild(new_nav_span,old_nav_span);
			var message = getElement("message",this.responseText).innerHTML;
			alert(message);
		}
	};
	
	xhttp.open('POST', 'membership-management.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params); 
	
}
