function validateAndSendAddressForm(formId) {
	
	var form = document.getElementById(formId);
	
	var zip_input = form.getElementsByTagName('input')[2];				
	var street_input = form.getElementsByTagName('input')[0];
	var city_input = form.getElementsByTagName('input')[1];
			
	if(zip_input.value.trim().length == 0){
		zip_input.value = '';
		zip_input.nextElementSibling.innerHTML = 'Zip code is empty!';
	}
	else{
		zip_input.nextElementSibling.innerHTML = '';
		if(!zip_input.value.trim().match("[0-9]+$")){
			zip_input.value = '';
			zip_input.nextElementSibling.innerHTML = 'Zip code is not correct!';
		}
	}
	if(street_input.value.trim().length == 0){
		street_input.value = '';
		street_input.nextElementSibling.innerHTML = 'Street name is empty!';
	}
	else{
		street_input.nextElementSibling.innerHTML = '';
	}
	if(city_input.value.trim().length == 0){
		city_input.value = '';
		city_input.nextElementSibling.innerHTML = 'City name is empty!';
	}
	else{
		city_input.nextElementSibling.innerHTML = '';
	}
	if(zip_input.nextElementSibling.innerHTML.length == 0 && street_input.nextElementSibling.innerHTML.length == 0 && city_input.nextElementSibling.innerHTML.length == 0){
		sendAddressData(formId);
	}
}

function sendAddressData(formId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var form = document.getElementById(formId);
	
	var zip_input = form.getElementsByTagName('input')[2];				
	var street_input = form.getElementsByTagName('input')[0];
	var city_input = form.getElementsByTagName('input')[1];
	var params = 'zip-input='+zip_input.value+'&street-input='+street_input.value+'&city-input='+city_input.value;
		
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var new_table = getElement("table",this.responseText);
			var old_table = document.getElementById("table");
			document.getElementById("datagrid").replaceChild(new_table,old_table);
			var new_nav_span = getElement("table-nums",this.responseText).firstChild;
			var old_nav_span = document.getElementById("table-nums").firstChild;
			document.getElementById("table-nums").replaceChild(new_nav_span,old_nav_span);
			var message = getElement("message",this.responseText).innerHTML;
			zip_input.value = '';
			street_input.value = '';
			city_input.value = '';
			alert(message);
		}
	};
	
	xhttp.open('POST', 'address-management.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params); 
}
function sendUpdatedAddressData(modalId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var modal = document.getElementById(modalId);
	
	var id_address = modal.getElementsByTagName('input')[0];
	var zip_input = modal.getElementsByTagName('input')[3];				
	var street_input = modal.getElementsByTagName('input')[1];
	var city_input = modal.getElementsByTagName('input')[2];
	var params = 'id-address='+id_address.value+'zip-input='+zip_input.value+'&street-input='+street_input.value+'&city-input='+city_input.value;
		
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
	
	xhttp.open('POST', 'address-management.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params);
}
