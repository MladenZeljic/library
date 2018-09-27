function validateAndSendAuthorForm(formId) {
	
	var form = document.getElementById(formId);
	
	var author_firstname_input = form.getElementsByTagName('input')[0];
	var author_lastname_input = form.getElementsByTagName('input')[1];
	var author_birth_date_input = form.getElementsByTagName('input')[2];

	if(author_firstname_input.value.trim().length == 0){
		author_firstname_input.value = '';
		author_firstname_input.nextElementSibling.innerHTML = 'Author firstname is empty!';
	}
	else{
		author_firstname_input.nextElementSibling.innerHTML = '';
	}
	if(author_lastname_input.value.trim().length == 0){
		author_lastname_input.value = '';
		author_lastname_input.nextElementSibling.innerHTML = 'Author lastname is empty!';
	}
	else{
		author_lastname_input.nextElementSibling.innerHTML = '';
	}
	if(author_birth_date_input.value.trim().length == 0){
		author_birth_date_input.value = '';
		author_birth_date_input.nextElementSibling.innerHTML = 'Author birth date is empty!';
	}
	else{
		author_birth_date_input.nextElementSibling.innerHTML = '';
	}
	if(author_firstname_input.nextElementSibling.innerHTML.length == 0 && author_lastname_input.nextElementSibling.innerHTML.length == 0 && author_birth_date_input.nextElementSibling.innerHTML.length == 0){
		sendAuthorData(formId);
	}
}

function sendAuthorData(formId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var form = document.getElementById(formId);
	
	var author_firstname_input = form.getElementsByTagName('input')[0];
	var author_lastname_input = form.getElementsByTagName('input')[1];
	var author_birth_date_input = form.getElementsByTagName('input')[2];	
	var author_biography_input = form.getElementsByTagName('textarea')[0];
	var params = 'author-firstname-input='+author_firstname_input.value+'&author-lastname-input='+author_lastname_input.value+'&author-birth-date-input='+author_birth_date_input.value+'&author-biography-input='+author_biography_input.value;
		
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var new_table = getElement("table",this.responseText);
			var old_table = document.getElementById("table");
			document.getElementById("datagrid").replaceChild(new_table,old_table);
			var new_nav_span = getElement("table-nums",this.responseText).firstChild;
			var old_nav_span = document.getElementById("table-nums").firstChild;
			document.getElementById("table-nums").replaceChild(new_nav_span,old_nav_span);
			var message = getElement("message",this.responseText).innerHTML;
			author_firstname_input.value = '';
			author_lastname_input.value = '';
			author_biography_input.value = '';
			alert(message);
		}
	};
	
	xhttp.open('POST', 'author-management.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params); 
}

