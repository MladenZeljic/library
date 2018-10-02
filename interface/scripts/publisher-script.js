function validateAndSendPublisherForm(formId) {
	
	var form = document.getElementById(formId);
	
	var publisher_name_input = form.getElementsByTagName('input')[0];
			
	if(publisher_name_input.value.trim().length == 0){
		publisher_name_input.value = '';
		publisher_name_input.nextElementSibling.innerHTML = 'Publisher name is empty!';
	}
	else{
		publisher_name_input.nextElementSibling.innerHTML = '';
	}
	if(publisher_name_input.nextElementSibling.innerHTML.length == 0){
		sendPublisherData(formId);
	}
}

function sendPublisherData(formId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var form = document.getElementById(formId);
	
	var publisher_name_input = form.getElementsByTagName('input')[0];
	var publisher_address_select = form.getElementsByTagName('select')[0];
	var publisher_address_id = publisher_address_select.options[publisher_address_select.selectedIndex].value;
	
	var params = 'publisher-name-input='+publisher_name_input.value+'&id-address='+publisher_address_id;	
		
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var new_table = getElement("table",this.responseText);
			var old_table = document.getElementById("table");
			document.getElementById("datagrid").replaceChild(new_table,old_table);
			var new_nav_span = getElement("table-nums",this.responseText).firstChild;
			var old_nav_span = document.getElementById("table-nums").firstChild;
			document.getElementById("table-nums").replaceChild(new_nav_span,old_nav_span);
			var message = getElement("message",this.responseText).innerHTML;
			publisher_name_input.value = '';
			publisher_address_select.selectedIndex = 0;
			alert(message);
		}
	};
	
	xhttp.open('POST', 'publisher-management.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params); 
	
}

function sendUpdatedPublisherData(formId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var form = document.getElementById(formId);
	
	var publisher_id_input = form.getElementsByTagName('input')[0];
	var publisher_name_input = form.getElementsByTagName('input')[1];
	var publisher_address_select = form.getElementsByTagName('select')[0];
	var publisher_address_id = publisher_address_select.options[publisher_address_select.selectedIndex].value;
	
	var params = 'id-publisher='+publisher_id_input.value+'&publisher-name-input='+publisher_name_input.value+'&id-address='+publisher_address_id;	
		
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
	
	xhttp.open('POST', 'publisher-management.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params); 
	
}

