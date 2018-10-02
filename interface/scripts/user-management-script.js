function sendUpdatedUserData(modalId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var modal = document.getElementById(modalId);
	
	var id_user = modal.getElementsByTagName('input')[0];
	var approved_input = modal.getElementsByTagName('input')[1];
	var status_input = modal.getElementsByTagName('input')[2];
	var role_select = modal.getElementsByTagName('select')[0];
	var role_id = role_select.options[role_select.selectedIndex].value;
	
	var params = 'id-user='+id_user.value+'&id-role='+role_id+'&approved='+approved_input.value+'&status='+status_input.value;
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
	
	xhttp.open('POST', 'user-management.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params);
	
}
