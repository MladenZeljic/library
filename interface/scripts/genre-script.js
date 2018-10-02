function validateAndSendGenreForm(formId) {
	
	var form = document.getElementById(formId);
	
	var genre_name_input = form.getElementsByTagName('input')[0];
			
	if(genre_name_input.value.trim().length == 0){
		genre_name_input.value = '';
		genre_name_input.nextElementSibling.innerHTML = 'Genre name is empty!';
	}
	else{
		genre_name_input.nextElementSibling.innerHTML = '';
	}
	if(genre_name_input.nextElementSibling.innerHTML.length == 0){
		sendGenreData(formId);
	}
}

function sendGenreData(formId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var form = document.getElementById(formId);
	
	var genre_name_input = form.getElementsByTagName('input')[0];
	var params = 'genre-name-input='+genre_name_input.value;
		
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var new_table = getElement("table",this.responseText);
			var old_table = document.getElementById("table");
			document.getElementById("datagrid").replaceChild(new_table,old_table);
			var new_nav_span = getElement("table-nums",this.responseText).firstChild;
			var old_nav_span = document.getElementById("table-nums").firstChild;
			document.getElementById("table-nums").replaceChild(new_nav_span,old_nav_span);
			var message = getElement("message",this.responseText).innerHTML;
			genre_name_input.value = '';
			alert(message);
		}
	};
	
	xhttp.open('POST', 'genre-management.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params); 
}

function sendUpdatedGenreData(modalId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var modal = document.getElementById(modalId);
	
	var id_genre = modal.getElementsByTagName('input')[0];
	var genre_name_input = modal.getElementsByTagName('input')[1];
	var params = 'id-genre='+id_genre.value+'&genre-name-input='+genre_name_input.value;
	
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
	
	xhttp.open('POST', 'genre-management.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params);
}
