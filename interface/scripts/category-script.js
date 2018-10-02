function validateAndSendCategoryForm(formId) {
	
	var form = document.getElementById(formId);
	
	var category_name_input = form.getElementsByTagName('input')[0];
			
	if(category_name_input.value.trim().length == 0){
		category_name_input.value = '';
		category_name_input.nextElementSibling.innerHTML = 'Category name is empty!';
	}
	else{
		category_name_input.nextElementSibling.innerHTML = '';
	}
	if(category_name_input.nextElementSibling.innerHTML.length == 0){
		sendCategoryData(formId);
	}
}

function sendCategoryData(formId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var form = document.getElementById(formId);
	
	var category_name_input = form.getElementsByTagName('input')[0];
	var params = 'category-name-input='+category_name_input.value;
		
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var new_table = getElement("table",this.responseText);
			var old_table = document.getElementById("table");
			document.getElementById("datagrid").replaceChild(new_table,old_table);
			var new_nav_span = getElement("table-nums",this.responseText).firstChild;
			var old_nav_span = document.getElementById("table-nums").firstChild;
			document.getElementById("table-nums").replaceChild(new_nav_span,old_nav_span);
			var message = getElement("message",this.responseText).innerHTML;
			category_name_input.value = '';
			alert(message);
		}
	};
	
	xhttp.open('POST', 'category-management.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params); 
}
function sendUpdatedCategoryData(modalId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var modal = document.getElementById(modalId);
	
	var id_category = modal.getElementsByTagName('input')[0];
	var category_name_input = modal.getElementsByTagName('input')[1];
	var params = 'id-category='+id_category.value+'&category-name-input='+category_name_input.value;
	
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
	
	xhttp.open('POST', 'category-management.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params);
}
