function validateAndSendLendForm(formId) {
	
	sendLendData(formId);
	
}

function sendLendData(formId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var form = document.getElementById(formId);
	
	var copy_select = form.getElementsByTagName('select')[0];
	var copy_id = copy_select.options[copy_select.selectedIndex].value;
	
	var params = 'id-copy='+copy_id;	
		
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var new_table = getElement("table",this.responseText);
			var old_table = document.getElementById("table");
			document.getElementById("datagrid").replaceChild(new_table,old_table);
			var new_nav_span = getElement("table-nums",this.responseText).firstChild;
			var old_nav_span = document.getElementById("table-nums").firstChild;
			document.getElementById("table-nums").replaceChild(new_nav_span,old_nav_span);
			var message = getElement("message",this.responseText).innerHTML;
			copy_select.remove(copy_select.selectedIndex); 
			copy_select.selectedIndex = 0;
			alert(message);
		}
	};
	
	xhttp.open('POST', 'user-book.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params); 
	
}
